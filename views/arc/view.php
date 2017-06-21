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
        <div class="row">
            <div class="col-md-6">

                <p>
                    <?= Html::a(Yii::t('app', 'Update'), ['update', 'workflowId' => $model->workflowId, 'placeId' => $model->placeId, 'transitionId' => $model->transitionId], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'workflowId' => $model->workflowId, 'placeId' => $model->placeId, 'transitionId' => $model->transitionId], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

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
            <div class="col-md-6">
                <?= \dungang\activity\workflow\widgets\WorkflowChart::widget(
                    \dungang\activity\workflow\helpers\WorkflowHelper::getWorkflowDefinitionData($model->workflowId)
                ) ?>
            </div>
        </div>
    </div>
</div>