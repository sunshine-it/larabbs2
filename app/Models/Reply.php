<?php

namespace App\Models;

// 数据模型类
class Reply extends Model
{
    // 只允许用户更改 content 字段
    protected $fillable = ['content'];

    public function topic()
    {
        // 数据模型的关联，一条回复属于一个话题
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        // 一个条回复属于一个作者所有
        return $this->belongsTo(User::class);
    }

}
