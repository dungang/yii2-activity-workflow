<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Document */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading"><strong><?= Html::encode($this->title) ?></strong></div>
    <div class="panel-body">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'document',
            'workflowId',
            'name',
            'docHandler',
            'intro:ntext',
            'createdAt',
            'createdUser',
            'updatedAt',
            'updatedUser',
        ],
    ]) ?>
</div>
</div>
