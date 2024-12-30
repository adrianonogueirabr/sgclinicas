<?php
class Fruta{
    var $nome;
    var $tipo;

    public function __construct(){ } 
    
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    

}

$frutas = new Fruta();
$frutas->setNome("abiu");
$frutas->setTipo("aguada");

print_r($frutas);
echo "Fruta: " .$frutas->getNome() ." Tipo: ". $frutas->getTipo();