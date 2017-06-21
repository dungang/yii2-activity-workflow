<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Arc */
/* @var $form yii\widgets\ActiveForm */
?>

<div>
            <?php $form = ActiveForm::begin(['id'=>'arc-form']); ?>

            <?= $form->field($model, 'workflowId')->dropDownList(\dungang\activity\workflow\models\Workflow::dropItems(), ['readOnly' => true]) ?>

            <?= $form->field($model, 'placeId')->dropDownList(\dungang\activity\workflow\models\Place::dropItems($model->workflowId)) ?>

            <?= $form->field($model, 'transitionId')->dropDownList(\dungang\activity\workflow\models\Transition::dropItems($model->workflowId)) ?>

            <?= $form->field($model, 'direction')->radioList(['IN' => 'IN', 'OUT' => 'OUT',], ['prompt' => '']) ?>

            <?= $form->field($model, 'arcType')->radioList(['SEQUENCE' => 'SEQUENCE', 'EXPLICIT_OR_SPLIT' => 'EXPLICIT OR SPLIT', 'IMPLICIT_OR_SPLIT' => 'IMPLICIT OR SPLIT', 'OR_JOIN' => 'OR JOIN', 'AND_SPLIT' => 'AND SPLIT', 'AND_JOIN' => 'AND JOIN',], ['prompt' => '']) ?>

            <?= $form->field($model, 'conditionExpress')->textarea(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
</div>
