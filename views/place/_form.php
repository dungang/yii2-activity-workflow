<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Place */
/* @var $form yii\widgets\ActiveForm */
?>
<div>
        <?php $form = ActiveForm::begin(['id'=>'place-form']); ?>

        <?= $form->field($model, 'placeName')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'intro')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'workflowId')->dropDownList(\dungang\activity\workflow\models\Workflow::dropItems()) ?>

        <?= $form->field($model, 'placeType')->radioList([ 'START' => 'START', 'INTER' => 'INTER', 'END' => 'END', ], ['prompt' => '']) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
</div>