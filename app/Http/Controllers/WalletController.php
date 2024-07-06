<?php

namespace App\Http\Controllers;

use App\Models\about_wallet;
use App\Models\student;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewFee;
use App\Models\Fee;

class WalletController extends Controller
{

    public function create_fee(Request $request)
    {

        $request->validate([

            'fee_name' => 'required|string',
            'benifats' => 'required|numeric|min:0',
        ]);

        $fee_name = $request->input('fee_name');
        $benifats = $request->input('benifats');

        $due_date = now()->addMonth()->format('y-m-d');


        $fee = Fee::create([
            'fee_name' => $fee_name,
            'benifats' => $benifats,
            'due_date' => $due_date,
        ]);

        $students = student::all();

        foreach ($students as $student) {
            $student->remain += $benifats;
            $student->save();
        }

        return response()->json([
            'message' => trans('success'),
            'data' => $fee,
        ]);
    }

    public function deposit_wallet(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'description' => 'required',
        ]);

        $student = Student::find($request->input('student_id'));

        if (!$student) {
            return response()->json([
                'message' => 'student not found',
            ], 404);
        }

        $amount = $request->input('amount');
        $description = $request->input('description');

        $student->wallet_balance += $amount;
        $student->save();

        $wallet_info = about_wallet::create([
            'student_id' => $student->id,
            'description' => $description,
            'amount' => $amount,
        ]);

        return response()->json([
            'message' => 'deposit successfully',
            'data' => $wallet_info,
        ]);
    }
    public function paid_fees(Request $request)
    {
      $request->validate([
        'amount'=>'required|numeric|min:0',
        'description'=>'required|string',
        ]);

        $user = auth()->user();
        if (!$user) {
            return response()->json('you are not auth', 401);
        }
        $student = $user->student;
        if (!$student) {

            return response()->json('You are not student', 403);
        }


        $amount = $request->input('amount');
        $description = $request->input('description');



        // Check if the user has already paid the fee
        if ($student->remain == 0) {
            return response()->json(['message' => 'you do not have any Fee for paid it']);

        } else if ($student->remain < $amount) {

            return response()->json([
                'message' => "you now pay more than your fees please {$student->remain} "
            ]);
        } else  if ($student->remain >= $amount) {

            $student->remain -= $amount;
            $student->save();


        if ($student->wallet_balance >= $amount) {

            $student->wallet_balance -= $amount;
            $student->save();
            // Save the updated benifats value
        } else {
            return response()->json([
                'message' => 'you do not have enough money for this operation please deposit in your wallet'
            ]);
        }

        $wallet_info =   about_wallet::create([
            'student_id' => $student->id,
            'description' => $description,
            'amount' => $amount,

        ]);


        return response()->json([
            'message' => 'success operation',
            'data' => $wallet_info,
        ]);
        }
    }
    public function show()
    {
        $user_id = Auth::id();
        $studentId = DB::table('students')
            ->where('user_id', $user_id)
            ->value('id');
        $balance = student::where('id', $studentId)->get(['wallet_balance','remain']);
        $operation = about_wallet::where('student_id', $studentId)->get();
        return response()->json([
            'balance' => $balance,
            'operation' => $operation,
        ]);
    }

    public function all_wallet_balance()
    {
        $students = student::all();

        $totalBalance = [];
        foreach ($students as $student) {
            $totalBalance[$student->id] = $student->wallet_balance;
        }
        $sum_balance = $students->sum('wallet_balance');
        return response()->json([
            'Balance' => $totalBalance,
            'sum' => $sum_balance,
        ]);
    }


}
