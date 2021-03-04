<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth:admin')->except('logout');

    }

    public function dashboard() {
        return view('pages.dashboard');
    }

    public function getDashboardInfo() {
        $admin = Auth::guard('admin')->user()->id;

        $data = Order::with(['transaction'])->orderBy('id','DESC')->where('order_from', $admin)->get();
        $order = Order::orderBy('id', "DESC")->where('order_from', $admin)->get();

        foreach ($data as $key => $value) {
            $transactions[] = $data[$key]->transaction;
        }

        $income = 0;
        // Kalau status transaksi sukses hitung total pendapatan
        foreach ($transactions as $key => $value) {
            if($transactions[$key]->status_code == 200) {
                $income += $transactions[$key]->payment->gross_amount; 
            }
        } 

        return response()->json([
            "transactions"  => $transactions,
            "income" => $income,
            "orders" => $order
        ]);
    }
}
