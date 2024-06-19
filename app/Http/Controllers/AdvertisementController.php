<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\advertisement;
use App\Models\classs;
use Illuminate\Support\Facades\DB;


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
            'title' => 'required',
            'advertisement' => 'required',
            'photo_path' => 'nullable|image|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $class_level = $request->input('class_level');
        $class_number = $request->input('class_number');

        $photo = null;
        if ($request->hasFile('photo_path')) {
            $photo = $request->file('photo_path')->store('photos');
        }

        $class = Classs::where('class_level', $class_level)
            ->where('class_number', $class_number)
            ->first();

        if (!$class){

            return response('this class does not exist ');
        }    
        $advertisement = advertisement::create([
            'class_id' => $class->id,
            'title' => $request->title,
            'advertisement' => $request->advertisement,
            'photo_path' => $photo,
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

    public function show_all_by_class(Request $request)
    {
        $class_level=$request->input('class_level');
        $class_number=$request->input('class_number');

        $class_id=DB::table('classses')
        ->where('classses.class_level',$class_level)
        ->where('classses.class_number',$class_number)
        ->value('classses.id');

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
        ]
   );
    }
    }

