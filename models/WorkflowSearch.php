<?php

namespace dungang\activity\workflow\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use dungang\activity\workflow\models\Workflow;

/**
 * WorkflowSearch represents the model behind the search form of `dungang\activity\workflow\models\Workflow`.
 */
class WorkflowSearch extends Workflow
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'startTask', 'createdUser', 'updatedUser'], 'integer'],
            [['workflowName', 'isValid', 'intro','usedAt', 'archivedAt',  'createdAt', 'updatedAt'], 'safe'],
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
        $query = Workflow::find();

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
            'startTask' => $this->startTask,
            'usedAt' => $this->usedAt,
            'archivedAt' => $this->archivedAt,
            'createdAt' => $this->createdAt,
            'createdUser' => $this->createdUser,
            'updatedAt' => $this->updatedAt,
            'updatedUser' => $this->updatedUser,
        ]);

        $query->andFilterWhere(['like', 'workflowName', $this->workflowName])
            ->andFilterWhere(['like', 'isValid', $this->isValid])
            ->andFilterWhere(['like', 'intro', $this->intro]);

        return $dataProvider;
    }
}
