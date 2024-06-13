<?php

namespace App\Http\Controllers;

use App\Models\subject;
use App\Models\classs;
use App\Models\class_subject;
use App\Models\grade;
use App\Models\test;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function show_test_by_class_level(Request $request)
    {

        $class_level=$request->input('class_level');
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
        $subject_name = $request->input('subject_name');


        if ($exam_paper_path) {
            $exam_paper_path = $request->file('exam_paper_path')->store('public/photos');
        }

        $class_id = DB::table('classses')
        ->where('classses.class_level',$class_level)
        ->where('classses.class_number',$class_number)
        ->value('classses.id');


        $subject_id = DB::table('subjects')
        ->where('subjects.name',$subject_name)
        ->where('subjects.the_class',$class_level)
        ->value('subjects.id');

        $class_subject_id = DB::table('class_subjects')
        ->where('class_subjects.class_id',$class_id)
        ->where('class_subjects.subject_id',$subject_id)
        ->value('class_subjects.id');
        if(!$class_subject_id){
            return response('this subject is not for this class');
        }

        $test = Test::create([
            'class_subject_id' => $class_subject_id,
            'type' => $request->input('type'),
            'exam_paper_path' => $exam_paper_path,
        ]);

        return response()->json([
            'message' => 'Test created successfully',
            'class level' => $class_level,
            'class number' => $class_number,
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

        $grade=DB::table('grades')
        ->where('grades.student_id',$request->student_id)
        ->where('grades.test_id',$request->test_id)
        ->select('grades.*')
        ->first();

        if($grade){
            return response('already exist');
        }

        $check_class1=DB::table('students')
        ->where('students.id',$request->student_id)
        ->value('students.class_id');

        $check_class2=DB::table('tests')
        ->where('tests.id',$request->test_id)
        ->join('class_subjects','tests.class_subject_id','class_subjects.id')
        ->value('class_subjects.class_id');


        if($check_class1!=$check_class2){
            return response('this studentd is not in the correct class');
        }

        $total_grade=DB::table('tests')
        ->where('tests.id',$request->test_id)
        ->join('class_subjects','class_subjects.id','tests.class_subject_id')
        ->join('subjects','subjects.id','class_subjects.subject_id')
        ->value('subjects.total_grade');

        $grade_type=DB::table('tests')
        ->where('tests.id',$request->test_id)
        ->value('tests.type');

        if($grade_type=='homework'||$grade_type=='oral_exam'||$grade_type=='quiz'){
            $total_grade_by_type=0.2*$total_grade;
        }

        if($grade_type=='exam'){
            $total_grade_by_type=0.4*$total_grade;
        }

        if ($request->grade>$total_grade_by_type){
            return response('this grade is bigger than the total grade');
        }
        $grade = grade::create([
            'student_id' => $request->student_id,
            'test_id' => $request->test_id,
            'grade' => $request->grade,
        ]);

        return response()->json([
            'grade' => $grade,
            'total_grade'=>$total_grade_by_type,

        ]);
    }
    public function show_grade_by_type(Request $request)
    {

        $type=$request->input('type');
        $subject_name=$request->input('subject_name');
        $user_id = Auth::id();
        $student_id = DB::table('students')
        ->where('students.user_id',$user_id)
        ->value('students.id');

        $grades_by_type= DB::table('grades')
        ->where('grades.student_id',$student_id)
        ->join('tests','tests.id','grades.test_id')
        ->join('class_subjects','class_subjects.id','tests.class_subject_id')
        ->join('subjects','subjects.id','class_subjects.subject_id')
        ->where('subjects.name',$subject_name)
        ->where('tests.type',$type)
        ->select('grades.*','tests.*')
        ->get();

        return response([
            'grades'=>$grades_by_type
        ]);

    }

    public function show_the_total_grade(){
        $user_id = Auth::id();
        $student_id = DB::table('students')
        ->where('students.user_id',$user_id)
        ->value('students.id');

        $types=['exam','quiz','homework','oral_exam'];

        $avg_by_type=[];
        $subjects = Subject::all();

        // Get all grades with related tables in a single query
        $grades = DB::table('grades')
            ->where('grades.student_id', $student_id)
            ->join('tests', 'tests.id', '=', 'grades.test_id')
            ->join('class_subjects', 'class_subjects.id', '=', 'tests.class_subject_id')
            ->join('subjects', 'subjects.id', '=', 'class_subjects.subject_id')
            ->select('subjects.name as subject_name', 'tests.type as test_type', 'grades.grade')
            ->get();

        // Group grades by subject and type
        $groupedGrades = [];
        foreach ($grades as $grade) {
            $groupedGrades[$grade->subject_name][$grade->test_type][] = $grade->grade;
        }

        // Calculate the averages
        foreach ($subjects as $subject) {
            $subjectName = $subject->name;
            $total_garde[$subjectName]=$subject->total_grade;
            foreach ($types as $type) {
                
                $avg_by_type[$subjectName][$type] = isset($groupedGrades[$subjectName][$type])
                    ? array_sum($groupedGrades[$subjectName][$type]) / count($groupedGrades[$subjectName][$type])
                    : null; // or 0 or another default value
                    $weight = 0;
                    if (in_array($type, ['quiz', 'oral_exam', 'homework'])) {
                        $weight = 0.2;
                    } elseif ($type == 'exam') {
                        $weight = 0.4;
                    }
        
                    // Calculate the total grade by type with the weight
                    $total_grade_by_type[$subjectName][$type] = $total_garde[$subjectName] * $weight;
                
            }
        }
        
        return response([
            'the_grades_for_this_student'=>$avg_by_type,
            'total_grade_ for_subjects'=>$total_garde,
            'total_grade_ by_type'=>$total_grade_by_type

    ]);

    }
    public function delete_grade($grade_id)
    {

        $grade = grade::where('id', $grade_id)->first();

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
