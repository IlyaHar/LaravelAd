<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::query()->orderBy('created_at', 'desc')->paginate(6);

        return view('home', compact('advertisements'));
    }
}
