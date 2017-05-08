<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "ftp", "s3", "rackspace"
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'visibility' => 'public',
        ],
        // 新建一个本地端uploads空间（目录） 用于存储上传的文件
        'uploads' => [
            'driver' => 'local',
            'root' => public_path('uploads'),// 文件将上传到public/uploads目录
        ],
        's3' => [
            'driver' => 's3',
            'key' => 'your-key',
            'secret' => 'your-secret',
            'region' => 'your-region',
            'bucket' => 'your-bucket',
        ],

        // 七牛云存储
        'qiniu' => [
            'driver'  => 'qiniu',
            'domains' => [
                'default'   => env('QINIU_DEFAULT'), //你的七牛域名
                'https'     => env('QINIU_HTTPS'),         //你的HTTPS域名
                'custom'    => env('QINIU_CUSTOM'),                //你的自定义域名
            ],
            'access_key'=> env('QINIU_ACCESS_KEY'),  //AccessKey
            'secret_key'=> env('QINIU_SECRET_KEY'),  //SecretKey
            'bucket'    => env('QINIU_BUCKET'),  //Bucket名字
            'notify_url'=> env('QINIU_NOTIFY_URL'),  //持久化处理回调地址
        ],

    ],

];
