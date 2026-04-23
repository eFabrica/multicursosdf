<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
/* Classe de Segurança */
class Protec {
	
	// Erro
	protected $erro = "";
	
	// Usuário
	protected $usuario = "";
	
	// Conexão
	protected $conexao = "";
	
	// Dados do Logado
	protected $dadosLogado;
	
	// Dados da Unidade
	protected $dadosUnidade;
	
	/* Contrutor */
	function __construct($dadosLogado, $dadosUnidade){
		
		// Seta Dados do Logado
		$this->setDadosLogado($dadosLogado);
		
		// Seta Dados da Unidade
		$this->setDadosUnidade($dadosUnidade);
		
		// Aciona Verificação de login
		$this->verificaLogin();
		
	}
	
	/* Verifica se está logado */
	public function verificaLogin(){
		 
		// Verifica Sessão
		if($_REQUEST["sessao"] != "arealogin" && $_REQUEST["sessao"] != ""){
			
			// Verifica se está logado
			if($this->dadosLogado->logado == "N" || $this->dadosLogado->logado == ""){
				
				// Seta Erro
				$this->setErro("É preciso efetuar o login.<br>", "arealogin");
				
				// Redireciona
				header("Location: index.php?sessao=arealogin");
				
				// Finaliza Script
				exit();
				
			}
		
			// Verifica se está suspenso
			if($this->dadosLogado->suspenso == "S"){
				
				// Desloga Usuário
				mysql_query("UPDATE `usuarios` SET logado = 'N' WHERE id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
				
				// Seta Erro
				$this->setErro("Usuário suspenso. Entre em contato com seu responsável.<br>", "arealogin");
				
				// Redireciona
				header("Location: ?sessao=arealogin");
				
				// Finaliza Script
				exit();
				
			}
			
			// Verifica se está deletado
			if($this->dadosLogado->deletado == "S"){
				
				// Desloga Usuário
				mysql_query("UPDATE `usuarios` SET logado = 'N' WHERE id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
				
				// Seta Erro
				$this->setErro("Usuário deletado. Entre em contato com seu responsável.<br>", "arealogin");
				
				// Redireciona
				header("Location: ?sessao=arealogin");
				
				// Finaliza Script
				exit();
				
			}
			
			// Verifica se a unidade está com acesso Bloqueado
			if($this->dadosLogado->logado == "S" && $this->dadosUnidade->acesso == "B"){
				
				// Desloga Usuário
				mysql_query("UPDATE `usuarios` SET logado = 'N' WHERE id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
				
				// Seta Erro
				$this->setErro("Sua unidade está com acesso bloqueado.", "arealogin");
				
				// Redireciona
				header("Location: ?sessao=arealogin");
				
				// Finaliza Script
				exit();
				
				
			}
		
		}
		
	}
	
	/* Settings */
		
		// Seta Dados da Unidade
		public function setDadosUnidade($dadosUnidade){
			
			// Atribui
			$this->dadosUnidade = $dadosUnidade;
			
		}
	
		// Seta Dados do Logado
		public function setDadosLogado($dadosLogado){
			
			// Atribui
			$this->dadosLogado = $dadosLogado;
			
		}
	
		// Seta Usuário
		public function setUsuario($usuario){
			
			// Atribui
			$this->usuario = $usuario;
			
		}
		
		// Seta Erro
		public function setErro($erro, $sessao){
			
			// Atribui
			$this->erro = $erro;			
			
			// Adiciona na Sessão
			$_SESSION["erros"][$sessao][] = $erro;
			
		}
		
	/* Getings */
		
		// Get Dados da Unidade
		public function getDadosUnidade(){
			
			// Retorna Dados da Unidade
			return $this->dadosUnidade;
			
		}
	
		// Get Dados do Logado
		public function getDadosLogado(){
			
			// Retorna Dados do Logado
			return $this->dadosLogado;
			
		}
	
		// Get Usuário
		public function getUsuario(){
			
			// Retorna Usuário
			return $this->usuario;
			
		}
		
		// Get Erro
		public function getErro(){
			
			// Retorna Erro
			return $this->erro;
			
		}
	
}

// Instancia Objeto
$_ClassProtec = new Protec($_dadosLogado, $_dadosUnidade);
?>

