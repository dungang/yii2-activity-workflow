<?php

namespace dungang\activity\workflow\models;

use dungang\activity\workflow\helpers\WorkflowHelper;
use Yii;

/**
 * This is the model class for table "wf_workflow".
 *
 * @property string $id
 * @property string $workflowName
 * @property int $startTask Required. The identity of the application task which, when executed, creates a new workflow case and puts a token on the start place.
 * @property string $isValid Default is NO. After defining all the places, transitions and arcs for a workflow process it must be validated before it can be used. This field shows the result of that validation.
 * @property string $intro
 * @property string $usedAt
 * @property string $archivedAt
 * @property string $createdAt The date and time on which this record was created.
 * @property int $createdUser The identity of the user who created this record.
 * @property string $updatedAt The date and time on which this record was last changed.
 * @property int $updatedUser The identity of the user who last changed this record.
 */
class Workflow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wf_workflow';
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
            [['workflowName'], 'required'],
            [['startTask', 'createdUser', 'updatedUser'], 'integer'],
            [['isValid', 'intro'], 'string'],
            [['usedAt', 'archivedAt', 'createdAt', 'updatedAt'], 'safe'],
            [['workflowName'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'workflowName' => Yii::t('app', 'Workflow Name'),
            'startTask' => Yii::t('app', 'Start Task'),
            'isValid' => Yii::t('app', 'Is Valid'),
            'intro' => Yii::t('app', 'Intro'),
            'usedAt' => Yii::t('app', 'Used At'),
            'archivedAt' => Yii::t('app', 'Archived At'),
            'createdAt' => Yii::t('app', 'Created At'),
            'createdUser' => Yii::t('app', 'Created User'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'updatedUser' => Yii::t('app', 'Updated User'),
        ];
    }

    /**
     * @inheritdoc
     * @return WorkflowQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WorkflowQuery(get_called_class());
    }

    public static function dropItems()
    {
        return WorkflowHelper::collection(self::className(),'workflowName','id',['isValid'=>'YES']);
    }
}
