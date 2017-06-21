<?php
/**
 * Author: dungang
 * Date: 2017/6/16
 * Time: 11:47
 */

namespace dungang\activity\workflow\services;


use dungang\activity\workflow\interfaces\DocHandlerInterface;
use dungang\activity\workflow\models\Arc;
use dungang\activity\workflow\models\Place;
use dungang\activity\workflow\models\Process;
use dungang\activity\workflow\models\Token;
use dungang\activity\workflow\models\Transition;
use dungang\activity\workflow\models\WorkItem;
use yii\base\Component;
use yii\db\Expression;

class WorkflowCase extends Component
{

    /**
     * @var WorkflowDefinition;
     */
    protected $wfDefinition;

    public $process;

    public $workItems;

    /**
     * @var string
     */
    public $doc;

    public function init()
    {
        $this->wfDefinition = new WorkflowDefinition([
            'docName'=>$this->doc
        ]);
    }

    public function instance($processId)
    {
        $this->process = Process::find()->where(['id'=>$processId])->one();
    }

    protected function readWorkItems()
    {
        $this->workItems = WorkItem::find()->where(['processId'=>$this->process->id])->all();
    }

    public function start($context)
    {
        $this->process = $this->createProcess($context);
        $this->createToken($this->wfDefinition->startPlace,$context);
    }

    protected function createProcess($context)
    {
        $process = new Process();
        $process->workflowId = $this->wfDefinition->workflow->id;
        $process->context = $context;
        $process->processStatus = 'OPEN';
        $process->startedAt = new Expression('NOW()');
        $process->save(false);
        return $process;
    }

    /**
     * @param $place Place
     * @param $context mixed
     * @return Token
     */
    protected function createToken($place,$context) {
        $token = new Token();
        $token->processId = $this->process->id;
        $token->workflowId = $this->wfDefinition->workflow->id;
        $token->placeId = $place->id;
        $token->tokenStatus = 'FREE';
        $token->context = $context;
        $token->enabledAt = new Expression('NOW()');
        if($token->save(false)) {
            //get transitions these accept  the input token
            //'SEQUENCE', 'IMPLICIT_OR_SPLIT',  'AND_JOIN'
            /*  @var $transitions Transition[] */
            /*  @var $transition Transition */
            list($transitions,$arcType)= $this->wfDefinition->getTransitionsOfInputPlace($place);
            if($arcType == 'SEQUENCE') {
                // SEQUENCE only one way
                if (isset($transitions['AUTO']) && is_array($transitions['AUTO'])) {
                    $transition = $transitions['AUTO'][0];
                    if($this->fireTransition($transition)){
                        $this->createWorkItem($transition,$context,'FINISHED');
                    }
                }
                else if(isset($transitions['USER']) && is_array($transitions['USER'])) {
                    $transition = $transitions['USER'][0];
                    $this->createWorkItem($transition,$context);
                }
                else if(isset($transitions['MSG']) && is_array($transitions['MSG'])) {
                    // now unsupported, in planning
                }
                // (isset($transitions['TIME']) && is_array($transitions['TIME']))
                else {
                    // now unsupported, in planning
                }


            } else if ($arcType == 'IMPLICIT_OR_SPLIT') {
                // SEQUENCE only one way
                if (isset($transitions['AUTO']) && is_array($transitions['AUTO'])) {
                    $transition = $transitions['AUTO'][0];
                    if($this->fireTransition($transition)){
                        $this->createWorkItem($transition,$context,'FINISHED');
                    }
                }
                else if(isset($transitions['USER']) && is_array($transitions['USER'])) {
                    foreach ($transitions['USER'] as $transition) {
                        $this->createWorkItem($transition,$context);
                    }
                }
                else if(isset($transitions['MSG']) && is_array($transitions['MSG'])) {
                    // now unsupported, in planning
                }
                // (isset($transitions['TIME']) && is_array($transitions['TIME']))
                else {
                    // now unsupported, in planning
                }

            } else if ($arcType == 'AND_JOIN') {
                // SEQUENCE only one way
                if (isset($transitions['AUTO']) && is_array($transitions['AUTO'])) {
                    $transition = $transitions['AUTO'][0];
                    if($this->fireTransition($transition)){
                        $this->createWorkItem($transition,$context,'FINISHED');
                    }
                }
                else if(isset($transitions['USER']) && is_array($transitions['USER'])) {
                    foreach ($transitions['USER'] as $transition) {
                        $this->createWorkItem($transition,$context);
                    }
                }
                else if(isset($transitions['MSG']) && is_array($transitions['MSG'])) {
                    // now unsupported, in planning
                }
                // (isset($transitions['TIME']) && is_array($transitions['TIME']))
                else {
                    // now unsupported, in planning
                }

            }

        }
        return $token;
    }


