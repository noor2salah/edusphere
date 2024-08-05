<?php

namespace App\Http\Controllers;

use App\Events\StudentCreated;
use App\Http\Middleware\Admin as MiddlewareAdmin;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendCodeResetPassword;
use App\Mail\VerfiyCode;
use App\Models\admin;
use App\Models\classs;
use App\Models\description_about_the_teacher;
use App\Models\ResetCodePassword;
use App\Models\student;
use App\Models\teacher;
use Illuminate\Support\Facades\Auth;
use App\Models\Verficationcode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    protected $VerfiyCode;

    public function generate_code(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $email = $request->email;
    $password = $request->password;
    $code = mt_rand(10000, 99999);

    $user = User::where('email', $email)->first();


    if (!$user) {
        return response()->json([
            'message' => 'User not found',
        ]);
    }
    if (!Hash::check($password, $user->password)) {
        return response()->json([
            'message' => 'Invalid password',
        ]);
    }

    $codeData = Verficationcode::create([
        'email' => $email,
        'code' => $code,
        'password' => $password,
        'user_id' => $user->id,
    ]);


    // Send email to user
    Mail::to($request->email)->send(new VerfiyCode($codeData->code, $password));

    return response()->json([
        'message' => trans('Code has been sent'),

    ]);

}
public function AddAccountStudent(Request $request)
{
    $e = $request->all();
    $validator = Validator::make($e, [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'birthdate' => 'required|date',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string',
        'phone' => 'required|string|unique:users',
        'address' => 'required|string',
        'profile_picture_path' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        'gender' => 'required',
        'role' => 'required|string',
        'class_level' => 'required',
        'class_number' => 'required',
        'enrollment_date' => 'required|date',
        'parent_name' => 'required|string',
        'parent_phone' => 'required|string|unique:students',
        'parent_email' => 'required|email|unique:students',
        'bus'=>'required|boolean',
    ]);

    $request->validate([
        'class_level' => 'required|in:7,8,9',
    ]);


    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    

    $class_level = $request->input('class_level');
    $class_number = $request->input('class_number');

    if ($request->hasFile('profile_picture_path')){

        $profile_picture_path = $request->file('profile_picture_path')->store('images','public');

        $imageUrl = asset('storage/'.$profile_picture_path);
    }

    else if(!$request->profile_picture_path && $request->gender=='female'){

        $imageUrl = asset('storage/images/default_female_picture.jpg');
    }
    else if(!$request->profile_picture_path && $request->gender=='male'){

        $imageUrl = asset('storage/images/default_male_picture.jpg');
    }
    // Check if the class exists
    $class = Classs::where('class_level', $class_level)
        ->where('class_number', $class_number)
        ->firstOrFail();

    try {
        DB::beginTransaction();


   //        $user= User::create([
        // Create user
        $user = User::create([
            'uid'=>null,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthdate' => $request->birthdate,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'profile_picture_path' => $imageUrl,
            'address' => $request->address,
            'role' => $request->role,
            'gender' => $request->gender
        ]);

        // Create student
        $student = Student::create([
            'user_id' => $user->id,
            'class_id' => $class->id,
            'enrollment_date' => $request->enrollment_date,
            'parent_name' => $request->parent_name,
            'parent_phone' => $request->parent_phone,
            'parent_email' => $request->parent_email,
            'bus'=>$request->bus
        ]);

        Event::dispatch(new StudentCreated($class));

        DB::commit();

        $student1['token'] = $user->createToken('token')->accessToken;
        $student1['Data'] = $student;
        $student1['class'] = $class;

        return response()->json([
            'message' => 'Register successfully',
            'student' => $student1,
            'user' => $user,

        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'message' => 'Failed to register student',
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function AddAccountTeacher(Request $request)
{
    $e = $request->all();
    $validator = Validator::make($e, [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'birthdate' => 'required|date',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string',
        'phone' => 'required|string|unique:users',
        'address' => 'required|string',
        'profile_picture_path' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        'gender' => 'required',
        'role' => 'required|string',
        'about' => 'required',
        'rate' => 'required|numeric',
        'hire_date' => 'required|date',
        'specialization' => 'required|string',
        'education' => 'required|string',
        'salary' => 'required',
        'cv'=> 'required|mimes:pdf',

    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    if ($request->hasFile('profile_picture_path')){

        $profile_picture_path = $request->file('profile_picture_path')->store('images','public');

        $imageUrl = asset('storage/'.$profile_picture_path);
    }

    else if(!$request->profile_picture_path && $request->gender=='female'){

        $imageUrl = asset('storage/images/default_female_picture.jpg');
    }
    else if(!$request->profile_picture_path && $request->gender=='male'){

        $imageUrl = asset('storage/images/default_male_picture.jpg');
    }
    $cv = $request->file('cv')->store('images','public');
    $cvurl = asset('storage/'.$cv);

    try {
        DB::beginTransaction();

       // $user= User::create([
        // Create user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthdate' => $request->birthdate,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'profile_picture_path' => $imageUrl,
            'address' => $request->address,
            'role' => $request->role,
            'gender' => $request->gender
        ]);

        // Create teacher
        $teacher = Teacher::create([
            'user_id' => $user->id,
            'rate' => $request->rate,
            'hire_date' => $request->hire_date,
            'specialization' => $request->specialization,
            'salary' => $request->salary,
            'education' => $request->education,
            'about'=>$request->about,
            'cv'=>$cvurl
        ]);



        DB::commit();

        $user['token'] = $user->createToken('token')->accessToken;
        $teacher['Data'] = $user;

        return response()->json([
            'message' => 'Register successfully',
            'teacher' => $teacher,
        ]);
    }
    catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'message' => 'Failed to register teacher',
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function login(Request $request)
    {
        $verfiyCode = Verficationcode::query()->firstWhere('code', $request['code']);
        if(empty($request['code'])&&empty($request['password'])){
            return response()->json([
                'message'=>'please enter your verification code and your password'
            ]);
        }
        if(empty($request['password'])){
            return response()->json([
                'message'=>'please enter your password'
            ]); 
        }
        
        if(empty($request['code'])){
            return response()->json([
                'message'=>'please enter your verification code'
            ]);
        }
        if (!$verfiyCode) {
            return response()->json([
                'message' => 'Invalid Code'
            ]);
        }

        $user = User::query()->find($verfiyCode->user_id);

        

        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid password'
            ]);


        }
        Auth::login($user);

        $token = $user->createToken('token')->accessToken;

        return response()->json([
            'token' => $token,
            'data' => $user,
            'message' => 'user login successfully'
        ]);
    }

    public function loginAdmin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $admin = User::query()->find(auth()->user()['id']);
            $success['token'] = $admin->createToken('token')->accessToken;
            $success['name'] = $admin;

            return response()->json([
                'data' => $success,
                'message' => 'user login successfully'
            ]);
        }

        return response()->json([
            'message' => 'Invalid login'
        ]);
    }
    public function logout()
    {
        auth()->user()->token()->revoke();
        return response()->json([

            'message' => 'user logout successfully'
        ]);
    }
    public function DeleteAccount($id)
    {
        User::find($id)->delete();
        return response()->json([

            'message' => 'your account deleted successfully'
        ]);
    }
    public function userforgetpassword(Request $request)
    {
        $data = $request->validate([

            'email' => 'required|email|exists:users',
        ]);
        //delete all old code that user send before
        ResetCodePassword::query()->where('email', $request['email'])->delete();

        //generate random code
        $data['code'] = mt_rand(10000, 99999);
        $data['token_code']=Hash::make($data['code']);

        //create a new code
        $codeData = ResetCodePassword::query()->create($data);

        //send email to user
        Mail::to($request['email'])->send(new SendCodeResetPassword($codeData['code']));


        return response()->json([
            'message' => trans('code is sent')
        ]);
    }
    public function usercheckcode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:reset_code_passwords',

        ]);

        //find the code
        $passwordReset = ResetCodePassword::query()->firstWhere('code', $request['code']);
        if(!is_null($passwordReset))
        return response()->json([
            'code' => $passwordReset['code'],
            'token_code'=> $passwordReset['token_code'],
            'message' => trans('password code is valid')

        ]);
    }
    public function userResetPassword(Request $request)
    {
        $request->validate([
            'password'=>'required',
            'token_code'=>['required','string']
        ]);


        $passwordReset = ResetCodePassword::query()
        ->where('token_code','=',$request->input('token_code'))
        ->first();

        if(!$passwordReset)
        {
            return response()->json([
                'message'=>'invalid code'
            ],400);

        }

        if(!$user = User::where('email', $passwordReset->email)->first())
        {
            return response()->json([
                'message'=>'user does not exist'
            ],404 );
        }

        $password = bcrypt($request->input('password'));

        $user->password = $password;
        $user->save();
        //delete current code
        $passwordReset->delete();


        return response()->json([
            'message' => 'password has been successfully reset',
        ]);
    }
    // public function userResetPassword(Request $request)
    // {
    //     $request->validate([
    //         'code'=>'required|exists:reset_code_passwords',
    //         'password'=>'required',
    //         'confirmed_password'=>'required|same:password',
    //     ]);

    //     $code = $request->input('code');

    //     if(!$passwordReset = DB::table('reset_code_passwords')->where('code',$code)->first())
    //     {
    //         return response()->json([
    //             'message'=>'invalid code'
    //         ],400);

    //     }

    //     if(!$user = User::where('email', $passwordReset->email)->first())
    //     {
    //         return response()->json([
    //             'message'=>'user does not exist'
    //         ],404 );
    //     }
    //     if(!$verfiyCode = Verficationcode::where('email', $passwordReset->email)->first())
    //     {
    //         return response()->json([
    //             'message'=>'verfiy code is invalid'
    //         ],404 );
    //     }

    //     $password = bcrypt($request->input('password'));
    //     $confirmed_password = bcrypt($request->input('confirmed_password'));

    //     $user->password = $password;
    //     $verfiyCode->password = $password;
    //     $user->save();

    //     $verfiyCode->save();
    //     //delete current code
    //     //$passwordReset->delete();

    //     return response()->json([
    //         'message' => 'password has been successfully reset',
    //     ]);
    // }
    public function profileStudent($id)
    {
        $student = DB::table('students')
        ->where('students.id',$id)
        ->join('users','users.id','=','students.user_id')
        ->join('classses','classses.id','=','students.class_id')
        ->select('users.*','students.*','classses.*')
        ->get();
        return response()->json([
            'message' => 'profile information',
            'data' => $student,
        ]);
    }
    public function profileteacher($id)
    {
        $teacher= DB::table('teachers')
        ->where('teachers.id',$id)
        ->join('users','users.id','=','teachers.user_id')
        ->select('users.*','teachers.*')
        ->get();

        return response()->json([
            'message' => 'profile information',
            'data' => $teacher,
        ]);
    }
    public function EditProfilestudent( Request $request)
    { $e = $request->all();
        $validator = Validator::make($e, [
            'email' => 'string|email|unique:users',
            'password' => 'string',
            'phone' => 'string|unique:users',
            'address' => 'string',
            'profile_picture_path' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'parent_phone' => 'string|unique:students',
            'parent_email' => 'email|unique:students',
         
    
        ]);
    
        $user_id = Auth::id();

        $student = Student::where('user_id', $user_id)->first();


        if (!$student) {
            return response()->json([
                'message' => 'student not found',
            ], 404);
        }

        $user = User::find($user_id);

        if (!$user) {
            return response()->json([
                'message' => 'user not found',
            ], 404);
        }

        if($request->email){
            $user->email = $request->email;

        }
        if($request->password){
            $user->password = Hash::make($request->password);

        }
        if($request->phone){
            $user->phone = $request->phone;

        }
        if ($request->hasFile('profile_picture_path')){

            $profile_picture_path = $request->file('profile_picture_path')->store('images','public');
    
            $imageUrl = asset('storage/'.$profile_picture_path);

            $user->profile_picture_path = $imageUrl;

        }

        if($request->parent_phone){
            $student->parent_phone = $request->parent_phone;

        }
        if($request->parent_email){
            $student->parent_email = $request->parent_email;

        }
        $user->save();
        $student->save();

        return response()->json([
            'message' => 'updated successfully',
            'user' => $user,
            'student' => $student,
        ]);
    }
    public function EditProfileteacher( Request $request)
    {

        $e = $request->all();
        $validator = Validator::make($e, [
            'email' => 'string|email|unique:users',
            'password' => 'string',
            'phone' => 'string|unique:users',
            'address' => 'string',
            'profile_picture_path' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'cv'=> 'mimes:pdf',
    
        ]);
    
        $user_id = Auth::id();

        $teacher=teacher::where('user_id', $user_id)->first();
        if (!$teacher) {
            return response()->json([
                'message' => 'teacher not found',
            ], 404);
        }

        $user = User::where('id', $teacher->user_id)->first();

        if (!$user) {
            return response()->json([
                'message' => 'user not found',
            ], 404);
        }
        if($request->email){
            $user->email = $request->email;

        }
        if($request->password){
            $user->password = Hash::make($request->password);

        }
        if($request->phone){
            $user->phone = $request->phone;

        }
        if($request->hasFile('cv')){
            $cv = $request->file('cv')->store('images','public');
            $cvurl = asset('storage/'.$cv);
            $teacher->cv=$cvurl;
        
        }
        if ($request->hasFile('profile_picture_path')){

            $profile_picture_path = $request->file('profile_picture_path')->store('images','public');
    
            $imageUrl = asset('storage/'.$profile_picture_path);

            $user->profile_picture_path = $imageUrl;

        }

        $user->save();
        $teacher->save();

        return response()->json([
            'message' => 'updated successfully',
            'user' => $user,
            'teacher' => $teacher,
        ]);
    }
    public function profileAdmin()
    {
        $profile = User::where('role','admin')->get();
        return response()->json($profile);
    }
    public function EditprofileAdmin(Request $request)
    {
            $user = Auth::user();

            if (!$user || $user->role!= 'admin') {
                return response()->json([
                    'essage' => 'You are not an admin',
                ], 403);
            }
            $admin = Admin::where('user_id',$user->id)->first();


                $profile_picture_path = $request->file('profile_picture_path')->store('images', 'public');
                $imageUrl = asset('storage/' . $profile_picture_path);
                $user->profile_picture_path = $imageUrl;

                $admin->update($request->all());
                $admin->save();

            return response()->json([
                'message' => 'Profile updated successfully',
                'admin' => $user,
                'url' => $imageUrl,
            ]);
    }

    public function add_uid_to_user(Request $request){

        $e = $request->all();
        $validator = Validator::make($e, [
            'uid'=>'required|numeric',
            'email' => 'required|string|email',
    
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'user not found',
        ], 404);
        }

        $user->uid = $request->uid;

        $user->save();

        return response()->json([
            'message' => 'added successfully',
    
        ], 200);
    

    }


}
