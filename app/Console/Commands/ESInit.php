<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ESInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //PHP artisan es:init
    protected $signature = 'es:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init an elastic for laravel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //输入PHP artisan es:init时,具体执行的内容
        $client = new Client();
        $url = config('scout.elasticsearch.hosts')[0].'/_template/estmp';
        $client -> delete($url);
        $params = [
            'json' => [
                'template' => config('scout.elasticsearch.index'),
                'mappings' => [
                    '_default_' => [
                        'dynamic_templates' => [
                            [
                                'strings' => [
                                    'match_mapping_type' => 'string',
                                    'mapping' => [
                                        'type' => 'text',
                                        'analyzer' => 'ik_smart',
                                        'fields' => [
                                            'keyword' => [
                                                'type' => 'keyword'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            ]
        ];
        $client ->put($url,$params);
        $this->info('模板创建成功');
        //http://127.0.0.1:9200/laravel/1
        $url = config('scout.elasticsearch.hosts')[0].'/'.config('scout.elasticsearch.index');
        $params = [
            'json' => [
                'settings' => [
                    'refresh_interval' => '5s',  //更新时间
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0,
                ],
                'mappings' => [
                    '_default_' => [
                        '_all' => [
                            'enabled' => false
                        ]
                    ]
                ]
            ]
        ];
        $client -> delete($url);
        $client -> put($url,$params);

        $this->info('创建索引成功');
    }
}
