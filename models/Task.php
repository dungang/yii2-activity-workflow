<?php

namespace dungang\activity\workflow\models;

use dungang\activity\workflow\helpers\WorkflowHelper;
use Yii;

/**
 * This is the model class for table "wf_task".
 *
 * @property string $id
 * @property string $taskName
 * @property string $handler
 * @property string $params
 * @property string $intro
 * @property string $createdAt The date and time on which this record was created.
 * @property int $createdUser The identity of the user who created this record.
 * @property string $updatedAt The date and time on which this record was last changed.
 * @property int $updatedUser The identity of the user who last changed this record.
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wf_task';
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
            [['taskName', 'handler'], 'required'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['createdUser', 'updatedUser'], 'integer'],
            [['taskName'], 'string', 'max' => 128],
            [['permission', 'params'], 'string', 'max' => 64],
            [['intro'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'taskName' => Yii::t('app', 'Task Name'),
            'handler' => Yii::t('app', 'Handler'),
            'params' => Yii::t('app', 'Params'),
            'intro' => Yii::t('app', 'Intro'),
            'createdAt' => Yii::t('app', 'Created At'),
            'createdUser' => Yii::t('app', 'Created User'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'updatedUser' => Yii::t('app', 'Updated User'),
        ];
    }

    /**
     * @inheritdoc
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }

    public static function dropItems()
    {
        return WorkflowHelper::collection(self::className(),'taskName','id');
    }
}
