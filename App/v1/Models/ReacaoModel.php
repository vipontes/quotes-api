<?php

namespace App\v1\Models;

final class ReacaoModel
{
    private $reacaoId;
    private $reacaoDescricao;
    private $reacaoIcon;

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
     * Get the value of reacaoDescricao
     */ 
    public function getReacaoDescricao()
    {
        return $this->reacaoDescricao;
    }

    /**
     * Set the value of reacaoDescricao
     *
     * @return  self
     */ 
    public function setReacaoDescricao($reacaoDescricao)
    {
        $this->reacaoDescricao = $reacaoDescricao;

        return $this;
    }

    /**
     * Get the value of reacaoIcon
     */ 
    public function getReacaoIcon()
    {
        return $this->reacaoIcon;
    }

    /**
     * Set the value of reacaoIcon
     *
     * @return  self
     */ 
    public function setReacaoIcon($reacaoIcon)
    {
        $this->reacaoIcon = $reacaoIcon;

        return $this;
    }
}