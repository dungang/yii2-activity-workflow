<?php

namespace dungang\activity\workflow\models;

use Yii;

/**
 * This is the model class for table "wf_arc".
 *
 * @property int $workflowId
 * @property int $placeId
 * @property int $transitionId
 * @property string $direction
 * @property string $arcType
 * @property string $conditionExpress guard
 * @property string $createdAt The date and time on which this record was created.
 * @property int $createdUser The identity of the user who created this record.
 * @property string $updatedAt The date and time on which this record was last changed.
 * @property int $updatedUser The identity of the user who last changed this record.
 */
class Arc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wf_arc';
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
            [['workflowId', 'placeId', 'transitionId'], 'required'],
            [['workflowId', 'placeId', 'transitionId', 'createdUser', 'updatedUser'], 'integer'],
            [['direction', 'arcType'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['conditionExpress'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'workflowId' => Yii::t('app', 'Workflow ID'),
            'placeId' => Yii::t('app', 'Place ID'),
            'transitionId' => Yii::t('app', 'Transition ID'),
            'direction' => Yii::t('app', 'Direction'),
            'arcType' => Yii::t('app', 'Arc Type'),
            'conditionExpress' => Yii::t('app', 'Condition Express'),
            'createdAt' => Yii::t('app', 'Created At'),
            'createdUser' => Yii::t('app', 'Created User'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'updatedUser' => Yii::t('app', 'Updated User'),
        ];
    }

    /**
     * @inheritdoc
     * @return ArcQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArcQuery(get_called_class());
    }
}
