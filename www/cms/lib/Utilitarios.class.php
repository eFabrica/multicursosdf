<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
/*
 * Classe de funções utilitárias.
 */
 
class Utilitarios{
	var $erro;
	var $iTemp;
	
	/*Construtor*/
	function Utilitarios(){
		
	}
	
	// Função tira mascaras
	function tiraMask($string){
		
		// Limpa string
		$string = str_replace(".", "", $string);
		$string = str_replace("/", "", $string);
		$string = str_replace("-", "", $string);
		$string = str_replace("%", "", $string);
		$string = str_replace(":", "", $string);
		
		// Retorna string
		return $string; 
	
	}
	
	// Função tira/coloca zero à esquerda
	function setZero($numero, $opcoes){
	
		// Verifica opção
		if($opcoes[0] == 1){
		
			// Limpa nosso número
			for($i=0;$i<strlen($numero);$i++){
				
				// Verifica char do nosso número
				if($numero{$i} > 0){
					
					// Caso for maior que zero
					$retorno .= $numero{$i};
					
					// Verifica se já foi encontrado número maior que zero
					if($ir == 0){
					
						// Incrementa ir
						$ir++;
						
					}
					
				}else{ // Caso for igual que zero
					
					// Verifica se já foi encontrado número maior que zero
					if($ir == 1){
					
						// Caso for maior que zero
						$retorno .= $numero{$i};
					
					}
					
				}
				
			}
			
			// Retorna
			return $retorno;
		
		} elseif($opcoes[0] == 2){
		
			// Retorna
			return str_pad($numero, $opcoes[1], "0", STR_PAD_LEFT);
		
		}
	
	}
	
	//Função que pega comando da url
	function getComand(){
		//Explode o comando
		return explode(",", $_GET["c"]);
	}
	
