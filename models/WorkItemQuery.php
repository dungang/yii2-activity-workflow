<?php

namespace dungang\activity\workflow\models;

/**
 * This is the ActiveQuery class for [[WorkItem]].
 *
 * @see WorkItem
 */
class WorkItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return WorkItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return WorkItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
