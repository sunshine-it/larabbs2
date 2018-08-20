<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
        // 只允许作者编辑除话题
        return $user->isAuthorOf($topic);
    }

    public function destroy(User $user, Topic $topic)
    {
        // 只允许作者删除话题
        return $user->isAuthorOf($topic);
    }
}
