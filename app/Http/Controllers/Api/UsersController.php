<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UserRequest;
use App\Transformers\UserTransformer;
use App\Models\Image;

// 用户控制器类
class UsersController extends Controller
{
    public function activedIndex(User $user)
    {
        return $this->response->collection($user->getActiveUsers(), new UserTransformer());
    }
    // 添加用户
    public function store(UserRequest $request)
    {
        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            return $this->response->error('验证码已失效', 422);
        }
        // 比对验证码是否与缓存中一致
        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            return $this->response->errorUnauthorized('验证码错误');
        }
        // 创建用户
        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
        ]);
        // 清除验证码缓存
        \Cache::forget($request->verification_key);
        // return $this->response->created();
        return $this->response->item($user, new UserTransformer())
                    ->setMeta([
                        'access_token' => \Auth::guard('api')->fromUser($user),
                        'token_type' => 'Bearer',
                        'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
                    ])
                    ->setStatusCode(201);
    }

    // 编辑用户
    public function update(UserRequest $request)
    {
        // 获取要编辑的用户
        $user = $this->user();
        $attributes = $request->only(['name', 'email', 'introduction', 'registration_id']);
        if ($request->avatar_image_id) {
            $image = Image::find($request->avatar_image_id);
            $attributes['avatar'] = $image->path;
        }
        $user->update($attributes);
        return $this->response->item($user, new UserTransformer);
    }

    public function me()
    {
        return $this->response->item($this->user(), new UserTransformer());
    }
}
