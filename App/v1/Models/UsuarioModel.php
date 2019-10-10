<?php

namespace App\v1\Models;

use JsonSerializable;

final class UsuarioModel implements JsonSerializable
{
    private $usuarioId = 0;
    private $usuarioNome = '';
    private $usuarioEmail = '';
    private $usuarioSenha = '';
    private $usuarioAtivo = 0;
    private $usuarioSobre = '';
    private $token = '';
    private $refreshToken = '';

    public function jsonSerialize() {
        return [
            'usuarioId' => $this->usuarioId,
            'usuarioNome' => $this->usuarioNome,
            'usuarioEmail' => $this->usuarioEmail,
            'usuarioSenha' => $this->usuarioSenha,
            'usuarioAtivo' => $this->usuarioAtivo,
            'usuarioSobre' => $this->usuarioSobre,
            'token' => $this->token,
            'refreshToken' => $this->refreshToken
        ];
    }

    /**
     * Get the value of usuarioId
     */ 
    public function getUsuarioId(): int
    {
        return $this->usuarioId;
    }

    /**
     * Set the value of usuarioId
     *
     * @return  self
     */ 
    public function setUsuarioId($usuarioId): self
    {
        $this->usuarioId = $usuarioId;

        return $this;
    }

    /**
     * Get the value of usuarioNome
     */ 
    public function getUsuarioNome(): string
    {
        return $this->usuarioNome;
    }

    /**
     * Set the value of usuarioNome
     * @return  self
     */ 
    public function setUsuarioNome($usuarioNome): self
    {
        $this->usuarioNome = $usuarioNome;
        return $this;
    }

    /**
     * Get the value of usuarioEmail
     */ 
    public function getUsuarioEmail(): string
    {
        return $this->usuarioEmail;
    }

    /**
     * Set the value of usuarioEmail
     * @return  self
     */ 
    public function setUsuarioEmail($usuarioEmail): self
    {
        $this->usuarioEmail = $usuarioEmail;
        return $this;
    }

    /**
     * Get the value of usuarioSenha
     */ 
    public function getUsuarioSenha(): string
    {
        return $this->usuarioSenha;
    }

    /**
     * Set the value of usuarioSenha
     * @return  self
     */ 
    public function setUsuarioSenha($usuarioSenha): self
    {
        $this->usuarioSenha = $usuarioSenha;
        return $this;
    }

    /**
     * Get the value of usuarioAtivo
     */ 
    public function getUsuarioAtivo(): int
    {
        return $this->usuarioAtivo;
    }

    /**
     * Set the value of usuarioAtivo
     * @return  self
     */ 
    public function setUsuarioAtivo($usuarioAtivo): self
    {
        $this->usuarioAtivo = $usuarioAtivo;
        return $this;
    }

    /**
     * Get the value of usuarioSobre
     */ 
    public function getUsuarioSobre(): string
    {
        return $this->usuarioSobre;
    }

    /**
     * Set the value of usuarioSobre
     * @return  self
     */ 
    public function setUsuarioSobre($usuarioSobre): self
    {
        $this->usuarioSobre = $usuarioSobre;
        return $this;
    }

    /**
     * Get the value of token
     */ 
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function setToken($token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get the value of refreshToken
     */ 
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * Set the value of refreshToken
     *
     * @return  self
     */ 
    public function setRefreshToken($refreshToken): self
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }
}