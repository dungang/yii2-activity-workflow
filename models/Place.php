<?php

namespace dungang\activity\workflow\models;

use dungang\activity\workflow\helpers\WorkflowHelper;
use Yii;

/**
 * This is the model class for table "wf_place".
 *
 * @property string $id
 * @property string $workflowId Required. Points to an entry on the WORKFLOW table.
 * @property string $placeName
 * @property string $placeType When a new workflow process is created a start place and an end place will be created automatically. The user is responsible for creating all the intermediate places.
 * @property string $createdAt The date and time on which this record was created.
 * @property int $createdUser The identity of the user who created this record.
 * @property string $updatedAt The date and time on which this record was last changed.
 * @property int $updatedUser The identity of the user who last changed this record.
 */
class Place extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wf_place';
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
            [['workflowId', 'placeName'], 'required'],
            [['workflowId', 'createdUser', 'updatedUser'], 'integer'],
            [['placeType'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['placeName'], 'string', 'max' => 64],
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
            'placeName' => Yii::t('app', 'Place Name'),
            'placeType' => Yii::t('app', 'Place Type'),
            'createdAt' => Yii::t('app', 'Created At'),
            'createdUser' => Yii::t('app', 'Created User'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'updatedUser' => Yii::t('app', 'Updated User'),
        ];
    }

    /**
     * @inheritdoc
     * @return PlaceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PlaceQuery(get_called_class());
    }

    public static function dropItems($workflowId)
    {
        return WorkflowHelper::collection(self::className(),'placeName','id',['workflowId'=>$workflowId]);
    }
}
