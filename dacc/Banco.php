<?php
require_once 'IArquivoDebitoAutomaticoCC.php';
require_once 'Arquivo.php';
require_once 'RegistroA.php';
require_once 'RegistroE.php';
require_once 'RegistroZ.php';

class Banco implements IArquivoDebitoAutomaticoCC
{
    private $arquivo = null;
    private $registroA = null;
    private $listaDeRegistroE = array();
    private $registroZ = null;
    private $registroZValorTotal = 0;
    private $registroZTotalDeRegistros = 0;

    public function iniciar($arquivoDeEntrada)
    {
        $this->arquivo = new Arquivo($arquivoDeEntrada);
        $this->prepararRegistroA();
        $this->prepararRegistroE();
        $this->prepararRegistroZ();
        $this->gerar();
    }

    private function prepararRegistroA()
    {
        $arrayDeDados = array();
        $arrayDeDados = $this->arquivo->excelPegarDadosEmArray();

        $this->registroA = new RegistroA();
        $this->registroA->setCodigoDoConvenio($arrayDeDados[3][0]);
        $this->registroA->setNomeDaEmpresa($arrayDeDados[3][1]);
        $this->registroA->setCodigoDoBanco($arrayDeDados[3][2]);
        $this->registroA->setNomeDoBanco($arrayDeDados[3][3]);
        $this->registroA->setNumeroSequencialDoArquivo($arrayDeDados[3][4]);

        unset($arrayDeDados);
    }

    private function prepararRegistroE()
    {
        $contador = 0;
        $arrayDeDados = array();

        $arrayDeDados = $this->arquivo->excelPegarDadosEmArray(1);

        unset($arrayDeDados[0]);
        unset($arrayDeDados[1]);
        unset($arrayDeDados[2]);

        foreach ($arrayDeDados as $key => $arrayDeRegistroE) {
            $contador++;

            $registroE = null;
            $registroE = new RegistroE();
            $registroE->setIdentificacaoDoClienteNaEmpresa($arrayDeRegistroE[0]);
            $registroE->setAgenciaParaDebito($arrayDeRegistroE[1]);
            $registroE->setIdentificacaoDoClienteNoBanco($arrayDeRegistroE[0]);
            $registroE->setDataDoVencimento($arrayDeRegistroE[2]);
            $registroE->setValorDeDebito($arrayDeRegistroE[3]);
            $registroE->setUsoDaEmpresa($contador, $arrayDeRegistroE[4], $arrayDeRegistroE[5]);

            $this->listaDeRegistroE[] = $registroE;
            $this->registroZAtualizarValorTotal($registroE->getValorDeDebito());

            unset($registroE);
        }

        $this->registroZAtualizarTotalDeRegistros($contador);

        unset($arrayDeDados);
    }

    private function prepararRegistroZ()
    {
        $this->registroZ = new RegistroZ();
        $this->registroZ->setTotalDeRegistrosDoArquivo($this->registroZTotalDeRegistros);
        $this->registroZ->setValorTotalDosRegistrosDoArquivo($this->registroZValorTotal);
    }

    private function registroZAtualizarValorTotal($valor)
    {
        $this->registroZValorTotal = $this->registroZValorTotal + $valor;
    }

    private function registroZAtualizarTotalDeRegistros($quantidade)
    {
        $this->registroZTotalDeRegistros = $quantidade;
    }

    private function nomeZip()
    {
        return 'Banco (Arquivo de Débito Automático em Conta Corrente) - Número ' . $this->registroA->getNumeroSequencialDoArquivo();
    }

    private function nomeTxt()
    {
        return 'empresa_' . date('dmY') . '_' . date('Hms') . '_' . $this->registroA->getNumeroSequencialDoArquivo();
    }

    private function gerar()
    {
        $this->arquivo->novo();
        $this->arquivo->gravar($this->registroA->getHeader() . chr(13) . chr(10));
        foreach ($this->listaDeRegistroE as $key => $registroE) {
            $this->arquivo->gravar($registroE->getDebitoEmContaCorrente() . chr(13) . chr(10));
        }
        $this->arquivo->gravar($this->registroZ->getTrailler());
        $this->arquivo->fechar();
        $this->arquivo->download($this->nomeZip(), $this->nomeTxt());
    }
}
