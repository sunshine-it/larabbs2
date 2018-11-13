<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Topic;
use Tests\Traits\ActingJWTUser;

class TopicApiTest extends TestCase
{
    use ActingJWTUser;

    protected $user;

    // setUp 方法会在测试开始之前执行
    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    // 测试查看话题 话题详情
    public function testShowTopic()
    {
        // 话题详情
        $topic = $this->makeTopic();
        $response = $this->json('GET', '/api/topics/'.$topic->id);
        // dd($response);
        $assertData= [
            'category_id' => $topic->category_id,
            'user_id' => $topic->user_id,
            'title' => $topic->title,
            'body' => $topic->body,
        ];

        $response->assertStatus(200)->assertJsonFragment($assertData);
    }
    // 测试用户 话题列表
    public function testIndexTopic()
    {
        $response = $this->json('GET', '/api/topics');
        // 直接访问 话题列表 接口，断言响应状态码为 200，断言响应数据结构中有 data 和 meta
        $response->assertStatus(200)->assertJsonStructure(['data', 'meta']);
    }

    // testStoreTopic 就是一个测试用户，测试发布话题
    public function testStoreTopic()
    {
        $data = ['category_id' => 1, 'body' => 'test body', 'title' => 'test title'];

        // $token = \Auth::guard('api')->fromUser($this->user);
        // 使用 $this->json 可以方便的模拟各种 HTTP 请求
        $response = $this->JWTActingAs($this->user)->json('POST', '/api/topics', $data);
        // dd($response);
        $assertData = [
            'category_id' => 1,
            'user_id' => $this->user->id,
            'title' => 'test title',
            'body' => clean('test body', 'user_topic_body'),
        ];
        $response->assertStatus(201)->assertJsonFragment($assertData);
    }
    // 测试修改话题
    public function testUpdateTopic()
    {
        $topic = $this->makeTopic();
        // dd($topic);
        $editData = ['category_id' => 2, 'body' => 'edit body', 'title' => 'edit title'];
        $response = $this->JWTActingAs($this->user)->json('PATCH', '/api/topics/'.$topic->id, $editData);
        // dd($response);
        $assertData = [
            'category_id' => 2,
            'user_id' => $this->user->id,
            'title' => 'edit title',
            'body' => clean('edit body', 'user_topic_body'),
        ];
        $response->assertStatus(200)->assertJsonFragment($assertData);
    }
    // 为当前测试的用户生成一个话题
    protected function makeTopic()
    {
        return factory(Topic::class)->create([
            'user_id' => $this->user->id,
            'category_id' => 1,
        ]);
    }

    // 测试删除话题
    public function testDeleteTopic()
    {
        $topic = $this->makeTopic();
        $response = $this->JWTActingAs($this->user)->json('DELETE', 'api/topics/'.$topic->id);
        $response->assertStatus(204);
        $response = $this->json('GET', '/api/topics/'.$topic->id);
        $response->assertStatus(404);
    }
}
