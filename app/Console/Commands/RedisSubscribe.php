<?php

namespace App\Console\Commands;

use Redis;
use Illuminate\Console\Command;

class RedisSubscribe extends Command{
    /**
     * 控制台命令名称
     *
     * @var string
     */
    protected $signature = 'redis:subscribe {user} {--queue}';

    /**
     * 控制台命令描述
     *
     * @var string
     */
    protected $description = 'Subscribe to a Redis channel';

    /**
     * 执行控制台命令
     *
     * @return mixed
     */
    public function handle()
    {
        Redis::subscribe(['web-channel'], function($message) {
            echo $message;
        });
    }
}