<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Process */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="process-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'workflowId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'context')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'processStatus')->dropDownList([ 'OPEN' => 'OPEN', 'CLOSED' => 'CLOSED', 'SUSPENDED' => 'SUSPENDED', 'CANCELLED' => 'CANCELLED', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'startedAt')->textInput() ?>

    <?= $form->field($model, 'endedAt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
