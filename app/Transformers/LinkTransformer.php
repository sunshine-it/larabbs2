<?php

namespace App\Transformers;

use App\Models\Link;
use League\Fractal\TransformerAbstract;

// 资源推荐接口类
class LinkTransformer extends TransformerAbstract
{
    public function transform(Link $link)
    {
        return [
            'id' => $link->id,
            'title' => $link->title,
            'link' => $link->link,
        ];
    }
}