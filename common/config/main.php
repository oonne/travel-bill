<?php
return [
	'name' => 'travel-bill',
    'timeZone' => 'Asia/Hong_Kong',
    'language' => 'zh-CN',
    'sourceLanguage' => 'zh-CN',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false
        ],
    ],
];
