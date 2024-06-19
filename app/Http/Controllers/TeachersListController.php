<?php

namespace App\Http\Controllers;

use App\Models\favorite_teacher;
use App\Models\student;
use App\Models\teacher;
use App\Models\user;
use Illuminate\support\Facades\Auth;
use Illuminate\support\facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TeachersListController extends Controller
{
    public function show_teachers_by_class(Request $request){

        $class_level = $request->input('class_level');

        $teachers = DB::table('classses')
        ->join('class_subjects','classses.id','=','class_subjects.class_id')
        ->join('teachers','teachers.id','=','class_subjects.teacher_id')
        ->join('users','users.id','=','teachers.user_id')
        ->where('classses.class_level','=',$class_level)
        ->select('users.*','teachers.*')
        ->distinct()
        ->get();

        if(count($teachers)==0){
            return response('there is no teachers');
        }

        return response($teachers,200);
    }

    
public function show_about_teacher(Request $request)
{
    $id = $request->input('teacher_id');

    // Fetch the teacher details
    $teacher = DB::table('teachers')
        ->where('teachers.id', $id)
        ->select('teachers.*')
        ->first();

    // Fetch the user details
    $user = DB::table('teachers')
        ->where('teachers.id', $id)
        ->join('users', 'teachers.user_id', '=', 'users.id')
        ->select('users.*')
        ->first();

    // Check if the teacher or user does not exist
    if (!$teacher || !$user) {
        return response()->json(['message' => 'Teacher not found'], 404);
    }

    // Calculate the age using Carbon
    $user->age = Carbon::parse($user->birthdate)->age;

    // Remove the birthdate from the response
    unset($user->birthdate);

    // Fetch the description about the teacher
    $about = DB::table('description_about_the_teachers')
        ->where('teacher_id', $id)
        ->get();

    // Check if descriptions exist
    if ($about->isEmpty()) {
        return response()->json(['message' => 'There is no description'], 404);
    }

    // Return the teacher's details with age and the descriptions
    return response()->json([
        'user' => $user,
        'teacher' => $teacher,
        'descriptions' => $about
    ], 200);
}
    public function add_to_favorite(Request $request){
        $id=$request->input('id');
        $teacher = teacher::find($id);
        $user_as_teacher=user::where('users.id',$teacher->user_id)
        ->select('users.*')
        ->get();
        $user_id = Auth::id();

        $student_id = DB::table('students')
        ->where('students.user_id',$user_id)
        ->value('students.id');

        if(!$teacher){
            return response('this teacher does not exist');
        }
        $fav_teacher=DB::table('favorite_teachers')
        ->where('favorite_teachers.teacher_id',$id)
        ->where('favorite_teachers.student_id',$student_id)
        ->select('favorite_teachers.*')
        ->get();
        if(count($fav_teacher)!=0){
            return response('alredy in favorite',200);
        }
        $fav_teacher = favorite_teacher :: create([
            'teacher_id' => $id,
            'student_id' => $student_id
        ]);

        return response([$fav_teacher,$teacher,$user_as_teacher],200);

    }

    public function remove_from_favorite($id){

        $teacher=favorite_teacher::find($id);

        if(!$teacher){
            return response('this teacher does not exist ,please try again',403);
        }

        $user_id = Auth::id();
        $student_id = DB::table('students')
        ->where('students.user_id',$user_id)
        ->value('students.id');

        if($student_id!=$teacher->student_id){
    
            return response('you can not delete this , you are not the owner');
    
        }

        $teacher->delete();
        return response('the teacher deleted from favorite');
    }

    public function show_favorite_teachers(){
        $user_id = Auth::id();

        $student_id = DB::table('students')
        ->where('students.user_id',$user_id)
        ->value('students.id');

        $fav_teachers = DB::table('favorite_teachers')
        ->join('teachers','teachers.id','=','favorite_teachers.teacher_id')
        ->join('users','users.id','=','teachers.user_id')
        ->where('favorite_teachers.student_id',$student_id)
        ->select('users.*','teachers.*')
        ->get();

        if(!$fav_teachers){
            return response('there is no teachers ,please try again',403);
        }

        return response($fav_teachers,200);
    }

}
