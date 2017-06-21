<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\WorkItem */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Work Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading"><strong><?= Html::encode($this->title) ?></strong></div>
    <div class="panel-body">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'workflowId',
            'placeId',
            'processId',
            'taskId',
            'context',
            'triggerSource',
            'workStatus',
            'enabledAt',
            'deadlinedAt',
            'finishedAt',
            'cancelledAt',
            'user',
            'role',
        ],
    ]) ?>
</div>
</div>
