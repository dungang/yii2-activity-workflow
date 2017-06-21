<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Transition */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'transitName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'role')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'workflowId')->dropDownList(\dungang\activity\workflow\models\Workflow::dropItems()) ?>

    <?= $form->field($model, 'taskId')->dropDownList(\dungang\activity\workflow\models\Task::dropItems()) ?>

    <?= $form->field($model, 'triggerSource')->radioList([ 'AUTO' => 'AUTO', 'USER' => 'USER', 'MSG' => 'MSG', 'TIME' => 'TIME', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'timeLimit')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
    <div class="col-md-6">
        <?=\dungang\activity\workflow\widgets\WorkflowChart::widget(
            \dungang\activity\workflow\helpers\WorkflowHelper::getWorkflowDefinitionData($model->workflowId)
        )?>
    </div>
</div>
