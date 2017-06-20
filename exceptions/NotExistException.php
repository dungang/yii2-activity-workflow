<?php
namespace dungang\activity\workflow\exceptions;


class NotExistException extends \Exception
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'NotExistException';
    }
}