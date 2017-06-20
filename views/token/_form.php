<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Token */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="token-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'workflowId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placeId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'processId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'context')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tokenStatus')->dropDownList([ 'FREE' => 'FREE', 'LOCKED' => 'LOCKED', 'CONSUMED' => 'CONSUMED', 'CANCELLED' => 'CANCELLED', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'enabledAt')->textInput() ?>

    <?= $form->field($model, 'cancelledAt')->textInput() ?>

    <?= $form->field($model, 'consumedAt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
