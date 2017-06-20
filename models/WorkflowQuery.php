<?php

namespace dungang\activity\workflow\models;

/**
 * This is the ActiveQuery class for [[Workflow]].
 *
 * @see Workflow
 */
class WorkflowQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Workflow[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Workflow|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
