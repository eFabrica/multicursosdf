<?
/*
 * Classe de funções de cpf.
 */
 
class CPF{
	var $erro;
	
	/*Construtor*/
	function CPF(){
				
	}
	
	//Valida cpf
	function validaCPF($cpf) { 
		//Válido
		$valido = true;
		
		//Retira os pontos e hífens
		$cpf = preg_replace("/[\.-]/", "", $cpf); 
		
		//Verifica se o cpf contém apenas um tipo de número
		for($i = 0; $i <= 9; $i++)  { 
			if($cpf ==  str_repeat($i , 11)) { 
				$valido = false; 
			} 
		} 
		 
		//Tira algumas porssibilidades de invalidez
		if($invalido == 1 or strlen($cpf) != 11 or !is_numeric($cpf) or $cpf == "12345678909") {$valido = false;} 
		 
		//Calcula o cpf
		$res  = $this->soma(10, $cpf); 
		$dig1 = $this->pegaDigito($res); 
		$res2 = $this->soma(11, $cpf.$dig1); 
		$dig2 = $this->pegaDigito($res2); 
	
		if($cpf{9} != $dig1 or $cpf{10} != $dig2) { $valido = false;} 
		
		//retorna a validez
		return $valido;
	} 
	
	//Calcula soma do cpf
	function soma($num, $cpf) { 
		$j = 0; 
		$res = ""; 
		for($i = $num; $i >= 2; $i--){ $res += ($i * $cpf{$j}); $j++;} 
		return $res; 
	} 
	
	//Pega digito do dpf
	function pegaDigito($res) { 
		$dig = $res % 11; 
		$dig = $dig < 2 ? $dig = 0 : $dig = 11 - $dig; 
		return $dig; 
	}  
		
	//Retorna erro
	function getErro(){
		return $this->erro;
	}
}

//Cria objeto
$_ClassCpf = new CPF;
?>

