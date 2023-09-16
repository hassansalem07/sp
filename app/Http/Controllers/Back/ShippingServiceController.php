<?php

namespace App\Http\Controllers\Back;

use App\{
    Models\ShippingService,
    Http\Requests\ShippingServiceRequest,
    Http\Controllers\Controller
};
use App\Models\Currency;
use App\Models\ShippingCity;

class ShippingServiceController extends Controller
{
    /**
     * Constructor Method.
     *
     * Setting Authentication
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('adminlocalize');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('back.shipping.index',[
            'datas' => ShippingCity::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShippingServiceRequest $request)
    {
        $input = $request->all();
        $curr = Currency::where('is_default',1)->first();
        $input['price'] = $request->price / $curr->value;

        ShippingCity::create($input);

        return redirect()->route('back.shipping.index')->withSuccess(__('New Shipping Service Added Successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingCity $shipping)
    {
        return view('back.shipping.edit',compact('shipping'));
    }


    /**
     * Change the status for editing the specified resource.
     *
     * @param  int  $id
     * @param  int  $status
     * @return \Illuminate\Http\Response
     */
    public function status($id,$status)
    {
        ShippingCity::find($id)->update(['status' => $status]);
        // ShippingCity::where('id','!=',$id)->where('id','!=',1)->update(['status' => 0]);
        
        return redirect()->route('back.shipping.index')->withSuccess(__('Status Updated Successfully.'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShippingServiceRequest $request, ShippingCity $shipping)
    {
        $input = $request->all();
        $curr = Currency::where('is_default',1)->first();
        // if($shipping->id == 1){
        //     if($request->is_condition){
        //         $input['is_condition'] = 1;
        //         $input['minimum_price'] = $request->minimum_price / $curr->value;
        //     }else{
        //         $input['is_condition'] = 0;
        //         $input['minimum_price'] = 0;
        //     }
        // }
        
        // $input['price'] = $request->price / $curr->value;

        $shipping->update($input);

        return redirect()->route('back.shipping.index')->withSuccess(__('Shipping City Updated Successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingCity $shipping)
    {
        $shipping->delete();
        return redirect()->route('back.shipping.index')->withSuccess(__('Shipping City Deleted Successfully.'));
    }
}
