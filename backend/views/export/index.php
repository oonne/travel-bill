<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\widgets\Alert;
use common\models\Expenses;
use common\models\Trip;

$this->title = '导出Excel';
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="alert-wrapper">
            <?= Alert::widget() ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <?php 
            // 出差项目筛选，进入页面默认是“全部”
            $trip = ['' => '全部'];
            foreach (Trip::getKeyValuePairs() as $key => $value) {
                $trip[$key] = $value;
            }
        ?>
        <?= Html::dropDownList('expenses_trip', $searchModel->expenses_trip, $trip, ['class' => 'input-sm'])?>
        <?= Html::a('下载', ['download?' . Yii::$app->request->queryString], ['class' => 'btn btn-primary btn-sm']) ?>
        
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-center'],
            'summary' => Html::tag('p', '<b>{totalCount}</b>条数据，共计<b>' .$summary. '</b>元.', ['class' => 'text-right text-muted']),
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'headerOptions' => ['class' => 'col-md-1'],
                ],
                [
                    'attribute' => 'expenses_trip',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'value' => function ($model, $key, $index, $column) {
                        return $model->trip ? $model->trip->trip_name : Html::tag('b', '出差项目错误', ['class' => 'text-danger']);
                    }
                ],
                [
                    'attribute' => 'expenses_money',
                    'headerOptions' => ['class' => 'col-md-1'],
                ],
                [
                    'attribute' => 'expenses_category',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'value' => function ($model, $key, $index, $column) {
                        return $model->category ? $model->category->category_name : Html::tag('b', '分类错误', ['class' => 'text-danger']);
                    }
                ],
                [
                    'attribute' => 'expenses_handler',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'value' => function ($model, $key, $index, $column) {
                        return $model->handler ? $model->handler->handler_name : Html::tag('b', '经手人错误', ['class' => 'text-danger']);
                    }
                ],
                [
                    'attribute' => 'expenses_receipt',
                    'headerOptions' => ['class' => 'col-md-1'],
                    'value' => function ($model, $key, $index, $column) {
                        return $model->receiptMsg;
                    }
                ],
                [
                    'attribute' => 'expenses_date',
                    'headerOptions' => ['class' => 'col-md-2'],
                ],
                [
                    'attribute' => 'expenses_remark',
                    'headerOptions' => ['class' => 'col-md-2'],
                ],
            ]
        ]) ?>
    </div>
</div>
<?php
$js = <<<JS
var tripHandle = function () {
    var id = $(this).val();
    window.location = '/export/index?ExpensesSearch%5Bexpenses_trip%5D='+id
};
$('select[name="expenses_trip"]').change(tripHandle);
JS;

$this->registerJs($js);
?>