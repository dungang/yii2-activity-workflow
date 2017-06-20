<?php
/**
 * Author: dungang
 * Date: 2017/6/15
 * Time: 14:15
 */

namespace dungang\activity\workflow\behaviors;


use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

class DateTimeBehavior extends Behavior
{
    /**
     * @var BaseActiveRecord
     */
    public $owner;

    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'onCreate',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'onUpdate',
        ];
    }

    public function onCreate()
    {
        $this->createAttr();
        $this->updateAttr();
    }

    public function onUpdate()
    {
        if($this->owner->dirtyAttributes) {
            $this->updateAttr();
        }
    }

    private function updateAttr(){
        $id = \Yii::$app->user->id;
        if ($this->owner->hasAttribute('updatedAt')) {
            $this->owner->setAttribute('updatedAt',new Expression('NOW()'));
        }
        if ($this->owner->hasAttribute('updatedUser')) {
            $this->owner->setAttribute('updatedUser',$id);
        }
    }

    private function createAttr() {
        $id = \Yii::$app->user->id;
        if ($this->owner->hasAttribute('createdAt')) {
            $this->owner->setAttribute('createdAt',new Expression('NOW()'));
        }
        if ($this->owner->hasAttribute('createdUser')) {
            $this->owner->setAttribute('createdUser',$id);
        }
    }
}