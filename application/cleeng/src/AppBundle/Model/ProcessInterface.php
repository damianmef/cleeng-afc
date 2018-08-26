<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 19.08.18
 * Time: 19:05
 */

namespace AppBundle\Model;

interface ProcessInterface
{
    public function addItem() : ProcessResponseObject;
    public function getItems() : ProcessResponseObject;
    public function editItem() : ProcessResponseObject;
    public function deleteItem() : ProcessResponseObject;
}