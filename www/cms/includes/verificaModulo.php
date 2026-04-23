<?php
// Verifica Módulo
if($_REQUEST["modulo"] == "empresa"){
	
}else{

	// Permissões
	$_ClassPermissao->validaPermissao(array("90", "95","96","97","98","99", "89"));
	
	// Verifica Sessão
	switch ($_REQUEST["sessao"]){
		
		// Caso for Inicial
		case "inicial": $_modulo = "inicio"; break;
		
		# Gerenciamentos	
			
			// Caso for Matrículas
			case "matriculas": $_modulo = "gerenciamentos"; break;
			
			// Caso for Matrículas Ativas de Clientes
			case "matriculasativas_clientes": $_modulo = "gerenciamentos"; break;
			
			// Caso for Matrículas Concluídas de Clientes
			case "matriculasconcluidas_clientes": $_modulo = "gerenciamentos"; break;
		
			// Caso for Alunos
			case "alunos": $_modulo = "gerenciamentos"; break;
			
			// Caso for Alunos
			case "alunos_clientes": $_modulo = "gerenciamentos"; break;
			
			// Caso for Clientes
			case "clientes": $_modulo = "gerenciamentos"; break;
			
			// Caso for Frequência/Dirário
			case "frequenciadiario": $_modulo = "gerenciamentos"; break;
			
			// Caso for Grade Horária
			case "gradehoraria": $_modulo = "gerenciamentos"; break;
			
			// Caso for Falta de Documentos
			case "faltadocumentos": $_modulo = "gerenciamentos"; break;
			
			// Caso for Falta de Documentos
			case "faltadocumentos_clientes": $_modulo = "gerenciamentos"; break;
			
			// Caso for Diário de Classe
			case "diarioclasse": $_modulo = "gerenciamentos"; break;
			
			// Caso for Notas
			case "notas": $_modulo = "gerenciamentos"; break;
			
			// Caso for Frequências
			case "frequencias": $_modulo = "gerenciamentos"; break;
		
		# Financeiro
			
			// Caso for Pagamentos
			case "pagamentos": $_modulo = "financeiro"; break;
		
			// Caso for Despesas
			case "despesas": $_modulo = "financeiro"; break;
			
			// Caso for Receitas
			case "receita": $_modulo = "financeiro"; break;
			
			// Caso for Faturas
			case "faturas": $_modulo = "financeiro"; break;
			
			// Caso for Cobranças
			case "cobrancas": $_modulo = "financeiro"; break;
			
		# Manutenção
		
			// Caso for Unidades
			case "unidades": $_modulo = "manutencao"; break;
			
			// Caso for Turnos
			case "turnos": $_modulo = "manutencao"; break;
			
			// Caso for Cursos
			case "cursos": $_modulo = "manutencao"; break;
			
			// Caso for Turmas Ativas
			case "turmasativas": $_modulo = "manutencao"; break;
			
			// Caso for Turmas Concluídas
			case "turmasconcluidas": $_modulo = "manutencao"; break;
			
			// Caso for Cidades
			case "cidades": $_modulo = "manutencao"; break;
			
			// Caso for Usuários
			case "usuarios": $_modulo = "manutencao"; break;		
			
			// Caso for Escolaridade
			case "escolaridade": $_modulo = "manutencao"; break;
			
			// Caso for Matérias
			case "materias": $_modulo = "manutencao"; break;
			
			// Caso for Carta de Cobrança
			case "cartacobranca": $_modulo = "manutencao"; break;
			
			// Caso for Documentos
			case "documentos": $_modulo = "manutencao"; break;
			
		# Relatórios
		
			// Caso for Grade Horária
			case "rel_gradehoraria": $_modulo = "relatorios"; break;
			
			// Caso for Frequências
			case "rel_frequencias": $_modulo = "relatorios"; break;
			
			// Caso for Horas Aula
			case "rel_horasaula": $_modulo = "relatorios"; break;
			
			// Caso for Horas Aula Geral
			case "rel_horasaulageral": $_modulo = "relatorios"; break;
			
			// Caso for Recibo
			case "rel_recibo": $_modulo = "relatorios"; break;
			
			// Caso for Lista de Chamada
			case "rel_listachamada": $_modulo = "relatorios"; break;
			
			// Caso for Ficha Cadastral
			case "rel_fichacadastral": $_modulo = "relatorios"; break;
			
			// Caso for Documentação
			case "rel_documentacao": $_modulo = "relatorios"; break;
			
			// Caso for Alunos Matriculados
			case "rel_alunosmatriculados": $_modulo = "relatorios"; break;
			
			// Caso for Alunos Concluídos
			case "rel_alunosconcluidos": $_modulo = "relatorios"; break;
			
			// Caso for Certificados
			case "rel_certificados": $_modulo = "relatorios"; break;
			
			// Caso for Carteirinhas
			case "rel_carteirinhas": $_modulo = "relatorios"; break;
			
			// Caso for Declaração Provisória
			case "rel_declaracaoprovisoria": $_modulo = "relatorios"; break;
			
			// Caso for Declaração de Matrícula
			case "rel_declaracaomatricula": $_modulo = "relatorios"; break;
			
			// Caso for DPF
			case "rel_dpf": $_modulo = "relatorios"; break;
			
		# Site
			
			// Caso for Escolher Atlas
			case "site_escolheratlas": $_modulo = "site"; break;	
			
			// Caso for Institucional
			case "site_institucional": $_modulo = "site"; break;	
			
			// Caso for Galeria de Fotos
			case "site_galeriafotos": $_modulo = "site"; break;	
			
			// Caso for Galeria de Vídeos
			case "site_galeriavideos": $_modulo = "site"; break;	
			
			// Caso for Contato
			case "site_contato": $_modulo = "site"; break;	
			
		default: $_modulo = "inicio";
		
	}
	
}
?>

