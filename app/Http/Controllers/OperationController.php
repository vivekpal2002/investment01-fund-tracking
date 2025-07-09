<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperationController extends Controller
{
    public function wallet(){
        return view('contents.wallet');
    }
    public function expenses(){
        return view('contents.expenses');
    }
    public function mutualfunds(){
        return view('contents.mutualfunds');
    }
    public function goal(){
        return view('contents.goal');
    }
    public function report(){
        return view('contents.reports');
    }
    public function calender(){
        return view('contents.calender');
    }


}
