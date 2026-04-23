<html>
<head>
<title>Multicursos - Forma&ccedil;&atilde;o Profissional</title>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-W7LSCNH');</script>
<!-- End Google Tag Manager -->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<link href="style.css" rel="stylesheet" type="text/css" /> 

<script src="js/jquery.js" type="text/javascript"></script> 
<script src="js/easySlider.js" type="text/javascript"></script> 
<script src="js/util.js" type="text/javascript"></script> 

</head>
<body bgcolor="#666666" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W7LSCNH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

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

			<?php include("menu.php"); ?>
           
	  </td>
	</tr>
	<tr>
		<td colspan="4" valign="top">
		
       	  <table width="985px" align="center">
            	<tr>
                	<td style="font-family:Verdana, Geneva, sans-serif">
						<br>
						<h2><font color="#FF0000">Dicas de Segurança</font></h2>
                        <br>
                        Saber o que fazer e o como fazer em situações de emergência é importante para garantir a segurança das pessoas. Mas, o mais importante é saber como evitar que os acidentes aconteçam.<br><br>
                        Veja algumas orientações da Multicursos e do Corpo de Bombeiros:
                        <br>
                      <ul>
                        <li><a class="linkQuemSomos" href="dicas.php?p=e">Choque elétrico</a><br></li>
                        <li><a class="linkQuemSomos" href="dicas.php?p=c">Crianças</a><br></li>
                        <li><a class="linkQuemSomos" href="dicas.php?p=d">Envenenamento doméstico</a><br></li>
                        <li><a class="linkQuemSomos" href="dicas.php?p=f">Incêndio florestal</a><br></li>
                        <li><a class="linkQuemSomos" href="dicas.php?p=r">Incêndio residêncial</a><br></li>
                        <li><a class="linkQuemSomos" href="dicas.php?p=l">Queima de lixo urbano ou resíduos</a><br></li>
                        <li><a class="linkQuemSomos" href="dicas.php?p=t">Temporada de praia</a><br></li>
                      </ul>
                      
                      <br>
                      
                      <?php
					 
								if(isset($_REQUEST["p"])){
									
								switch ($_REQUEST["p"]){
									case "e":
										include("dicase.php");
										break;
									case "c":
										include("dicasc.php");
										break;
									case "d":
										include("dicasd.php");
										break;
									case "f":
										include("dicasf.php");
										break;
									case "r":
										include("dicasr.php");
										break;
									case "l":
										include("dicasl.php");
										break;
									case "t":
										include("dicast.php");
										break;
								
									}
								}
					  ?>

						<br><br>
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