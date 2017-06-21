<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Place */

$this->title = $model->placeName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workflows'), 'url' => ['/workflow']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Places'), 'url' => ['index', 'id' => $model->workflowId]];
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
                        'placeName',
                        'intro',
                        'placeType',
                        'createdAt',
                        'createdUser',
                        'updatedAt',
                        'updatedUser',
                    ],
                ]) ?>
    </div>
</div>
