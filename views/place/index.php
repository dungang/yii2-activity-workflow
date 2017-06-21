<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel dungang\activity\workflow\models\PlacetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $workflowId integer */

$this->title = Yii::t('app', 'Places');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workflows'), 'url' => ['/workflow']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading"><strong><?= Html::encode($this->title) ?></strong></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">

                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?= Html::a(Yii::t('app', 'Create Place'), ['create', 'workflowId' => $workflowId], ['class' => 'btn btn-success']) ?>
                </p>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'placeName',
                        'intro',
                        'placeType',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
            <div class="col-md-6">

                <div class="col-md-6">
                    <?= \dungang\activity\workflow\widgets\WorkflowChart::widget(
                        \dungang\activity\workflow\helpers\WorkflowHelper::getWorkflowDefinitionData($workflowId)
                    ) ?>
                </div>
            </div>
        </div>
    </div>
</div>
