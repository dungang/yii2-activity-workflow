<?php

namespace dungang\activity\workflow\models;

use Yii;

/**
 * This is the model class for table "wf_token".
 *
 * @property string $id
 * @property string $workflowId
 * @property string $placeId
 * @property string $processId
 * @property string $context The primary key of the database entry as passed down by the previous transition (application task).
 * @property string $tokenStatus When a token is created it will automatically have a FREE status. A token on an input place must be FREE before a transition can be fired.
 * @property string $enabledAt The date and time on which this token appeared in this place.
 * @property string $cancelledAt The date and time on which this token was cancelled.
 * @property string $consumedAt The date and time on which this token was consumed by a transition being fired.
 */
class Token extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wf_token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['workflowId', 'placeId', 'processId', 'context'], 'required'],
            [['workflowId', 'placeId', 'processId'], 'integer'],
            [['tokenStatus'], 'string'],
            [['enabledAt', 'cancelledAt', 'consumedAt'], 'safe'],
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
            'placeId' => Yii::t('app', 'Place ID'),
            'processId' => Yii::t('app', 'Process ID'),
            'context' => Yii::t('app', 'Context'),
            'tokenStatus' => Yii::t('app', 'Token Status'),
            'enabledAt' => Yii::t('app', 'Enabled At'),
            'cancelledAt' => Yii::t('app', 'Cancelled At'),
            'consumedAt' => Yii::t('app', 'Consumed At'),
        ];
    }

    /**
     * @inheritdoc
     * @return TokenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TokenQuery(get_called_class());
    }
}
