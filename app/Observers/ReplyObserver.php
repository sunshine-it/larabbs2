<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

// 模型监控器类
class ReplyObserver
{
    // 创建回复后事件（回复数加一）
    public function created(Reply $reply)
    {
        $topic = $reply->topic;
        // 当新增话题回复时,话题的 reply_count 做 +1 处理
        $topic->increment('reply_count', 1);
        // 通知作者话题被回复了
        $topic->user->notify(new TopicReplied($reply));

        // 如果评论的作者不是话题的作者，才需要通知
        // if ( ! $reply->user->isAuthorOf($topic)) {
        //     $topic->user->notify(new TopicReplied($reply));
        // }
    }
    // 过滤xss攻击
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function updating(Reply $reply)
    {
        //
    }
    // deleted() 方法来监控『回复删除后』事件
    public function deleted(Reply $reply)
    {
        // 当回复被删除后,话题的 reply_count 也需要 -1 处理
        $reply->topic->decrement('reply_count', 1);
    }

}