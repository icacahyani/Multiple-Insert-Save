<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Customer;
use App\Product;
use App\Sales;

class InvoiceController extends Controller
{
    //
    public function index()
    {
    	$product_list = Product::pluck('productname', 'id');
    	return view('invoice.info', compact('product_list'));
    }

    public function create(Request $request)
    {
    	$customer = new Customer;
        $customer->firstname = $request->fn;
        $customer->lastname = $request->ln;
        $customer->sex = $request->sex;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->location = $request->location;

        if($customer->save()){
            $id = $customer->id;
            foreach ($request->productname as $key => $v) {
                $data = array('cus_id' => $id,
                              'pro_id' => $v,
                              'qty' => $request->qty [$key],
                              'price' => $request->price [$key],
                              'dis' => $request->dis [$key],
                              'amount' => $request->amount [$key]);
                Sales::create($data);
            }
        }
        return redirect('/');
    }

    public function edit()
    {
    	return view('invoice.update');
    }

    public function update()
    {
        
    }

    public function findPrice(Request $request)
    {
        $data = Product::select('price')->where('id', $request->id)->first();
        return response()->json($data);

    }
}
