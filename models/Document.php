<?php

namespace dungang\activity\workflow\models;

use dungang\activity\workflow\helpers\WorkflowHelper;
use Yii;

/**
 * This is the model class for table "wf_document".
 *
 * @property string $id
 * @property string $document
 * @property string $workflowId
 * @property string $name
 * @property string $docHandler
 * @property string $intro
 * @property string $createdAt The date and time on which this record was created.
 * @property int $createdUser The identity of the user who created this record.
 * @property string $updatedAt The date and time on which this record was last changed.
 * @property int $updatedUser The identity of the user who last changed this record.
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wf_document';
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
            [['document', 'workflowId', 'name'], 'required'],
            [['workflowId', 'createdUser', 'updatedUser'], 'integer'],
            [['intro'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['document'], 'string', 'max' => 32],
            [['name', 'docModel'], 'string', 'max' => 128],
            [['document'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'document' => Yii::t('app', 'Document'),
            'workflowId' => Yii::t('app', 'Workflow ID'),
            'name' => Yii::t('app', 'Name'),
            'docHandler' => Yii::t('app', 'Doc Handler'),
            'intro' => Yii::t('app', 'Intro'),
            'createdAt' => Yii::t('app', 'Created At'),
            'createdUser' => Yii::t('app', 'Created User'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'updatedUser' => Yii::t('app', 'Updated User'),
        ];
    }

    /**
     * @inheritdoc
     * @return DocumentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DocumentQuery(get_called_class());
    }

    public static function dropItems()
    {
        return WorkflowHelper::collection(self::className());
    }
}
