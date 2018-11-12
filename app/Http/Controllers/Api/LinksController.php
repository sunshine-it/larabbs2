<?php

namespace App\Http\Controllers\Api;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Transformers\LinkTransformer;

// 资源推荐控制器类
class LinksController extends Controller
{
    //
    public function index(Link $link)
    {
        $links = $link->getAllCached();
        // dd($links);
        return $this->response->collection($links, new LinkTransformer());
    }
}
