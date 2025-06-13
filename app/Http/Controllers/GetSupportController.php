<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Support;

class GetSupportController extends Controller
{
    public function index()
    {
        $data = Support::get()->first();

        return view('customer.support', compact('data'));
    }
}
