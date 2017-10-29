<?php
/**
 * Created by PhpStorm.
 * User: dennis
 * Date: 28.10.17
 * Time: 22:16
 */

namespace Mini\Dao;


class DaoException extends \Exception
{
    public function __construct(
        $message,
        $code = 0,
        \Exception $previous = null
    ) {

        parent::__construct($message, $code, $previous);
    }
}