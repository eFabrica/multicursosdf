<?php
/* Classe que valida as permissões */
Class Permissao {
	
	protected $rn;
	protected $utilitarios;
	
	// Construtor
	public function __construct(){
		
		$this->rn = new Rn();
		$this->utilitarios = new Utilitarios();
		
	}
	
	// Verifica Permissão
	public function validaPermissao ($permitido){
		
		// Dados do Logado
		$dadosLogado = $this->rn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
		
		// Verifica se é master
		if($dadosLogado->nivel != "100"){
			
			// Verifica contidade da permissão
			if(count($permitido) > 0){
				
				// Sucesso
				$sucesso = false;
				
				// lê permissões
				for($i = 0; $i < count($permitido); $i++){
					
					// Compara nível atual com os permitidos
					if($dadosLogado->nivel == $permitido[$i]){$sucesso = true;}
					
				}
				
				// Verifica sucesso
				if(!$sucesso){
					
					// Redireicona para página de sem permissão
					print($this->utilitarios->redirecionarJS("?sessao=inicial&sempermissao=true&" . $dadosLogado->nivel . "|" . $permitido[$i]));
					
					
					// Finaliza Script
					exit();
					
				}
				
			}else{
				
				// Redireicona para página de sem permissão
				print($this->utilitarios->redirecionarJS("?sessao=inicial&sempermissao=true"));
				
				// Finaliza Script
				exit();
				
			}
			
		}
		
	}
	
	// Verifica Permissão
	public function validaPermissaoSee ($conteudo, $permitido, $nm=false){
		
		// Dados do Logado
		$dadosLogado = $this->rn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
		
		// Verifica se é master
		if($dadosLogado->nivel != "100"){
			
			// Verifica contidade da permissão
			if(count($permitido) > 0){
				
				// Sucesso
				$sucesso = false;
				
				// lê permissões
				for($i = 0; $i < count($permitido); $i++){
					
					// Compara nível atual com os permitidos
					if($dadosLogado->nivel == $permitido[$i]){$sucesso = true;}
					
				}
				
				// Verifica sucesso
				if($sucesso){
					
					// Retorna conteúdo
					return $conteudo;
					
				}
				
			}
			
		}else{
			
			// Verifica não master
			if(!$nm){
			
				// Retorna conteúdo
				return $conteudo;
			
			}
			
		}
		
	}
	
	// Verifica Permissão
	public function validaPermissaoSeeReturn ($permitido, $nm=false){
		
		// Dados do Logado
		$dadosLogado = $this->rn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
		
		// Verifica se é master
		if($dadosLogado->nivel != "100"){
			
			// Verifica contidade da permissão
			if(count($permitido) > 0){
				
				// Sucesso
				$sucesso = false;
				
				// lê permissões
				for($i = 0; $i < count($permitido); $i++){
					
					// Compara nível atual com os permitidos
					if($dadosLogado->nivel == $permitido[$i]){$sucesso = true;}
					
				}
				
				// Retorna Sucesso
				return $sucesso;
				
			}
			
		}else{
			
			// Verifica não master
			if(!$nm){
			
				// Retorna
				return true;
			
			}
			
		}
		
	}
	
}

// Instancia Classe
$_ClassPermissao = new Permissao;
?>
