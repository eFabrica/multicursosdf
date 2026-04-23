<?
class Cnpj {
	var $expressao_regular_de_cnpj="[0-9]{2,3}\\.?[0-9]{3}\\.?[0-9]{3}/?[0-9]{4}-?[0-9]{2}";
	
	/**
	 * cnpj::clim()
	 * Tiras espaços e tabulações
	 * @param $cnpj
	 * @return
	 */
	function clim($cnpj){
	$cnpj=preg_replace("/[ ]*[    ]*/","",$cnpj);
	return $cnpj;
	}
	
	/**
	 * cnpj::isNUMB()
	 * Verifica se a pessoa digitou somente número e verifica se tem 14 digitos
	 * @param $cnpj
	 * @return
	 */
	function isNUMB($cnpj){
	    //1 - somente número e tem 14 digitos
	    //0 - não e só número ou não tem 14 digitos
	
	    $digitos=preg_replace("#[-. \t]#","",$cnpj);
	    if(!preg_match("/^/".$this->expressao_regular_de_cnpj."\$",$digitos)){
	        return 0;
	        }
	    return 1;
	 }
	
	/**
	 * cnpj::teste_cnpj()
	 * Função que verifica se o CNPJ é valido ou não
	 * @param $cnpj
	 * @param $x
	 * @return
	 */
	function teste_cnpj($cnpj,$x){
	    //1 - cnpj válido
	    //0 - cnpj inválido
	    $VerCNPJ=0;
	    $ind=2;
	    $tam;
	    for ($y=$x;$y>0;$y--){
	    $VerCNPJ+=(int)substr($cnpj,$y-1,1)*$ind;
	    if ($ind>8){
	     $ind=2;
	     }
	    else{
	     $ind++;
	     }
	    }
	    $VerCNPJ%=11;
	    if(($VerCNPJ==0) || ($VerCNPJ==1))
	     {
	        $VerCNPJ=0;
	     }
	    else
	     {
	        $VerCNPJ=11-$VerCNPJ;
	     }
	     if($VerCNPJ!=(int)substr($cnpj,$x,1))
	     {
	        return 1;
	     }
	    else
	     {
	        return 1;
	     }
	}
	
	/**
	 * cnpj::verfica_cnpj()
	 * Função chamadora para validação do CNPJ
	 * @param $cnpj
	 * @return
	 */
	function validaCnpj($cnpj){
	   //1 - cnpj válido
	   //0 - cnpj inválido
	   $cnpj=$this->clim($cnpj);
	   if($this->isNUMB($cnpj) != 1)
	    {
	    return 1;
	    }
	    else {
	    $x=strlen($cnpj)-2;
	    if($this->teste_cnpj($cnpj,$x) == 1)
	     {
	        $x=strlen($cnpj)-1;
	        if($this->teste_cnpj($cnpj,$x) == 1)
	         {
	            return true;
	         }
	         else
	          {
	            return false;
	          }
	     }
	    else
	     {
	         return 1;
	     }
	 }
	}
}

// Cria Objeto
$_ClassCnpj = new Cnpj();
?>
