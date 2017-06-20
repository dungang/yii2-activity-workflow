<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\TokenSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="token-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'workflowId') ?>

    <?= $form->field($model, 'placeId') ?>

    <?= $form->field($model, 'processId') ?>

    <?= $form->field($model, 'context') ?>

    <?php // echo $form->field($model, 'tokenStatus') ?>

    <?php // echo $form->field($model, 'enabledAt') ?>

    <?php // echo $form->field($model, 'cancelledAt') ?>

    <?php // echo $form->field($model, 'consumedAt') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
