<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GlobalSupport;

class GetSupportController extends Controller
{
    public function index()
    {
        $data = GlobalSupport::get()->first();

        return view('customer.support', compact('data'));
    }
}
