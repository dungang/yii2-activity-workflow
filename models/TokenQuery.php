<?php

namespace dungang\activity\workflow\models;

/**
 * This is the ActiveQuery class for [[Token]].
 *
 * @see Token
 */
class TokenQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Token[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Token|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
