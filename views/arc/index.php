<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel dungang\activity\workflow\models\ArcSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/** @var $workflowId int */

$this->title = Yii::t('app', 'Arcs');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workflows'), 'url' => ['/workflow']];
$this->params['breadcrumbs'][] = $this->title;
$data = \dungang\activity\workflow\helpers\WorkflowHelper::getWorkflowDefinitionData($workflowId);
$places = is_array($data['places'])? \yii\helpers\ArrayHelper::index($data['places'],'id'):[];
$transitions = is_array($data['transitions'])? \yii\helpers\ArrayHelper::index($data['transitions'],'id'):[];
?>
<div class="panel panel-info">

    <div class="panel-heading"><strong><?= Html::encode($this->title) ?></strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?= Html::a(Yii::t('app', 'Create Arc'), ['create', 'workflowId' => $workflowId], ['class' => 'btn btn-success mjax']) ?>
                </p>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute'=>'placeId',
                            'content'=>function($model) use ($places){
                                if(isset($places[$model->placeId])) {
                                    return $places[$model->placeId]->placeName;
                                } else {
                                    return $model->placeId;
                                }
                            }
                        ],
                        [
                            'attribute'=>'direction',
                            'content'=>function($model){
                                if ($model->direction == 'IN') {
                                    return '<i class="fa fa-arrow-right"></i>';
                                }
                                return '<i class="fa fa-arrow-left"></i>';
                            }
                        ],
                        [
                            'attribute'=>'transitionId',
                            'content'=>function($model) use ($transitions){
                                if(isset($transitions[$model->transitionId])) {
                                    return $transitions[$model->transitionId]->transitName;
                                } else {
                                    return $model->transitionId;
                                }
                            }
                        ],
                        'arcType',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
            <div class="col-md-6">
                <?= \dungang\activity\workflow\widgets\WorkflowChart::widget(
                   $data
                ) ?>
            </div>
        </div>
    </div>
</div>
