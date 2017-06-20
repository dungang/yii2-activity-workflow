<?php

namespace dungang\activity\workflow\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use dungang\activity\workflow\models\WorkItem;

/**
 * WorkItemSearch represents the model behind the search form of `dungang\activity\workflow\models\WorkItem`.
 */
class WorkItemSearch extends WorkItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'workflowId', 'transitionId', 'processId', 'taskId', 'user'], 'integer'],
            [['context', 'triggerSource', 'workStatus', 'enabledAt', 'deadlinedAt', 'finishedAt', 'cancelledAt', 'role'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = WorkItem::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'workflowId' => $this->workflowId,
            'transitionId' => $this->transitionId,
            'processId' => $this->processId,
            'taskId' => $this->taskId,
            'enabledAt' => $this->enabledAt,
            'deadlinedAt' => $this->deadlinedAt,
            'finishedAt' => $this->finishedAt,
            'cancelledAt' => $this->cancelledAt,
            'user' => $this->user,
        ]);

        $query->andFilterWhere(['like', 'context', $this->context])
            ->andFilterWhere(['like', 'triggerSource', $this->triggerSource])
            ->andFilterWhere(['like', 'workStatus', $this->workStatus])
            ->andFilterWhere(['like', 'role', $this->role]);

        return $dataProvider;
    }
}
