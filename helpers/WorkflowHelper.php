<?php
/**
 * Author: dungang
 * Date: 2017/6/15
 * Time: 17:30
 */

namespace dungang\activity\workflow\helpers;


use dungang\activity\workflow\models\Arc;
use dungang\activity\workflow\models\Place;
use dungang\activity\workflow\models\Transition;
use yii\db\Query;

class WorkflowHelper
{

    /**
     * @param $model \yii\db\ActiveRecord|string
     * @param $text string
     * @param string $key string
     * @param null|array $condition
     * @return array
     */
    public static function collection($model,$text='name',$key='id',$condition=null) {
        if ($rows = (new Query())->select([$key,$text])->from($model::tableName())
            ->where($condition)->all()) {
            $map = [];
            foreach($rows as $row){
                $map[$row[$key]] = $row[$text];
            }
            return $map;
        }
        return [];
    }

    /**
     * @param $workflowId string
     * @return array
     */
    public static function getWorkflowDefinitionData($workflowId)
    {
        return [
            'places'=>Place::findAll(['workflowId'=>$workflowId]),
            'transitions'=>Transition::findAll(['workflowId'=>$workflowId]),
            'arcs'=>Arc::findAll(['workflowId'=>$workflowId]),
        ];
    }
}