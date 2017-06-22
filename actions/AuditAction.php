<?php
/**
 * Author: dungang
 * Date: 2017/6/22
 * Time: 11:13
 */

namespace dungang\activity\workflow\actions;


use dungang\activity\workflow\models\Transition;
use dungang\activity\workflow\models\Workflow;
use dungang\activity\workflow\models\WorkItem;
use dungang\activity\workflow\services\WorkflowCase;
use yii\base\Action;

class AuditAction extends Action
{
    public function run($workItemId){

        if(\Yii::$app->request->isPost) {

            $workItem = WorkItem::findOne($workItemId);
            $wf = Workflow::findOne($workItem->workflowId);
            $wfCase = new WorkflowCase([
                'doc'=>$wf->document,
                'workflow'=>$wf,
            ]);
            $transition = Transition::findOne($workItem->transitionId);
            $wfCase->fireTransition($transition);
        } else {

        }
    }
}