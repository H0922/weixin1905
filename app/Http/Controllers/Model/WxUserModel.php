<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WxUserModel extends Controller
{
    protected $table = "wx_user";
    protected $primaryKey = "user_id";
}
