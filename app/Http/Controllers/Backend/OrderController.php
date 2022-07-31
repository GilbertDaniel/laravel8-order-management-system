<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Utils\OrderUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $orderUtil;
    /**
     * Constructor
     *
     * @param OrderUtils $order
     * @return void
     */

    public function __construct(OrderUtil $orderUtil)
    {
        $this->orderUtil = $orderUtil;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate();

        return view('backend.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Item::select('id', 'name', 'price')
            ->get();
        return view('backend.order.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        // creating order
        $order = Order::create([
            'final_total' => $request->final_total,
        ]);

        if ($order) {
            $order_no = $this->orderUtil->generateOrderNo($order->id);
            $order->order_no = $order_no;
            $order->save();

            $total_items = count($request->product_id);
            for ($i = 0; $i < $total_items; $i++) {
                // creating order lines
                $order_detail = OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $request->product_id[$i],
                    'price' => $request->price[$i],
                    'quantity' => $request->quantity[$i],
                    'sub_total' => $request->sub_total[$i],

                ]);
            }

        }

        DB::commit();

        return redirect()->route('orders')->with('message', 'Data Saved Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        $products = Item::select('id', 'name', 'price')
            ->get();

        return view('backend.order.edit', compact('order', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $total_items = $request->product_id;

        DB::beginTransaction();

        $order = Order::find($id);
        $order->update([
            'final_total' => $request->final_total
        ]);

        for ($i=0; $i < count($total_items); $i++) {

            $update_data = [
                'product_id'=> $request->product_id[$i],
                'price'=> $request->price[$i],
                'quantity' => $request->quantity[$i],
                'sub_total'=> $request->sub_total[$i],
            ];
            # code...
            DB::table('order_details')
              ->where('order_id', $id)
              ->update($update_data);
        }

        DB::commit();

        return redirect()->route('orders')->with('message', 'Data Saved Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        DB::beginTransaction();

        $order = Order::where('id', $id)
            ->with(['order_details'])
            ->first();

        $deleted_order_line = $order->order_details;
        $deleted_order_line_ids = $deleted_order_line->pluck('id')->toArray();
        $order->delete();
        OrderDetail::whereIn('id', $deleted_order_line_ids)->delete();

        DB::commit();

        return redirect()->route('orders')->with('message', 'Data deleted successfully.');
    }
}
