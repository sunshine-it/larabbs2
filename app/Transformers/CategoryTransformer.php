<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

// 帖子|话题改变类
class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description,
        ];
    }
}