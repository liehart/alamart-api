<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RequestBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RequestBarangController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = RequestBarang::all();

        if (count($barang) > 0)
            return $this->sendResponse($barang, "Mengambil barang sukses");

        return $this->sendError("Barang kosong");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'harga' => 'required|numeric',
            'keterangan' => 'required',
        ]);
        if($validator->fails())
            return $this->sendError('Validation error', $validator->errors());

        $barang = RequestBarang::create($storeData);

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
        $barang = RequestBarang::find($id);

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
        $barang = RequestBarang::find($id);

        if (!$barang)
            return $this->sendError("Barang tidak ditemukan");

        $storeData = $request->all();
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'harga' => 'required|numeric',
            'keterangan' => 'required',
        ]);
        if($validator->fails())
            return $this->sendError('Validation error', $validator->errors());

        $barang->nama = $storeData['nama'];
        $barang->harga = $storeData['harga'];
        $barang->keterangan = $storeData['keterangan'];

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
        $barang = RequestBarang::find($id);

        if ($barang) {
            $barang->delete();
            return $this->sendResponse(null, "Menghapus barang sukses");
        }

        return $this->sendError("Barang tidak ditemukan");
    }
}
