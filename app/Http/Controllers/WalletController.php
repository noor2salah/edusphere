<?php

namespace App\Http\Controllers;

use App\Models\about_wallet;
use App\Models\student;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
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
    public function withdraw_wallet(Request $request)
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
        if ($student->wallet_balance >= $amount) {
            $student->wallet_balance -= $amount;
            $student->save();

            $wallet_info =   about_wallet::create([
                'student_id' => $student->id,
                'description' => $description,
                'amount' => $amount,
            ]);

            return response()->json([
                'message' => 'success operation',
                'data' => $wallet_info,
            ]);
        } else {
            return response()->json('failed');
        }
    }
    public function show()
    {
        $user_id = Auth::id();
        $studentId = DB::table('students')
            ->where('user_id', $user_id)
            ->value('id');
        $balance = student::where('id',$studentId)->get('wallet_balance');
        $walletOperations = about_wallet::where('student_id', $studentId)->get(['id', 'amount', 'description']);

        return response()->json([
            'balance'=>$balance,
            'Data' => $walletOperations,

        ]);
    }
    public function all_wallet_balance()
    {
        $students = student::all();

        $totalBalance=[];
        foreach($students as $student)
        {
            $totalBalance[$student->id] = $student->wallet_balance;

        }
        $sum_balance = $students->sum('wallet_balance');
        return response()->json([
            'Balance'=>$totalBalance,
            'sum' =>$sum_balance,
        ]);
    }
}