	//Seta ação
	function setAcaoDB($usuario, $tabela, $idTabela, $acao, $extras=0){
		//Adiciona registro de ação
		@mysql_query("INSERT INTO log_acoes (`idacesso`, `usuario` , `tabela` , `idtabela` , `acao` , `extras` , `data` , `hora` ) 
									 VALUES('" . $_SESSION["idAcesso"] . "', 
									 		'" . $usuario . "', 
									 		'" . $tabela . "', 
											'" . $idTabela . "', 
											'" . $acao . "', 
											'" . $extras . "',
											now(), now())") or die (mysql_error());
	}
	
	//Abrevia nome
	function abreviaNome($nome){
		//Explode nome pelos espaços
		$nomeTemp = explode(" ", $nome);
		
		//Retorna nome abreviado
		return ((count($nomeTemp) > 1)?$nomeTemp[0] . " " . ucfirst(substr($nomeTemp[1], 0, 1)) . ".":$nomeTemp[0]);
	}
	
	//Salva Url
	function salvaUrl($local, $url){
		//Busca url do user
		$buscaUrl = mysql_query("SELECT id FROM url WHERE usuario='" . $_SESSION["idUser"] . "' AND local='" . $local . "'");
		
		//Verifica o total achado
		if(mysql_num_rows($buscaUrl) == 0){
			//Insere
			mysql_query("INSERT INTO url (`usuario`, `local`, `url`) VALUES ('" . $_SESSION["idUser"] . "', '" . $local . "', '" . $url . "')");
		}else{
			//Altera
			mysql_query("UPDATE url SET `local` = '" . $local . "', `url` = '" . $url . "' WHERE usuario='" . $_SESSION["idUser"] . "'");
		}
	}
	
	//Retorna url
	function getUrl($local){
		//Busca url do user
		$buscaUrl = mysql_query("SELECT url FROM url WHERE usuario='" . $_SESSION["idUser"] . "' AND local LIKE '%" . $local . "%'");
		
		//Dados da url
		$dadosUrl = mysql_fetch_assoc($buscaUrl);
		
		//retorna url
		return $dadosUrl[url];
	}
	
	//Redireciona em JS
	function redirecionarJS($url, $opcao=0, $arrayOpcoes=0, $location=true){
		//Código em JS
		$codJS = "";
		
		//Tag de inicio de código JS
		$codJS .= "<script language=\"javascript\" type=\"text/javascript\">" . "\n\r";
		
		//Verifica opções
		switch($opcao){
			case "1": $codJS .= "alert(\"" . $arrayOpcoes[0] . "\");\n"; break;
			case "2": 
				$codJS .= "alert(\"" . $arrayOpcoes[0] . "\");\n"; 
				$codJS .= "opener.location.href = \"" . $arrayOpcoes[1] . "\";\n"; 
			break;
			case "3": 
				$codJS .= "alert(\"" . $arrayOpcoes[0] . "\");\n"; 
				$codJS .= "opener.location.href = \"" . $arrayOpcoes[1] . "\";\n"; 
				$codJS .= "window.close();\n"; 
			break;
			case "4":
				$codJS .= "alert(\"" . $arrayOpcoes[0] . "\");\n"; 
				$codJS .= "window.open('" . $arrayOpcoes[1] . "',";
				$codJS .= "'" . $arrayOpcoes[2] . "',";
				$codJS .= "'toolbar=no,location=no,directories=no,status=no,menubar=no,";
				$codJS .= "scrollbars=" . $arrayOpcoes[3] . ",";
				$codJS .= "resizable=" . $arrayOpcoes[4] . ",";
				$codJS .= "width=" . $arrayOpcoes[5] . ",";
				$codJS .= "height=" . $arrayOpcoes[6] . "');";
			break;
			case "5": 
				$codJS .= "alert(\"" . $arrayOpcoes[0] . "\");\n"; 
				$codJS .= "parent.opener.location.href = \"" . $arrayOpcoes[1] . "\";\n"; 
			break;
			case "6": 
				$codJS .= "opener.location.href = \"" . $arrayOpcoes[0] . "\";\n"; 
			break;
			case "7": 
				$codJS .= "parent.opener.location.href = \"" . $arrayOpcoes[1] . "\";\n"; 
			break;
			case "8":
				$codJS .= "alert(\"" . $arrayOpcoes[0] . "\");\n"; 
				$codJS .= "window.open('" . $arrayOpcoes[1] . "');";
			break;
			//case "": $codJS .= ""; break;
			default: "";
		}
		
		//Redirecionando
		if($location)$codJS .= "location.href='" . $url . "';\n";
		
		//Fechando tag de inicio de código JS
		$codJS .= "</script>";
		
		//Retorna script
		return $codJS;
	}
	
	/*Aplica tags em termos na string*/
	function aplicaTagString($string, $termoProcurar, $tag1, $tag2){
		return str_replace($termoProcurar, "<" . $tag1 . ">" . $termoProcurar . "</" . $tag2 . ">", $string);
	}
	
	/* Verifica situação do usuário */
	function verificaSituacao($dados, $situacaoInicio="<font color=\"#FF0000\"><strong>", $situacaoFinal="</strong></font>"){
		
		//Verifica se está suspenso
		$situacao .= (($dados["suspenso"] == "S")?" (Suspenso)":"");
		$situacao .= (($dados["demitido"] == "S")?" (Demitido)":"");
		$situacao .= (($dados["deletado"] == "S")?" (Deletado)":"");
		$situacao .= (($dados["suspensa"] == "S")?" (Suspensa)":"");
		$situacao .= (($dados["deletada"] == "S")?" (Deletada)":"");
		$situacao .= (($dados["finalizada"] == "S")?" (Finalizada)":"");
	
		//retorna situação
		return $situacaoInicio.$situacao.$situacaoFinal;
	}
	
	function removeTree($rootDir)
		/**
		 *  Função para remover um diretório sem ter que apagar manualmente cada arquivo e pasta dentro dele
		 *  Autor: Carlos Reche
		 *  E-mail: carlosreche@yahoo.com
		 *
		 */
		{
			if (!is_dir($rootDir))
			{
				return false;
			}
		
			if (!preg_match("/\\/$/", $rootDir))
			{
				$rootDir .= '/';
			}
		
		
			$stack = array($rootDir);
		
			while (count($stack) > 0)
			{
				$hasDir = false;
				$dir    = end($stack);
				$dh     = opendir($dir);
		
				while (($file = readdir($dh)) !== false)
				{
					if ($file == '.'  ||  $file == '..')
					{
						continue;
					}
		
					if (is_dir($dir . $file))
					{
						$hasDir = true;
						array_push($stack, $dir . $file . '/');
					}
		
					else if (is_file($dir . $file))
					{
						@unlink($dir . $file);
					}
				}
		
				closedir($dh);
		
				if ($hasDir == false)
				{
					array_pop($stack);
				}
			}
		
			return true;
		}
		
	/* Cria Menu */
	function criaMenu($text, $link, $onclick, $pos, $img=0, $path=""){
		
		// Verifica Pos
		if($pos == "esq"){
			
			return "<table border='0' cellpadding='0' cellspacing='0'>
						<tr>
							<td align='left'><img src='" . $path . "imagens/botoes/botaoEsquerdoBlank.png' border='0'></td>
							<td style='background-image:url(" . $path . "imagens/fundos/botaoBlank_f.png);background-repeat:repeat-x;'><a href='" . $link . "' onClick=\"" . $onclick . "\">" . $text . "</a></td>
							<td align='left'><img src='" . $path . "imagens/botoes/ext/" . $img . ".png' border='0'></td>
						</tr>
					</table>";
			
		}elseif($pos == "dir"){
			
			return "<table border='0' cellpadding='0' cellspacing='0'>
						<tr>
							<td align='left'><img src='" . $path . "imagens/botoes/ext/" . $img . ".png' border='0'></td>
							<td style='background-image:url(" . $path . "imagens/fundos/botaoBlank_f.png);background-repeat:repeat-x;'><a href='" . $link . "' onClick=\"" . $onclick . "\">" . $text . "</a></td>
							<td align='left'><img src='" . $path . "imagens/botoes/botaoDireitoBlank.png' border='0'></td>
						</tr>
					</table>";
			
		}
		
	}
	
	/* Cria Legenda */
	function criaLegenda ($text, $tipo=0){
		
		// Limpa Text
		$text = str_replace("\n", "<br>", $text);
		$text = str_replace("\r", "<br>", $text);
		$text = str_replace("<br><br>", "<br>", $text);
		$text = trim($text);
		$text = addslashes($text);
		
		# Monta Legenda
			
			// Verifica Tipo
			switch ($tipo){
				
				case 1:
					
					// Legenda
					$legenda = "<table width='284' border='0' cellpadding='0' cellspacing='0'>
							<tr>
								<td align='left'><img src='imagens/diversos/caixaCimaLegenda.gif' width='284' height='9'></td>
							</tr>
							<tr>
								<td valign=top style='background-image:url(imagens/fundos/caixaMeioLegenda.gif);'>
									<table width='90%' border='0' cellpadding='0' cellspacing='0' align='center'>
										<tr>
											<td width='11%'><img src='imagens/icones/legenda.png'></td>
											<td width='89%'><div align='justify'>" . $text . "</div></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td align='left'><img src='imagens/diversos/caixaBaixoLegenda_.gif' width='284'></td>
							</tr>
						</table>";
					
				break;
				
				default: 
				
					// Legenda
					$legenda = "<table width='284' border='0' cellpadding='0' cellspacing='0'>
								<tr>
									<td align='left'><img src='imagens/diversos/caixaCimaLegenda.gif' width='284' height='9'></td>
								</tr>
								<tr>
									<td valign=top style='background-image:url(imagens/fundos/caixaMeioLegenda.gif);'>
										<table width='90%' border='0' cellpadding='0' cellspacing='0' align='center'>
											<tr>
												<td width='11%'><img src='imagens/icones/legenda.png'></td>
												<td width='89%'><div align='justify'>" . $text . "</div></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td align='left'><img src='imagens/diversos/caixaBaixoLegenda.gif' width='284' height='73'></td>
								</tr>
							</table>";
					
			}
								
		// Limpa Legenda
		$legenda = str_replace("\n", "", $legenda);
		$legenda = str_replace("\r", "", $legenda);	
		$legenda = trim($legenda);
		$legenda = addslashes($legenda);
			
		// Retorna Legenda
		return "onMouseOver=\"legend('" . $legenda . "', 5,5); return true;\" onMouseOut=\"setVisibilidade(1); return true;\"";
		
	}
	
	/* Controle de ordem */
	function OrdemControl ($text, $url, $campo, $path=""){
		
		// Html
		return "<a href='" . $url . "&campo=" . $campo . "&ordem=" . (($_REQUEST["campo"] == $campo && $_REQUEST["ordem"] == "asc")?"desc":"asc") . "'>" . $text . "</a>&nbsp;" . (($_REQUEST["campo"] == $campo)?"<img src='" . $path . "imagens/diversos/" . $_REQUEST["ordem"] . ".png'>":"");
			
	}
	
	/* Ref Tópico */
	function refTopico(){
		
		// Verifica ref
		switch ($_REQUEST["ref"]){
			
			case "novo": return " [ Novo(a) ] "; break;
			case "edit": return " [ Edita ] "; break;
			case "alunos": return " [ Alunos ]"; break;
			case "estagio": return " [ Estágio ]"; break;
			case "prestadoreservicos": return " [ Prestadores de Serviços ]"; break;
			case "estagiotreinamento": return " [ Estágio de Treinamento ]"; break;
			case "freelancer": return " [ FreeLancer ]"; break;
			
			//case "": return ""; break;
			
		}
		
	}
	
	/* Verifica Campo */
	function verCampo ($id, $msg, $campo){
		
		// Monta HTML
		$html .= "<span id='" . $id . "'>" . $campo . "
				  	<span class=\"textfieldRequiredMsg\">" . $msg . "</span>
				  </span>
				  <script type=\"text/javascript\">var " . $id . " = new Spry.Widget.ValidationTextField(\"" . $id . "\", \"none\", {validateOn:[\"blur\"]});</script>";
		
		// Retorna HTML
		return $html;
		
	}
	
	// Abrevia Nome
	function abreviaNome1 ($nome){
		
		// Explode Nome
		$nomes = explode(" ", $nome);
		
		// Verifica Segundo nome
		switch (strtolower($nomes[1])){
			
			case "da": $segundoNome = $nomes[2]; break;
			case "do": $segundoNome = $nomes[2]; break;
			case "de": $segundoNome = $nomes[2]; break;
			
		}
		
		// Retorna Nome
		return ($nomes[0] . " " . $nomes[1] . " " . $segundoNome);
		
	}
	
	// Deixa letras
	function deixaL ($string){
		
		// String temp
		$stringTemp = "";
		
		// Verifica string
		for($i=0;$i<strlen($string);$i++){
			if(preg_match("/[A-z]/", $string{$i})){
				$stringTemp .= $string{$i};
			}elseif(preg_match("/[0-9]/", $string{$i})){
				$stringTemp .= $string{$i};
			}elseif(preg_match("/[ ]/", $string{$i})){
				$stringTemp .= $string{$i};
			}
		}
		
		// Retorna string
		return $stringTemp;
	}
	
	//deixa apenas números
	function deixaN ($valor){
		
		//valor temp
		$valorTemp = "";
		
		//Verifica valor
		for($i=0;$i<strlen($valor);$i++){
			if(preg_match("/[0-9]/", $valor{$i})){
				$valorTemp .= $valor{$i};
			}
		}
		
		//retorna valortemp
		return $valorTemp;
	}
	
	//deixa apenas números
	function deixaNN ($valor){
		//Desformatando valor
		$valor = limpaFormat($valor);
		
		//retira acentos
		$valor = acentos($valor);
		
		//valor temp
		$valorTemp = "";
		
		//Verifica valor
		for($i=0;$i<strlen($valor);$i++){
			if(preg_match("/[0-9]/", $valor{$i}) || $valor{$i} == "."){
				$valorTemp .= $valor{$i};
			}
		}
		
		//retorna valortemp
		return $valorTemp;
	}
	
	
	//completa com espaço em branco
	function completaEB ($string, $tot){
		//EB
		$eb = "";
		
		//String
		$string = $string;
		
		//Verifica quantidade de letras
		if(strlen($string) < $tot){
			//Diferença
			$diferenca = $tot - strlen($string);
			
			//preenche zero
			for($i=1;$i<=$diferenca;$i++){
				//Verifica
				if($i == $diferenca){
					$string .= $eb . " ";
				}else{
					$eb .= " ";
				}
			}
			
			//retorna
			return $string;
		}else{
			//retorna
			return $string;
		}
	}
	
	// Retornar i Temp
	function getITemp(){
	
		return $this->iTemp;
	
	}
	
	// Formata CPF
	function formataCPF ($cpf){
		
		// Verifica se foi informado algum CPF
		if($cpf != ""){
		
			// Limpa CPF
			$cpf = preg_replace("/[\.-]/", "", $cpf);
			
			return substr($cpf, 0, 3) . "." . substr($cpf, 3, 3) . "." . substr($cpf, 6, 3) . "-" . substr($cpf, 9, 2);
			
		}
		
	}
	
	// Formata CEP
	function formataCEP ($cep){
		
		// Verifica se foi informado algum CEP
		if($cep != ""){
		
			// Limpa CEP
			$cep = preg_replace("/[\.-]/", "", $cep);
			
			return substr($cep, 0, 5) . "-" . substr($cep, 5, 3);
			
		}
		
	}
	
	// Formata CNPJ
	function formataCNPJ ($cnpj){
		
		// Verifica se foi informado algum CNPJ
		if($cnpj != ""){
		
			// Limpa CNPJ
			$cnpj = preg_replace("/[\.-]/", "", $cnpj);
			
			return substr($cnpj, 0, 2) . "." . substr($cnpj, 2, 3) . "." . substr($cnpj, 5, 3) . "/" . substr($cnpj, 8, 4) . "-" . substr($cnpj, 12, 2);
			
		}
		
	}	
	
	//Retorna erro
	function getErro(){
		return $this->erro;
	}
}

//Cria objeto
$_ClassUtilitarios = new Utilitarios;
?>

