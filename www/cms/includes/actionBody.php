<?php
// Verifica Sessão
switch ($_REQUEST["sessao"]){
	
	// Área Login
	case "arealogin": print("onload=\"document.arealogin.login.focus();
							 	 	  document.arealogin.login.select();\"");
	break;
	
	// Despesas
	case "despesas": 
		
		// Verifica referência
		if($_REQUEST["ref"] == "novo" || $_REQUEST["ref"] == "edit"){
			
			print("onload=\"document.formDespesas.descricao.focus();
			   			    document.formDespesas.descricao.select();\"");
			
		}
		
	break; 
	
	// Alunos
	case "alunos": 
		
		// Verifica referência
		if($_REQUEST["ref"] == "novo" || $_REQUEST["ref"] == "edit"){
			
			print("onload=\"document.formAluno.nome.focus();
			   			    document.formAluno.nome.select();\"");
			
		}
		
	break; 
	
	// Turmas
	case "turmas": 
		
		// Verifica referência
		if($_REQUEST["ref"] == "novo" || $_REQUEST["ref"] == "edit"){
			
			print("onload=\"document.formTurma.curso.focus();\"");
			
		}
		
	break; 
	
	// Cursos
	case "cursos": 
		
		// Verifica referência
		if($_REQUEST["ref"] == "novo" || $_REQUEST["ref"] == "edit"){
			
			print("onload=\"document.formCurso.sigla.focus();
			   			    document.formCurso.sigla.select();\"");
			
		}
		
	break; 
	
	// Turnos
	case "turnos": 
		
		// Verifica referência
		if($_REQUEST["ref"] == "novo" || $_REQUEST["ref"] == "edit"){
			
			print("onload=\"document.formTurno.turno.focus();
			   			    document.formTurno.turno.select();\"");
			
		}
		
	break; 
	
	// Documentos
	case "documentos": 
		
		// Verifica referência
		if($_REQUEST["ref"] == "novo" || $_REQUEST["ref"] == "edit"){
			
			print("onload=\"document.formDocumento.documento.focus();
			   			    document.formDocumento.documento.select();\"");
			
		}
		
	break; 
	
	// Unidades
	case "unidades": 
		
		// Verifica referência
		if($_REQUEST["ref"] == "novo" || $_REQUEST["ref"] == "edit"){
			
			print("onload=\"document.formUnidade.razaosocial.focus();
			   			    document.formUnidade.razaosocial.select();\"");
			
		}
		
	break; 
	
	// Cidades
	case "cidades": 
		
		// Verifica referência
		if($_REQUEST["ref"] == "novo" || $_REQUEST["ref"] == "edit"){
			
			print("onload=\"document.formCidade.cidade.focus();
			   			   document.formCidade.cidade.select();\"");
			
		}
		
	break; 
	
	// Diario de Classe
	case "diarioclasse": 
	
		// Verifica Referência
		if($_REQUEST["ref"] == "novo"){
			
			// Verifica Etapa
			switch ($_REQUEST["etapa"]){
				
				// Etapa 2
				case "2": 
				
					print("onload=\"document.formDiarioClasse.conteudo.focus();
				   			        document.formDiarioClasse.conteudo.select();\"");
				
				break;
				
				// Etapa 1
				default: 
				
			}
			
		}else{
			
			// Verifica Etapa
			switch ($_REQUEST["etapa"]){
				
				// Etapa 1
				default: 
				
					
					
			}
			
		}
		
	break; 
	
	case "cobrancas":

		print("onload=\"Mascaras.carregar();
						document.formCobranca.cpf.focus();
						document.formCobranca.cpf.select();\"");
		
	break;
	
	// Em Branco
	case "": print("onload=\"document.arealogin.login.focus();
							 document.arealogin.login.select();\"");
	break;
	
}
?>

