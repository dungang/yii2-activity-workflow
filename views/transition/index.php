<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel dungang\activity\workflow\models\TransitionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Transitions');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workflows'), 'url' => ['/workflow']];
$this->params['breadcrumbs'][] = $this->title;
$tasks = \dungang\activity\workflow\models\Task::find()->indexBy('id')->all();
?>
<div class="panel panel-info">

    <div class="panel-heading"><strong><?= Html::encode($this->title) ?></strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">

                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?= Html::a(Yii::t('app', 'Create Transition'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'transitName',
                        [
                            'attribute'=>'taskId',
                            'content' => function($model) use($tasks){
                                if(isset($tasks[$model->taskId])) {
                                    return $tasks[$model->taskId]->taskName;
                                }
                                return $model->taskId;
                            }
                        ],
                        'role',
                        'triggerSource',
                        //'timeLimit:datetime',
                        'intro:ntext',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
            <div class="col-md-6">
                <?=\dungang\activity\workflow\widgets\WorkflowChart::widget(
                    \dungang\activity\workflow\helpers\WorkflowHelper::getWorkflowDefinitionData($workflowId)
                )?>
            </div>
        </div>
    </div>
</div>
