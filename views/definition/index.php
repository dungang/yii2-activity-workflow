<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel dungang\activity\workflow\models\WorkflowSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Workflows');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading"><strong><?= Html::encode($this->title) ?></strong></div>
    <div class="panel-body">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Workflow'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'workflowName',
            'startTask',
            'isValid',
            'intro:ntext',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{/workflow/transition} {/workflow/place} {/workflow/arc} {view} {update} {delete}',
                'buttons'=>[
                    '/workflow/transition'=>function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Transition'),
                            'aria-label' => Yii::t('yii', 'Transition'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="fa fa-ban"></span>', $url, $options);
                    },
                    '/workflow/place'=>function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Place'),
                            'aria-label' => Yii::t('yii', 'Place'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="fa fa-home"></span>', $url, $options);
                    },
                    '/workflow/arc'=>function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Arc'),
                            'aria-label' => Yii::t('yii', 'Arc'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="fa fa-arrow-circle-o-right"></span>', $url, $options);
                    },
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
        </div>
</div>
