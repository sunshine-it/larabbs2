<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 图片模型
class Image extends Model
{
    protected $fillable = ['type', 'path'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
