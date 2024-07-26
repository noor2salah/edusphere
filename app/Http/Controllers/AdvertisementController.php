<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\advertisement;
use App\Models\classs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::all();
        return response()->json($advertisements);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'class_level' => 'required',
            'class_number' => 'required|numeric',
            'type'=>'required|string',
            'photo_path' => 'nullable|image|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $request->validate([
            'class_level' => 'required|in:7,8,9',
            'type' => 'required|in:bus,trips,wallet,exam,results,instuctions,other',
        ]);
       
        
        $class_level = $request->input('class_level');
        $class_number = $request->input('class_number');


    $photo_path = $request->file('photo_path')->store('images','public');

    $imageUrl = asset('storage/'.$photo_path);

        $class = Classs::where('class_level', $class_level)
            ->where('class_number', $class_number)
            ->first();

        if (!$class){

            return response('this class does not exist ');
        }
        $advertisement = advertisement::create([
            'class_id' => $class->id,
            'type'=>$request->type,
            'photo_path' => $imageUrl,
        ]);

      
        return response()->json([
            'advertisements' => $advertisement,
        ], 200);
    }
    public function show(Request $request)
    {
        $id=$request->input('advertisement_id');

        $advertisements = advertisement::find($id);
        if (!$advertisements) {
            return response()->json([
                'message' => 'not found any Advertisements',

            ], 200);
        }
        return response()->json([
            'message' => 'retruved successfully',
            'data' => $advertisements,
        ], 200);
    }

    public function show_all_by_class()
    {
        $user_id = Auth::id();
        $class_id = DB::table('students')
        ->where('students.user_id',$user_id)
        ->value('students.class_id');


        if (!$class_id) {
            return response()->json([
                'message' => 'this class does not exist',

            ], 200);
        }

        $advertisements=DB::table('advertisements')
        ->where('advertisements.class_id',$class_id)
        ->select('advertisements.*')
        ->get();

        if (count($advertisements)==0) {
            return response()->json([
                'message' => 'not found any Advertisements',

            ], 200);
        }

        return response()->json([
            'message' => 'retruved successfully',
            'data' => $advertisements,
        ], 200);
    }
    public function destroy($id)
    {
        $advertisements = advertisement::find($id);
        if (!$advertisements) {

            return response()->json([
                'message' => 'advertisement not found',

            ]);
        }
        $advertisements->delete();
        return response()->json([
            'message' => 'advertisements deleted successfully',
        ]);
    }
    public function SearchAdvertisement($title)
    {
        $advertisement = advertisement::where('title', 'like', '%' . $title . '%')
        ->get();

    if ($advertisement) {
        return response()->json([
            'advertisement'=>$advertisement
        ]);
    }
    return response()->json(
        [
            'message' => 'not found !'
        ]);
    }
}

