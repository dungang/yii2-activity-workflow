<?php

namespace dungang\activity\workflow\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use dungang\activity\workflow\models\Token;

/**
 * TokenSearch represents the model behind the search form of `dungang\activity\workflow\models\Token`.
 */
class TokenSearch extends Token
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'workflowId', 'placeId', 'processId'], 'integer'],
            [['context', 'tokenStatus', 'enabledAt', 'cancelledAt', 'consumedAt'], 'safe'],
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
        $query = Token::find();

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
            'placeId' => $this->placeId,
            'processId' => $this->processId,
            'enabledAt' => $this->enabledAt,
            'cancelledAt' => $this->cancelledAt,
            'consumedAt' => $this->consumedAt,
        ]);

        $query->andFilterWhere(['like', 'context', $this->context])
            ->andFilterWhere(['like', 'tokenStatus', $this->tokenStatus]);

        return $dataProvider;
    }
}
