<?
/*
 * Classe de arquivos.
 */
 
class Files{

	var $erro;
	
	/*Construtor*/
	function Files(){
		
		
	}
	
	// Pega Extensão
	function getExt($string){
		
		// Separa a string pelos pontos
		$separ = explode(".", $string);
		
		// Retorna o último registro da separação
		return "." . $separ[count($separ)-1];
		
	}
	
	// Escreve em arquivo
	function writeFile($path, $nome, $conteudo){
			
		// Abrindo o Arquivo
		$abrePath = fopen($path.$nome, "w+");
		
		// Escrevendo no Arquivo
		$escreveArquivo = fwrite($abrePath, $conteudo);
	
	}
	
	// UpLoad de arquivos
	function UpLoad($campo, $tipos,  $tamanho, $diretorio, $nome=0){
		//Tamanho
		$tamanho = (1024*$tamanho);
		
		//Enviado
		$enviado = false;
	
		//Verifica se o campo foi preenchido
		if(empty($campo)){$this->erro .= "Campo precisa ser preenchido.<br>";}else{
		
			//Permissão
			$permissao = false;
			
			//Verifica tipo
			if($tipos[0] != "*"){
			
				//Verifica se o tipo confere
				for($i=0;$i<count($tipos);$i++){
				
					//Verificando permissão
					$permissao = ($_FILES[$campo]["type"] == $tipos[$i]) ? true : $permissao ;
					
				}
				
			}else{
			
				//Permissão
				$permissao = true;
			
			}
			
			//Verifica permissão
			if(!$permissao){$this->erro .= "Tipo do arquivo está incorreto.<br>";}else{
				
				//Verifica se o tamanho confere
				if($_FILES[$campo]["size"] > $tamanho){$this->erro .= "Tamanho do arquivo precisa diminuir em: " . (($_FILES[$campo]["size"] - $tamanho)*1024) . " Kb. <br>";}else{
					
					//Verifica erro
					if($_FILES[$campo]["error"] === 0){
						
						//Faz o upload
						move_uploaded_file($_FILES[$campo]["tmp_name"], ((substr($diretorio, -1) == "/") ? $diretorio : $diretorio . "/") . (($nome) ? $nome . substr($_FILES[$campo]["name"], -4) : $_FILES[$campo]["name"] ));
						
						//Mensagem de sucesso
						$this->erro .= "Upload efetuado com sucesso!<br>";
						
						//Enviado
						$enviado = true;
						
					}else{
					
						//Verifica outros erros
						switch($_FILES[$campo]["error"]){
						
							case 1: $this->erro .= "O arquivo no upload é maior do que o limite definido em upload_max_filesize no php.ini.<br>"; break;
							
							case 2: $this->erro .= "O arquivo ultrapassa o limite de tamanho em MAX_FILE_SIZE que foi especificado no formulário HTML.<br>"; break;
							
							case 3: $this->erro .= "O upload do arquivo foi feito parcialmente.<br>"; break;
							
							case 4: $this->erro .= "Não foi feito o upload do arquivo.<br>"; break;
							
						}
						
					}
					
				}
				
			}
			
		}
		
		//Retorna
		return $enviado;
		
	}
	
	//Retorna erro
	function getErro(){
	
		return $this->erro;
		
	}
	
}

// Cria objeto
$_ClassFiles = new Files;
?>

