<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Arc */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Arc',
]) . $model->workflowId;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Arcs'), 'url' => ['index','id'=>$model->workflowId]];
$this->params['breadcrumbs'][] = ['label' => $model->workflowId, 'url' => ['view', 'workflowId' => $model->workflowId, 'placeId' => $model->placeId, 'transitionId' => $model->transitionId]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="panel panel-info">

    <div class="panel-heading"><strong><?= Html::encode($this->title) ?></strong></div>
    <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
</div>
