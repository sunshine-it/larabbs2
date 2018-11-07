<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Transformers\CategoryTransformer;

// 分类列表控制器类
class CategoriesController extends Controller
{
    public function index()
    {
        // 分类数据是集合，所以这里使用 $this->response->collection 返回数据
        return $this->response->collection(Category::all(), new CategoryTransformer());
    }
}
