<?php

namespace App\v1\Models;

final class QuoteReacaoModel
{
    private $quoteId;
    private $usuarioId;
    private $reacaoId;
    private $quoteReacaoData;

    /**
     * Get the value of quoteId
     */ 
    public function getQuoteId()
    {
        return $this->quoteId;
    }

    /**
     * Set the value of quoteId
     *
     * @return  self
     */ 
    public function setQuoteId($quoteId)
    {
        $this->quoteId = $quoteId;

        return $this;
    }

    /**
     * Get the value of usuarioId
     */ 
    public function getUsuarioId()
    {
        return $this->usuarioId;
    }

    /**
     * Set the value of usuarioId
     *
     * @return  self
     */ 
    public function setUsuarioId($usuarioId)
    {
        $this->usuarioId = $usuarioId;

        return $this;
    }

    /**
     * Get the value of reacaoId
     */ 
    public function getReacaoId()
    {
        return $this->reacaoId;
    }

    /**
     * Set the value of reacaoId
     *
     * @return  self
     */ 
    public function setReacaoId($reacaoId)
    {
        $this->reacaoId = $reacaoId;

        return $this;
    }

    /**
     * Get the value of quoteReacaoData
     */ 
    public function getQuoteReacaoData()
    {
        return $this->quoteReacaoData;
    }

    /**
     * Set the value of quoteReacaoData
     *
     * @return  self
     */ 
    public function setQuoteReacaoData($quoteReacaoData)
    {
        $this->quoteReacaoData = $quoteReacaoData;

        return $this;
    }
}