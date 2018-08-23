<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Topic; //模型
use App\Handlers\SlugTranslateHandler; //翻译助手（写好的提供请求接口翻译内容的类文件）

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $topic; //配置等下需要用的参数

    //构造函数 通常用来给成员属性赋值 （配置参数）
    public function __construct(Topic $topic)
    {
        // 队列任务构造器中接收了 Eloquent 模型，将会只序列化模型的 ID
        $this->topic = $topic;
    }

    public function handle()
    {
        // 请求百度 API 接口进行翻译
        $slug = app(SlugTranslateHandler::class)->translate($this->topic->title);

        // 为了避免模型监控器死循环调用，我们使用 DB 类直接对数据库进行操作
        // 这里必须用 \DB::table() 来读取表数据然后修改，而不能实例化模型
        \DB::table('topics')->where('id', $this->topic->id)->update(['slug' => $slug]);
    }
}