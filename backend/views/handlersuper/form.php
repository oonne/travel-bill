<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\widgets\Alert;
use common\models\Trip;

$this->title = $model->isNewRecord ? '增加经手人' : '修改经手人';
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
        <?= $form->field($model, 'handler_name') ?>
        <?= $form->field($model, 'handler_trip')->dropDownList(Trip::getKeyValuePairs()) ?>
        <div class="form-group">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    </div>
</div>