<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Arc */

$this->title = $model->workflowId;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workflows'), 'url' => ['/workflow']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Arcs'), 'url' => ['index', 'id' => $model->workflowId]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading"><strong><?= Html::encode($this->title) ?></strong></div>
    <div class="panel-body">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'workflowId',
                        'placeId',
                        'transitionId',
                        'direction',
                        'arcType',
                        'conditionExpress',
                        'createdAt',
                        'createdUser',
                        'updatedAt',
                        'updatedUser',
                    ],
                ]) ?>
    </div>
</div>