<?php

namespace App\Http\Controllers;

use App\Models\classs;
use App\Models\User;
use App\Models\student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    //Admin
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'class_level' =>'required|integer',
            'class_number'=>'required|integer',


        ]);
        if($validator->fails())
        {
            return response()->json($validator->errors());
        }
        $request->validate([
            'class_level' => 'required|in:7,8,9',
        ]);
        
        $class=DB::table('classses')
        ->where('classses.class_level',$request->class_level)
        ->where('classses.class_number',$request->class_number)
        ->select('classses.*')
        ->get();

        if(count($class)!=0){
            return response('this class is already exist');
        }
        
        $class=classs::create([
            'class_level' => $request->class_level,
            'class_number' => $request->class_number,

        ]);
        return response()->json($class,200);
    }
    public function show_all_class_levels()
    {
        $class = DB::table('classses')
        ->select('classses.class_level')
        ->distinct()
        ->get();
        return response()->json($class);

    }
    public function show_all_class_numbers(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'class_level' =>'required|integer',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }
        $request->validate([
            'class_level' => 'required|in:7,8,9',
        ]);
        
        $class = DB::table('classses')
        ->where('classses.class_level',$request->class_level)
        ->select('classses.class_number')
        ->get();
        return response()->json($class);

    }
    
    public function detete_class($id)
    {
        $classes = classs::find($id);
        if (!$classes) {

            return response()->json([
                'message' => 'class not found',

            ]);
        }
        $classes->delete();
        return response()->json([
            'message' => 'class deleted successfully',
        ]);
    }
    /*public function showStudentsByClass($id,Request $request)
    {
        $students = student::where('class_id', $id)->with('class','user')->get();

        return response()->json([
            'data' => $students,
            'status' => true,
        ], 200);

        }*/
    public function EditClass($id,Request $request)
    {
        $class = classs::find($id);
        if(!$class)
        {
            return response()->json('class not found');
        }
        $class->update($request->all());
        return response()->json($class,200);
    }



}

