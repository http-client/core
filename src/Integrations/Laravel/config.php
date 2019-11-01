<?php

declare(strict_types=1);

return [
    'wechat' => [
        /*
         * 微信开放平台信息配置
         */
        'open_platform' => [
            /*
             * 微信开放平台第三方平台接入信息配置
             * 支持多个配置，按照 `default` 格式添加即可
             */
            'default' => [
                'app_id' => env('WEFORGE_WECHAT_OPEN_PLATFORM_APP_ID'),
                'secret' => env('WEFORGE_WECHAT_OPEN_PLATFORM_SECRET'),
                'token' => env('WEFORGE_WECHAT_OPEN_PLATFORM_TOKEN'),
                'aes_key' => env('WEFORGE_WECHAT_OPEN_PLATFORM_AES_KEY'),
            ],
        ],
    ],
];
