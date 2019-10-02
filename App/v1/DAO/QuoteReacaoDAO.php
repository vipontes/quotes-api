<?php

namespace App\v1\DAO;

class QuoteReacaoDAO extends Connection
{
    private $lastError = '';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the value of lastError
     */ 
    public function getLastError()
    {
        return $this->lastError;
    }

}