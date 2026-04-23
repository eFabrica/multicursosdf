<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Inicia Sessão
session_start();

// Caminho da Pasta Raiz
$pathInc = '../../../';

// Arquivo de Configurações
require_once($pathInc . "inc/config.inc.php");

# Dados de Logado
	
	// Verifica se está logado
	if($_SESSION["dadosLogin"]["idLogado"] > 0){

		// Dados do Logado
		$_dadosLogado = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
		
		// Dados da Unidade
		$_dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "100")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N'");
	
	}

// Biblioteca de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Biblioteca de Data
require_once($pathInc . "lib/Data.class.php");
?>
<html>
	<head>
		<title>Cobranças</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link href="<?php print($pathInc);?>css/estilos.css" rel="stylesheet" type="text/css">
		<style>
		h1, h2, h3, h4, p {margin:0px;}
		</style>
	</head>
	
	<body>
		<table width="700" border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td align='left'><img src="<?php print($pathInc);?>imagens/diversos/logo.jpg"></td>
				<td width="100%">
					<h3>
					<?php print($_dadosUnidade->razaosocial);?> - <?php print($_dadosUnidade->nomefantasia);?><br />
					<?php print($_dadosUnidade->endereco);?> - <?php print($cidadeUnidade->cidade);?> - <?php print($_dadosUnidade->estado);?><br />
					Fone: <?php print($_dadosUnidade->telefonefixo);?> - CNPJ: <?php print($_ClassUtilitarios->formataCNPJ($_dadosUnidade->cnpj));?>
					</h3>	
				</td>
			</tr>
		</table>
		<table width="99%" border="0" cellpadding="2" cellspacing="2">
			<tr>
				<td align="center">
					<h1><u>Relatório de Cobranças</u></h1>
					<b>Emissão: </b><?php print(date("d/m/Y H:i:s"));?><br>
					<b>Palavra-Chave: </b><?php print($_REQUEST["pc"]);?>
				</td>
			</tr>
		</table>
		<table id="consultaTable" class="consulta" cellspacing="1" align="center">
			<thead>
				<tr>
					<th width="1%">#</th>
					<th width="1%" align="center"><input type="checkbox" onclick="select_all(this, 'formRegistros', 'registros[]')"></th>
					<th width="35%">Nome</th>
					<th width="10%">Empresa</th>
					<th width="10%">Vencimento</th>
					<th width="15%">Valor</th>
					<th width="5%">Tipo</th>
					<th width="5%">Doc</th>
					<th width="10%">Turma</th>
					<th width="5%">SPC</th>
					<th width="5%">PAGO</th>
				</tr>
			</thead>
			<tbody>
				<?php	
				/* Construindo sql */
				$sql = "SELECT cobranca.id,
							   cobranca.nome,
							   cobranca.empresa,
							   cobranca.vencimento,
							   cobranca.valor,
							   cobranca.tipo,
							   cobranca.doc,
							   cobranca.turma,
							   cobranca.spc,
							   cobranca.pago FROM `cobranca` ";
				
				// Verifica se tem palavra chave
				if ($_REQUEST["pc"] != ""){
					
					// QUERY - Nome
					$sql .= " WHERE cobranca.nome LIKE '%" . $_REQUEST["pc"] . "%' OR ";
					
					// QUERY - Endereço
					$sql .= " cobranca.endereco LIKE '%" . $_REQUEST["pc"] . "%' OR ";
					
					// QUERY - Telefone
					$sql .= " cobranca.telefone LIKE '%" . $_REQUEST["pc"] . "%' OR ";
					
					// QUERY - CPF
					$sql .= " cobranca.cpf LIKE '%" . $_ClassUtilitarios->tiraMask($_REQUEST["pc"]) . "%' OR ";
					
					// QUERY - Empresa
					$sql .= " cobranca.empresa LIKE '%" . $_REQUEST["pc"] . "%' OR ";
					
					// QUERY - Turma
					$sql .= " cobranca.turma LIKE '%" . $_REQUEST["pc"] . "%' OR ";
					
					// QUERY - Vencimento
					$sql .= " cobranca.vencimento LIKE '%" . $_ClassData->transformaData($_REQUEST["pc"]) . "%' OR ";
					
					// QUERY - Valor
					$sql .= " cobranca.valor LIKE '%" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["pc"]) . "%' OR ";
					
					// QUERY - Tipo
					$sql .= " cobranca.tipo LIKE '%" . $_REQUEST["pc"] . "%' OR ";
					
					// QUERY - Doc
					$sql .= " cobranca.doc LIKE '%" . str_replace("@doc", "", $_REQUEST["pc"]) . "%' OR ";
					
					// QUERY - SPC
					$sql .= " cobranca.spc = '" . str_replace("@spc", "", $_REQUEST["pc"]) . "' OR ";
					
					// QUERY - Histórico
					$sql .= " cobranca.historico LIKE '%" . $_REQUEST["pc"] . "%' OR ";
					
					// QUERY - Pago
					$sql .= " cobranca.pago = '" . str_replace("@pago", "", $_REQUEST["pc"]) . "%'";
					
				}
				
				// Agrupa Resultados
				$sql .= " ORDER BY nome, empresa ASC";
				
				/* Fim da construção */
				//print($sql);
				// Paginação
				//require_once($pathInc . "lib/Paginacao.class.php");
				
				// Configurações da paginacao
				//$_ClassPaginacao->setQuery($sql);
				//$_ClassPaginacao->setUrl("?modulo=" . $_REQUEST["modulo"] . "&sessao=" . $_REQUEST["sessao"] . "&pc=" . $_REQUEST["pc"]);
				//$_ClassPaginacao->setRegistrosPorPagina("999999");
				//$_ClassPaginacao->setPaginaAtual((($_REQUEST["pg"] == 0)?"1":$_REQUEST["pg"]));
				//$_ClassPaginacao->paginando();
				
				// Busca Registros
				$buscaRegistro = $_ClassMysql->query($sql);
										
				// Verifica total achado
				if(mysql_num_rows($buscaRegistro) == 0){
					?>
					<tr>
						<td align="center" colspan="11"><b>Nenhum resultado encontrado.</b></td>
					</tr>
					<?
				}else{
					
					// Traz resultados
					while($trazResultados = mysql_fetch_object($buscaRegistro)){
						
						?>
						<tr class=row0>
							<td align='left'><?php print($trazResultados->id); ?></td>
							<td align="center"><input type="checkbox" name="registros[]" value="<?=$trazResultados->id?>"></td>
							<td align="left"><a href="<?php print("?modulo=" . $_REQUEST["modulo"] . "&sessao=" . $_REQUEST["sessao"] . "&pc=" . $_REQUEST['pc'] . "&pg=" . $_REQUEST['pg'] . "&ref=edit&idRegistro=" . $trazResultados->id); ?>"><b><?php print($trazResultados->nome);?></b></a></td>
							<td align='center'><?php print($trazResultados->empresa);?></td>
							<td align='center'><?php print($_ClassData->transformaData($trazResultados->vencimento, 2));?></td>
							<td align='right'>R$&nbsp;<?php print($_ClassDinheiro->formataMoeda($trazResultados->valor));?></td>
							<td align='center'><?php print($trazResultados->tipo);?></td>
							<td align='center'><?php print($trazResultados->doc);?></td>
							<td align='center'><?php print($trazResultados->turma);?></td>
							<td align='center'><img src="<?php print($pathInc . "imagens/diversos/" . $trazResultados->spc . ".png");?>"></td>
							<td align='center'><img src="<?php print($pathInc . "imagens/diversos/" . $trazResultados->pago . ".png");?>"></td>
						</tr>
						<?php
					}
					
				}
				?>
			</tbody>
		</table>
	</body>
</html>