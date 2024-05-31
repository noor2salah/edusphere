<?php

namespace App\Http\Controllers;

use App\Models\favorite_book;
use App\Models\student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\library;

class LibraryController extends Controller

{
    /*
    public function index()
    {
        $library = library::all();
        return response()->json($library);
    }
    */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'book_name' =>'required|string',
            'book_path'=>'required|mimes:pdf',
            'type' =>'required|string',

        ]);
        if($validator->fails())
        {
            return response()->json($validator->errors());
        }
        if($request->hasFile('book_path'))
        {
            $book = $request->file('book_path')->store('books');
        }
        $library=library::create([
            'book_name' => $request->book_name,
            'book_path' => $book,
            'type' => $request->type,
        ]);
        return response()->json($library,200);
    }
    
    public function show_educational()
    {
        $books = library::where('type','educational')->get();
        return response()->json($books,200);

    }
    public function show_entertainment()
    {
        $books = library::where('type','entertainment')->get();
        return response()->json($books,200);

    }

    public function add_to_favorite($id){
        $book=library::find($id);
        if(!$book){
            return response('this book does not exist ,please try again',403);
        }
        $user_id = Auth::id();
        $student_id = DB::table('students')
        ->where('students.user_id',$user_id)
        ->value('students.id');

        $fav_book=DB::table('favorite_books')
        ->where('favorite_books.library_id',$id)
        ->where('favorite_books.student_id',$student_id)
        ->select('favorite_books.*')
        ->get();
        if(count($fav_book)!=0){
            return response('alredy in favorite',200);
        }

        $fav_book=favorite_book::create([
            'library_id' => $id,
            'student_id' => $student_id
        ]);
        return response($fav_book,200);
    }
    public function remove_from_favorite($id){
        $book=favorite_book::find($id);
        if(!$book){
            return response('this book does not exist ,please try again',403);
        }
        $user_id = Auth::id();
        $student_id = DB::table('students')
        ->where('students.user_id',$user_id)
        ->value('students.id');
        if($book->student_id==$student_id){
            $book->delete();
            return response('the book deleted from favorite');
    
        }
        return response('you can not delete this book');
 
    }
    public function show_favorite_books(){
        $user_id = Auth::id();
        $student_id = DB::table('students')
        ->where('students.user_id',$user_id)
        ->value('students.id');
       
        $fav_books= DB::table('favorite_books')
        ->where('favorite_books.student_id',$student_id)
        ->join('libraries','favorite_books.library_id','=','libraries.id')
        ->SELECT('libraries.*')
        ->get();

        if(count($fav_books)==0){
            return response('there is no favorite books');
        }
        return response($fav_books,200);


    }

}
