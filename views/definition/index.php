<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel dungang\activity\workflow\models\WorkflowSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Workflows');
$this->params['breadcrumbs'][] = $this->title;

$tasks = \dungang\activity\workflow\models\Task::find()->indexBy('id')->all();
?>
<div class="panel panel-info">

    <div class="panel-heading"><strong><?= Html::encode($this->title) ?></strong></div>
    <div class="panel-body">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Workflow'), ['create'], ['class' => 'btn btn-success mjax']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'workflowName',
            [
                'attribute'=>'startTask',
                'content' => function($model) use($tasks){
                    if(isset($tasks[$model->startTask])) {
                        return $tasks[$model->startTask]->taskName;
                    }
                    return $model->startTask;
                }
            ],
            'isValid',
            [
                'class' => 'dungang\mjax\ActionColumn',
                'template'=>'{/workflow/transition} {/workflow/place} {/workflow/arc} {view} {update} {delete}',
                'buttons'=>[
                    '/workflow/transition'=>function ($url) {
                        $options = [
                            'title' => Yii::t('yii', 'Transition'),
                            'aria-label' => Yii::t('yii', 'Transition'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="fa fa-ban"></span> ' . \Yii::t('app','Transitions'), $url, $options);
                    },
                    '/workflow/place'=>function ($url) {
                        $options = [
                            'title' => Yii::t('yii', 'Place'),
                            'aria-label' => Yii::t('yii', 'Place'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="fa fa-home"></span> ' . \Yii::t('app','Places'), $url, $options);
                    },
                    '/workflow/arc'=>function ($url) {
                        $options = [
                            'title' => Yii::t('yii', 'Arc'),
                            'aria-label' => Yii::t('yii', 'Arc'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="fa fa-arrow-circle-o-right"></span> ' . \Yii::t('app','Arcs'), $url, $options);
                    },
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
        </div>
</div>
