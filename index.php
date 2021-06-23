<?php
require_once 'dacc/GeradorArquivoDACC.php';
require_once 'dacc/Banco.php';

try {
    if (isset($_FILES['arquivo']['tmp_name'])) {
        $extensao = null;
        $extensao = explode('.', $_FILES['arquivo']['name']);
        $extensao = strtolower(end($extensao));
        $extensaoPermitida = array('xlsx', 'zip');

        if (in_array($extensao, $extensaoPermitida)) {
            $banco = null;
            $geradorArquivoDACC = null;

            // Parametro de entrada - Nome do banco
            $banco = 'Banco';
            
            $geradorArquivoDACC = new GeradorArquivoDACC(new $banco(), $_FILES['arquivo']);
        
            unset($geradorArquivoDACC);
        }
    }
} catch (Exception $e) {
    echo "Ops! Erro: " . $e->getMessage();
}

if (isset($_GET['download'])) {
    $planilhaModelo = null;

    $planilhaModelo = $_SERVER['DOCUMENT_ROOT'] . DS . 'modelo' . DS . 'debito-automatico.zip';

    header('Content-Type: application/zip');
    header('Content-Length: ' . filesize($planilhaModelo));
    header('Content-Disposition: attachment; filename=' . basename('debito-automatico.zip'));
    readfile($planilhaModelo);
}
