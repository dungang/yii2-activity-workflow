<?php
/**
 * Author: dungang
 * Date: 2017/6/16
 * Time: 19:34
 */

namespace dungang\activity\workflow\interfaces;


interface DocHandlerInterface
{

    /**
     * @return array
     */
    public static function getVars();

    /**
     * @return array
     */
    public static function getValues();


    /**
     * @param $role mixed
     * @param $currentUserId mixed
     * @return mixed
     */
    public static function getTransitionUser($role,$currentUserId);


    /**
     * @param $context mixed
     * @return mixed
     */
    public static function afterStartWorkflow($context);

}