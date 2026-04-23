<?
/*
 * Classe que manipula imagens gerando keys.
 */


//Classe para criar imagem key
class geraKey{

	//Declarando variáveis
	var $erro = "";
	var $imagemDeFundo;
	var $imagemDeFundoTemp;
	var $textoKey;
	var $corDoTextoKey;
	var $fontDoTextoKey;
	var $sizeDoTextoKey = "media";
	
	//Seta imagem de fundo
	function setaImagemDeFundo($imagemDeFundoTemp){
		
		// Atribui
		$this->imagemDeFundoTemp = $imagemDeFundoTemp;
		
		//Verifica se a imagem existe
		if(!file_exists($this->imagemDeFundoTemp)){
			//Seta erro
			$this->erro .= "Imagem não existe.<br>";
		}else{
			//Seta imagem
			switch(substr($this->imagemDeFundoTemp, -3)){
				case "jpg": case "jpeg": $this->imagemDeFundo = imagecreatefromjpeg($this->imagemDeFundoTemp); break;
				case "gif": $this->imagemDeFundo = imagecreatefromgif($this->imagemDeFundoTemp); break;
				case "png": $this->imagemDeFundo = imagecreatefrompng($this->imagemDeFundoTemp); break;
			}
		}
	}
	
	//Seta texto key
	function setaTextoKey($textoKey){$this->textoKey = $textoKey;}
	
	//Seta cor do texto key
	function setaCorDoTextoKey($corDoTextoKey){
		//separa cor
		$corDoTextoKeyTemp = explode("-", $corDoTextoKey);
		
		//Atribui cor
		$this->corDoTextoKey = imagecolorallocate($this->imagemDeFundo, $corDoTextoKeyTemp[0], $corDoTextoKeyTemp[1], $corDoTextoKeyTemp[2]);
	}
	
	//Seta fonte do texto key
	function setaFonteDoTextoKey($fonteDoTextoKey){
		//Verifica se a fonte existe
		$this->fonteDoTextoKey = $fonteDoTextoKey ;
	}
	
	//Seta size do texto key
	function setaSizeDoTextoKey($sizeDoTextoKey){$this->sizeDoTextoKey = $sizeDoTextoKey;}
	
	//Gerando key
	function gerarKey(){
		//Verifica se tem erro
		if(empty($this->erro)){
			//Distância horizontal
			$x = 20;
			
			//Distância vertical
			$y = 50;
			
			//Gera
			for($i=0;$i<strlen($this->textoKey);$i++){
				//Incrementa distãncia horizontal
				($i > 0) ? $x += 25 : "" ;
				
				//Size do texto key
				switch($this->sizeDoTextoKey){
					case "pequena": $size = rand(7,14); break;
					case "media": $size = rand(15, 25); break;
					case "grande": $size = rand(31, 62); break;
				}
				
				//Organizando imagem
				imagettftext($this->imagemDeFundo, $size, rand(1, 10), $x, $y, $this->corDoTextoKey, $this->fonteDoTextoKey, $this->textoKey);
				
				//Cria imagem
				switch(substr($this->imagemDeFundoTemp, -3)){
					case "jpg": case "jpeg": 
						//Envia imagem
						header("content-type: image/jpeg");
						imagejpeg($this->imagemDeFundo);
					break;
					case "gif": 
						//Envia imagem
						header("content-type: image/gif");
						imagegif($this->imagemDeFundo);
				 	break;
					case "png": 
						//Envia imagem
						header("content-type: image/png");
						imagepng($this->imagemDeFundo);
					break;
				}
			}
		}
	}
	function getErro(){
		print($this->erro);
	}
}

//Cria Obejto
$_ClassGeraKey = new geraKey;
?>

