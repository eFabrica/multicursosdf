<?php
/* Classe de Mensagens */

Class Mensagens {
	
	// Mensagem Sucesso
	protected $mensagem_sucesso = "";
	
	// Mensagem Erro
	protected $mensagem_erro = "";
	
	// Largura
	protected $largura = "80";
	
	/* Construtor */
	public function __construct(){
		
		
		
	}
	
	/* Caixa de Sucesso! */
	
		public function caixaSucesso (){
			
			return "<table border='0' cellpadding='0' cellspacing='0' width='" . $this->largura. "%'>
						<tr>
							<td align='left'><div id='border-top-s'><div><div></div></div></div></td>
						</tr>
						<tr>
							<td align='left'>
								<table border='0' cellpadding='2' cellspacing='2' width='100%' class='table_main_s'>
									<tr>
										<td align='center' width='5%'><img src='imagens/icones/sucesso.png'></td>
										<td width='95%'>" . $this->mensagem_sucesso. "</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td align='left'><div id='border-bottom-s'><div><div></div></div></div></td>
						</tr>
					</table>";
			
		}
		
	/* Caixa de Erro! */
	
		public function caixaErro (){
			
			return "<table border='0' cellpadding='0' cellspacing='0' width='" . $this->largura. "%'>
						<tr>
							<td align='left'><div id='border-top-e'><div><div></div></div></div></td>
						</tr>
						<tr>
							<td align='left'>
								<table border='0' cellpadding='2' cellspacing='2' width='100%' class='table_main_e'>
									<tr>
										<td align='center' width='5%'><img src='imagens/icones/erro.png'></td>
										<td width='95%'>" . $this->mensagem_erro. "</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td align='left'><div id='border-bottom-e'><div><div></div></div></div></td>
						</tr>
					</table>";
			
		}
		
	/* Exibir Mensagem */
	
		public function exibirMensagem (){
			
			// Verifica se tem mensagem de Sucesso
			if($this->mensagem_sucesso != "") print($this->caixaSucesso());
			
			// Verifica se tem mensagem de Erro
			if($this->mensagem_erro != "") print($this->caixaErro());
			
		}
	
	/* Settings */
	
		public function setMensagem_sucesso($mensagemSucesso){
			
			// Atribui
			$this->mensagem_sucesso .= $mensagemSucesso;
			
		}
		
		public function setMensagem_erro($mensagemErro){
			
			// Atribui
			$this->mensagem_erro .= $mensagemErro;
			
		}
		
		public function setLargura($largura){
			
			// Atribui
			$this->largura = $largura;
			
		}
		
	/* Getings */
	
		public function getMensagem_sucesso(){
			
			// Retorna Mensagem de Sucesso
			return trim($this->mensagem_sucesso);
			
		}
		
		public function getMensagem_erro(){
			
			// Retorna Mensagem de Erro
			return trim($this->mensagem_erro);
			
		}
		
		public function getLargura(){
			
			// Retorna
			return $this->largura;
			
		}
	
}

// Instancia o Objeto
$_ClassMensagens = new Mensagens();
?>

