<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        //initialize midtrans payment gateway
        $this->_midtrans_init();
    }

    public function index()
    {
        $ownerId = Auth::guard('admin')->user()->id;
        $data = Order::with(['transaction', 'order_details'])->where('order_from', $ownerId)->get();

        if(count($data) > 0) {

            foreach ($data as $key => $value) {
                $transactions[] = $data[$key]->transaction;
                $order_details[] = $data[$key]->order_details[0];
            }
    
            foreach ($order_details as $key => $value) {
                $products[] = Product::where('id', $order_details[$key]->product_id)->get();
            }
    
            foreach ($products as $key => $value) {
                $x[] = $products[$key][0];
            }
            $products = $x;
            unset($x);
        } else {
            $transactions = [];
            $order_details = [];
            $products = [];
        }

        return view('pages.admin.transactions.index', compact(['transactions', 'order_details', 'products']));
    }

    public function checkout()
    {
        return view('pages.checkout');
    }

    public function token(Request $request)
    {

        //GET PRODUCT INFO
        $product = Product::findOrFail($request->input('product_id'));

        error_log('masuk ke snap token dri ajax');

        $time = time();
        $params = array(
            'transaction_details' => array(
                'order_id' => uniqid("IYN"),
                'gross_amount' => 0,
            ),

            "enabled_payments" => array(
                "bca_va",
                "gopay",
                "indomaret"
            ),

            'customer_details' => array( //DATA MASIH STATIS
                'first_name' => 'customer',
                'last_name' => '1',
                'email' => 'customer@example.com',
                'phone' => '08111222333',
                'shipping_address' => array(
                    'first_name'    => "customer",
                    'last_name'     => "1",
                    'email'         => 'customer@example.com',
                    'phone'         => '08111222333',
                    'address'       => "Bakerstreet 221B.",
                    'city'          => "Jakarta",
                    'postal_code'   => "51162",
                    'country_code'  => 'IDN'

                ),
                "billing_address" => array(
                    "first_name"    => "customer",
                    "last_name"     => "1",
                    'email'         => 'customer@example.com',
                    'phone'         => '08111222333',
                    'address'       => "Bakerstreet 221B.",
                    'city'          => "Jakarta",
                    'postal_code'   => "51162",
                    'country_code'  => 'IDN'
                ),
            ),

            "credit_card" => array(
                "secure" => true
            ),

            'expiry' => array(
                'start_time' => date("Y-m-d H:i:s O", $time),
                'unit'       => 'hour',
                'duration'   => 24
            ),

            'item_details' => array(
                array(
                    'id'        => 'item2',
                    'price'     => $product->price,
                    'quantity'  => $request->input('quantity'),
                    'name'      => $product->name
                )
            )
        );

        try { //Return snap token if success
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Throwable $err) {
            return $err;
        }
    }

    public function finish(Request $request)
    {

        $order_data = $request->input('order_data');
        $order_data = json_decode($order_data, true);

        $result = $request->input('result_data');
        $result = ((array) json_decode($result));
        // dd($result);
        try {
            $va_number = ((array) $result['va_numbers'][0]);
        } catch (\Throwable $th) {
            $va_number = [
                'va_number' => '',
                'bank' => ''
            ];
        }

        // Add New Transaction
        $newTransaction = new Transaction;
        $newTransaction->id = $result['transaction_id'];
        $newTransaction->status_code = $result['status_code'];
        $newTransaction->status_message = $result['status_message'];
        $newTransaction->transaction_time = $result['transaction_time'];
        $newTransaction->transaction_status = $result['transaction_status'];
        $newTransaction->fraud_status = $result['fraud_status'];
        $newTransaction->pdf_url = $result['pdf_url'];
        $newTransaction->save();

        if ($newTransaction) {

            //Add Payment
            $payment_data = array(
                'transaction_id' => $newTransaction->id,
                'payment_type' => $result['payment_type'],
                'va_number' => $va_number['va_number'],
                'bank' => $va_number['bank'],
                'gross_amount' => $result['gross_amount']
            );
            Payment::create($payment_data);

            //Add Order & Order Details
            $orderData = array(
                'transaction_id' => $newTransaction->id,
                'order_from' => 2, // DATA MASIH STATiS
                'customer_id' => 1, // DATA MASIH STATIS
                'status' => $result['transaction_status'],
            );
            $order = Order::create($orderData);

            $order_details_data = array(
                'product_id' => $order_data['product_id'], // DATA MASIH STATIS
                'quantity' => $order_data['quantity'],
                'order_id' => $order->id
            );
            $order->order_details()->create($order_details_data);

            //Add Shipment
            $shipment_data = array( //DATA ARRAY MASIH STATIS
                'transaction_id' => $newTransaction->id,
                'first_name'    => "customer",
                'last_name'     => "1",
                'email'         => 'customer@example.com',
                'phone'         => '08111222333',
                'address'       => "Bakerstreet 221B.",
                'city'          => "Jakarta",
                'postal_code'   => "51162",
                'country_code'  => 'IDN'

            );
            Shipment::create($shipment_data);
        }


        return "berhasil";
    }

    public function notification(Request $request)
    {

        $notif = new \Midtrans\Notification();

        $transaction = $notif->transaction_status;
        $transaction_id = $notif->transaction_id;
        $status_code = $notif->status_code;
        $fraud = $notif->fraud_status;

        // error_log("Order ID = $notif->order_id: " . "transaction status = $transaction, fraud staus = $fraud" . 
        // " Trans ID = $transaction_id" . " Status code = $status_code" . " Status Message = $notif->status_message");

        if ($transaction == 'settlement') {
            if ($fraud == 'challenge') {
                // TODO Set payment status in merchant's database to 'challenge'
                Transaction::where('id', strval($transaction_id))->update([
                    'status_code' => $status_code,
                    'transaction_status' => $transaction,
                    'status_message' => 'Transaksi berhasil'
                ]);
            } else if ($fraud == 'accept') {
                // TODO Set payment status in merchant's database to 'success'
                Transaction::where('id', strval($transaction_id))->update([
                    'status_code' => $status_code,
                    'transaction_status' => $transaction,
                    'status_message' => 'Transaksi berhasil'
                ]);
            }
        } else if ($transaction == 'cancel') {
            if ($fraud == 'challenge') {
                // TODO Set payment status in merchant's database to 'failure'
                Transaction::where('id', strval($transaction_id))->update([
                    'status_code' => $status_code,
                    'transaction_status' => $transaction,
                    'status_message' => 'Transaksi gagal'
                ]);
            } else if ($fraud == 'accept') {
                // TODO Set payment status in merchant's database to 'failure'
                Transaction::where('id', strval($transaction_id))->update([
                    'status_code' => $status_code,
                    'transaction_status' => $transaction,
                    'status_message' => 'Transaksi gagal'
                ]);
            }
        } else if ($transaction == 'deny') {
            // TODO Set payment status in merchant's database to 'failure'
            Transaction::where('id', strval($transaction_id))->update([
                'status_code' => $status_code,
                'transaction_status' => $transaction,
                'status_message' => 'Transaksi gagal'
            ]);
        } else if ($transaction == 'expire') {
            if ($fraud == 'challenge') {
                // TODO Set payment status in merchant's database to 'failure'
                Transaction::where('id', strval($transaction_id))->update([
                    'status_code' => $status_code,
                    'transaction_status' => $transaction,
                    'status_message' => 'Transaksi gagal'
                ]);
            } else if ($fraud == 'accept') {
                // TODO Set payment status in merchant's database to 'failure'
                Transaction::where('id', strval($transaction_id))->update([
                    'status_code' => $status_code,
                    'transaction_status' => $transaction,
                    'status_message' => 'Transaksi gagal'
                ]);
            }
        }
    }
}
