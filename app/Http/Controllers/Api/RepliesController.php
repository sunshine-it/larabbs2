<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use App\Models\Reply;
use App\Models\User;
use App\Http\Requests\Api\ReplyRequest;
use App\Transformers\ReplyTransformer;

// 话题回复控制器类
class RepliesController extends Controller
{
    // 话题回复列表方法（游客可访问）
    public function index(Topic $topic)
    {
        // 分页查询话题的所有评论，
        $replies = $topic->replies()->paginate(20);
        // 使用 ReplyTransformer 转换评论数据并返回
        return $this->response->paginator($replies, new ReplyTransformer());
    }
    // 某个用户回复列表（游客可访问）
    public function userIndex(User $user)
    {
        // 分页查询用户的所有评论，
        $replies = $user->replies()->paginate(20);
        // 使用 ReplyTransformer 转换评论数据并返回
        return $this->response->paginator($replies, new ReplyTransformer());
    }

    // 添加回复
    public function store(ReplyRequest $request, Topic $topic, Reply $reply)
    {
        $reply->content = $request->content;
        $reply->topic_id = $topic->id;
        $reply->user_id = $this->user()->id;
        $reply->save();
        return $this->response->item($reply, new ReplyTransformer())
                    ->setStatusCode(201);
    }

    // 删除回复
    public function destroy(Topic $topic, Reply $reply)
    {
        if ($reply->topic_id != $topic->id) {
            return $this->response->errorBadRequest();
        }
        $this->authorize('destroy', $reply);
        $reply->delete();
        return $this->response->noContent();
    }
}
