<?php
/**
 * Registro “E” - Débito em Conta Corrente
 */
class RegistroE
{
    private $codigoDoRegistro = null;
    private $identificacaoDoClienteNaEmpresa = null;
    private $agenciaParaDebito = null;
    private $identificacaoDoClienteNoBanco = null;
    private $dataDoVencimento = null;
    private $valorDeDebito = null;
    private $codigoDaMoeda = null;
    private $usoDaEmpresa = null;
    private $reservadoParaOFuturo = null;
    private $codigoDoMovimento = null;

    public function __construct()
    {
        $this->setCodigoDoRegistro('E');
        $this->setIdentificacaoDoClienteNaEmpresa('');
        $this->setAgenciaParaDebito('');
        $this->setIdentificacaoDoClienteNoBanco('');
        $this->setDataDoVencimento('');
        $this->setValorDeDebito('');
        $this->setCodigoDaMoeda('03');
        $this->setUsoDaEmpresa('', '', '');
        $this->setReservadoParaOFuturo('');
        $this->setCodigoDoMovimento('0');
    }

    private function setCodigoDoRegistro($valor)
    {
        $this->codigoDoRegistro = substr($valor, 0, 1);
    }

    public function setIdentificacaoDoClienteNaEmpresa($valor)
    {
        $this->identificacaoDoClienteNaEmpresa = str_pad(substr($valor, 0, 25), 25, ' ');
    }

    public function setAgenciaParaDebito($valor)
    {
        $this->agenciaParaDebito = str_pad(substr($valor, 0, 4), 4, ' ');
    }

    public function setIdentificacaoDoClienteNoBanco($valor)
    {
        $this->identificacaoDoClienteNoBanco = str_pad(substr($valor, 0, 14), 14, ' ');
    }

    public function setDataDoVencimento($valor)
    {
        $this->dataDoVencimento = str_pad(substr($valor, 0, 8), 8, ' ');
    }

    public function setValorDeDebito($valor)
    {
        $valor = str_replace(['R$ ', 'R$', '.', ',', ' '], '', $valor);
        $this->valorDeDebito = str_pad(substr($valor, 0, 15), 15, '0', STR_PAD_LEFT);
    }

    private function setCodigoDaMoeda($valor)
    {
        $this->codigoDaMoeda = substr($valor, 0, 2);
    }

    public function setUsoDaEmpresa($id, $cpf, $descricao)
    {
        $valor = null;

        $id = str_pad(substr($id, 0, 15), 15, '0', STR_PAD_LEFT);

        $cpf = substr(' CPF ' . $cpf, 0, 34);
        $descricao = substr($descricao, 0, 34);

        $valor = trim(substr($id . $cpf . ' ' . $descricao, 0, 49));

        $this->usoDaEmpresa = str_pad($valor, 60, ' ');
    }

    private function setReservadoParaOFuturo($valor)
    {
        $this->reservadoParaOFuturo = str_pad(substr($valor, 0, 20), 20, ' ');
    }

    private function setCodigoDoMovimento($valor)
    {
        $this->codigoDoMovimento = substr($valor, 0, 1);
    }

    public function getValorDeDebito()
    {
        return $this->valorDeDebito;
    }

    public function getDebitoEmContaCorrente()
    {
        return $this->codigoDoRegistro .
        $this->identificacaoDoClienteNaEmpresa .
        $this->agenciaParaDebito .
        $this->identificacaoDoClienteNoBanco .
        $this->dataDoVencimento .
        $this->valorDeDebito .
        $this->codigoDaMoeda .
        $this->usoDaEmpresa .
        $this->reservadoParaOFuturo .
        $this->codigoDoMovimento;
    }
}
