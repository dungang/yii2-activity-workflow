<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Transition */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workflows'), 'url' => ['/workflow']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transitions'), 'url' => ['index']];
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
                        'taskId',
                        'role',
                        'transitName',
                        'triggerSource',
                        'timeLimit:datetime',
                        'intro:ntext',
                        'createdAt',
                        'createdUser',
                        'updatedAt',
                        'updatedUser',
                    ],
                ]) ?>
    </div>
</div>
