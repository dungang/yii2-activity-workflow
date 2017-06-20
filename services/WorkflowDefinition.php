<?php
/**
 * Author: dungang
 * Date: 2017/6/15
 * Time: 21:52
 */

namespace dungang\activity\workflow\services;


use dungang\activity\workflow\exceptions\NotExistException;
use dungang\activity\workflow\exceptions\WorkflowDefinitionException;
use dungang\activity\workflow\interfaces\DocHandlerInterface;
use dungang\activity\workflow\models\Arc;
use dungang\activity\workflow\models\Document;
use dungang\activity\workflow\models\Place;
use dungang\activity\workflow\models\Task;
use dungang\activity\workflow\models\Transition;
use dungang\activity\workflow\models\Workflow;
use yii\base\Component;

class WorkflowDefinition extends Component
{

    /**
     * @var string 文档名称
     */
    public $docName;

    /**
     * @var Document
     */
    public $document;

    /**
     * @var Workflow workflow workflow
     */
    public $workflow;

    /**
     * @var Place start place
     */
    public $startPlace;

    /**
     * @var Place end place
     */
    public $endPlace;

    /**
     * @var Place[] intel places
     */
    public $places;

    /**
     * @var Transition[] transitions
     */
    public $transitions;

    /**
     * @var Arc[] in or out arcs
     */
    public $arcs;

    /**
     * @var Task  a workflow start task
     */
    public $startTask;


    public function init()
    {
        if ($this->document = Document::find()->where(['document'=>$this->docName])->one()) {
            if(!$this->workflow = Workflow::find()->where(['id'=>$this->document->workflowId,'isValid'=>['YES','USED']])->one()) {
                throw new NotExistException('No Workflow Definition Match Document!');
            }
            if (!$this->checkDefinition()) {
                throw new WorkflowDefinitionException('Workflow Definition Error!');
            }
        } else {
            throw new NotExistException('Document Not Exist!');
        }
    }



    /**
     * 查找符合条件的向弧 input type : 'SEQUENCE', 'IMPLICIT_OR_SPLIT',  'AND_JOIN'
     * @param $placeId String
     * @return  array
     */
    public function findInArcsOfInputPlaceId($placeId){
        $contentArcs = [];
        //input type : 'SEQUENCE', 'IMPLICIT_OR_SPLIT',  'AND_JOIN'
        foreach($this->arcs as $arc){
            if($arc->direction == 'IN' && $arc->placeId == $placeId) {
                $contentArcs[$arc->arcType] = $arc;
            }
        }
        //seq first
        if(isset($contentArcs['SEQUENCE'])) {
            return [$contentArcs['SEQUENCE'],'SEQUENCE'];
        } else if ($contentArcs['IMPLICIT_OR_SPLIT']) {
            return [$contentArcs['IMPLICIT_OR_SPLIT'],'IMPLICIT_OR_SPLIT'];
        } else if ($contentArcs['AND_JOIN']){
            return [$contentArcs['AND_JOIN'],'AND_JOIN'];
        } else {
            return [];
        }
    }

    /**
     * @param $place Place
     * @return array
     * @throws WorkflowDefinitionException
     */
    public function getTransitionsOfInputPlace($place) {
        if ($place->placeType == 'END') {
            throw new WorkflowDefinitionException('End Place Not Allowed As Input Pace');
        }
        list($arcs,$arcType) = $this->findInArcsOfInputPlaceId($place->id);
        $transitions = [];
        foreach($arcs as $arc) {
            if($transition = $this->transitions[$arc->transitionId]) {
                $transitions[$transition->triggerSource] = $transition;
            }
        }
        if ($transitions) {
            return [$transitions,$arcType];
        }
        throw new WorkflowDefinitionException('Input Place Must Has One Or More Transition');
    }

    /**
     * 查找符合条件的向弧 output type : 'SEQUENCE', 'EXPLICIT_OR_SPLIT',  'OR_JOIN'
     * @param $transitionId String
     * @return  array
     */
    public function findOutArcsOfTransition($transitionId){
        $contentArcs = [];
        /* @var $handlerClass DocHandlerInterface | String */
        //output type : 'SEQUENCE', 'EXPLICIT_OR_SPLIT',  'OR_JOIN'
        foreach($this->arcs as $arc){
            if($arc->direction == 'OUT' && $arc->transitionId == $transitionId) {
                if($arc->arcType == 'EXPLICIT_OR_SPLIT') {
                    $handlerClass = $this->document->docHandler;
                    if (class_exists($handlerClass)) {
                        $values = $handlerClass::getValues();
                        if(!$this->calculateExpress($arc->conditionExpress,$values)) {
                            continue;
                        }
                    }
                }
                $contentArcs[$arc->arcType] = $arc;
            }
        }
        //seq first
        if(isset($contentArcs['SEQUENCE'])) {
            return [$contentArcs['SEQUENCE'],'SEQUENCE'];
        } else if ($contentArcs['EXPLICIT_OR_SPLIT']) {
            return [$contentArcs['EXPLICIT_OR_SPLIT'],'EXPLICIT_OR_SPLIT'];
        } else if ($contentArcs['OR_JOIN']){
            return [$contentArcs['OR_JOIN'],'OR_JOIN'];
        } else {
            return [];
        }
    }

