<?php

namespace dungang\activity\workflow;


/**
 * Class Module
 * @package huluwa\workflow
 */
class Module extends \yii\base\Module
{
    public $defaultRoute='definition';
    /**
     * @var string
     */
    public $controllerNamespace = 'dungang\activity\workflow\controllers';
    
    public function init()
    {
        parent::init();
    }
}
