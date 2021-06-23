<?php
date_default_timezone_set("Brazil/East");
define('DS', DIRECTORY_SEPARATOR);

require_once str_replace('/', DS, 'library/phpExcel/Classes/PHPExcel/IOFactory.php');

class Arquivo
{
    const diretorioTemporario = null;
    private $arquivoDeEntrada = null;
    private $arquivoXlsx = null;
    private $arquivoNovoTxt = null;
    private $arquivoNovoTxtFopen = null;
    private $arquivoNovoZip = null;

    public function __construct($arquivoDeEntrada)
    {
        $this->diretorioTemporario = $_SERVER['DOCUMENT_ROOT'] . DS . 'temporario' . DS;
        $this->arquivoDeEntrada = $arquivoDeEntrada;
        $this->salvarArquivoDeEntrada();
    }

    private function gerarNome($extensao)
    {
        $nome = null;
        $nome = md5(uniqid(rand(), true)) . '.' . $extensao;

        if (file_exists($this->diretorioTemporario . $nome)) {
            $this->gerarNome();
        }

        return $nome;
    }

    private function pegarExtensao()
    {
        $extensao = null;
        $extensao = explode('.', $this->arquivoDeEntrada['name']);
        $extensao = strtolower(end($extensao));
        return $extensao;
    }

    public function novo()
    {
        $this->arquivoNovoTxt = $this->diretorioTemporario . $this->gerarNome('txt');
        $this->arquivoNovoTxtFopen = fopen($this->arquivoNovoTxt, 'w');
    }

    public function gravar($buffer)
    {
        fwrite($this->arquivoNovoTxtFopen, $buffer);
    }

    public function fechar()
    {
        fclose($this->arquivoNovoTxtFopen);
    }

    private function salvarArquivoDeEntrada()
    {
        switch ($this->pegarExtensao()) {
            case 'xlsx':
                $this->mover();
                break;

            case 'zip':
                $this->extrair();
                break;

            default:
                # code...
                break;
        }
    }

    private function mover()
    {
        $nome = null;
        $nome = $this->gerarNome('xlsx');

        move_uploaded_file($this->arquivoDeEntrada['tmp_name'], $this->diretorioTemporario . $nome);

        $this->arquivoXlsx = $this->diretorioTemporario . $nome;
    }

    private function extrair()
    {
        $nome = null;
        $nome = $this->gerarNome('xlsx');

        $zip = null;
        $zip = new ZipArchive;

        $zip->open($this->arquivoDeEntrada['tmp_name']);
        $zip->renameIndex(0, $nome);
        $zip->close();

        $zip->open($this->arquivoDeEntrada['tmp_name']);
        $zip->extractTo($this->diretorioTemporario);
        $zip->close();

        $this->arquivoXlsx = $this->diretorioTemporario . $nome;
    }

    public function excelPegarDadosEmArray($sheet = 0)
    {
        $phpExcelObjReader = null;
        $phpExcelWorksheetArray = null;

        $phpExcelObjReader = PHPExcel_IOFactory::createReader('Excel2007');
        $phpExcelWorksheetArray = $phpExcelObjReader->load($this->arquivoXlsx)->getSheet($sheet)->toArray();

        return $phpExcelWorksheetArray;
    }

    private function compactar($nome)
    {
        $zip = null;

        $zip = new ZipArchive;
        $this->arquivoNovoZip = substr($this->arquivoNovoTxt, 0, -4) . '.zip';

        if ($zip->open($this->arquivoNovoZip, ZIPARCHIVE::CREATE) === true) {
            $zip->addFile($this->arquivoNovoTxt, $nome . '.txt');
            $zip->close();
        }
    }

    public function download($nomeZip, $nomeTxt)
    {
        $this->compactar($nomeTxt);
        header("Content-Type: application/zip");
        header("Content-Length: " . filesize($this->arquivoNovoZip));
        header("Content-Disposition: attachment; filename=" . basename($nomeZip . '.zip'));
        readfile($this->arquivoNovoZip);
        $this->limpar();
    }

    private function limpar()
    {
        unlink($this->arquivoXlsx);
        unlink($this->arquivoNovoTxt);
        unlink($this->arquivoNovoZip);

        unset($this->arquivoDeEntrada);
        unset($this->arquivoXlsx);
        unset($this->arquivoNovoTxt);
        unset($this->arquivoNovoTxtFopen);
        unset($this->arquivoNovoZip);
    }
}
