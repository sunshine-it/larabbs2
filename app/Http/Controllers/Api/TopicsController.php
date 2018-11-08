<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Transformers\TopicTransformer;
use App\Http\Requests\Api\TopicRequest;
use App\Models\User;

// 话题控制器类
class TopicsController extends Controller
{
    // 话题列表游客可以访问
    public function index(Request $request, Topic $topic)
    {
        $query = $topic->query();

        if ($categoryId = $request->category_id) {
            $query->where('category_id', $categoryId);
        }

        // 为了说明 N+1问题，不使用 scopeWithOrder
        switch ($request->order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }
        $topics = $query->paginate(20);
        return $this->response->paginator($topics, new TopicTransformer());
    }
    // 某个用户的发布的话题
    public function userIndex(User $user, Request $request)
    {
        $topics = $user->topics()->recent()->paginate(20);
        return $this->response->paginator($topics, new TopicTransformer());
    }

    // 话题详情
    public function show(Topic $topic)
    {
        return $this->response->item($topic, new TopicTransformer());
    }

    // 添加话题
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $this->user()->id;
        $topic->save();
        return $this->response->item($topic, new TopicTransformer())
                    ->setStatusCode(201);
    }
    // 修改话题
    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());
        return $this->response->item($topic, new TopicTransformer());
    }
    // 删除话题
    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();
        return $this->response->noContent();
    }
}