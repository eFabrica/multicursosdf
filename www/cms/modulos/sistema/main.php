<?php

// Verifica Módulo
if($_REQUEST["modulo"] == "empresa"){
	
	// Verifica Sessão
	switch ($_REQUEST["sessao"]){
		
		// Caso for Inicial
		case "inicial": require_once($pathInc . "modulos/empresas/_matricular.php"); break;
		
		# Gerenciamentos	
			
			// Caso for Matricular
			case "matricular": require_once($pathInc . "modulos/empresas/_matricular.php"); break;
			
		# Relatórios
			
			// Caso for matrículas
			case "matriculas": require_once($pathInc . "modulos/empresas/_matriculas.php"); break;
			
		default: require_once($pathInc . "modulos/empresas/_matricular.php");
		
	}
	
}else{

	// Permissões
	$_ClassPermissao->validaPermissao(array("90","95","96","97","98","99","89"));
	
	// Verifica Sessão
	switch ($_REQUEST["sessao"]){
		
		// Caso for Inicial
		case "inicial": require_once($pathInc . "modulos/sistema/inicial.php"); break;
		
		# Gerenciamentos	
			
			// Caso for Matrículas
			case "matriculas": 
				
				// Verifica Sub sessão
				if($_REQUEST["subsessao"] == "empresas"){
					
					// Permissões
					$_ClassPermissao->validaPermissao(array("98","99","89"));
				
					// Matrículas para Empresas
					require_once($pathInc . "modulos/gerenciamentos/_matriculas_clientes.php");
					
				}elseif($_REQUEST["subsessao"] == "consultageral"){
				
					// Permissões
					$_ClassPermissao->validaPermissao(array("99", "98","89"));
				
					// Matrículas
					require_once($pathInc . "modulos/gerenciamentos/_matriculas.consultaGeral.php");
						
				}else{
				
					// Permissões
					$_ClassPermissao->validaPermissao(array("99", "98","89"));
				
					// Matrículas
					require_once($pathInc . "modulos/gerenciamentos/_matriculas.php");
				}
				
			break;
			
			// Caso for Matrículas Ativas de Clientes
			case "matriculasativas_clientes": 
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("94","98","99","89"));
			
				// Matrículas Ativas de Clientes
				require_once($pathInc . "modulos/gerenciamentos/_matriculasativas_clientes.php");
				
			break;
			
			// Caso for Matrículas Concluídas de Clientes
			case "matriculasconcluidas_clientes": 
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("94","98","99","89"));
			
				// Matrículas Concluídas de Clientes
				require_once($pathInc . "modulos/gerenciamentos/_matriculasconcluidas_clientes.php");
				
			break;
		
			// Caso for Alunos
			case "alunos": 
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98","89"));
			
				// Alunos
				require_once($pathInc . "modulos/gerenciamentos/_alunos.php"); 
				
			break;
			
			// Caso for Alunos
			case "alunos_clientes": 
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("94","98","99","89"));
			
				// Alunos
				require_once($pathInc . "modulos/gerenciamentos/_alunos_clientes.php"); 
				
			break;
			
			// Caso for Clientes
			case "clientes": 
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("99","89"));
				
				// Clientes
				require_once($pathInc . "modulos/gerenciamentos/_clientes.php"); 
				
			break;
			
			// Caso for Frequência/Dirário
			case "frequenciadiario": 
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("95", "99","89"));
			
				// Grade Horária
				require_once($pathInc . "modulos/gerenciamentos/_frequenciadiario.php"); 
				
			break;
			
			// Caso for Grade Horária
			case "gradehoraria": 
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("95", "99","89"));
			
				// Grade Horária
				require_once($pathInc . "modulos/gerenciamentos/_gradehoraria.php"); 
				
			break;
			
			// Caso for Falta de Documentos
			case "faltadocumentos": 
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98","89"));
			
				// Falta de Documentos
				require_once($pathInc . "modulos/gerenciamentos/_faltadocumentos.php"); 
				
			break;
			
			// Caso for Falta de Documentos
			case "faltadocumentos_clientes": 
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("94","98","99","89"));
			
				// Falta de Documentos
				require_once($pathInc . "modulos/gerenciamentos/_faltadocumentos_clientes.php"); 
				
			break;
			
			// Caso for Diário de Classe
			case "diarioclasse": 
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99","89"));
			
				// Diário de Classe
				require_once($pathInc . "modulos/gerenciamentos/_diarioclasse.php"); 
				
			break;
			
			// Caso for Notas
			case "notas": 
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("99","89"));
			
				// Notas
				require_once($pathInc . "modulos/gerenciamentos/_notas.php"); 
				
			break;
			
			// Caso for Frequências
			case "frequencias": 
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("94", "99","89"));
			
				// FreQuencias
				require_once($pathInc . "modulos/gerenciamentos/_frequencias.php"); 
				
			break;
		
		# Financeiro
			
			// Caso for Pagamentos
			case "pagamentos": 
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("89"));
			
				// Pagamentos
				require_once($pathInc . "modulos/financeiro/_pagamentos.php"); 
				
			break;
		
			// Caso for Despesas
			case "despesas": 
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("89"));
			
				// Despesas
				require_once($pathInc . "modulos/financeiro/_despesas.php"); 
				
			break;
			
			// Caso for Receitas
			case "receita": 
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("89"));
			
				// Receitas
				require_once($pathInc . "modulos/financeiro/_receita.php"); 
				
			break;
			
			// Caso for Faturas
			case "faturas": 
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("94","89"));
			
				// Faturas
				require_once($pathInc . "modulos/financeiro/_faturas.php"); 
				
			break;
			
			
			// Caso for Cobranças
			case "cobrancas": 
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("90", "94", "98", "99","89"));
			
				// Cobranças
				require_once($pathInc . "modulos/financeiro/_cobrancas.php"); 
				
			break;

            // Caso for Retornos
			case "retornos":

				// Permissões
				$_ClassPermissao->validaPermissao(array("99"));

				// retornos
				require_once($pathInc . "modulos/financeiro/_retornos.php");

			break;
			
		# Manutenção
		
			// Caso for Unidades
			case "unidades": 
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("99","89"));
			
				// Unidades
				require_once($pathInc . "modulos/manutencao/_unidades.php"); 
				
			break;
			
			// Caso for Turnos
			case "turnos":  
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("99","89"));
			
				// Turnos
				require_once($pathInc . "modulos/manutencao/_turnos.php"); 
				
			break;
			
			// Caso for Cursos
			case "cursos":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99","89"));
			
				// Cursos
				require_once($pathInc . "modulos/manutencao/_cursos.php"); 
				
			break;
			
			// Caso for Turmas Ativas
			case "turmasativas":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98","89"));
			
				// Turmas Ativas
				require_once($pathInc . "modulos/manutencao/_turmasativas.php"); 
				
			break;
			
			// Caso for Turmas Concluídas
			case "turmasconcluidas":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98","89"));
			
				// Turmas Concluídas
				require_once($pathInc . "modulos/manutencao/_turmasconcluidas.php"); 
				
			break;
			
			// Caso for Cidades
			case "cidades":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99","89"));
			
				// Cidades
				require_once($pathInc . "modulos/manutencao/_cidades.php"); 
				
			break;
			
			// Caso for Usuários
			case "usuarios":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99","89"));
			
				// Usuários
				require_once($pathInc . "modulos/manutencao/_usuarios.php"); 
				
			break;		
			
			// Caso for Escolaridade
			case "escolaridade":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99","89"));
			
				// Escolaridade
				require_once($pathInc . "modulos/manutencao/_escolaridade.php"); 
			
			break;
			
			// Caso for Matérias
			case "materias":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99","89"));
			
				// Matérias
				require_once($pathInc . "modulos/manutencao/_materias.php"); 
			
			break;
			
			// Caso for Carta de Cobrança
			case "cartacobranca":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("89"));
			
				// Carta de Cobrança
				require_once($pathInc . "modulos/manutencao/_cartacobranca.php"); 
			
			break;
			
			// Caso for Documentos
			case "documentos":

				// Permissões
				$_ClassPermissao->validaPermissao(array("99","89"));

				// Documentos
				require_once($pathInc . "modulos/manutencao/_documentos.php");

			break;

            // Caso for Faixa de Matrícula
			case "faixamatricula":

				// Permissões
				$_ClassPermissao->validaPermissao(array(""));

				// Documentos
				require_once($pathInc . "modulos/manutencao/_faixamatricula.php");

			break;
			
		# Relatórios
		
			// Caso for Grade Horária
			case "rel_gradehoraria":  
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98","89"));
			
				// Relatórios de Grade Horária
				require_once($pathInc . "modulos/relatorios/_rel.gradehoraria.php"); 
			
			break;
			
			// Caso for Frequências
			case "rel_frequencias":  
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98","89"));
			
				// Relatórios de Frequências
				require_once($pathInc . "modulos/relatorios/_rel.frequencias.php"); 
			
			break;
			
			// Caso for Horas Aula
			case "rel_horasaula":
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("95", "99","89"));
				
				// Relatório de Horas Aula
				require_once($pathInc . "modulos/relatorios/_rel.horasaula.php"); 
			
			break;
			
			// Caso for Horas Aula Geral
			case "rel_horasaulageral":
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99","89"));
				
				// Relatório de Horas Aula
				require_once($pathInc . "modulos/relatorios/_rel.horasaulageral.php"); 
			
			break;
			
			// Caso for Recibo
			case "rel_recibo":
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99","89"));
				
				// Relatório Recibo
				require_once($pathInc . "modulos/relatorios/_rel.recibo.php"); 
			
			break;
			
			// Caso for Lista de Chamada
			case "rel_listachamada":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98","89"));
			
				// Lista de Chamada
				require_once($pathInc . "modulos/relatorios/_rel.listachamada.php"); 
			
			break;
			
			// Caso for Ficha Cadastral
			case "rel_fichacadastral":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98", "89"));
			
				// Ficha Cadastral
				require_once($pathInc . "modulos/relatorios/_rel.ficha.php"); 
			
			break;
			
			// Caso for Documentação
			case "rel_documentacao":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98","89"));
			
				// Documentação
				require_once($pathInc . "modulos/relatorios/_rel.documentacao.php"); 
			
			break;
			
			// Caso for Alunos Matriculados
			case "rel_alunosmatriculados":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98","89"));
			
				// Alunos Matriculados
				require_once($pathInc . "modulos/relatorios/_rel.alunosmatriculados.php"); 
			
			break;
			
			// Caso for Alunos Concluídos
			case "rel_alunosconcluidos":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98","89"));
			
				// Alunos Concluídos
				require_once($pathInc . "modulos/relatorios/_rel.alunosconcluidos.php"); 
			
			break;
			
			// Caso for Certificados
			case "rel_certificados":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98","89"));
			
				// Certificado
				require_once($pathInc . "modulos/relatorios/_rel.certificados.php"); 
			
			break;
			
			// Caso for Carteirinhas
			case "rel_carteirinhas":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98","89"));
			
				// Carteirinhas
				require_once($pathInc . "modulos/relatorios/_rel.carteirinhas.php"); 
			
			break;
			
			// Caso for Declaração Provisória
			case "rel_declaracaoprovisoria":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98","89"));
			
				// Declaração Provisória
				require_once($pathInc . "modulos/relatorios/_rel.declaracaoprovisoria.php"); 
			
			break;
			
			// Caso for Declaração de Matrícula
			case "rel_declaracaomatricula":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98","89"));
			
				// Declaração de Matrícula
				require_once($pathInc . "modulos/relatorios/_rel.declaracaomatricula.php"); 
			
			break;
			
			// Caso for DPF
			case "rel_dpf":  
			
				// Permissões
				$_ClassPermissao->validaPermissao(array("99", "98","89"));
			
				// DPF
				require_once($pathInc . "modulos/relatorios/_rel.dpf.php"); 
			
			break;
			
		# Site
			
			// Caso for Escolher Atlas
			case "site_escolheratlas":  
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("89"));
			
				// Escolher Atlas
				require_once($pathInc . "modulos/site/_escolheratlas.php"); 
			
			break;	
			
			// Caso for Institucional
			case "site_institucional":  
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("89"));
			
				// Institucional
				require_once($pathInc . "modulos/site/_institucional.php"); 
			
			break;	
			
			// Caso for Galeria de Fotos
			case "site_galeriafotos":  
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("89"));
			
				// Galeria de Fotos
				require_once($pathInc . "modulos/site/_galeriafotos.php"); 
			
			break;	
			
			// Caso for Galeria de Vídeos
			case "site_galeriavideos":  
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("89"));
			
				// Galeria de Vídeos
				require_once($pathInc . "modulos/site/_galeriavideos.php"); 
			
			break;	
			
			// Caso for Contato
			case "site_contato":  
				
				// Permissões
				$_ClassPermissao->validaPermissao(array("89"));
			
				// Contato
				require_once($pathInc . "modulos/site/_contato.php"); 
			
			break;	
		
	}
	
}
?>