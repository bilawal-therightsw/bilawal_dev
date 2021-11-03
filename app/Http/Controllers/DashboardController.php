<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index(){
        try {
            $user_count = User::where('user_type',User::User)->count();
            $staff_count = User::where('user_type',User::Staff)->count();
            $product_count = Product::count();
            return view('dashboard',compact('user_count','staff_count','product_count'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