    /**
     * 查找符合条件的向弧 input type : 'SEQUENCE', 'IMPLICIT_OR_SPLIT',  'AND_JOIN'
     * @param $transitionId String|integer
     * @return  array
     */
    public function findInArcsOfTransition($transitionId){
        $contentArcs = [];
        //input type : 'SEQUENCE', 'IMPLICIT_OR_SPLIT',  'AND_JOIN'
        foreach($this->arcs as $arc){
            if($arc->direction == 'In' && $arc->transitionId == $transitionId) {
                $contentArcs[$arc->arcType] = $arc;
            }
        }
        //seq first
        if(isset($contentArcs['SEQUENCE'])) {
            return [$contentArcs['SEQUENCE'],'SEQUENCE'];
        } else if ($contentArcs['IMPLICIT_OR_SPLIT']) {
            return [$contentArcs['IMPLICIT_OR_SPLIT'],'IMPLICIT_OR_SPLIT'];
        } else if ($contentArcs['AND_JOIN']){
            return [$contentArcs['AND_JOIN'],'AND_JOIN'];
        } else {
            return [];
        }
    }

    /**
     * @param $transition Transition
     * @return array
     * @throws WorkflowDefinitionException
     */
    public function getOutPlacesOfTransition($transition) {
        /* @var $arcs Arc[] */
        /* @var $arcType String */
        list($arcs,$arcType) = $this->findOutArcsOfTransition($transition->id);
        $places = [];
        foreach($arcs as $arc) {
            if($place = $this->places[$arc->placeId]) {
                $places[$place->id] = $place;
            }
        }
        if ($places) {
            return [$places,$arcType];
        }
        throw new WorkflowDefinitionException('Transition Must Has One Or More Output Place');
    }

//    /**
//     *
//     * @param $transition Transition
//     * @param $context
//     */
//    public function fireTransition($transition,$context){
//        if($task = Task::find()->where(['id'=>$transition->taskId])->one()){
//            $handlerClass = $task->handler;
//            if (class_exists($handlerClass)) {
//                $handler = \Yii::createObject($handlerClass);
//                $handler->execute($context);
//            }
//        }
//    }

    public function calculateExpress($express,$values){
        return true;
    }

    public function startTask()
    {

    }

    protected function checkStartTask()
    {
        if(!$this->workflow->startTask) {
            throw new NotExistException('No Start Task Defined In Workflow!');
        }

        if(!$this->startTask = Task::find()->where(['id'=>$this->workflow->startTask])) {
            throw new NotExistException('Start Task Defined In Workflow Not Found!');
        }
    }

    protected function checkDefinition()
    {
        $this->checkStartTask();
        $this->checkPlaces();
        $this->checkTransition();
        $this->checkArc();
        return true;
    }

    protected function checkTransition()
    {
        if(!$this->transitions = Transition::find()->where(['workflowId'=>$this->workflow->id])->indexBy('id')->all()){
            throw new NotExistException('A Workflow Must Have  One Or More Transition !');
        }
        return true;
    }

    protected function checkArc()
    {
        if(!$this->arcs = Arc::find()->where(['workflowId'=>$this->workflow->id])->all()){
            throw new NotExistException('A Workflow Must Have  One Or More Arc !');
        }
        return true;
    }

    /**
     * @return bool
     * @throws NotExistException
     */
    protected function checkPlaces() {

        $this->places = Place::find()->where(['workflowId'=>$this->workflow->id])->indexBy('id')->all();

        foreach ($this->places as $place) {
            if($place->placeType == 'START') {
                $this->startPlace = $place;
            } else if ($place->placeType == 'END') {
                $this->endPlace = $place;
            }
        }

        if (empty($this->startPlace)) {
            throw new NotExistException('Start Place Not Exist!');
        }

        if (empty($this->endPlace)) {
            throw new NotExistException('End Place Not Exist!');
        }

        if (count($this->places)>2) {
            throw new NotExistException('Intel Places Not Exist!');
        }
        return true;
    }

}