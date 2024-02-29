<!DOCTYPE html>
<html lang="pt-br">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversão de moedas - Guanabara</title>
    <link rel="stylesheet" href="style.css">

    </head>
    <body>
    <main>

    <?php 
         $valor1 = $_GET['v1'] ?? " ";

    ?>
        <main>
            <h1>Conversor - Real(R$) para Dólar($)</h1>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
                    <label for="V1">Informe o valor em reais(R$):</label>
                    <input type="number" name="din" id="din" step="1.00" value="<?=$valor1?>">
                    <input type="submit" value="Converter moeda (R$) para ($)">
                </form>
        </main>
    
    <h1>Resultado</h1>
        <?php 
            $inicio = date("m-d-Y", strtotime("-7 days"));
            $fim = date("m-d-Y");

            // $timezone = new DateTimeZone('America/Sao_Paulo'); 
            // $agora = new DateTime('now', $timezone);
                
            $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''. $inicio .'\'&@dataFinalCotacao=\'' . $fim . '\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

            $dados = json_decode(file_get_contents($url), true);

            $cotacao = $dados["value"][0]["cotacaoCompra"];

            //Valor digitado (R$)
            //$real = $_REQUEST["din"];
            $real = $_REQUEST["din"] ?? 0;

            //$real = 100;

            //Conversão
            $dolar = $real/$cotacao;

            $padraoReal = numfmt_create("pt-BR", NumberFormatter::CURRENCY);
            $padraoDolar = numfmt_create("us", NumberFormatter::CURRENCY);

            echo "<p>" . numfmt_format_currency($padraoReal, $real, "BRL") . " valem <strong>" . numfmt_format_currency($padraoReal, $dolar, "USD") . "</strong></p>";

            echo "<p>Cotação em " . date('d-m-Y') . "<strong> = $cotacao </strong></p>";


            date_default_timezone_set('America/Sao_Paulo');
            echo "<p>Última conversão às <strong>" . date('h:i:s A') . "</strong></p>";

        ?>
    </main>
    </body>
</html>