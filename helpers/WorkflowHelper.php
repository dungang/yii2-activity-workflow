<?php
/**
 * Author: dungang
 * Date: 2017/6/15
 * Time: 17:30
 */

namespace dungang\activity\workflow\helpers;


use dungang\activity\workflow\models\Document;
use dungang\activity\workflow\models\Place;
use dungang\activity\workflow\models\Process;
use dungang\activity\workflow\models\Token;
use dungang\activity\workflow\models\Workflow;
use yii\db\Expression;
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

    public static function startWorkflowByDocumentId($document,$docId) {
        //find doc model
        $doc = Document::find()->where(['document'=>$document])->one();

        if ($doc) {

            //find doc's workflow
            $wf = Workflow::find()->where(['id'=>$doc->workflowId,'isValid'=>['YES','USED']])->one();

            if ($wf) {
                //find start place
                $place = Place::find()->where(['workflowId'=>$wf->id,'placeType'=>'START'])->one();

                if ($place) {
                    // start task
                    // The identity of the application task which, when executed,
                    // creates a new workflow process and puts a token on the start place.
                    //create Process
                    $process = new Process();
                    $process->workflowId = $wf->id;
                    $process->context = $docId;
                    $process->processStatus = 'OPEN';
                    if ($process->save(false)) {
                        //create token
                        $token = new Token();
                        $token->context = $docId;
                        $token->workflowId = $wf->id;
                        $token->processId = $process->id;
                        $token->placeId = $place->id;
                        $token->tokenStatus = 'FREE';
                        $token->enabledAt = new Expression('NOW()');
                        if ($token->save()) {
                            if ($wf->isValid == 'YES') {
                                $wf->isValid = 'USED';
                                $wf->usedAt = new Expression('NOW()');
                                $wf->save(false);
                            }
                        }
                    }

                }

            }
        }

    }
}