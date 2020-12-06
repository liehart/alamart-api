<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $barang = Barang::all();

        if (count($barang) > 0)
            return $this->sendResponse($barang, "Mengambil barang sukses");

        return $this->sendError("Barang kosong");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validator = Validator::make($request->all(), [
            'nama' => 'required|',
            'harga' => 'required',
            'deskripsi' => 'required',
        ]);
        if($validator->fails())
            return $this->sendError('Validation error', $validator->errors());

        $barang = Barang::create($storeData);

        return $this->sendResponse($barang, "Barang berhasil ditambah");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barang = Barang::find($id);

        if ($barang)
            return $this->sendResponse($barang, "Mengambil barang sukses");

        return $this->sendError("Barang tidak ditemukan");
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
        $barang = Barang::find($id);

        if (!$barang)
            return $this->sendError("Barang tidak ditemukan");

        $storeData = $request->all();
        $validator = Validator::make($request->all(), [
            'nama' => 'required|',
            'harga' => 'required',
            'deskripsi' => 'required',
        ]);
        if($validator->fails())
            return $this->sendError('Validation error', $validator->errors());

        $barang = Barang::find($id);

        $barang->nama = $storeData['nama'];
        $barang->harga = $storeData['harga'];
        $barang->deskripsi = $storeData['deskripsi'];

        $barang->save();

        return $this->sendResponse($barang, "Barang berhasil ditambah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::find($id);

        if ($barang) {
            $barang->delete();
            return $this->sendResponse(null, "Menghapus barang sukses");
        }

        return $this->sendError("Barang tidak ditemukan");
    }
}
