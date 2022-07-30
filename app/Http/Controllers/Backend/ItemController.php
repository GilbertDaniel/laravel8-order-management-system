<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\backend\ItemRequest;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Utils\ItemUtil;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    protected $itemUtil;
    /**
     * Constructor
     *
     * @param ItemUtils $item
     * @return void
     */

    public function __construct(ItemUtil $itemUtil)
    {
        $this->itemUtil = $itemUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::paginate();
        return view('backend.item.index', compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $sku = $this->itemUtil->generateItemSku('sku1');

        // echo $sku;
        $categories = ItemCategory::all();
        return view('backend.item.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        $item = Item::create([
            'name' => $request->name,
            'price' => $request->price,
            'category_id'=> $request->category_id,
            'description' => $request->description

        ]);

        if($item){
            $sku = $this->itemUtil->generateItemSku($item->id);
                $item->sku = $sku;
                $item->save();
        }

        return redirect()->route('items')->with('message', 'Data Saved Successfully');
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
        $item = Item::find($id);
        $categories = ItemCategory::all();

        return view('backend.item.edit', compact('item','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemRequest $request, $id)
    {
        $item = Item::find($id);
        $item->update([
            'name' => $request->name,
            'price' => $request->price,
            'category_id'=> $request->category_id,
            'description' => $request->description
        ]);
        return redirect()->route('items')->with('message', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();

        return redirect()->route('items')->with('message', 'Data deleted successfully.');
    }
}
