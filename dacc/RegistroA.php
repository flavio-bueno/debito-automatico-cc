<?php
/**
 * Registro “A” - Header
 */
class RegistroA
{
    private $codigoDoRegistro = null;
    private $codigoDeRemessa = null;
    private $codigoDoConvenio = null;
    private $nomeDaEmpresa = null;
    private $codigoDoBanco = null;
    private $nomeDoBanco = null;
    private $dataDeGeracao = null;
    private $numeroSequencialDoArquivo = null;
    private $versaoDoLayout = null;
    private $identificacaoDoServico = null;
    private $reservadoParaOFuturo = null;

    public function __construct()
    {
        $this->setCodigoDoRegistro('A');
        $this->setCodigoDeRemessa('1');
        $this->setCodigoDoConvenio('');
        $this->setNomeDaEmpresa('');
        $this->setCodigoDoBanco('');
        $this->setNomeDoBanco('');
        $this->setDataDeGeracao(date('Ymd'));
        $this->setNumeroSequencialDoArquivo('');
        $this->setVersaoDoLayout('04');
        $this->setIdentificacaoDoServico('DEBITO AUTOMATICO');
        $this->setReservadoParaOFuturo('');
    }

    private function setCodigoDoRegistro($valor)
    {
        $this->codigoDoRegistro = substr($valor, 0, 1);
    }

    private function setCodigoDeRemessa($valor)
    {
        $this->codigoDeRemessa = substr($valor, 0, 1);
    }

    public function setCodigoDoConvenio($valor)
    {
        $this->codigoDoConvenio = str_pad(substr($valor, 0, 20), 20, ' ');
    }

    public function setNomeDaEmpresa($valor)
    {
        $this->nomeDaEmpresa = str_pad(substr($valor, 0, 20), 20, ' ');
    }

    public function setCodigoDoBanco($valor)
    {
        $this->codigoDoBanco = str_pad(substr($valor, 0, 3), 3, '0', STR_PAD_LEFT);
    }

    public function setNomeDoBanco($valor)
    {
        $this->nomeDoBanco = str_pad(substr($valor, 0, 20), 20, ' ');
    }

    private function setDataDeGeracao($valor)
    {
        $this->dataDeGeracao = substr($valor, 0, 8);
    }

    public function setNumeroSequencialDoArquivo($valor)
    {
        $this->numeroSequencialDoArquivo = str_pad(substr($valor, 0, 6), 6, '0', STR_PAD_LEFT);
    }

    private function setVersaoDoLayout($valor)
    {
        $this->versaoDoLayout = substr($valor, 0, 2);
    }

    private function setIdentificacaoDoServico($valor)
    {
        $this->identificacaoDoServico = substr($valor, 0, 17);
    }

    private function setReservadoParaOFuturo($valor)
    {
        $this->reservadoParaOFuturo = str_pad(substr($valor, 0, 52), 52, ' ');
    }

    public function getNumeroSequencialDoArquivo()
    {
        return $this->numeroSequencialDoArquivo;
    }

    public function getHeader()
    {
        return $this->codigoDoRegistro .
        $this->codigoDeRemessa .
        $this->codigoDoConvenio .
        $this->nomeDaEmpresa .
        $this->codigoDoBanco .
        $this->nomeDoBanco .
        $this->dataDeGeracao .
        $this->numeroSequencialDoArquivo .
        $this->versaoDoLayout .
        $this->identificacaoDoServico .
        $this->reservadoParaOFuturo;
    }
}
