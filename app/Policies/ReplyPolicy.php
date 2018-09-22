<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

// 策略类
class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        // return $reply->user_id == $user->id;
        return true;
    }
    // 处理回复策略，实现权限控制
    public function destroy(User $user, Reply $reply)
    {
        // 拥有删除回复权限的用户，应当是『回复的作者』或者『回复话题的作者』
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
