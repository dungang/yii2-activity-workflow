<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Document */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="document-form">

    <?php $form = ActiveForm::begin(['id'=>'document-form']); ?>

    <?= $form->field($model, 'document')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'workflowId')->dropDownList(\dungang\activity\workflow\models\Workflow::dropItems(),['prompt' => '']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'docHandler')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
