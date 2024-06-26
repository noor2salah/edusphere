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
        $task=task::create([
            'class_subject_id'=>$class_subject_id

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

    /*
    public function store_question(request $request){
        $validator = Validator::make($request->all(), [
            'task_id'=>'required|integer',
            'the_question'=>'required|string',
            'question_grade'=>'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $task=task::find($request->class_subject_id);
        if(!$task){
            return response('try again');
        }
        $task_question=task_question::create([
            'task_id'=>$request->task_id,
            'the_question'=>$request->the_question,
            'question_grade'=>$request->question_grade

        ]);
        return response($task_question,200);
    }*/

    public function show_task($id){
        $task=task::find($id);
        if(!$task){
            return response('there is no task');
        }
        $the_task=DB::table('tasks')
        ->where('tasks.id',$id)
        ->join('task_questions','task_questions.task_id','=','tasks.id')
        ->join('question_answers','question_answers.task_question_id','=','task_questions.id')
        ->select('tasks.*','task_questions.*','question_answers.*')
        ->get();
        return response($the_task);
    }

    public function solve_task(Request $request,$id){

        $task=task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        $task_questions=DB::table('task_questions')
        ->where('task_questions.task_id',$id)
        ->select('task_questions.*')
        ->get();

        $validator = Validator::make($request->all(), [
            'answers' => 'required|array', 
            'answers.*.answer_id' => 'required|integer'
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $the_grade=0;


        foreach ($task_questions as $i => $task_question) {
            $answer_id = $request->answers[$i]['answer_id'];

            $the_answer=DB::table('question_answers')
            ->where('question_answers.task_question_id',$task_question->id)
            ->where('question_answers.id',$request->answers[$i]['answer_id'])
            ->select('question_answers.*')
            ->first();

            
            if ($the_answer && $the_answer->correct_answer) {
                $the_grade += $task_question->question_grade;
            }
        }
        return response($the_answer);
    }
}
