<?php

namespace App\v1\Models;

final class QuoteModel
{
    private $quoteId;
    private $usuarioId;
    private $quoteDataCriacao;
    private $quoteConteudo;
    private $quoteConteudoOfensivo;
    private $quoteUsuarioConteudoOfensivoId;

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
     * Get the value of quoteDataCriacao
     */ 
    public function getQuoteDataCriacao()
    {
        return $this->quoteDataCriacao;
    }

    /**
     * Set the value of quoteDataCriacao
     *
     * @return  self
     */ 
    public function setQuoteDataCriacao($quoteDataCriacao)
    {
        $this->quoteDataCriacao = $quoteDataCriacao;

        return $this;
    }

    /**
     * Get the value of quoteConteudo
     */ 
    public function getQuoteConteudo()
    {
        return $this->quoteConteudo;
    }

    /**
     * Set the value of quoteConteudo
     *
     * @return  self
     */ 
    public function setQuoteConteudo($quoteConteudo)
    {
        $this->quoteConteudo = $quoteConteudo;

        return $this;
    }

    /**
     * Get the value of quoteConteudoOfensivo
     */ 
    public function getQuoteConteudoOfensivo()
    {
        return $this->quoteConteudoOfensivo;
    }

    /**
     * Set the value of quoteConteudoOfensivo
     *
     * @return  self
     */ 
    public function setQuoteConteudoOfensivo($quoteConteudoOfensivo)
    {
        $this->quoteConteudoOfensivo = $quoteConteudoOfensivo;

        return $this;
    }

    /**
     * Get the value of quoteUsuarioConteudoOfensivoId
     */ 
    public function getQuoteUsuarioConteudoOfensivoId()
    {
        return $this->quoteUsuarioConteudoOfensivoId;
    }

    /**
     * Set the value of quoteUsuarioConteudoOfensivoId
     *
     * @return  self
     */ 
    public function setQuoteUsuarioConteudoOfensivoId($quoteUsuarioConteudoOfensivoId)
    {
        $this->quoteUsuarioConteudoOfensivoId = $quoteUsuarioConteudoOfensivoId;

        return $this;
    }
}