<?php
use yii\helpers\Html;
use yii\widgets\Menu;
use backend\assets\AppAsset;

AppAsset::register($this);

$route = Yii::$app->requestedAction->uniqueId;

$menu = [
    [
        'label' => '系统',
        'url' => '#',
        'items' => [
            'site' => ['label' => '系统信息', 'url' => ['site/index'], 'active' => in_array($route, ['site/index'])],
            'usersuper' => ['label' => '用户管理', 'url' => ['usersuper/index'], 'active' => in_array($route, ['usersuper/index', 'usersuper/add-user', 'usersuper/update-user'])],
            'handlersuper' => ['label' => '经手人管理', 'url' => ['handlersuper/index'], 'active' => in_array($route, ['handlersuper/index', 'handlersuper/add-handler', 'handlersuper/update-handler'])],
            'recyclesuper' => ['label' => '回收站', 'url' => ['recyclesuper/index'], 'active' => in_array($route, ['recyclesuper/index', 'recyclesuper/view-recycle'])],
        ],
    ],
    [
        'label' => '账单',
        'url' => '#',
        'items' => [
            'categorysuper' => ['label' => '分类管理', 'url' => ['categorysuper/index'], 'active' => in_array($route, ['categorysuper/index', 'categorysuper/add-category', 'categorysuper/update-category'])],
            'tripsuper' => ['label' => '出差项目', 'url' => ['tripsuper/index'], 'active' => in_array($route, ['tripsuper/index', 'tripsuper/add-trip', 'tripsuper/update-trip'])],
            'expensessuper' => ['label' => '消费记录', 'url' => ['expensessuper/index'], 'active' => in_array($route, ['expensessuper/index', 'expensessuper/add-expenses', 'expensessuper/update-expenses', 'expensessuper/view-expenses'])],
            'export' => ['label' => '导出Excel', 'url' => ['export/index'], 'active' => in_array($route, ['export/index'])],
        ]
    ],
];

?>

<?php $this->beginContent('@app/views/layouts/base.php'); ?>
    <div id="wrapper">
         <nav class="sidebar">
            <?= Html::a('<img src="/img/aura.png" class="logo-rotation">', Yii::$app->homeUrl, ['class' => 'sidebar-logo']) ?>
            <?= Menu::widget([
                'encodeLabels' => false,
                'submenuTemplate' => "\n<ul class=\"nav nav-second-level collapse\">\n{items}\n</ul>\n",
                'options' => [
                    'class' => 'nav',
                    'id' => 'side-menu'
                ],
                'items' => $menu
            ]) ?>
        </nav>

        <div id='page-wrapper'>
            <?= $content ?>
        </div>

    </div>

<?php $this->endContent() ?>