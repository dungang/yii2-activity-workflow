<?php

namespace dungang\activity\workflow\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use dungang\activity\workflow\models\Document;

/**
 * DocumentSearch represents the model behind the search form of `dungang\activity\workflow\models\Document`.
 */
class DocumentSearch extends Document
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'workflowId', 'createdUser', 'updatedUser'], 'integer'],
            [['document', 'name', 'docHandler', 'intro', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = Document::find();

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
            'createdAt' => $this->createdAt,
            'createdUser' => $this->createdUser,
            'updatedAt' => $this->updatedAt,
            'updatedUser' => $this->updatedUser,
        ]);

        $query->andFilterWhere(['like', 'document', $this->document])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'docHandler', $this->docHandler])
            ->andFilterWhere(['like', 'intro', $this->intro]);

        return $dataProvider;
    }
}
