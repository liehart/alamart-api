<?php

namespace App\Http\Controllers\API;

use App\Models\Item;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $transaksi = Transaksi::all();

        if(count($transaksi)>0)
            return $this->sendResponse($transaksi, "Get transactions success");

        return $this->sendError("No transactions available");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $userid = 2; //Auth::guard('api')->user()->id;
        $storeData = $request->all();
        $validator = Validator::make($request->all(), [
            'alamat_pengiriman' => 'required',
            'tanggal_pengiriman' => 'required',
            'items.*.id' => 'required|numeric|exists:items,id,deleted_at,NULL',
            'items.*.quantity' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }

        $items = $storeData['items'];
        $storeData['harga'] = 0;

        $storeData['user_id'] = $userid;

        foreach ($items as $item) {
            $harga = Item::find($item['id'])->harga;
            $storeData['harga'] += $item['quantity'] * $harga;
        }

        $transaksi = Transaksi::create($storeData);

        foreach ($items as $item) {
            $item['item_id'] = $item['id'];
            $item['transaksi_id'] = $transaksi['id'];
            TransaksiItem::create($item);
        }

        return $this->sendResponse($transaksi, 'Order created');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $transaksi = Transaksi::find($id);

        if ($transaksi)
            return $this->sendResponse($transaksi, 'Transaction retrieved successfully');

        return $this->sendError("Transaction not found");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);

        if (is_null($transaksi))
            return $this->sendError('Transaction not found');

        $transaksi->delete();

        return $this->sendResponse(null, 'Transaction deleted successfully.');
    }
}
