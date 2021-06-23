<?php
/**
 * Registro “Z” - Trailler
 */
class RegistroZ
{
    private $codigoDoRegistro = null;
    private $totalDeRegistrosDoArquivo = null;
    private $valorTotalDosRegistrosDoArquivo = null;
    private $reservadoParaOFuturo = null;

    public function __construct()
    {
        $this->setCodigoDoRegistro('Z');
        $this->setTotalDeRegistrosDoArquivo('');
        $this->setValorTotalDosRegistrosDoArquivo('');
        $this->setReservadoParaOFuturo('');
    }

    private function setCodigoDoRegistro($valor)
    {
        $this->codigoDoRegistro = substr($valor, 0, 1);
    }

    public function setTotalDeRegistrosDoArquivo($valor)
    {
        $valor = $valor + 2;
        $this->totalDeRegistrosDoArquivo = str_pad(substr($valor, 0, 6), 6, '0', STR_PAD_LEFT);
    }

    public function setValorTotalDosRegistrosDoArquivo($valor)
    {
        $this->valorTotalDosRegistrosDoArquivo = str_pad(substr($valor, 0, 17), 17, '0', STR_PAD_LEFT);
    }

    private function setReservadoParaOFuturo($valor)
    {
        $this->reservadoParaOFuturo = str_pad($valor, 126, ' ');
    }

    public function getTrailler()
    {
        return $this->codigoDoRegistro .
        $this->totalDeRegistrosDoArquivo .
        $this->valorTotalDosRegistrosDoArquivo .
        $this->reservadoParaOFuturo;
    }
}
