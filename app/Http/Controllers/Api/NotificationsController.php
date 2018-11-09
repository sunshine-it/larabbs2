<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Transformers\NotificationTransformer;

// 消息通知控制器类
class NotificationsController extends Controller
{
    // 消息通知列表
    public function index()
    {
        // 分页查询消息通知的所有消息，
        $notifications = $this->user->notifications()->paginate(20);
        // dd($notifications);
        return $this->response->paginator($notifications, new NotificationTransformer());
    }
}
