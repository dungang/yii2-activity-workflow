<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Transition */
/* @var $form yii\widgets\ActiveForm */
?>

<div>

    <?php $form = ActiveForm::begin(['id'=>'transition-form']); ?>

    <?= $form->field($model, 'transitName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'role')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'workflowId')->dropDownList(\dungang\activity\workflow\models\Workflow::dropItems()) ?>

    <?= $form->field($model, 'taskId')->dropDownList(\dungang\activity\workflow\models\Task::dropItems()) ?>

    <?= $form->field($model, 'triggerSource')->radioList([ 'AUTO' => 'AUTO', 'USER' => 'USER', 'MSG' => 'MSG', 'TIME' => 'TIME', ], ['prompt' => '']) ?>

    <?php // $form->field($model, 'timeLimit')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
