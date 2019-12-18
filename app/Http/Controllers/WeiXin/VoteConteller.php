<?php

namespace App\Http\Controllers\WeiXin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoteConteller extends Controller
{
    
   public function index(){
       $data=$_GET;
       dd($data);
   }
}
