<?php
/**
 * Author: dungang
 * Date: 2017/6/16
 * Time: 9:38
 */

namespace dungang\activity\workflow\exceptions;


class WorkflowDefinitionException extends \Exception
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'WorkflowDefinitionException';
    }
}