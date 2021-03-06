<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Spatie\Permission\Traits\HasRoles;

// 用户模型
class User extends Authenticatable implements JWTSubject
{
    // 最近活跃时间
    use Traits\LastActivedAtHelper;
    // 活跃用户
    use Traits\ActiveUserHelper;

    use HasRoles;

    use Notifiable {
        notify as protected laravelNotify;
    }

    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }


    /**
     * The attributes that are mass assignable.
     * app/Models/User.php
     * @var array
     */
    protected $fillable = [
        'name','phone', 'email', 'password', 'introduction', 'avatar',
        'weixin_openid', 'weixin_unionid', 'registration_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    // 新增与话题模型的关联
    public function topics()
    {
         // 用户与话题中间的关系是 一对多 的关系
        return $this->hasMany(Topic::class);
    }

    // 优化
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    // 一个用户可以拥有多条评论
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    // 清除未读消息标示
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    // 密码修改器
    public function setPasswordAttribute($value)
    {
        // 如果值的长度等于 60，即认为是已经做过加密的情况
        if (strlen($value) != 60) {
            // 不等于 60，做密码加密处理
            $value = bcrypt($value);
        }
        $this->attributes['password'] = $value;
    }

    // 头像修改器
    public function setAvatarAttribute($path)
    {
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if ( ! starts_with($path, 'http')) {
            // 拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }
        $this->attributes['avatar'] = $path;
    }

    // JWT
    public function getJWTIdentifier()
    {
        // 返回 User 的 id
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // 额外在 JWT 载荷中增加的自定义内容
        return [];
    }
}
