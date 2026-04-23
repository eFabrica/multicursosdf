<?php require_once("php7_mysql_shim.php");
/*
 * Classe de funções mysql.
 */
 
class Mysql{
	var $erro;
	var $host="localhost";
	var $user="root";
	var $senha="";
	var $banco="contelbcombr";
	
	/*Construtor*/
	function Mysql(){
		
	}
	
	/*Set o host*/
	function setHost ($host){
		$this->host = $host;
	}
	
	/*Seta o usuário*/
	function setUser ($user){
		$this->user = $user;
	}
	
	/*Seta a senha*/
	function setSenha ($senha){
		$this->senha = $senha;
	}
	
	/*Seta o banco de dados*/
	function setBanco ($banco){
		$this->banco = $banco;
	}
	
	/* Retorna banco de dados */
	function getBanco(){return $this->banco;}

	/*Função que efetua a conexão com o banco de dados*/
	function conecta(){
		$con = mysql_connect($this->host, $this->user, $this->senha) or die ($this->erro = mysql_error());
		mysql_select_db ($this->banco, $con) or die($this->erro .= mysql_error());
		return $con;
	}
	
	/* Função que executa query */
	function query($query){
		
		$exc = @mysql_query($query) or die (mysql_error());
		
		return $exc;
		
	}
	
	//Retorna erro
	function getErro(){
		return $this->erro;
	}
}

//Cria objeto
$_ClassMysql = new Mysql;
?>

