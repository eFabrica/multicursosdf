<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Inicia Sessão
session_start();

// Caminho da Pasta Raiz
$pathInc = '../';

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

// Verifica Referência
switch ($_REQUEST["ref"]){
	
	// Caso for Cidades
	case "cidades":
		
		?>

		<select id="cidades" name="<?=$_REQUEST["ref"]?>">
			<?php
			// Busca Cidades
			$buscaCidades = mysql_query("SELECT * FROM `cidades` WHERE estado = '" . $_REQUEST["uf"] . "' AND deletado = 'N' ORDER BY cidade ASC");
			
			// Traz Cidades
			while($trazCidades = mysql_fetch_object($buscaCidades)){
				
				?>
				<option value="<?php print($trazCidades->id); ?>"><?php print(rawurlencode($trazCidades->cidade)); ?></option>
				<?php
				
			}
			?>
		</select>
		<?php
		
	break;
	
	// Caso for Número Turma
	case "numeroTurma":
		
		// Dados da Turma
		$dadosTurma = $_ClassRn->getDadosTable("turmas", "numero", "curso = '" . $_REQUEST["curso"] . "' ORDER BY id DESC LIMIT 0,1");
		?>
		<input type="text" name="numero" size="5" value="<?php print($dadosTurma->numero+1);?>">
		<?php
		
	break;

	// Caso for Matérias
	case "materias":
		
		?>
		<select name="materia">
			<option value=""></option>
			<?php
			// Verifica se tem turma
			if($_REQUEST["turma"]  > 0){
			
				// Dados da Turma
				$dadosTurma = $_ClassRn->getDadosTable("turmas", "curso", "id = '" . $_REQUEST["turma"] . "'");
					
				// Busca Matérias
				$buscaMaterias = $_ClassMysql->query("SELECT * FROM `materias` WHERE unidade = '" . $_dadosUnidade->id . "' AND curso = '" . $dadosTurma->curso . "' AND deletado = 'N'");
				
				// Traz Matérias
				while($trazMaterias = mysql_fetch_object($buscaMaterias)){
					?>
					<option value="<?php print($trazMaterias->id);?>"><?php print(rawurlencode($trazMaterias->materia));?></option>
					<?php
					
				}
				
			}
			?>
		</select>
		<?php
		
	break;
	
	// Caso for Pagamento
	case "pagamento":
		
		// Dados da Parcela
		$dadosParcela = $_ClassRn->getDadosTable("parcelas", "*", "id = '" . $_REQUEST["idParcela"] . "'");
		
		// Verifica se se está paga
		if($dadosParcela->paga == "S"){
			
			// Inverte pagamento
			$_ClassMysql->query("UPDATE `parcelas` SET paga = 'N', datahorai = NOW(), ultimoeditou = '" . $_dadosLogado->id . "', datahorae = NOW() WHERE id = '" . $_REQUEST["idParcela"] . "'");
			
			?>
			<img src="imagens/diversos/N.png" border="0">
			<?php
			
		}elseif($dadosParcela->paga == "N"){
			
			// Inverte pagamento
			$_ClassMysql->query("UPDATE `parcelas` SET paga = 'S', datahorai = '', ultimoeditou = '" . $_dadosLogado->id . "', datahorae = NOW() WHERE id = '" . $_REQUEST["idParcela"] . "'");
			
			?>
			<img src="imagens/diversos/S.png" border="0">
			<?php
			
		}
		
	break;
	
	case "atualizaVagas":
		
		// Busca Turma
		$buscaTurma = mysql_query("SELECT * FROM `turmas` WHERE id = '" . $_REQUEST["turma"] . "'");
		
		// Dados da Turma
		$dadosTurma = mysql_fetch_object($buscaTurma);
		
		// Exibe Vagas
		print(rawurlencode(($dadosTurma->vagas-$dadosTurma->vagasocupadas) . "&nbsp;<font style='font-size:10px;'><i>( <b>Atualizado em:</b> " . date("d/m/Y G:i:s") . ")</i></font>"));
		
	break;
	
	case "atualizaTempoReserva":
		
		// Dados da Reserva
		$dadosReserva = $_ClassRn->getDadosTable("clientes_reservas_matriculas", "*", "id = '" . $_REQUEST["idReserva"] . "'");
		//var_dump($dadosReserva);
		// Verifica se foi deletado
		if($dadosReserva->deletado == 'N'){
		
			// Dados da Turma
			$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $dadosReserva->turma . "'");
			
			// Dados do Turno
			$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");
			
			// Modo
			if($_REQUEST["modo"] == 2){
				
				// Tempo Restante
				$tempoRestante = ((time()-strtotime($dadosReserva->dat_reserva))-3600);
				
				// Verifica tempo
				print("<b>Tempo Restante: " . ceil(((($tempoRestante < 0)?str_replace("-", "", $tempoRestante):0)/60)) . " Minutos.</b>");
				
			}else{
				
				?>
				<img src="<?php print("imagens/diversos/setaGi.jpg");?>">
				<a href="?modulo=empresa&sessao=matricular&etapa=3&idReserva=<?php print($dadosReserva->id);?>">
					<?php $tempoRestante = ((time()-strtotime($dadosReserva->dat_reserva))-3600); print($_ClassData->transformaData($dadosTurma->datainicio, 2) . " - " . $dadosTurno->turno . " (" . $dadosReserva->qtd . " Vagas. <b>Tempo Restante: " . ceil(((($tempoRestante < 0)?str_replace("-", "", $tempoRestante):0)/60)) . " Minutos.</b>)");?>
				</a>
				<?php
				
			}
			
		}elseif($dadosReserva->deletado == 'S'){print("nops");}else{print($_REQUEST["idReserva"]);}
		
	break;
	
	case "preencheDados":
		
		// Verifica Cpf
		if($_REQUEST["cpf"] != ""){
		
			// Dados do Aluno
			$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "cpf = '" . $_ClassUtilitarios->deixaN($_REQUEST["cpf"]) . "' AND deletado = 'N'");
			
			// Retorna os dados
			print(rawurlencode($dadosAluno->nome) . "|||" . $_ClassData->transformaData($dadosAluno->datanascimento, 2));
		
		}else{print("|||");}
		
	break;
	
	default:
		
		// Requer Arquivo
		if (file_exists($pathInc . "includes/aplications/_" . $_REQUEST["ref"] . ".apl.php")) require_once($pathInc . "includes/aplications/_" . $_REQUEST["ref"] . ".apl.php");
	
}
?>