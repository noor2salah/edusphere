<?php

namespace App\Http\Controllers;


use App\Models\task;
use App\Models\task_grade;
use App\Models\task_question;
use App\Models\question_answer;
use App\Models\user;
use App\Models\student;
use App\Models\class_subject;
use Illuminate\support\Facades\Auth;
use Illuminate\support\facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class TaskController extends Controller
{
    public function store_task(request $request){
        $validator = Validator::make($request->all(), [
            'questions' => 'required|array', 
            'questions.*.the_question' => 'required|string', 
            'questions.*.question_grade' => 'required|integer',
            'answers' => 'required|array', 
            'answers.*.the_answer' => 'required|string', 
            'answers.*.correct_answer' => 'required|boolean',
            'answers.*.task_question_id' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user_id = Auth::id();
        $teacher_id = DB::table('teachers')
        ->where('teachers.user_id',$user_id)
        ->value('teachers.id');


        $class_subject_id=DB::table('class_subjects')
        ->where('class_subjects.teacher_id',$teacher_id)
        ->value('class_subjects.id');

        if(!$class_subject_id){
            return response('try again');
        }

        $task_grade=0;
        foreach ($request->questions as $question_data) {

            $task_grade+=$question_data['question_grade'];
        }
        $task=task::create([
            'class_subject_id'=>$class_subject_id,
            'total_grade'=>$task_grade

        ]);
        $task_questions = [];
        $question_answers=[];
        foreach ($request->questions as $question_data) {
            $task_question = Task_question::create([
                'task_id' => $task->id,
                'the_question' => $question_data['the_question'],
                'question_grade' => $question_data['question_grade']
            ]);
            $task_questions[] = $task_question;
        }
            foreach ($request->answers as $answer_data) {
                $check=DB::table('tasks')
                ->where('tasks.id',$task->id)
                ->join('task_questions','tasks.id','task_questions.task_id')
                ->where('task_questions.id',$answer_data['task_question_id'])
                ->value('task_questions.id');    
                
                if(!$check){
                    return response('this answer for this question does not belong to this task');
                }
            }

            foreach ($request->answers as $answer_data) {
                $question_answer = question_answer::create([
                    'task_question_id' => $answer_data['task_question_id'],
                    'the_answer' => $answer_data['the_answer'],
                    'correct_answer' => $answer_data['correct_answer']
                ]);
                $question_answers[] = $question_answer;
            }
        
        return response([$task,$task_questions,$question_answers],200);
    }

    public function show_all_tasks_for_student(){

        $user_id = Auth::id();

        $student_id=DB::table('students')
        ->where('students.user_id',$user_id)
        ->value('students.id');

        $student = Student::find($student_id);

        if (!$student) {

            return response()->json('You are not student', 403);
        }

        
        $tasks=DB::table('tasks')
        ->join('class_subjects','class_subjects.id','tasks.class_subject_id')
        ->join('classses','classses.id','class_subjects.class_id')
        ->where('classses.id',$student->class_id)
        ->join('subjects','subjects.id','class_subjects.subject_id')
        ->join('teachers','teachers.id','class_subjects.teacher_id')
        ->join('users','users.id','teachers.user_id')
        ->select('tasks.*','subjects.name','users.first_name','users.last_name')
        ->get();

        return response($tasks);

    }
    public function show_all_tasks_for_teacher(){

        $user_id = Auth::id();

        $teacher_id=DB::table('teachers')
        ->where('teachers.user_id',$user_id)
        ->value('teachers.id');

        $teacher = Student::find($teacher_id);

        if (!$teacher) {

            return response()->json('You are not teacher', 403);
        }

        
        $tasks=DB::table('tasks')
        ->join('class_subjects','class_subjects.id','tasks.class_subject_id')
        ->join('subjects','subjects.id','class_subjects.subject_id')
        ->join('teachers','teachers.id','class_subjects.teacher_id')
        ->where('teachers.id',$teacher_id)
        ->join('users','users.id','teachers.user_id')
        ->select('tasks.*','subjects.name','users.first_name','users.last_name')
        ->get();

        return response($tasks);

    }


    public function show_task($id){
        
        
        $task=task::find($id);

        if(!$task){
            return response('there is no task');
        }

        
        $the_task=DB::table('tasks')
        ->where('tasks.id',$id)
        ->join('class_subjects','class_subjects.id','tasks.class_subject_id')
        ->join('subjects','subjects.id','class_subjects.subject_id')
        ->join('teachers','teachers.id','class_subjects.teacher_id')
        ->join('users','users.id','teachers.user_id')
        ->select('tasks.*','subjects.name','users.first_name','users.last_name')
        ->get();

        $the_questions=DB::table('tasks')
        ->where('tasks.id',$id)
        ->join('task_questions','task_questions.task_id','=','tasks.id')
        ->select('task_questions.*')
        ->get();
        
        $the_answers=DB::table('tasks')
        ->where('tasks.id',$id)
        ->join('task_questions','task_questions.task_id','=','tasks.id')
        ->join('question_answers','question_answers.task_question_id','=','task_questions.id')
        ->select('question_answers.*')
        ->get();

        return response([
            'task'=>$the_task,
            'questions'=>$the_questions,
            'answers'=>$the_answers
        ]);
    }

    public function solve_task(Request $request){

        $user_id = Auth::id();

        $student_id=DB::table('students')
        ->where('students.user_id',$user_id)
        ->value('students.id');

        $student = Student::find($student_id);

        if (!$student) {

            return response()->json('You are not student', 403);
        }

        $validator = Validator::make($request->all(), [
            'task_id'=>'required|integer',
            'answers' => 'required|array', 
            'answers.*.answer_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $task=task::find($request->task_id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $check1=DB::table('tasks')
        ->where('tasks.id',$request->task_id)
        ->join('class_subjects','class_subjects.id','tasks.class_subject_id')
        ->join('classses','classses.id','class_subjects.class_id')
        ->where('classses.id',$student->class_id)
        ->select('tasks.*')
        ->first();

        if (!$check1) {
            return response()->json(['error' => 'this task is not available to you'], 404);
        }

        $check2=DB::table('task_grades')
        ->where('task_grades.task_id',$request->task_id)
        ->select('task_grades.*')
        ->get();

        if (count($check2)!==0) {
            return response()->json(['error' => 'you have already solved this task'], 404);
        }

        $task_questions=DB::table('task_questions')
        ->where('task_questions.task_id',$request->task_id)
        ->select('task_questions.*')
        ->get();

        $the_grade=0;

        foreach ($task_questions as $i => $task_question) {
            $answer_id = $request->answers[$i]['answer_id'];

            $the_answer=DB::table('question_answers')
            ->where('question_answers.task_question_id',$task_question->id)
            ->where('question_answers.id',$answer_id)
            ->select('question_answers.*')
            ->first();

            if ($the_answer && $the_answer->correct_answer ==1) {
                $the_grade += $task_question->question_grade;
            }
        }

        task_grade::create([
            'student_id'=>$student_id,
            'task_id'=>$request->task_id,
            'grade'=>$the_grade
        ]);

        return response($the_grade);
    }
}
