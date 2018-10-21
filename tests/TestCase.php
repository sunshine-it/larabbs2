<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function sms()
    {
        $sms = app('easysms');
        try {
            $sms->send(13242712858, [
                'content'  => '【云盛网络测试】您的验证码是6666。如非本人操作，请忽略本短信',
            ]);
        } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
            $message = $exception->getException('yunpian')->getMessage();
            dd($message);
        }
       }
}
