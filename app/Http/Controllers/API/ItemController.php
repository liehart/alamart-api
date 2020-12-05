<?php

namespace App\Http\Controllers\API;

use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ItemController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $products = Item::all();

        if(count($products)>0)
            return $this->sendResponse($products, "Get products success");

        return $this->sendError("No products available");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validator = Validator::make($storeData,[
            'nama' => 'required|max:60',
            'deskripsi' => 'required',
            'harga' => 'required|numeric'
        ]);

        if($validator->fails())
            return $this->sendError('Validation error', $validator->errors());

        $product = Item::create($storeData);

        return $this->sendResponse($product, 'Product created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $product=Item::find($id);

        if (is_null($product))
            return $this->sendError('Product not found');

        return $this->sendResponse($product, 'Product retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $product = Item::find($id);

        if (is_null($product))
            return $this->sendError('Product not found');

        $storeData = $request->all();
        $validator = Validator::make($storeData,[
            'nama' => 'required|max:60|unique:products',
            'deskripsi' => 'required|alpha',
            'harga' => 'required|numeric'
        ]);

        if($validator->fails())
            return $this->sendError('Validation error', $validator->errors());

        $product->nama = $storeData['nama'];
        $product->deskripsi = $storeData['deskripsi'];
        $product->harga = $storeData['harga'];

        $product->save();

        return $this->sendResponse($product, 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        $product = Item::find($id);

        if (is_null($product))
            return $this->sendError('Product not found');

        $product->delete();

        return $this->sendResponse(null, 'Product deleted successfully.');
    }
}
