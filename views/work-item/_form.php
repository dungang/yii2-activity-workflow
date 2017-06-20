<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\WorkItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'workflowId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placeId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'processId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taskId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'context')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'triggerSource')->dropDownList([ 'AUTO' => 'AUTO', 'USER' => 'USER', 'MSG' => 'MSG', 'TIME' => 'TIME', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'workStatus')->dropDownList([ 'ENABLED' => 'ENABLED', 'IN_PROGRESS' => 'IN PROGRESS', 'CANCELLED' => 'CANCELLED', 'FINISHED' => 'FINISHED', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'enabledAt')->textInput() ?>

    <?= $form->field($model, 'deadlinedAt')->textInput() ?>

    <?= $form->field($model, 'finishedAt')->textInput() ?>

    <?= $form->field($model, 'cancelledAt')->textInput() ?>

    <?= $form->field($model, 'user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
