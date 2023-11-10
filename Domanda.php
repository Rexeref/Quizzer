<?php
class Domanda
{
    static public $counterDomande = 0;
    private $domanda;
    private $risposte;
    private $veridicitaRisposte;

    public function __construct($domanda)
    {
    self::$counterDomande++;
    $this->domanda = $domanda;
    $this->risposte = array();
    $this->veridicitaRisposte = array();
    }

    public function getdomanda()
    {
    return $this->domanda;
    }

    public function getrisposte()
    {
    return $this->risposte;
    }

    public function addrisposta($risposta)
    {
    $this->risposte[] = $risposta;
    }

    public function getveridicitarisposte()
    {
    return $this->veridicitaRisposte;
    }

    public function addveridicitarisposta($vRisposta)
    {
    $this->veridicitaRisposte[] = $vRisposta;
    }
}
