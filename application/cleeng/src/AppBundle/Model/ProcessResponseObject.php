<?php
/**
 * Created by PhpStorm.
 * User: damian
 * Date: 19.08.18
 * Time: 19:10
 */

namespace AppBundle\Model;

class ProcessResponseObject
{
    /**
     * @var bool
     */
    private $status = false;

    /**
     * @var string
     */
    private $msg = '';

    /**
     * @var array
     */
    private $data = [];

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     */
    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * @param string $msg
     */
    public function setMsg(string $msg): void
    {
        $this->msg = $msg;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function updateData(array $data): void
    {
        $this->data = array_merge($this->data, $data);
    }

    public function toArray()
    {
        return [
            'status' => $this->getStatus(),
            'msg' => $this->getMsg(),
            'data' => $this->getData()
        ];
    }
}