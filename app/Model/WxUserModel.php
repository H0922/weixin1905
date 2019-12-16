<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WxUserModel extends Model
{
    protected $table = "wx_user";
    protected $primaryKey = "user_id";
    
   
    public function WxText()
    {
        return $this->hasOne(WxText::class);
    }
}