    /**
     * @param $transition Transition
     * @return array|\dungang\activity\workflow\models\Token[]
     */
    protected function transitionCanPlaces($transition){
        list($inArcs,$arcType) = $this->wfDefinition->findInArcsOfTransition($transition->id);
        $placeIds = [];
        foreach($inArcs as $arc){
            $placeIds[] = $arc->placeId;
        }
        if(!empty($placeIds)) {

            if($arcType == 'SEQUENCE' || $arcType == 'IMPLICIT_OR_SPLIT') {
                if($token = Token::find()->where([
                        'workflowId'=>$this->wfDefinition->workflow->id,
                        'placeId'=>$placeIds[0],
                        'processId'=>$this->process->id,
                        'tokenStatus'=>'FREE'
                    ])->one()){
                    return [$token];
                }
            } else if ($arcType == 'AND_JOIN') {
                $tokens = Token::find()->where([
                    'workflowId'=>$this->wfDefinition->workflow->id,
                    'placeId'=>$placeIds[0],
                    'processId'=>$this->process->id,
                    'tokenStatus'=>'FREE'
                ])->all();
                if($tokens && count($tokens) == count($inArcs)) {
                    return $tokens;
                }
            }
        }
        return [];

    }

    /**
     * @param $transition Transition
     * @param $context mixed
     * @return bool
     */
    public function fireTransition($transition,$context =null) {
        $freeTokens = $this->transitionCanPlaces($transition);
        if($freeTokens) {
            if($context ==null) {
                $token = $freeTokens[0];
                $context = $token->context;
            }
            //$this->wfDefinition->fireTransition($transition,$context);
            foreach($freeTokens as $token){
                $token->tokenStatus = 'CONSUMED';
                $token->save(false);
            }
            /* @var $outArcs Arc[] */
            list($outArcs,$_) = $this->wfDefinition->findOutArcsOfTransition($transition->id);
            foreach ($outArcs as $arc) {
                $this->createToken($this->wfDefinition->places[$arc->placeId],$context);
            }
            return true;
        }
        return false;
    }



    /**
     * @param $transition Transition
     * @param $context mixed
     * @param $status String
     * @return WorkItem
     */
    protected function createWorkItem($transition,$context,$status='ENABLED')
    {
        $item = new WorkItem();
        $item->workflowId = $this->wfDefinition->workflow->id;
        $item->processId = $this->process->id;
        $item->context = $context;
        $item->workStatus = $status;
        $item->taskId = $transition->taskId;
        $item->transitionId= $transition->id;
        $item->triggerSource= $transition->triggerSource;
        $item->enabledAt = new Expression('NOW()');
        if($transition->triggerSource == 'USER') {
            $item->role = $transition->role;
            $item->user = $this->getWorkItemUser($transition);
        }
        $item->save(false);
        return $item;
    }

    /**
     * @param $transition Transition
     * @return mixed
     */
    public function getWorkItemUser($transition){
        if($role = $transition->role) {
            /* @var $handlerClass DocHandlerInterface | String */
            $handlerClass = $this->wfDefinition->document->docHandler;
            if (class_exists($handlerClass)) {
                return $handlerClass::getTransitionUser($role,\Yii::$app->user->id);
            }
        }
        return null;
    }
}