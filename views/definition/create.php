<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model dungang\activity\workflow\models\Workflow */

$this->title = Yii::t('app', 'Create Workflow');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workflows'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-info">

    <div class="panel-heading"><strong><?= Html::encode($this->title) ?></strong></div>
    <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
</div>
