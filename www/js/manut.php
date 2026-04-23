<!-- include-me.php -->
<?php require_once("php7_mysql_shim.php");
include("fckeditor.php") ;
//include("conexao.php") ;
?>

<?php
/*
	$cpf = $_REQUEST["cpf"];
	$senha = $_REQUEST["senha"];

	$Acesso = $_REQUEST["Acesso"];
	if ($Acesso != ""){
	
	*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Multicursos</title>
<link href="css_style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {
	font-family: arial;
	font-weight: bold;
}
.style3 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body bottommargin="0" leftmargin="0" topmargin="0" rightmargin="0">
	<table align="center" background="images/background_limpo.jpg" height="600" width="631" border="0" cellpadding="0" cellspacing="0" >
    	<tr>
        	<td valign="top"><p align="center"><span class="style2">&Aacute;rea de Manuten&ccedil;&atilde;o
            	</span><br />
				<br />
              <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial; font-size:x-small">
                    <tr>
                      <td><a href="manut.php?Acesso=true&pag=bomb">Brigadista</a></td>
                      <td><a href="manut.php?Acesso=true&pag=soc">Socorrista</a></td>
                      <td><a href="manut.php?Acesso=true&pag=out">Mais Cursos</a></td>
                    </tr>
                    <tr>
                      <td><a href="manut.php?Acesso=true&pag=img&Acesso=true">Galeria Imagem (incluir)</a></td>
                      <td><a href="manut.php?Acesso=true&pag=emp">Empresas &amp; Servi&ccedil;os</a></td>
                      <td><a href="manut.php?Acesso=true&pag=loc">Localiza&ccedil;&atilde;o</a></td>
                    </tr>
                    <tr>
                      <td><a href="manut.php?Acesso=true&pag=imgx&Acesso=true">Galeria Imagem (excluir)</a></td>
                      <td><a href="manut.php?Acesso=true&pag=quem">Quem Somos</a></td>
                      <td><a href="manut.php?Acesso=true&pag=cont">Contato</a></td>
                    </tr>
                    <tr>
                      <td><a href="manut.php?Acesso=true&pag=duv">D&uacute;vidas &amp; Sugest&otilde;es</a></td>
                      <td>
                      	<?php 
							echo "<a href='cms/areaLogin.php?act=logar&cpf=$cpf&senha=$senha' >SGE</a>";						
						?>

                    </td>
                      <td><span class="style3"><a href="home.php">Sair</a></span></td>
                    </tr>
              </table>   	
                <?php 
				
				
				if ($_REQUEST["pag"]=="imgx"){ 
					if ($_REQUEST["fotox"]!=""){
						$pastax = $_REQUEST["dirx"];
						$fotoxx = $_REQUEST["fotox"];
						$raizx = getcwd();
						$dirxx = "fotos/".$pastax."/".$fotoxx;
						$filedelete = $raizx."/fotos/".$pastax."/".$fotoxx;
						unlink($filedelete);
						//$queryx = "DELETE FROM `TAB_FOTO` WHERE NOMEFOTO = '$dirxx'";
						//echo $queryx."<BR>";
						//echo $filedelete;
						//$resultx = mysql_query($queryx);
						
					}
				
				
				?>
                	<br />
                	<table border="1" style="font-family:Arial; font-size:x-small" width="100%">
                    	
                    	<tr>
                    	  <td colspan="3" align="center"><strong>Clique na imagem para excluir</strong></td>
                   	  </tr>
                    	<tr>
                        	<td align="center">Brigada de Inc&ecirc;ndio</td>
                            <td align="center">Cursos de Forma&ccedil;&atilde;o</td>
                            <td align="center">Socorrista</td>
                        </tr>
                        <tr>
                        	<td>
                            	<?php
								
								$diretorioB = getcwd();
								$diretorioB = $diretorioB."/fotos/Brigada/";
								$ponteiroB  = opendir($diretorioB);
								while ($nome_itensB = readdir($ponteiroB)) {
									$itensB[] = $nome_itensB;
								}
								sort($itensB);
								foreach ($itensB as $listarB) {
								  if ($listarB!="." && $listarB!=".."){ 
										if (is_dir($listarB)) { 
											$pastasB[]=$listarB; 
										} else{ 
											$arquivosB[]=$listarB;
										}
								  }
								}
								if ($arquivosB != "") {
									foreach($arquivosB as $listarB){
									$diretorioBB = "Brigada";
									print " Arquivo: <a href='manut.php?Acesso=true&pag=imgx&dirx=$diretorioBB&fotox=$listarB'>$listarB</a><br>";}
								   }
								   
								?>
                            </td>
                            <td>
                            	<?php
								$diretorioC = getcwd();
								$diretorioC = $diretorioC."/fotos/Cursos/";
								$ponteiroC  = opendir($diretorioC);
								while ($nome_itensC = readdir($ponteiroC)) {
									$itensC[] = $nome_itensC;
								}
								sort($itensC);
								foreach ($itensC as $listarC) {
								  if ($listarC!="." && $listarC!=".."){ 
										if (is_dir($listarC)) { 
											$pastasC[]=$listarC; 
										} else{ 
											$arquivosC[]=$listarC;
										}
								  }
								}
								if ($arquivosC != "") {
									foreach($arquivosC as $listarC){
									$diretorioCC = "Cursos";
									print " Arquivo: <a href='manut.php?Acesso=true&pag=imgx&dirx=$diretorioCC&fotox=$listarC'>$listarC</a><br>";}
								   }
								?>
                            </td>
                            <td>
                            	<?php
								$diretorioS = getcwd();
								$diretorioS = $diretorioS."/fotos/Socorrista/";
								$ponteiroS  = opendir($diretorioS);
								while ($nome_itensS = readdir($ponteiroS)) {
									$itensS[] = $nome_itensS;
								}
								sort($itensS);
								foreach ($itensS as $listarS) {
								  if ($listarS!="." && $listarS!=".."){ 
										if (is_dir($listarS)) { 
											$pastas[]=$listar; 
										} else{ 
											$arquivosS[]=$listarS;
										}
								  }
								}
								if ($arquivosS != "") {
									foreach($arquivosS as $listarS){
									$diretorioSS = "Socorrista";
									print " Arquivo: <a href='manut.php?Acesso=true&pag=imgx&dirx=$diretorioSS&fotox=$listarS'>$listarS</a><br>";}
								   }
								?>
                            </td>
                        </tr>                    
                    </table>
                
                
                <?php  } ?>
                
                
           	  <?php  if ($_REQUEST["pag"]=="img"){ 
				
						//se existir o arquivo
						if(isset($_FILES["arquivo"])){
					
							$arquivo = $_FILES["arquivo"];
							$legenda = $_REQUEST["legenda"];	
							$pasta_dir = "fotos/".$_REQUEST["Pasta"]."/";				
						
							$arquivo_nome = $pasta_dir . $arquivo["name"];
						
							// Faz o upload da imagem
							move_uploaded_file($arquivo["tmp_name"], $arquivo_nome);
						
							//aqui salva no banco o path da foto
							//mysql_query("INSERT INTO `TAB_FOTO` (ID, NOMEFOTO, LEGENDA) VALUES ('', '$arquivo_nome', '$legenda' )");
							echo "<script>alert('Foto gravada com sucesso.');</script>";
						}
				
				
				?>
                
			  <form action="manut.php" method="post" enctype = "multipart/form-data">					
                  <table style="font-family:Arial; font-size:x-small" width="100%">
                            <tr>
                              <td align="center" valign="middle">
                                <input type="radio" name="Pasta" value="Brigada" />Brigada de Inc&ecirc;ndio &nbsp;
                                <input type="radio" name="Pasta" value="Cursos" />
                                Cursos de Forma&ccedil;&atilde;o&nbsp;
                                <input type="radio" name="Pasta" value="Socorrista" />
                                Socorrista
                              </td>
                            </tr>
                  </table>
                        
                  <table width="100%">
                      <tr>
                          <td align="right">Legenda:</td>
                          <td align="left"><input type="text" name="legenda" width="350" /></td>
                    </tr>
                      <tr>
                          <td width="30%" align="right">Foto:</td>
                      <td width="70%" align="left">
                                <input type="file" name="arquivo" />
                                <input type="hidden" name="Acesso" value="true" />
                                <input type="hidden" name="pag" value="img" />                          </td>
                    </tr>
                      <tr>
                          <td colspan="2" align="center"><input type="submit" value="Salvar Foto" /></td>
                      </tr>
                  </table>
			  </form>	    
				<?php } ?>    
                
                <?php 
					if(isset($_REQUEST["pag"])){
						if (($_REQUEST["pag"]!="img") && ($_REQUEST["pag"]!="imgx")){
						
							$pag1 = $_REQUEST["pag"];
							$tabela = strtoupper("TAB_".$_REQUEST["pag"]);
							
							if ($_REQUEST["texto"]=="in"){
								$editor = $_REQUEST["FCKeditor1"];
//								echo $editor;
								//$query2 = "UPDATE `$tabela` SET TEXTO = '$editor' WHERE ID = 1";
								//$result2 = mysql_query($query2);
							}
														
							//$query = "SELECT TEXTO FROM `$tabela`";
							//$result = mysql_query($query);
																	
							echo "<form action='manut.php?Acesso=true&pag=$pag1&texto=in' method='post'>";
							echo "<p align='center'>"; 
							$oFCKeditor = new FCKeditor('FCKeditor1') ;
							$oFCKeditor->BasePath	= '' ;
							$oFCKeditor->Value		= mysql_result($result, 0, "TEXTO");
							$oFCKeditor->Width		= '600' ;
							$oFCKeditor->Height		= '400' ;
							$oFCKeditor->Create() ;
							echo "<input type='submit' value='Gravar'>";
							echo "</p>";
							echo "</form>";
								
						}
					}
			?>                                                 
                
                                
       	  </td>
        </tr>
        <tr>
        	<td background="images/rodape2.jpg" height="41">
            	
            </td>
        </tr>
    </table>
</body>
</html>
<?php // } ?>