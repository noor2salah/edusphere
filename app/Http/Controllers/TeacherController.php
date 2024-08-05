<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Illuminate\Support\Facades\DB;



class TeacherController extends Controller
{
    public function show_all_teachers(Request $request){

        $class_level = $request->input('class_level');

        $teachers = DB::table('teachers')
        ->get();

        if(count($teachers)==0){
            return response('there is no teachers');
        }

        return response($teachers,200);
    }
}
