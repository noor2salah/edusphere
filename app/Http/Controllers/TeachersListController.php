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

    public function show_about_teacher(Request $request){

        $id = $request->input('teacher_id');
        $about = DB::table('description_about_the_teachers')
        ->where('description_about_the_teachers.teacher_id','=',$id)
        ->select('description_about_the_teachers.*')
        ->get();

        if(count($about)==0){
            return response('there is no description');
        }

        return response($about,200);

    }
    public function add_to_favorite($id){
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
