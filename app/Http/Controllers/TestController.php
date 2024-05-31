<?php

namespace App\Http\Controllers;

use App\Models\subject;
use App\Models\classs;
use App\Models\class_subject;
use App\Models\grade;
use App\Models\test;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use PHPUnit\Event\Code\Test as CodeTest;


class TestController extends Controller
{
    //test method
    public function index()
    {
        $tests = Test::with(['class_subject' => function ($query) {
            $query->select('class_id')->with(['class' => function ($query) {
                $query->select('class_level', 'class_number');
            }]);
        }])->get();



        return response()->json($tests);
    }
    public function show_test_by_class_level($class_level)
    {

        $tests = Test::whereHas('class_subject', function ($query) use ($class_level) {
            $query->whereHas('class', function ($query) use ($class_level) {
                $query->where('class_level', $class_level);
            });
        })->with(['class_subject' => function ($query) {
            $query->select('class_id', 'subject_id')->with(['class' => function ($query) {
                $query->select('class_level', 'class_number');
            }, 'subject']);
        }])->get();

        return response()->json($tests);
    }
    public function store_test(Request $request)
    {
        $class_level = $request->input('class_level');
        $class_number = $request->input('class_number');
        $exam_paper_path = $request->file('exam_paper_path');

        if ($exam_paper_path) {
            $exam_paper_path = $request->file('exam_paper_path')->store('public/photos');
        }

        $class = Classs::where('class_level', $class_level)
            ->where('class_number', $class_number)
            ->firstOrFail();

        $subject_name = $request->input('name');

        $subject = subject::where('name', $subject_name)->firstOrFail();

        $class_subject = class_subject::create([
            'class_id' => $class->id,
            'subject_id' => $subject->id,
        ]);

        $test = Test::create([
            'class_subject_id' => $class_subject->id,
            'type' => $request->input('type'),
            'exam_paper_path' => $exam_paper_path,
        ]);

        return response()->json([
            'message' => 'Test created successfully',
            'class' => $class,
            'test' => $test,
        ], 201);
    }
    public function delete_test($id)
    {

        $tests = test::find($id);
        if (!$tests) {

            return response()->json([
                'message' => 'test not found',

            ]);
        }
        $tests->delete();
        return response()->json([
            'message' => 'tests deleted successfully',
        ]);
    }
    //grade test methods
    public function store_grade_test(Request $request)
    {
        $e = $request->all();
        $validator = Validator::make($e, [
            'student_id' => 'required',
            'test_id' => 'required',
            'grade' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $grade = grade::create([
            'student_id' => $request->student_id,
            'test_id' => $request->test_id,
            'grade' => $request->grade,
        ]);

        return response()->json([
            'grade' => $grade,
        ]);
    }
    public function show_grade($test_id)
    {

        $grades = grade::where('test_id', $test_id)
            ->with(['student' => function ($query) {
                $query->select('id');
            }])
            ->get();

        return response()->json($grades);
    }
    public function show_grade_by_student($student_id)
    {


        $grades = grade::where('student_id', $student_id)
            ->with(['test' => function ($query) {
                $query->select('id', 'type');
            }])
            ->get();

        return $grades;
    }
    public function delete_grade($student_id)
    {

        $grade = grade::where('student_id', $student_id)->first();

        if (!$grade) {

            return response()->json([
                'message' => 'grade not found',

            ]);
        }
        $grade->delete();
        return response()->json([
            'message' => 'grade deleted successfully',
        ]);
    }
}
