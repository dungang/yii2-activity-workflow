<?php

namespace dungang\activity\workflow\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProcessSearch represents the model behind the search form of `dungang\activity\workflow\models\Process`.
 */
class ProcessSearch extends Process
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'workflowId', 'createdUser', 'updatedUser'], 'integer'],
            [['context', 'processStatus', 'startedAt', 'endedAt', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = Process::find();

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
            'startedAt' => $this->startedAt,
            'endedAt' => $this->endedAt,
            'createdAt' => $this->createdAt,
            'createdUser' => $this->createdUser,
            'updatedAt' => $this->updatedAt,
            'updatedUser' => $this->updatedUser,
        ]);

        $query->andFilterWhere(['like', 'context', $this->context])
            ->andFilterWhere(['like', 'processStatus', $this->processStatus]);

        return $dataProvider;
    }
}
