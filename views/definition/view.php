<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Workflow */
/* @var $places dungang\activity\workflow\models\Place[] */
/* @var $transitions dungang\activity\workflow\models\Transition[] */
/* @var $arcs dungang\activity\workflow\models\Arc[] */

$this->title = $model->workflowName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workflows'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$data = \dungang\activity\workflow\helpers\WorkflowHelper::getWorkflowDefinitionData($model->id);
$data['id'] = 'workflow-chart';
?>
<div class="panel panel-info">

    <div class="panel-heading"><strong><?= Html::encode($this->title) ?></strong></div>
    <div class="panel-body">
        <?=\yii\bootstrap\Tabs::widget([
            'items'=>[
                [
                    'label'=>'流程图',
                    'active'=>true,
                    'content'=> \dungang\activity\workflow\widgets\WorkflowChart::widget($data)
                ],
                [
                    'label'=>'信息',
                    'content'=> DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'workflowName',
                            'startTask',
                            'isValid',
                            'intro:ntext',
                            'createdAt',
                            'createdUser',
                            'updatedAt',
                            'updatedUser',
                        ],
                    ])
                ],
            ]
        ])?>
    </div>
</div>
