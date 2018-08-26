<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 25.08.18
 * Time: 20:48
 */

namespace AppBundle\Entity;


interface Entity
{
    public function getSimpleValues() : array;
    public function getId() : int;
}