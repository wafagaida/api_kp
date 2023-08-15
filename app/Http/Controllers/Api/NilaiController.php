<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(){
        return response()->json(Nilai::orderBy('nis', 'ASC')->get());
    }
}
