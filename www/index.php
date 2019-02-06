<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

include("vendor/autoload.php");
use GuzzleHttp\Client;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['cnpj'])) {
    $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => 'https://www.receitaws.com.br/v1/',
        // You can set any number of default request options.
        'timeout'  => 2.0,
    ]);

    $response = $client->request('GET', 'cnpj/' .clean($_POST['cnpj']) );
    $dados = json_decode($response->getBody()->getContents());

    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            break;
        case JSON_ERROR_DEPTH:
        case JSON_ERROR_STATE_MISMATCH:
        case JSON_ERROR_CTRL_CHAR:
        case JSON_ERROR_SYNTAX:
        case JSON_ERROR_UTF8:
            echo 'Erro ';
            exit();
            break;
        default:
            echo ' - Unknown error';
            exit();
            break;
        break;
    }

    $base['cnpj']                = $dados->cnpj;
    $base['nome']                = $dados->nome;
    $base['atividade_principal'] = $dados->atividade_principal[0]->text;
    $base['telefone']            = $dados->telefone;
    $base['data_situacao']       = $dados->data_situacao;
    $base['uf']                  = $dados->uf;
    $base['bairro']              = $dados->bairro;
    $base['cep']                 = $dados->cep;
    $base['logradouro']          = $dados->logradouro;
    $base['numero']              = $dados->numero;
    $base['abertura']            = $dados->abertura;
    $base['tipo']                = $dados->tipo;
    $base['pais']                = 'Brasil';
    $base['fantasia']            = $dados->fantasia;
    $base['var2']                = 'var2';
    $base['var3']                = 'var3';
    
    $base['FCPJ16']                = 'adasd FCPJ16';
    $base['FCPJ68']                = 'adasd FCPJ68';
    $base['FCPJ67']                = 'adasd FCPJ67';
    $base['FCPJ66']                = 'adasd FCPJ66';
    $base['FCPJ65']                = 'adasd FCPJ65';
    $base['FCPJ64']                = 'adasd FCPJ64';
    $base['FCPJ63']                = 'adasd FCPJ63';
    $base['FCPJ62']                = 'adasd FCPJ62';
    $base['FCPJ61']                = 'adasd FCPJ61';
    $base['FCPJ60']                = 'adasd FCPJ60';
    $base['FCPJ44']                = 'adasd FCPJ44';
    $base['FCPJ10']                = 'adasd FCPJ10';
    $base['FCPJ70']                = 'adasd FCPJ70';
    $base['FCPJ21']                = 'adasd FCPJ21';
    $base['FCPJ3']                = 'adasd FCPJ3';
    $base['FCPJ2']                 = $dados->nome;


    // Fazendo para a 01 - BM
    $corretoras = [
        'BM' => [
            'file' => '01-BM.fdf',
            'fields' => [
                'xxf' => 'abertura',
                'Ramo atividade' => 'atividade_principal',
                'País_2' => 'pais',
                'CNPJMFRow1_2' => 'cnpj',
                'var1' => 'nome',
                'var2' => 'var2',
                'var3' => 'var3',
                'cod_cliente' => 'cnpj',
                'CNPJMF' => 'cnpj',
                'CNPJMFRow2_2' => 'cnpj',
                'Nome3' => 'nome',
                'NACRow1_2' => 'nome',
                'Nome fantasia' => 'nome',
                'CEP' => 'cep',
                'telefone contato' => 'telefone',
                'Telefone DDIDDDnúmero' => 'telefone',
                'Bairro' => 'bairro',
            ]
        ],

        'BS2' => [
            'file' => '02-BS2.fdf',
            'fields' => [
                'FCPJ16' => 'FCPJ16',
                'FCPJ68' => 'FCPJ68',
                'FCPJ67' => 'FCPJ67',
                'FCPJ66' => 'FCPJ66',
                'FCPJ65' => 'FCPJ65',
                'FCPJ64' => 'FCPJ64',
                'FCPJ63' => 'FCPJ63',
                'FCPJ62' => 'FCPJ62',
                'FCPJ61' => 'FCPJ61',
                'FCPJ60' => 'FCPJ60',
                'FCPJ44' => 'FCPJ44',
                'FCPJ10' => 'bairro',
                'FCPJ70' => 'FCPJ70',
                'FCPJ2' => 'FCPJ2',
                'FCPJ3' => 'FCPJ3',
                'FCPJ4' => 'fantasia',
                'FCPJ5' => 'atividade_principal',
                'FCPJ21' => 'FCPJ21',

            ]
        ],
    ];


    foreach ($corretoras as $nome => $dados) {
        $aux = file_get_contents("templates/{$dados['file']}");
        $pdf_file = str_replace(".fdf",'.pdf', $dados['file']);

        foreach ($dados['fields'] as $chave => $troca) {
            $aux = str_replace("(||{$chave}||)", "(".utf8_decode($base[$troca]).")", $aux);
        }

        file_put_contents("templates/__{$dados['file']}", $aux);
        $command = "pdftk originals/{$pdf_file} fill_form templates/__{$dados['file']} output {$pdf_file}";

        exec($command, $output);
    }
        
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Geração de PDF</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <form class="form-inline" method="POST">
              <div class="form-group">
                <label for="cnpj">CNPJ</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj" value="<?PHP echo $_POST['cnpj'];?>">
              </div>
              <button type="submit" class="btn btn-primary">Buscar Dados</button> 
              <span class="label label-default" data-cnpj="21.129.438/0001-44">Meu Cambio</span>
              <span class="label label-default" data-cnpj="42.591.651/0001-43">Mc Donalds</span>
              <span class="label label-default" data-cnpj="76.535.764/0001-43">Oi telecom</span>
              <span class="label label-default" data-cnpj="33.592.510/0001-54">Vale</span>
            </form>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
    <script>
    $(document).ready(function(){
        $('#cnpj').mask('99.999.999/0009-99');
    });        

    $('.label').on('click', function(){
        $('#cnpj').val($(this).data('cnpj'));
    });
    </script>
  </body>
</html>
<?PHP
function clean ($cnpj) {
    return  preg_replace("/[^0-9]/", "", $cnpj );
}
?>