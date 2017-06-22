<?php

namespace dungang\activity\workflow\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use dungang\activity\workflow\models\Arc;

/**
 * ArcSearch represents the model behind the search form of `dungang\activity\workflow\models\Arc`.
 */
class ArcSearch extends Arc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['workflowId', 'placeId', 'transitionId', 'createdUser', 'updatedUser'], 'integer'],
            [['direction', 'arcType', 'conditionExpress', 'conditionIntro', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = Arc::find();

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
            'workflowId' => $this->workflowId,
            'placeId' => $this->placeId,
            'transitionId' => $this->transitionId,
            'createdAt' => $this->createdAt,
            'createdUser' => $this->createdUser,
            'updatedAt' => $this->updatedAt,
            'updatedUser' => $this->updatedUser,
        ]);

        $query->andFilterWhere(['like', 'direction', $this->direction])
            ->andFilterWhere(['like', 'arcType', $this->arcType])
            ->andFilterWhere(['like', 'conditionIntro', $this->conditionIntro])
            ->andFilterWhere(['like', 'conditionExpress', $this->conditionExpress]);

        return $dataProvider;
    }
}
