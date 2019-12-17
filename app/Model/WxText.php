<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WxText extends Model
{
    protected $table = "wx_text";
    protected $primaryKey = "text_id";

    public function WxUserModel()
    {
        return $this->belongsTo(WxUserModel::class);
    }
}
