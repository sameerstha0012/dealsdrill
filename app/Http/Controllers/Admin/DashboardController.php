<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $available = Product::where([['status', '=', 'Avaliable']])->count();
        $total = Product::count();
        $users = User::where([['status', '=', 'Active']])->count();
            
        return view('admin.pages.dashboard', compact('available', 'total', 'users'));
    }
}
