<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Inicia Sessão
session_start();

// Caminho da Pasta Raiz
$pathInc = '../../';

// Arquivo de Configurações
require_once($pathInc . "inc/config.inc.php");

# Dados de Logado
	
	// Verifica se está logado
	if($_SESSION["dadosLogin"]["idLogado"] > 0){

		// Dados do Logado
		$_dadosLogado = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
		
		// Dados da Unidade
		$_dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "master")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N'");
	
	}

// Biblioteca de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Biblioteca de Data
require_once($pathInc . "lib/Data.class.php");

// Dados da Unidade
$dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "100")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N' AND acesso = 'L'");
?>
<html>
    <head>
        <title>Relatório de Devedores de Matrículas On-line</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="<?php print($pathInc);?>css/estilos.css" rel="stylesheet" type="text/css">
        <style>
            input{

                font-family:"Times New Roman", Times, serif;
                font-size:12px;
                color:#00000;
                border:0px;
                text-align:center;
                width:250px;
                height:25px;

            }

            h1, h2, h3, h4, p {margin:0px;}
        </style>
    </head>
	
    <body>
        <table width="700" border="0" cellspacing="2" cellpadding="2">
            <tr>
                <td align='left'><img src="<?php print($pathInc);?>imagens/diversos/logo.jpg"></td>
                <td width="100%">
                    <h3>
                    <?php print($dadosUnidade->razaosocial);?> - <?php print($dadosUnidade->nomefantasia);?><br />
                    <?php print($dadosUnidade->endereco);?> - <?php print($cidadeUnidade->cidade);?> - <?php print($dadosUnidade->estado);?><br />
                    Fone: <?php print($dadosUnidade->telefonefixo);?> - CNPJ: <?php print($_ClassUtilitarios->formataCNPJ($dadosUnidade->cnpj));?>
                    </h3>
                </td>
            </tr>
        </table>
        <table width="99%" border="0" cellpadding="2" cellspacing="2">
            <tr>
                <td align="center">
                    <h2><u>Relatório de Devedores de Matrículas On-line</u></h2>
                    <b>Emissão: </b><?php print(date("d/m/Y H:i:s"));?><br>
                </td>
            </tr>
        </table>
        <table width="99%" border="0" cellpadding="2" cellspacing="2">
            <?php
            // Contador
            $cont = 1;

            // Busca Matrículas
            $buscaMatriculas = $_ClassMysql->query("SELECT alunos.nome,
                                                           matriculas.*     FROM `matriculas`,
                                                                                 `alunos` WHERE alunos.id            = matriculas.aluno AND
                                                                                                alunos.deletado      = 'N' AND
                                                                                                matriculas.online    = 'S' AND
                                                                                                matriculas.concluido = 'N' AND
                                                                                                matriculas.deletado  = 'N' ORDER BY alunos.nome ASC");

            // Verifica o total achado
            if(mysql_num_rows($buscaMatriculas) > 0){

                // Traz Matrículas
                while($trazMatricula = mysql_fetch_object($buscaMatriculas)){

                    // Dados da Turma
                    $dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $trazMatricula->turma . "'");

                    // Dados do Curso
                    $dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");

                    // Total Pago
                    $totalPago = $trazMatricula->valor_dinheiro-
                                 $trazMatricula->valor_desconto+
                                 $trazMatricula->valor_cheque+
                                 $trazMatricula->valor_cartaocredito+
                                 $trazMatricula->valor_cartaodebito+
                                 $trazMatricula->valor_boleto+
                                 $trazMatricula->valor_adicional;

                    // Verifica valor do curso
                    if ($totalPago < $dadosCurso->valor) {
                        ?>
                        <tr>
                            <td align='left'><ol><?php print($cont++ . ". " . $trazMatricula->nome . " (" . $dadosCurso->sigla.$dadosTurma->numero . ") - <b>Montante Devido: R$ " . $_ClassDinheiro->formataMoeda(bcsub($dadosCurso->valor, $totalPago, 2)) . "</b>");?></ol></td>
                        </tr>
                        <?php
                    }

                }

            }
            ?>
        </table>
    </body>
</html>