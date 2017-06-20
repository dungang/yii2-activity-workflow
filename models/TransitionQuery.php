<?php

namespace dungang\activity\workflow\models;

/**
 * This is the ActiveQuery class for [[Transition]].
 *
 * @see Transition
 */
class TransitionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Transition[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Transition|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
