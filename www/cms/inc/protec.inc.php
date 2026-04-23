<?php
// Verifica Sessão
if($_REQUEST["sessao"] != ""){
	
	// Verifica se está logado
	if($_dadosLogado->logado == "N" || $_dadosLogado->logado == ""){
		
		// Seta Erro
		$_SESSION["erros"]["arealogin"][] = "É preciso efetuar o login.<br>";
		
		// Redireciona
		header("Location: areaLogin.php");
		
		// Finaliza Script
		exit();
		
	}

	// Verifica se está suspenso
	if($_dadosLogado->suspenso == "S"){
		
		// Desloga Usuário
		$_ClassMysql->query("UPDATE `usuarios` SET logado = 'N' WHERE id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
		
		// Seta Erro
		$_SESSION["erros"]["arealogin"][] = "Usuário suspenso. Entre em contato com seu responsável.<br>";
		
		// Redireciona
		header("Location: areaLogin.php");
		
		// Finaliza Script
		exit();
		
	}
	
	// Verifica se está deletado
	if($_dadosLogado->deletado == "S"){
		
		// Desloga Usuário
		$_ClassMysql->query("UPDATE `usuarios` SET logado = 'N' WHERE id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
		
		// Seta Erro
		$_SESSION["erros"]["arealogin"][] = "Usuário deletado. Entre em contato com seu responsável.<br>";
		
		// Redireciona
		header("Location: areaLogin.php");
		
		// Finaliza Script
		exit();
		
	}
	
	// Verifica se a unidade está com acesso Bloqueado
	if($_dadosLogado->logado == "S" && $_dadosUnidade->id <= 0 && $_dadosLogado->nivel != "100"){
		
		// Desloga Usuário
		$_ClassMysql->query("UPDATE `usuarios` SET logado = 'N' WHERE id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
		
		// Seta Erro
		$_SESSION["erros"]["arealogin"][] = "Sua Unidade não existe mais.";
		
		// Redireciona
		header("Location: areaLogin.php");
		
		// Finaliza Script
		exit();
		
		
	}
	
	// Verifica se a unidade está com acesso Bloqueado
	if($_dadosLogado->logado == "S" && $_dadosUnidade->acesso == "B" && $_dadosLogado->nivel != "100"){
		
		// Desloga Usuário
		$_ClassMysql->query("UPDATE `usuarios` SET logado = 'N' WHERE id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
		
		// Seta Erro
		$_SESSION["erros"]["arealogin"][] = "Sua unidade está com acesso bloqueado.";
		
		// Redireciona
		header("Location: areaLogin.php");
		
		// Finaliza Script
		exit();
		
		
	}
	
}else{
	
	// Redireciona
	header("Location: areaLogin.php");
	
	// Finaliza Script
	exit();
	
}
?>

