<?php

namespace App\Http\Controllers;

use App\Mail\SendCodeResetPassword;
use App\Mail\VerfiyCode;
use App\Models\ResetCodePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{

    public function number_of_total_school_students_for_admin(){

        $the_number=DB::table('students')
        ->count('students.id');

        return response($the_number);
    }

    public function number_of_total_class_level_students(Request $request){

        $validator = Validator::make($request->all(), [

            'class_level'=>'required|integer'
        ]);

        $request->validate([
            'class_level' => 'required|in:7,8,9',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $the_number=DB::table('students')
        ->join('classses','classses.id','students.class_id')
        ->where('classses.class_level',$request->class_level)
        ->count('students.id');

        return response($the_number);
    }
    
    public function number_of_total_class_students(Request $request){

        $validator = Validator::make($request->all(), [

            'class_level'=>'required|integer',
            'class_number'=>'required|integer'

        ]);

        $request->validate([
            'class_level' => 'required|in:7,8,9',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $the_number=DB::table('students')
        ->join('classses','classses.id','students.class_id')
        ->where('classses.class_level',$request->class_level)
        ->where('classses.class_number',$request->class_number)
        ->count('students.id');

        return response($the_number);
    }

    public function show_students_in_class(Request $request){

        $validator = Validator::make($request->all(), [

            'class_level'=>'required|integer',
            'class_number'=>'required|integer'

        ]);

        $request->validate([
            'class_level' => 'required|in:7,8,9',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $class_id=DB::table('classses')
        ->where('classses.class_level',$request->class_level)
        ->where('classses.class_number',$request->class_number)
        ->value('classses.id');

        $students=DB::table('students')
        ->where('students.class_id',$class_id)
        ->join('users','users.id','students.user_id')
        ->select('users.*')
        ->get();

        return response($students);

    }

    public function show_student_profile(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'student_id'=>'required|integer'  

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $student = DB::table('students')
        ->where('students.id',$request->student_id)
        ->join('users','users.id','=','students.user_id')
        ->join('classses','classses.id','=','students.class_id')
        ->select('users.*','students.*','classses.*')
        ->get();
        return response()->json( $student);
    }

        
} 

