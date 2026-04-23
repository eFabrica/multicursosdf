<?php require_once("php7_mysql_shim.php");
// Inicia Sessão
session_start();

// Caminho da Pasta Raiz
$pathInc = './';

// Arquivo de Configurações
require_once($pathInc . "inc/config.inc.php");
?>
<html>
	<head>

		<?php require_once($pathInc . "includes/head.php"); ?>
			<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
	</head>

	<body>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align='left'><?php require_once($pathInc . "includes/topo.php"); ?></td>
			</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table_main">
			<tr>
				<td align='left'><br></td>
			</tr>
			<tr>
				<td align="center">
					<?php
					// Seta largura das Mensagens
					$_ClassMensagens->setLargura(35);
					
					// Verifica Ação
					if($_REQUEST["act"] == "logar"){
						
						// Verifica Campos
						$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["cpf"], "É preciso informar seu cpf."));
						$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["senha"], "É preciso informar sua senha."));
						
						// Caso não tenha erro
						if($_ClassMensagens->getMensagem_erro() == ""){
							
							// Limpa CPF
							$_REQUEST["cpf"] = preg_replace("/[\.-]/", "", $_REQUEST["cpf"]);
							
							// Dados do Usuário
							$dadosUser = $_ClassRn->getDadosTable("usuarios", "*", "cpf = '" . $_REQUEST["cpf"] . "' AND senha = '" . md5($_REQUEST["senha"]) . "' AND deletado = 'N'");
							
							// Verifica Total achado
							if($_ClassRn->getTot() == 0){
								
								// Seta Erro
								$_ClassMensagens->setMensagem_erro("Dados inválidos.<br>");
								
							}
							
						}
						
						// Caso não tenha erro
						if($_ClassMensagens->getMensagem_erro() == ""){
							
							# Loga Usuário
							
								// Cadastra id na sessão
								$_SESSION["dadosLogin"]["idLogado"] = $dadosUser->id;
								
								// Altera modo de logado
								$_ClassMysql->query("UPDATE `usuarios` SET logado = 'S', ultimologin = now(), acessos = (acessos+1)  WHERE id = '" . $dadosUser->id . "'");
							
							// Verifica Nivel
							if($dadosUser->nivel == "100"){
								
								// Busca Turmas
								$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE deletado = 'N' AND concluido = 'N'");
								
								// Traz Turmas
								while($trazTurmas = mysql_fetch_object($buscaTurmas)){
									
									// Busca Matrículas
									$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE deletado = 'N' AND turma = '" . $trazTurmas->id . "'");
									
									// Edita Turmas
									$_ClassMysql->query("UPDATE `turmas` SET vagasocupadas = '" . mysql_num_rows($buscaMatriculas) . "' WHERE id = '" . $trazTurmas->id . "'");
									
								}
								
								// Redireciona
								print($_ClassUtilitarios->redirecionarJS($pathInc . "mainMaster.php?sessao=inicial"));
								
							}else{
								
								// Redireciona
								print($_ClassUtilitarios->redirecionarJS($pathInc . "?" . (($dadosUser->empresa > 0)?"modulo=empresa&":"") . "sessao=" . (($dadosUser->nivel == "90")?"cobrancas":"inicial")));
							
							}
							
							
						}
						
					}
					
					// Verifica Erro na Sessão
					if(count($_SESSION["erros"]["arealogin"]) > 0){
						
						// Lê Erros
						for($k = 0; $k < count($_SESSION["erros"]["arealogin"]); $k++){
							
							// Seta Erro
							$_ClassMensagens->setMensagem_erro($_SESSION["erros"]["arealogin"][$k]);
							
						}
						
						// Limpa Sessão de Erro
						unset($_SESSION["erros"]["arealogin"]);
						
					}
					
					// Exibir Mensagem
					print($_ClassMensagens->exibirMensagem());
					?>
					<table border="0" cellpadding="0" cellspacing="0" width="35%" style="margin:10px;">
						<tr>
							<td align='left'><div id="border-top"><div><div></div></div></div></td>
						</tr>
						<tr>
							<td class="table_main">
								<form action="" method="POST" name="arealogin">
									<input type="hidden" name="act" value="logar">
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td width="40%" align="center"><img src="<?=$pathInc;?>

imagens/icones/cadeadoFechado.png" border="0"></td>
											<td width="60%">
												<table border="0" cellpadding="2" cellspacing="2" width="100%">
													<tr>
														<td align="right"><b>CPF:</b></td>
														<td align='left'><input type="text" name="cpf" onFocus="limpaCampo(this);" onKeyUp="maskCPF(this, document.arealogin.senha)"></td>
													</tr>
													<tr>
														<td align="right"><b>Senha:</b></td>
														<td align='left'><input type="password" name="senha"></td>
													</tr>
													<tr>
														<td align='left'></td>
														<td align='left'><?php print($_ClassUtilitarios->criaMenu("Logar", "#", "document.arealogin.submit();", "esq", "007"));?></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</form>
							</td>
						</tr>
						<tr>
							<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<div id="border-bottom"><div><div></div></div></div>
		<script language="javascript" type="text/javascript" src="js/legenda2.js"></script>
	</body>
</html>
<?php
// Verifica Ação
if($_REQUEST["act"] != "logar"){
	
	// Destroi Sessão
	session_destroy();
	
}
?>