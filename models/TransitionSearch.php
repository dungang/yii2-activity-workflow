<?php

namespace dungang\activity\workflow\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use dungang\activity\workflow\models\Transition;

/**
 * TransitionSearch represents the model behind the search form of `dungang\activity\workflow\models\Transition`.
 */
class TransitionSearch extends Transition
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'workflowId', 'taskId', 'timeLimit', 'createdUser', 'updatedUser'], 'integer'],
            [['role', 'transitName', 'triggerSource', 'intro', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = Transition::find();

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
            'taskId' => $this->taskId,
            'timeLimit' => $this->timeLimit,
            'createdAt' => $this->createdAt,
            'createdUser' => $this->createdUser,
            'updatedAt' => $this->updatedAt,
            'updatedUser' => $this->updatedUser,
        ]);

        $query->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'transitName', $this->transitName])
            ->andFilterWhere(['like', 'triggerSource', $this->triggerSource])
            ->andFilterWhere(['like', 'intro', $this->intro]);

        return $dataProvider;
    }
}
