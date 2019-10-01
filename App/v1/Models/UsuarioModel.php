<?php

namespace App\v1\Models;

final class UsuarioModel
{
    private $usuarioId = 0;
    private $usuarioNome = '';
    private $usuarioEmail = '';
    private $usuarioSenha = '';
    private $usuarioAtivo = 0;
    private $usuarioSobre = '';

    public function __construct()
    {
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
     * Get the value of usuarioEmail
     */ 
    public function getUsuarioEmail()
    {
        return $this->usuarioEmail;
    }

    /**
     * Set the value of usuarioEmail
     *
     * @return  self
     */ 
    public function setUsuarioEmail($usuarioEmail)
    {
        $this->usuarioEmail = $usuarioEmail;

        return $this;
    }

    /**
     * Get the value of usuarioSenha
     */ 
    public function getUsuarioSenha()
    {
        return $this->usuarioSenha;
    }

    /**
     * Set the value of usuarioSenha
     *
     * @return  self
     */ 
    public function setUsuarioSenha($usuarioSenha)
    {
        $this->usuarioSenha = $usuarioSenha;

        return $this;
    }

    /**
     * Get the value of usuarioAtivo
     */ 
    public function getUsuarioAtivo()
    {
        return $this->usuarioAtivo;
    }

    /**
     * Set the value of usuarioAtivo
     *
     * @return  self
     */ 
    public function setUsuarioAtivo($usuarioAtivo)
    {
        $this->usuarioAtivo = $usuarioAtivo;

        return $this;
    }

    /**
     * Get the value of usuarioSobre
     */ 
    public function getUsuarioSobre()
    {
        return $this->usuarioSobre;
    }

    /**
     * Set the value of usuarioSobre
     *
     * @return  self
     */ 
    public function setUsuarioSobre($usuarioSobre)
    {
        $this->usuarioSobre = $usuarioSobre;

        return $this;
    }
}