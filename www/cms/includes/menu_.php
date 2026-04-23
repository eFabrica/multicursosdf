<?php
// Verifica se está logado
if($_dadosLogado->logado == "S" && $_dadosUnidade->acesso == "L"){
	
	// $_codJs .= $_ClassPermissao->validaPermissaoSee(, array(""));
	
	// Cod Js
	$_codJs .= "";
	
	$_codJs .= "<script language='javascript' type='text/javascript'>";
	$_codJs .= "function mmLoadMenus() {";
	$_codJs .= "if (window.mm_menu_0712005129_0) return;";
	
	// Arquivo
	$_codJs .= "window.mm_menu_0712005129_0 = new Menu(\"root\",120,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);\r\n";
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712005129_0.addMenuItem(\"Inicial\",\"location='?sessao=inicial'\");\r\n", array("99", "98", "97", "96", "95"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712005129_0.addMenuItem(\"Mudar de Unidade\",\"location='mainMaster.php?sessao=inicial'\");\r\n", array(""));
	$_codJs .= "mm_menu_0712005129_0.addMenuItem(\"Sair\",\"location='modulos/sistema/sair.php'\");\r\n";
	$_codJs .= "mm_menu_0712005129_0.hideOnMouseOut=true;\r\n";
	$_codJs .= "mm_menu_0712005129_0.menuBorder=1;\r\n";
	$_codJs .= "mm_menu_0712005129_0.menuLiteBgColor='#ffffff';\r\n";
	$_codJs .= "mm_menu_0712005129_0.menuBorderBgColor='#d8d8d8';\r\n";
	$_codJs .= "mm_menu_0712005129_0.bgColor='#ffffff';\r\n";
			
				// Gerenciamentos - Rh - Matrículas - Privados
				$_codJs .= "window.mm_menu_0712010718_1_5 = new Menu(\"Privados\",120,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);";
				$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_5.addMenuItem(\"Ex-Aluno\",\"location='?sessao=matriculas&ref=novo'\");\r\n", array("99", "98"));
				$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_5.addMenuItem(\"Novo Aluno\",\"location='?sessao=alunos&ref=novo'\");\r\n", array("99", "98"));
				$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_5.addMenuItem(\"Consulta\",\"location='?sessao=matriculas'\");\r\n", array("99", "98"));
				$_codJs .= "mm_menu_0712010718_1_5.hideOnMouseOut=true;";
				$_codJs .= "mm_menu_0712010718_1_5.menuBorder=1;";
				$_codJs .= "mm_menu_0712010718_1_5.menuLiteBgColor='#ffffff';";
				$_codJs .= "mm_menu_0712010718_1_5.menuBorderBgColor='#d8d8d8';";
				$_codJs .= "mm_menu_0712010718_1_5.bgColor='#ffffff';";
				
				// Gerenciamentos - Rh - Matrículas - Empresas
				$_codJs .= "window.mm_menu_0712010718_1_4 = new Menu(\"Empresas\",120,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);";
				$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_4.addMenuItem(\"Ex-Aluno\",\"location='?sessao=matriculas&subsessao=empresas&ref=novo'\");\r\n", array("99", "98"));
				$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_4.addMenuItem(\"Novo Aluno\",\"location='?sessao=alunos&ref=novo'\");\r\n", array("99", "98"));
				$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_4.addMenuItem(\"Consulta\",\"location='?sessao=matriculas&subsessao=empresas'\");\r\n", array("99", "98"));
				$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_4.addMenuItem(\"Requerimentos\",\"location='?sessao=matriculas&subsessao=empresas&ref=requerimentos'\");\r\n", array("99", "98"));
				$_codJs .= "mm_menu_0712010718_1_4.hideOnMouseOut=true;";
				$_codJs .= "mm_menu_0712010718_1_4.menuBorder=1;";
				$_codJs .= "mm_menu_0712010718_1_4.menuLiteBgColor='#ffffff';";
				$_codJs .= "mm_menu_0712010718_1_4.menuBorderBgColor='#d8d8d8';";
				$_codJs .= "mm_menu_0712010718_1_4.bgColor='#ffffff';";
	
			// Gerenciamentos - Rh - Matrículas
			$_codJs .= "window.mm_menu_0712010718_1_3 = new Menu(\"Matrículas\",120,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);";
			$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_3.addMenuItem(mm_menu_0712010718_1_5,\"location='#'\");\r\n", array("99", "98"));		
			$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_3.addMenuItem(mm_menu_0712010718_1_4,\"location='#'\");\r\n", array("99", "98"));
			$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_3.addMenuItem(\"Consulta Geral\",\"location='?sessao=matriculas&subsessao=consultageral'\");\r\n", array("99", "98"));
			$_codJs .= "mm_menu_0712010718_1_3.hideOnMouseOut=true;";
			$_codJs .= "mm_menu_0712010718_1_3.childMenuIcon=\"imagens/diversos/arrow.gif\";\r\n";
			$_codJs .= "mm_menu_0712010718_1_3.menuBorder=1;";
			$_codJs .= "mm_menu_0712010718_1_3.menuLiteBgColor='#ffffff';";
			$_codJs .= "mm_menu_0712010718_1_3.menuBorderBgColor='#d8d8d8';";
			$_codJs .= "mm_menu_0712010718_1_3.bgColor='#ffffff';";
			
			// Gerenciamentos - Rh - Matrículas 2
			$_codJs .= "window.mm_menu_0712010718_1_6 = new Menu(\"Matrículas\",120,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);";
			$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_6.addMenuItem(\"Ativas\",\"location='?sessao=matriculasativas_clientes'\");\r\n", array(""), true);		
			$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_6.addMenuItem(\"Concluídas\",\"location='?sessao=matriculasconcluidas_clientes'\");\r\n", array(""), true);		
			$_codJs .= "mm_menu_0712010718_1_6.hideOnMouseOut=true;";
			$_codJs .= "mm_menu_0712010718_1_6.childMenuIcon=\"imagens/diversos/arrow.gif\";\r\n";
			$_codJs .= "mm_menu_0712010718_1_6.menuBorder=1;";
			$_codJs .= "mm_menu_0712010718_1_6.menuLiteBgColor='#ffffff';";
			$_codJs .= "mm_menu_0712010718_1_6.menuBorderBgColor='#d8d8d8';";
			$_codJs .= "mm_menu_0712010718_1_6.bgColor='#ffffff';";
	
		// Gerenciamentos - Rh
		$_codJs .= "window.mm_menu_0712010718_1_0 = new Menu(\"Rh\",160,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);";
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_0.addMenuItem(\"Alunos\",\"location='?sessao=alunos_clientes'\");\r\n", array(""), true);
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_0.addMenuItem(\"Alunos\",\"location='?sessao=alunos'\");\r\n", array("99", "98"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_0.addMenuItem(mm_menu_0712010718_1_3,\"location='?sessao=matriculas'\");\r\n", array("99", "98"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_0.addMenuItem(mm_menu_0712010718_1_6,\"location='#'\");\r\n", array(""), true);
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_0.addMenuItem(\"Matrículas\",\"location='?sessao=matriculas'\");\r\n", array(""), true);
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_0.addMenuItem(\"Falta de Documentos\",\"location='?sessao=faltadocumentos_clientes'\");\r\n", array(""), true);
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_0.addMenuItem(\"Falta de Documentos\",\"location='?sessao=faltadocumentos'\");\r\n", array("99", "98"));
		$_codJs .= "mm_menu_0712010718_1_0.hideOnMouseOut=true;";
		$_codJs .= "mm_menu_0712010718_1_0.childMenuIcon=\"imagens/diversos/arrow.gif\";\r\n";
		$_codJs .= "mm_menu_0712010718_1_0.menuBorder=1;";
		$_codJs .= "mm_menu_0712010718_1_0.menuLiteBgColor='#ffffff';";
		$_codJs .= "mm_menu_0712010718_1_0.menuBorderBgColor='#d8d8d8';";
		$_codJs .= "mm_menu_0712010718_1_0.bgColor='#ffffff';";
		
		// Gerenciamentos - Institucional
		$_codJs .= "window.mm_menu_0712010718_1_1 = new Menu(\"Institucional\",100,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);";
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_1.addMenuItem(\"Clientes\",\"location='?sessao=clientes'\");\r\n", array("99"));
		$_codJs .= "mm_menu_0712010718_1_1.hideOnMouseOut=true;";
		$_codJs .= "mm_menu_0712010718_1_1.menuBorder=1;";
		$_codJs .= "mm_menu_0712010718_1_1.menuLiteBgColor='#ffffff';";
		$_codJs .= "mm_menu_0712010718_1_1.menuBorderBgColor='#d8d8d8';";
		$_codJs .= "mm_menu_0712010718_1_1.bgColor='#ffffff';";
		
		// Gerenciamentos - Escolar
		$_codJs .= "window.mm_menu_0712010718_1_2 = new Menu(\"Escolar\",120,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);";
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_2.addMenuItem(\"Frequï¿½ncia/Diï¿½rio\",\"location='?sessao=frequenciadiario'\");\r\n", array("99"));
		//$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_2.addMenuItem(\"Diï¿½rio de Classe\",\"location='?sessao=diarioclasse'\");\r\n", array("99"));
		//$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_2.addMenuItem(\"Frequï¿½ncias\",\"location='?sessao=frequencias'\");\r\n", array("99"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_2.addMenuItem(\"Grade Horária\",\"location='?sessao=gradehoraria'\");\r\n", array("99"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_2.addMenuItem(\"Notas\",\"location='?sessao=notas'\");\r\n", array("99"));
		$_codJs .= "mm_menu_0712010718_1_2.hideOnMouseOut=true;";
		$_codJs .= "mm_menu_0712010718_1_2.menuBorder=1;";
		$_codJs .= "mm_menu_0712010718_1_2.menuLiteBgColor='#ffffff';";
		$_codJs .= "mm_menu_0712010718_1_2.menuBorderBgColor='#d8d8d8';";
		$_codJs .= "mm_menu_0712010718_1_2.bgColor='#ffffff';";
	
	// Gerenciamentos
	$_codJs .= "window.mm_menu_0712010718_1 = new Menu(\"root\",106,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);\r\n";
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1.addMenuItem(mm_menu_0712010718_1_0,\"#\");\r\n", array("", "99", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1.addMenuItem(mm_menu_0712010718_1_1,\"#\");\r\n", array("99"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1.addMenuItem(mm_menu_0712010718_1_2,\"#\");\r\n", array("99"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1.addMenuItem(\"Grade Horária\",\"location='?sessao=gradehoraria'\");\r\n", array("95"), true);
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1.addMenuItem(\"Matrícular\",\"location='?modulo=empresa&sessao=matricular'\");\r\n", array("94"), true);
	$_codJs .= "mm_menu_0712010718_1.hideOnMouseOut=true;\r\n";
	$_codJs .= "mm_menu_0712010718_1.childMenuIcon=\"imagens/diversos/arrow.gif\";\r\n";
	$_codJs .= "mm_menu_0712010718_1.menuBorder=1;\r\n";
	$_codJs .= "mm_menu_0712010718_1.menuLiteBgColor='#ffffff';\r\n";
	$_codJs .= "mm_menu_0712010718_1.menuBorderBgColor='#d8d8d8';\r\n";
	$_codJs .= "mm_menu_0712010718_1.bgColor='#ffffff';\r\n";
	
	// Financeiro
	$_codJs .= "window.mm_menu_0712011011_2 = new Menu(\"root\",107,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);\r\n";
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011011_2.addMenuItem(\"Pagamentos\",\"location='?sessao=pagamentos'\");\r\n", array(""));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011011_2.addMenuItem(\"Despesas\",\"location='?sessao=despesas'\");\r\n", array(""), true);
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011011_2.addMenuItem(\"Receita\",\"location='?sessao=receita'\");\r\n", array(""), true);
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011011_2.addMenuItem(\"Faturas\",\"location='?sessao=faturas'\");\r\n", array(""));
	$_codJs .= "mm_menu_0712011011_2.hideOnMouseOut=true;\r\n";
	$_codJs .= "mm_menu_0712011011_2.menuBorder=1;\r\n";
	$_codJs .= "mm_menu_0712011011_2.menuLiteBgColor='#ffffff';\r\n";
	$_codJs .= "mm_menu_0712011011_2.menuBorderBgColor='#d8d8d8';\r\n";
	$_codJs .= "mm_menu_0712011011_2.bgColor='#ffffff';\r\n";
	
			// Manutenção - Escolar - Turmas
			$_codJs .= "window.mm_menu_0712011423_3_4 = new Menu(\"Turmas\",100,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);";
			$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3_4.addMenuItem(\"Ativas\",\"window.location.href='?sessao=turmasativas'\");\r\n", array("99", "98"));
			$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3_4.addMenuItem(\"Concluídas\",\"window.location.href='?sessao=turmasconcluidas'\");\r\n", array("99", "98"));
			$_codJs .= "mm_menu_0712011423_3_4.hideOnMouseOut=true;";
			$_codJs .= "mm_menu_0712011423_3_4.menuBorder=1;";
			$_codJs .= "mm_menu_0712011423_3_4.menuLiteBgColor='#ffffff';";
			$_codJs .= "mm_menu_0712011423_3_4.menuBorderBgColor='#d8d8d8';";
			$_codJs .= "mm_menu_0712011423_3_4.bgColor='#ffffff';";
	
		// Manutenção - Escolar
		$_codJs .= "window.mm_menu_0712011423_3_1 = new Menu(\"Escolar\",100,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);";
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3_1.addMenuItem(\"Cursos\",\"location='?sessao=cursos'\");\r\n", array("99"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3_1.addMenuItem(mm_menu_0712011423_3_4,\"location='?sessao=turmas'\");\r\n", array("99", "98"));
		$_codJs .= "mm_menu_0712011423_3_1.hideOnMouseOut=true;";
		$_codJs .= "mm_menu_0712011423_3_1.childMenuIcon=\"imagens/diversos/arrow.gif\";\r\n";
		$_codJs .= "mm_menu_0712011423_3_1.menuBorder=1;";
		$_codJs .= "mm_menu_0712011423_3_1.menuLiteBgColor='#ffffff';";
		$_codJs .= "mm_menu_0712011423_3_1.menuBorderBgColor='#d8d8d8';";
		$_codJs .= "mm_menu_0712011423_3_1.bgColor='#ffffff';";
		
		// Manutenção - Modelos
		$_codJs .= "window.mm_menu_0712011423_3_2 = new Menu(\"Modelos\",150,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);";
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3_2.addMenuItem(\"Carta&nbsp;de&nbsp;Cobran&ccedil;a\",\"location='?sessao=cartacobranca'\");\r\n", array(""));
		$_codJs .= "mm_menu_0712011423_3_2.hideOnMouseOut=true;";
		$_codJs .= "mm_menu_0712011423_3_2.menuBorder=1;";
		$_codJs .= "mm_menu_0712011423_3_2.menuLiteBgColor='#ffffff';";
		$_codJs .= "mm_menu_0712011423_3_2.menuBorderBgColor='#d8d8d8';";
		$_codJs .= "mm_menu_0712011423_3_2.bgColor='#ffffff';";
			
		// Manutenção - Sistema
		$_codJs .= "window.mm_menu_0712011423_3_3 = new Menu(\"Sistema\",80,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);";
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3_3.addMenuItem(\"Unidades\",\"location='?sessao=unidades'\");\r\n", array("99"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3_3.addMenuItem(\"Usu&aacute;rios&nbsp;&nbsp;&nbsp;\",\"location='?sessao=usuarios'\");\r\n", array("99"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3_3.addMenuItem(\"Escolaridade\",\"location='?sessao=escolaridade'\");\r\n", array("99"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3_3.addMenuItem(\"Turnos\",\"location='?sessao=turnos'\");\r\n", array("99"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3_3.addMenuItem(\"Cidades\",\"location='?sessao=cidades'\");\r\n", array("99"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3_3.addMenuItem(\"Matérias\",\"location='?sessao=materias'\");\r\n", array("99"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3_3.addMenuItem(\"Documentos\",\"location='?sessao=documentos'\");\r\n", array("99"));
		$_codJs .= "mm_menu_0712011423_3_3.hideOnMouseOut=true;";
		$_codJs .= "mm_menu_0712011423_3_3.menuBorder=1;";
		$_codJs .= "mm_menu_0712011423_3_3.menuLiteBgColor='#ffffff';";
		$_codJs .= "mm_menu_0712011423_3_3.menuBorderBgColor='#d8d8d8';";
		$_codJs .= "mm_menu_0712011423_3_3.bgColor='#ffffff';";
	
	// Manutenção
	$_codJs .= "window.mm_menu_0712011423_3 = new Menu(\"root\",159,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);\r\n";
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3.addMenuItem(mm_menu_0712011423_3_1,\"location='#\");\r\n", array("99","98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3.addMenuItem(mm_menu_0712011423_3_2,\"location='#'\");\r\n", array(""));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3.addMenuItem(mm_menu_0712011423_3_3,\"location='#'\");\r\n", array("99"));
	$_codJs .= "mm_menu_0712011423_3.hideOnMouseOut=true;\r\n";
	$_codJs .= "mm_menu_0712011423_3.childMenuIcon=\"" . $pathInc . "imagens/diversos/arrow.gif\";";
	$_codJs .= "mm_menu_0712011423_3.menuBorder=1;\r\n";
	$_codJs .= "mm_menu_0712011423_3.menuLiteBgColor='#ffffff';\r\n";
	$_codJs .= "mm_menu_0712011423_3.menuBorderBgColor='#d8d8d8';\r\n";
	$_codJs .= "mm_menu_0712011423_3.bgColor='#ffffff';\r\n";		
		
		// Relatórios - Escolar
		$_codJs .= "window.mm_menu_0712011614_4_1 = new Menu(\"Horas Aula\",100,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);";
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4_1.addMenuItem(\"Detalhada\",\"location='?sessao=rel_horasaula'\");\r\n", array("99"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4_1.addMenuItem(\"Geral\",\"location='?sessao=rel_horasaulageral'\");\r\n", array("99"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4_1.addMenuItem(\"Recibo\",\"location='?sessao=rel_recibo'\");\r\n", array("99"));
		$_codJs .= "mm_menu_0712011614_4_1.hideOnMouseOut=true;";
		$_codJs .= "mm_menu_0712011614_4_1.menuBorder=1;";
		$_codJs .= "mm_menu_0712011614_4_1.menuLiteBgColor='#ffffff';";
		$_codJs .= "mm_menu_0712011614_4_1.menuBorderBgColor='#d8d8d8';";
		$_codJs .= "mm_menu_0712011614_4_1.bgColor='#ffffff';";
		
		// Relatórios - Declaraï¿½ï¿½es
		$_codJs .= "window.mm_menu_0712011614_4_2 = new Menu(\"Declaraï¿½ï¿½es\",100,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);";
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4_2.addMenuItem(\"Provisória\",\"location='?sessao=rel_declaracaoprovisoria'\");\r\n", array("99", "98"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4_2.addMenuItem(\"Matrícula\",\"location='?sessao=rel_declaracaomatricula'\");\r\n", array("99", "98"));
		$_codJs .= "mm_menu_0712011614_4_2.hideOnMouseOut=true;";
		$_codJs .= "mm_menu_0712011614_4_2.menuBorder=1;";
		$_codJs .= "mm_menu_0712011614_4_2.menuLiteBgColor='#ffffff';";
		$_codJs .= "mm_menu_0712011614_4_2.menuBorderBgColor='#d8d8d8';";
		$_codJs .= "mm_menu_0712011614_4_2.bgColor='#ffffff';";
	
	// Relatórios
	$_codJs .= "window.mm_menu_0712011614_4 = new Menu(\"root\",132,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);\r\n";
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(\"Grade Horária\",\"location='?sessao=rel_gradehoraria'\");\r\n", array("99", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(\"Frequï¿½ncias\",\"location='?sessao=rel_frequencias'\");\r\n", array("99", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(\"Lista de Chamada\",\"location='?sessao=rel_listachamada'\");\r\n", array("99", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(mm_menu_0712011614_4_1,\"location='#'\");\r\n", array("99"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(\"Ficha Cadastral\",\"location='?sessao=rel_fichacadastral'\");\r\n", array("99", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(\"Documentaï¿½ï¿½o\",\"location='?sessao=rel_documentacao'\");\r\n", array("99", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(\"Alunos Matriculados\",\"location='?sessao=rel_alunosmatriculados'\");\r\n", array("99", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(\"Alunos Concluídos\",\"location='?sessao=rel_alunosconcluidos'\");\r\n", array("99", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(\"Certificados\",\"location='?sessao=rel_certificados'\");\r\n", array("99", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(\"Carteirinhas\",\"location='?sessao=rel_carteirinhas'\");\r\n", array("99", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(mm_menu_0712011614_4_2,\"location='#'\");\r\n", array("99", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(\"DPF\",\"location='?sessao=rel_dpf'\");\r\n", array("99", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(\"Horas Aula\",\"location='?sessao=rel_horasaula'\");\r\n", array("95"), true);
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(\"Matrículas\",\"location='?modulo=empresa&sessao=matriculas'\");\r\n", array("94"), true);
	$_codJs .= "mm_menu_0712011614_4.hideOnMouseOut=true;\r\n";
	$_codJs .= "mm_menu_0712011614_4.childMenuIcon=\"" . $pathInc . "imagens/diversos/arrow.gif\";";
	$_codJs .= "mm_menu_0712011614_4.menuBorder=1;\r\n";
	$_codJs .= "mm_menu_0712011614_4.menuLiteBgColor='#ffffff';\r\n";
	$_codJs .= "mm_menu_0712011614_4.menuBorderBgColor='#d8d8d8';\r\n";
	$_codJs .= "mm_menu_0712011614_4.bgColor='#ffffff';\r\n";
	
	// Site
	$_codJs .= "window.mm_menu_1001141613_5 = new Menu(\"root\",142,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);\r\n";
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_1001141613_5.addMenuItem(\"Escolher a Atlas?\",\"location='?sessao=site_escolheratlas'\");\r\n", array(""));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_1001141613_5.addMenuItem(\"Institucional\",\"location='?sessao=site_institucional'\");\r\n", array(""));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_1001141613_5.addMenuItem(\"Galeria de Fotos\",\"location='?sessao=site_galeriafotos'\");\r\n", array(""));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_1001141613_5.addMenuItem(\"Galeria de Vï¿½deos\",\"location='?sessao=site_galeriavideos'\");\r\n", array(""));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_1001141613_5.addMenuItem(\"Contato\",\"location='?sessao=site_contato'\");\r\n", array(""));
	$_codJs .= "mm_menu_1001141613_5.hideOnMouseOut=true;\r\n";
	$_codJs .= "mm_menu_1001141613_5.childMenuIcon=\"" . $pathInc . "imagens/diversos/arrow.gif\";";
	$_codJs .= "mm_menu_1001141613_5.menuBorder=1;\r\n";
	$_codJs .= "mm_menu_1001141613_5.menuLiteBgColor='#ffffff';\r\n";
	$_codJs .= "mm_menu_1001141613_5.menuBorderBgColor='#d8d8d8';\r\n";
	$_codJs .= "mm_menu_1001141613_5.bgColor='#ffffff';\r\n";
	$_codJs .= "mm_menu_1001141613_5.writeMenus();\r\n";
	$_codJs .= "}\r\n";
	
	$_codJs .= "	mmLoadMenus();\r\n";
	$_codJs .= "</script>\r\n";
	
	// Exibe Código Js
	print($_codJs);
	?>

	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td class="menu_f" width="100%">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<?php print($_ClassPermissao->validaPermissaoSee("<td align='left'><a href=\"#\" onMouseOut=\"MM_startTimeout();\" onMouseOver=\"MM_showMenu(window.mm_menu_0712005129_0,0,24,null,'arquivo');\"><img name=\"arquivo\" src=\"" . $pathInc . "imagens/diversos/arquivo.jpg\" width=\"61\" height=\"25\" border=\"0\" alt=\"\"></a></td>", array("99", "98", "97", "96", "95", "94")));?>
						<?php print($_ClassPermissao->validaPermissaoSee("<td colspan=\"2\"><a href=\"#\" onMouseOut=\"MM_startTimeout();\" onMouseOver=\"MM_showMenu(window.mm_menu_0712010718_1,0,24,null,'cadastro');\"><img name=\"cadastro\" src=\"" . $pathInc . "imagens/diversos/gerenciamentos.jpg\" width=\"109\" height=\"25\" border=\"0\" alt=\"\"></a></td>", array("95", "98", "99", "94")));?>
						<?php print($_ClassPermissao->validaPermissaoSee("<td align='left'><a href=\"#\" onMouseOut=\"MM_startTimeout();\" onMouseOver=\"MM_showMenu(window.mm_menu_0712011011_2,0,24,null,'financeiro');\"><img name=\"financeiro\" src=\"" . $pathInc . "imagens/diversos/financeiro.jpg\" width=\"78\" height=\"25\" border=\"0\" alt=\"\"></a></td>", array("")));?>
						<?php print($_ClassPermissao->validaPermissaoSee("<td align='left'><a href=\"#\" onMouseOut=\"MM_startTimeout();\" onMouseOver=\"MM_showMenu(window.mm_menu_0712011423_3,0,24,null,'manutencao');\"><img name=\"manutencao\" src=\"" . $pathInc . "imagens/diversos/manutencao.jpg\" width=\"86\" height=\"25\" border=\"0\" alt=\"\"></a></td>", array("99", "98")));?>
						<?php print($_ClassPermissao->validaPermissaoSee("<td align='left'><a href=\"#\" onMouseOut=\"MM_startTimeout();\" onMouseOver=\"MM_showMenu(window.mm_menu_0712011614_4,0,24,null,'relatorios');\"><img name=\"relatorios\" src=\"" . $pathInc . "imagens/diversos/relatorios.jpg\" width=\"76\" height=\"25\" border=\"0\" alt=\"\"></a></td>", array("95", "99", "98", "94")));?>
						<?php print($_ClassPermissao->validaPermissaoSee("<td align='left'><a href=\"#\" onMouseOut=\"MM_startTimeout();\" onMouseOver=\"MM_showMenu(window.mm_menu_1001141613_5,0,24,null,'site');\"><img name=\"site\" src=\"" . $pathInc . "imagens/diversos/site.jpg\" width=\"48\" height=\"25\" border=\"0\" alt=\"\"></a></td>", array("")));?>
					</tr>
				</table>
			</td>
			<td align="right"><img src="imagens/diversos/menu_d.gif"></td>
		</tr>
	</table>
	<?php
}
?>