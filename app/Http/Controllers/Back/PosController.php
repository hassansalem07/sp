<?php

namespace App\Http\Controllers\Back;

use App\Helpers\PriceHelper;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Category;
use App\Models\Item;
use App\Models\Order;
use App\Models\PosOrder;
use App\Models\PosOrderProduct;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PosController extends Controller
{

    public function index()
    {
        $pos_orders = PosOrder::with('order_products')->orderBy('id','desc')->get();
       return view('pos.index',compact('pos_orders'));
    }


    public function order_products($order)
    {
        $products = PosOrderProduct::where('pos_order_id',$order)->get();
        return view('pos.products',compact('products'));
    }


    public function invoice($order)
    {
        $order = PosOrder::with('order_products')->where('id',$order)->first();
        return view('pos.invoice',compact('order'));
    }


    public function create()
    {
        $categories = Category::with('items')->get();
        return view('pos.create',compact('categories'));

    }

    public function store(Request $request)
    {
        $sub_total = floatval(preg_replace("/[^-0-9\.]/","",$request->sub_total));
        $discount = floatval($request->discount);
        $pos_order = PosOrder::create([
            'transaction_number' => Str::random(10),
            'sub_total' => $sub_total,
            'discount' => $discount,
            'total' => $sub_total - $discount,
            'notes' => $request->notes,
        ]);

        foreach ($request->products as $key => $product) {
           $order_details= PosOrderProduct::create([
                'pos_order_id' => $pos_order->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'sizes' => $product['size'],
            ]);

            $item = Item::where('id',$product['id'])->first();
            $item->stock -= $product['quantity'];
            $item->save();
        }

        return redirect()->route('pos.index');
    }


    public function sub_category(Request $request)
    {
        $sub_categories = Subcategory::where('category_id',$request->main_id)->get();
        $products = Item::with(['attributes.options' => function($q){
            $q->where('stock','>',0);
        }])->where('category_id',$request->main_id)->get();
       return response()->json([
           'sub_categories' => $sub_categories,
           'products' => $products
           ]);
    }


    public function get_sub_category_products(Request $request)
    {
        $products = Item::with(['attributes.options' => function($q){
            $q->where('stock','>',0);
        }])->where('subcategory_id',$request->sub_id)->get();
       return response()->json([
           'products' => $products
           ]);
    }





}
