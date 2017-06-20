<?php

namespace dungang\activity\workflow\models;

/**
 * This is the ActiveQuery class for [[Process]].
 *
 * @see Process
 */
class ProcessQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Process[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Process|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
