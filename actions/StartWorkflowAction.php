<?php
/**
 * Author: dungang
 * Date: 2017/6/20
 * Time: 17:30
 */

namespace dungang\activity\workflow\actions;


use dungang\activity\workflow\services\WorkflowCase;
use dungang\activity\workflow\services\WorkflowDefinition;
use yii\base\Action;

class StartWorkflowAction extends Action
{
    public function run($doc,$context){
        $wfDefinition = new WorkflowDefinition([
            'docName'=>$doc
        ]);
        $wfCase = new WorkflowCase([
            'wfDefinition'=>$wfDefinition,
        ]);
        $wfCase->start($context);
    }
}