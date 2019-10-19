<?php

namespace App\v1\Models;

use JsonSerializable;

final class QuoteModel implements JsonSerializable
{
    private $quoteId;
    private $usuarioId;
    private $quoteDataCriacao;
    private $quoteConteudo;
    private $quoteConteudoOfensivo;
    private $quoteUsuarioConteudoOfensivoId;
    private $usuarioNome;
    private $usuarioDenunciaNome;
    private $quoteGostei;
    private $quoteNaoGostei;

    public function jsonSerialize() {
        return [
            'quoteId' => $this->quoteId,
            'usuarioId' => $this->usuarioId,
            'quoteDataCriacao' => $this->quoteDataCriacao,
            'quoteConteudo' => $this->quoteConteudo,
            'quoteConteudoOfensivo' => $this->quoteConteudoOfensivo,
            'quoteUsuarioConteudoOfensivoId' => $this->quoteUsuarioConteudoOfensivoId,
            'usuarioNome' => $this->usuarioNome,
            'usuarioDenunciaNome' => $this->usuarioDenunciaNome,
            'quoteGostei' => $this->quoteGostei,
            'quoteNaoGostei' => $this->quoteNaoGostei,
        ];
    }

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

    /**
     * Get the value of usuarioNome
     */ 
    public function getUsuarioNome()
    {
        return $this->usuarioNome;
    }

    /**
     * Set the value of usuarioNome
     *
     * @return  self
     */ 
    public function setUsuarioNome($usuarioNome)
    {
        $this->usuarioNome = $usuarioNome;

        return $this;
    }

    /**
     * Get the value of usuarioDenunciaNome
     */ 
    public function getUsuarioDenunciaNome()
    {
        return $this->usuarioDenunciaNome;
    }

    /**
     * Set the value of usuarioDenunciaNome
     *
     * @return  self
     */ 
    public function setUsuarioDenunciaNome($usuarioDenunciaNome)
    {
        $this->usuarioDenunciaNome = $usuarioDenunciaNome;

        return $this;
    }

    /**
     * Get the value of quoteGostei
     */ 
    public function getQuoteGostei()
    {
        return $this->quoteGostei;
    }

    /**
     * Set the value of quoteGostei
     *
     * @return  self
     */ 
    public function setQuoteGostei($quoteGostei)
    {
        $this->quoteGostei = $quoteGostei;

        return $this;
    }

    /**
     * Get the value of quoteNaoGostei
     */ 
    public function getQuoteNaoGostei()
    {
        return $this->quoteNaoGostei;
    }

    /**
     * Set the value of quoteNaoGostei
     *
     * @return  self
     */ 
    public function setQuoteNaoGostei($quoteNaoGostei)
    {
        $this->quoteNaoGostei = $quoteNaoGostei;

        return $this;
    }
}