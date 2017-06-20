<?php

namespace dungang\activity\workflow\models;

/**
 * This is the ActiveQuery class for [[Arc]].
 *
 * @see Arc
 */
class ArcQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Arc[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Arc|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
