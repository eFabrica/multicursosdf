<html>
<head>
<title>Multicursos - Forma&ccedil;&atilde;o Profissional</title>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">

<link href="style.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />	

<script src="js/jquery.js" type="text/javascript"></script> 
<script src="js/easySlider.js" type="text/javascript"></script> 
<script src="js/util.js" type="text/javascript"></script> 

<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js?load=effects" type="text/javascript"></script>
<script src="js/lightbox.js" type="text/javascript"></script>

</head>
<body bgcolor="#666666" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div class="main">
<table align="center" id="Table_01" width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="ececec">
	<tr>
		<td colspan="4" valign="top" height="321px">
        	<div class="logo"></div>
            <div class="texto"></div>	
        
               
            <div id="container">
                <div id="content">
                    <div id="slider" >
                        <ul>
                        <li ><img border="0" src='img/imgemMenu3.jpg' alt='Imagem 01' /></li>
                        <li  class = 'hide_slide'><img border="0" src='img/imgemMenu1.jpg' alt='Imagem 02' /></li>
                        <li  class = 'hide_slide'><img border="0" src='img/imgemMenu2.jpg' alt='Imagem 03' /></li>
                        </ul>
                  </div>
              </div>
          </div>

			<?php 
			
				include("menu.php"); 
			
				$cpf = $_REQUEST["cpf"];
				$senha = $_REQUEST["senha"];
				
				
			
			?>
            
	  </td>
	</tr>
	<tr>
		<td colspan="4" valign="top">
		
       	  <table width="985px" align="center" border="0">
            	<tr>
                	<td style="font-family:Verdana, Geneva, sans-serif" align="center">
						
                        <br>
                        	<h3>Área do Administrador</h3>
                        <br>
                        
                        <table width="70%" bgcolor="#FFFFFF" align="center">
                        	<tr align="center">
                            	<td>
                                	<a href="manutagenda.php">
	                                	<img src="img/agenda.png" border=0>                                
                                    </a>
                                </td>
                                <td>
                                	<?php 
										print "<a href='http://www.multicursosdf.com.br/cms/areaLogin.php?act=logar&cpf=$cpf&senha=$senha'><img src='img/sge.png' border='0'></a>";									
									?>                                	
                                </td>
                            </tr>
                        </table>
                        
                        <br>
                        


                    </td>
                </tr>
            </table>
    	
    </tr>
    <tr>
    	<td colspan="4">
   	    	<img src="img/rodape.png" width="1000" height="31"></td>
    </tr>    
</table>
</div>
</body>
</html>