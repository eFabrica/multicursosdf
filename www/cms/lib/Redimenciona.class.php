<?
//Classe para redimencionar a img
class RedimencionaImagem{

	//Declarando as variaveis
	var $img;
	var $erro;
	var $ext;
	var $imgTemp;
	var $novaAltura;
	var $novaLargura;
	var $path;
	
	//Redimenciona
	function Redimenciona($img, $novaLargura=0, $novaAltura=0){
	
		//Atribui os dados
		$this->img = $img;
		$this->novaLargura = $novaLargura;
		$this->novaAltura = $novaAltura;
		$this->path = $img;
		
		//Verifica se a img existe
		if(file_exists($this->img) == false){
		
			//Erro
			$this->erro .= "Imagem inexistente<br>";
			
		}
		
		//Verifica a extenção da img
		$this->ext = strtolower(substr($this->img, -4));
		$this->ext = str_replace("jpeg", "jpg", $this->ext);
		
		//Caso tiver redimencionamento e os dados estiverem em branco
		if($this->novaAltura == "" || $this->novaLargura == ""){
		
			//Erro
			$this->erro .= "Dados de redimencionamento inválidos.<br>";
			
		}
		
		//Caso não tenha erro passa para a próxima parte
		if($this->erro == ""){
		
			//Coloca a imagem como plano de fundo
			if($this->ext == ".gif"){$this->img = imagecreatefromgif("$this->img");}
			
			if($this->ext == ".jpg"){$this->img = imagecreatefromjpeg("$this->img");}
			
			if($this->ext == ".png"){$this->img = imagecreatefrompng("$this->img");}
			
			//Dados da img
			$largura = imagesx($this->img);
			$altura = imagesy($this->img);
			
			//Imagem temp
			$this->imgTemp = imagecreatetruecolor($novaLargura, $novaAltura);
			
			//Redimenciona a imagem
			imagecopyresized($this->imgTemp, $this->img, 0, 0, 0, 0, $novaLargura, $novaAltura, $largura, $altura);
			imagedestroy($this->img);
			
			//Atribui a img temp para a img
			$this->img = $this->imgTemp;
		
			//Cria a img
			ImageJPEG($this->img,$this->path,100);
		
		}
		
	}
	
	//Função de erro
	function getErro(){
	
		//Retorna o error
		return $this->erro;
		
	}
	
}

//Cria objeto
$_ClassRedimenciona = new RedimencionaImagem;
?>

