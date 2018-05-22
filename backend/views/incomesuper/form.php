<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Handler;
use yii\jui\DatePicker;
use backend\widgets\Alert;

$this->title = $model->isNewRecord ? '添加' : '修改';
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
    <div class="col-lg-6">
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'income_item') ?>
        <?= $form->field($model, 'income_money') ?>
        <?= $form->field($model, 'income_date')->widget(DatePicker::className(), [
            'options' => ['class' => 'form-control'],
            'clientOptions' => ['firstDay' => 0],
            'dateFormat' => 'yyyy-MM-dd'
        ]) ?>
        <?= $form->field($model, 'income_handler')->dropDownList(Handler::getKeyValuePairs()) ?>
        <?= $form->field($model, 'income_remark') ?>
        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    </div>
</div>