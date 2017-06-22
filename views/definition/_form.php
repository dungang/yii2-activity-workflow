<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Workflow */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="workflow-form">

    <?php $form = ActiveForm::begin(['id'=>'workflow-form']); ?>

    <?= $form->field($model, 'workflowName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'document')->dropDownList(\dungang\activity\workflow\models\Document::dropItems()) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'startTask')->dropDownList(\dungang\activity\workflow\models\Task::dropItems()) ?>

    <?= $form->field($model, 'isValid')->radioList([ 'YES' => 'YES', 'NO' => 'NO', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>