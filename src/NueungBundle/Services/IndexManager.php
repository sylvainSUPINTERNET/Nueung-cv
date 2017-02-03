<?php

namespace NueungBundle\Services;


class IndexManager
{
    protected $username;

    public function __construct($username)
    {
        $this->username = $this->getUserName();
    }

    public function getUserName()
    {
        return $this->username;
    }


}
