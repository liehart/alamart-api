<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\RequestBarang;
use Illuminate\Http\Request;

class RequestBarangController extends Controller
{
    public function index()
    {
        $request = RequestBarang::orderBy('id', 'ASC')->get();

        return view('request.index', compact('request'));
    }
}
