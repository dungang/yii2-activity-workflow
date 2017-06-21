<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Workflow */
/* @var $places dungang\activity\workflow\models\Place[] */
/* @var $transitions dungang\activity\workflow\models\Transition[] */
/* @var $arcs dungang\activity\workflow\models\Arc[] */

$this->title = $model->workflowName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workflows'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading"><strong><?= Html::encode($this->title) ?></strong></div>
    <div class="panel-body">

        <div class="row">
            <div class="col-md-6">
                <p>
                    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
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
                        'id',
                        'workflowName',
                        'startTask',
                        'isValid',
                        'intro:ntext',
                        'createdAt',
                        'createdUser',
                        'updatedAt',
                        'updatedUser',
                    ],
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= \dungang\activity\workflow\widgets\WorkflowChart::widget([
                    'places'=>$places,
                    'transitions'=>$transitions,
                    'arcs'=>$arcs,
                ]) ?>
            </div>
        </div>

    </div>
</div>
