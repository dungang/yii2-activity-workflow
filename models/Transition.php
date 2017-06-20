<?php

namespace dungang\activity\workflow\models;

use dungang\activity\workflow\helpers\WorkflowHelper;
use Yii;

/**
 * This is the model class for table "wf_transition".
 *
 * @property string $id
 * @property string $workflowId
 * @property string $taskId Required. The identity of the application task which will be activated when this transition is fired.
 * @property string $role Required. The identity of the group of users (ROLE) to which this workitem will be assigned when the entry is created. If this is no-blank the corresponding workitem will be available to all users who share that role and not a single specified user.
 * @property string $transitName
 * @property string $triggerSource A transition cannot be fired until there is at least one FREE token on each of its input places.
 * @property int $timeLimit Optional. Only valid if transition_trigger=TIME. It is a value in minutes, but is displayed and input in hours and minutes. Valid values are between 0? and 999?.
 * @property string $intro
 * @property string $createdAt The date and time on which this record was created.
 * @property int $createdUser The identity of the user who created this record.
 * @property string $updatedAt The date and time on which this record was last changed.
 * @property int $updatedUser The identity of the user who last changed this record.
 */
class Transition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wf_transition';
    }


    public function behaviors()
    {
        return [
            'dungang\activity\workflow\behaviors\DateTimeBehavior',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['workflowId', 'transitName'], 'required'],
            [['workflowId', 'taskId', 'timeLimit', 'createdUser', 'updatedUser'], 'integer'],
            [['triggerSource', 'intro'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['role'], 'string', 'max' => 32],
            [['transitName'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'workflowId' => Yii::t('app', 'Workflow ID'),
            'taskId' => Yii::t('app', 'Task ID'),
            'role' => Yii::t('app', 'Role'),
            'transitName' => Yii::t('app', 'Transit Name'),
            'triggerSource' => Yii::t('app', 'Trigger Source'),
            'timeLimit' => Yii::t('app', 'Time Limit'),
            'intro' => Yii::t('app', 'Intro'),
            'createdAt' => Yii::t('app', 'Created At'),
            'createdUser' => Yii::t('app', 'Created User'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'updatedUser' => Yii::t('app', 'Updated User'),
        ];
    }

    /**
     * @inheritdoc
     * @return TransitionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransitionQuery(get_called_class());
    }


    public static function dropItems($workflowId)
    {
        return WorkflowHelper::collection(self::className(),'transitName','id',['workflowId'=>$workflowId]);
    }
}
