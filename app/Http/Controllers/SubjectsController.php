<?php

namespace App\Http\Controllers;

use App\Models\photos_about_subject;
use App\Models\subject;
use App\Models\class_subject;
use App\Models\subject_units;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectsController extends Controller
{
    public function store_subject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'the_class' => 'required|integer',
            'about_subject' => 'required|string',
            'total_grade'=>'required|integer',
            'book_path' => 'required|mimes:jpg,png,jpeg',
            'photos'=>'required|array',
            'photos.*.photo_for_subject'=>'nullable|image',
            'unit_number' => 'required|integer',
            'title' => 'required|string',
            'description' => 'required|string',
            'photo_path' => 'nullable|image|max:2048'

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        if ($request->hasFile('book_path')) {
            $book = $request->file('book_path')->store('books');
        }
        if ($request->hasFile('photo_path')) {
            $photo_path = $request->file('photo_path')->store('photos');
        }
        $request->validate([
            'the_class' => 'required|in:7,8,9',
        ]);

        $subject=DB::table('subjects')
        ->where('subjects.name',$request->name)
        ->where('subjects.the_class',$request->the_class)
        ->select('subjects.*')
        ->get();

        if(count($subject)!=0){

            return response('this subject already exist');
        }
        $subject = subject::create([
            'name' => $request->name,
            'the_class' => $request->the_class,
            'about_subject' => $request->about_subject,
            'total_grade'=>$request->total_grade,
            'book_path' => $book,
        ]);
        $subject_units = subject_units::create([
            'subject_id' => $subject->id,
            'unit_number' => $request->unit_number,
            'title' => $request->title,
            'description' => $request->description,
            'photo_path' => $photo_path
        ]);

        $photos_about_subject=[];
        foreach ($request->photos as $the_photo) {

            if (isset($the_photo['photo_for_subject']) && $the_photo['photo_for_subject']->isValid()) {
                // Store the photo in local storage
                $photo_path = Storage::disk('public')->put('photos', $the_photo['photo_for_subject']);
            }

            $photo_about_subject = photos_about_subject::create([
                'subject_id'=>$subject->id,
                'photo_path'=>$photo_path,
            ]);
            $photos_about_subject[] = $photo_about_subject;
        }
        return response()->json(['the subject added',$subject,$subject_units,$photos_about_subject], 200);
    }

    public function store_class_subject(Request $request){

        $validator = Validator::make($request->all(), [
            'class_id' => 'required|integer',
            'teacher_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'time_on_sun' => 'nullable|date_format:H:i',
            'time_on_mon' => 'nullable|date_format:H:i',
            'time_on_tue' => 'nullable|date_format:H:i',
            'time_on_wed' => 'nullable|date_format:H:i',
            'time_on_thu' => 'nullable|date_format:H:i',
            'exam_date_and_time' => 'nullable|date_format:Y-m-d H:i:s',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $class_level1=DB::table('subjects')
        ->where('subjects.id',$request->subject_id)
        ->value('subjects.the_class');
        $class_level2=DB::table('classses')
        ->where('classses.id',$request->class_id)
        ->where('classses.class_level',$class_level1)
        ->select('classses.class_level')
        ->get();

        if(count($class_level2)==0){
            return response('the subject you are trying to put is not for this class');
        }


        $class_subject =DB::table('class_subjects')
        ->where('class_subjects.class_id',$request->class_id)
        ->where('class_subjects.subject_id',$request->subject_id)
        ->select('class_subjects.*')
        ->get();

        if(count($class_subject)!=0){
            return response('already exist');
        }

        $class_subject = class_subject::create([
            'class_id' => $request->class_id,
            'teacher_id' =>  $request->teacher_id,
            'subject_id' =>  $request->subject_id,
            'time_on_sun' => $request->time_on_sun,
            'time_on_mon' => $request->time_on_mon,
            'time_on_tue' => $request->time_on_tue,
            'time_on_wed' => $request->time_on_wed,
            'time_on_thu' => $request->time_on_thu,
            'exam_date_and_time' => $request->exam_date_and_time,
        ]);

        return response()->json(['added',$class_subject], 200);

    }


    public function show_the_schedule(){

    }
    public function show_all_the_schedules(){

    }

    public function show_subjects_of_the_class($the_class)
    {
        $subjects = DB::table('subjects')
            ->where('the_class', $the_class)
            ->get();
        return response()->json($subjects, 200);
    }
    public function show_subject($id)
    {
        $subject = DB::table('subjects')
            ->where('subjects.id', $id)
            ->join('subject_units', 'subject_units.subject_id', '=', 'subjects.id')
            ->join('photos_about_subjects','photos_about_subjects.subject_id','subjects.id')
            ->select('subjects.*', 'subject_units.*','photos_about_subjects.*')
            ->get();
        return response()->json($subject, 200);
    }
}
