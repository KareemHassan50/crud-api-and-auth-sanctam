<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Faker\Core\Number;
use Illuminate\Http\Request;

class NumbersController extends Controller
{
    public function index(Request $req)
    {
        $data1 = (int)$req->number1;
        $data2 = (int)$req->number2;

        // echo gettype($data1);
        echo $data1 . " " . $data2;
        // $sum = 0;
        // for ($i = 0; $i = $data2; $i++) {
        //     $sum += $i;
        // }
        // echo $sum;
        // return response($sum);
    }
}