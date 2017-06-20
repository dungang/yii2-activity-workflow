<?php

namespace dungang\activity\workflow\models;

use Yii;

/**
 * This is the model class for table "wf_work_item".
 *
 * @property string $id
 * @property string $workflowId
 * @property string $transitionId
 * @property string $processId
 * @property string $taskId Required. The identity of the application task which will be activated when this transition is fired.
 * @property string $context The primary key of a database entry that will be passed to the application task when this workitem is processed.
 * @property string $triggerSource Set by the system. Shows how this transition was fired.
 * @property string $workStatus
 * @property string $enabledAt The data and time on which this workitem was enabled.
 * @property string $deadlinedAt where the transition_trigger=TIME this is the date and time on which the deadline expires.
 * @property string $finishedAt The data and time on which this workitem was finished
 * @property string $cancelledAt The data and time on which this workitem was cancelled
 * @property string $user
 * @property string $role
 */
class WorkItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wf_work_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['workflowId', 'transitionId', 'processId', 'user', 'role'], 'required'],
            [['workflowId', 'transitionId', 'processId', 'taskId', 'user'], 'integer'],
            [['triggerSource', 'workStatus'], 'string'],
            [['enabledAt', 'deadlinedAt', 'finishedAt', 'cancelledAt'], 'safe'],
            [['context'], 'string', 'max' => 255],
            [['role'], 'string', 'max' => 32],
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
            'transitionId' => Yii::t('app', 'Transition ID'),
            'processId' => Yii::t('app', 'Process ID'),
            'taskId' => Yii::t('app', 'Task ID'),
            'context' => Yii::t('app', 'Context'),
            'triggerSource' => Yii::t('app', 'Trigger Source'),
            'workStatus' => Yii::t('app', 'Work Status'),
            'enabledAt' => Yii::t('app', 'Enabled At'),
            'deadlinedAt' => Yii::t('app', 'Deadlined At'),
            'finishedAt' => Yii::t('app', 'Finished At'),
            'cancelledAt' => Yii::t('app', 'Cancelled At'),
            'user' => Yii::t('app', 'User'),
            'role' => Yii::t('app', 'Role'),
        ];
    }

    /**
     * @inheritdoc
     * @return WorkItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WorkItemQuery(get_called_class());
    }
}
