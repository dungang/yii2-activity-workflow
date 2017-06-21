<?php

namespace dungang\activity\workflow\models;

use Yii;

/**
 * This is the model class for table "wf_process".
 *
 * @property string $id
 * @property string $workflowId
 * @property string $context The primary key of the database entry to which this case refers in the format of an sql WHERE clause.This is produced by the application task identified in START_TASK_ID on the WORKFLOW table.
 * @property string $processStatus
 * @property string $startedAt Set by the system when this entry is opened.
 * @property string $endedAt Set by the system when this entry is closed. This occurs when a token is placed in the end place.
 * @property string $createdAt The date and time on which this record was created.
 * @property int $createdUser The identity of the user who created this record.
 * @property string $updatedAt The date and time on which this record was last changed.
 * @property int $updatedUser The identity of the user who last changed this record.
 */
class Process extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wf_process';
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
            [['workflowId', 'createdUser', 'updatedUser'], 'integer'],
            [['context'], 'required'],
            [['processStatus'], 'string'],
            [['startedAt', 'endedAt', 'createdAt', 'updatedAt'], 'safe'],
            [['context'], 'string', 'max' => 255],
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
            'context' => Yii::t('app', 'Context'),
            'processStatus' => Yii::t('app', 'Process Status'),
            'startedAt' => Yii::t('app', 'Started At'),
            'endedAt' => Yii::t('app', 'Ended At'),
            'createdAt' => Yii::t('app', 'Created At'),
            'createdUser' => Yii::t('app', 'Created User'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'updatedUser' => Yii::t('app', 'Updated User'),
        ];
    }

    /**
     * @inheritdoc
     * @return ProcessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProcessQuery(get_called_class());
    }
}
