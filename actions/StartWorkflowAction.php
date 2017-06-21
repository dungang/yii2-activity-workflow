<?php
/**
 * Author: dungang
 * Date: 2017/6/20
 * Time: 17:30
 */

namespace dungang\activity\workflow\actions;


use dungang\activity\workflow\services\WorkflowCase;
use yii\base\Action;

class StartWorkflowAction extends Action
{
    public function run($doc,$context){
        $wfCase = new WorkflowCase([
            'doc'=>$doc
        ]);
        $wfCase->start($context);
        $session = \Yii::$app->session;
        $session->setFlash('success', \Yii::t('app','You have successfully started your workflow case.'));
        $this->controller->goBack();
    }
}