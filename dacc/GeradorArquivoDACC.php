<?php
require_once 'IArquivoDebitoAutomaticoCC.php';

class GeradorArquivoDACC
{
    public function __construct(IArquivoDebitoAutomaticoCC $banco, $arquivo)
    {
        $banco->iniciar($arquivo);
        unset($banco);
    }
}
