<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;

// 分类控制器
class CategoriesController extends Controller
{
    //
    public function show(Category $category, Request $request, Topic $topic)
    {
        // 读取分类 ID 关联的话题 -分享，并按每 20 条分页
        $topics = $topic->withOrder($request->order)
                        ->with('user', 'category')
                        ->where('category_id', $category->id)
                        ->paginate(20);

        // 传参变量话题和分类到模板中
        return view('topics.index', compact('topics', 'category'));
    }
}
