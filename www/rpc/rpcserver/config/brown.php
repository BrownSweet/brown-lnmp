<?php

return [
    'framework' =>[
        'name'=>'tp',
        'env'=>'testing'
    ],
    'rpc'        => [
        'server' => [
            'enable'     => true,
            'host'       => '0.0.0.0',
            'port'       => 9073,
            'worker_num' => swoole_cpu_num(),
            'service_name'=>'msh',
            'register'=>[
                'enable'=>true,
                'class'=>\brown\register\Consul::class,
                'uri'=>'http://120.53.236.218:8500',
                'weight'=>1,
                'host'=>'120.53.84.26',
                'port'=> 9073,
            ],
            'services'   => [
                \app\controller\Tianyu::class
            ],

        ],
        'client' => [
            'timeout'=>60,
            'register'=>[
                'enable'=>false,
                'uri'=>'http://120.53.236.218:8500',
                'class'=>\brown\register\Consul::class,
                'service_name'=>[
                    'msh'
                ]
            ],
            'msh'=>[
                'host'=>'120.53.84.26',
                'port'=>'9073'
            ],

        ],
    ],
    'queue'=>[
        'enable'=>true,
        'worker'=>[
            \brown\server\queue\Cmq::getInstance()
        ],
        'worker_num'=>swoole_cpu_num(),
        'listen'=>[

        ],
    ],
    'hot_update' => [
        'enable'  => true,
        'name'    => ['*.php'],
        'include' => [dirname(__DIR__) . DIRECTORY_SEPARATOR],
        'exclude' => [],
    ],
    'parser'=>[
        'class'=>\brown\pack\Packer::class,
    ],
    'trace'=>[
        'tracerUrl'=>'http://127.0.0.1:9411/api/v2/spans'
    ]
];
