<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel dungang\activity\workflow\models\TokenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tokens');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading"><strong><?= Html::encode($this->title) ?></strong></div>
    <div class="panel-body">
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'workflowId',
            'placeId',
            'processId',
            'context',
            'tokenStatus',
            // 'enabledAt',
            // 'cancelledAt',
            // 'consumedAt',

            ['class' => 'dungang\mjax\ActionColumn','template'=>'{view}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
        </div>
</div>
