<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Task */

$this->title = $model->taskName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <strong><?= Html::encode($this->title) ?></strong>
    </div>

    <div class="panel-body">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'taskName',
            'handler',
            'params',
            'intro',
            'createdAt',
            'createdUser',
            'updatedAt',
            'updatedUser',
        ],
    ]) ?>
    </div>

</div>

