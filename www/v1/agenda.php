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
<script>

</script>


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
        
			<?php include("banner.php"); ?>
		<?php include("menu.php"); ?>
            
	  </td>
	</tr>
	<tr>
		<td colspan="4" valign="top">
		
       	  <table width="985px" align="center">
            	<tr>
					<td style="font-family:Verdana, Geneva, sans-serif">
                    	<br>
                        <p align="center"><strong>Veja a agenda de todos os cursos</strong></p>
                        <br>                       
                        
                          <strong>Cursos:</strong><br>
                          <ul>
                            <li><a class="linkQuemSomos" href="agenda.php?p=b">Brigadista (bombeiro)</a><br></li>
                            <li><a class="linkQuemSomos" href="agenda.php?p=c">Capacitação continuada (reciclagem de brigadistas)</a><br></li>
                            <li><a class="linkQuemSomos" href="agenda.php?p=s">Socorrista</a><br></li>
                            <li><a class="linkQuemSomos" href="agenda.php?p=d">D.E.A (Utilização do desfibrilador externo automático)</a><br></li>
                            <li><a class="linkQuemSomos" href="agenda.php?p=v">Formação de Brigadista voluntário</a><br></li>
                            <li><a class="linkQuemSomos" href="agenda.php?p=p">Primeiros socorros (básico)</a><br></li>
                            <li><a class="linkQuemSomos" href="agenda.php?p=a">Salvamento aquático (Salva-vidas)</a><br></li>
                            <li><a class="linkQuemSomos" href="agenda.php?p=5">NR – 05: CIPA Comissão interna de prevenção de acidentes</a><br></li>
                            <li><a class="linkQuemSomos" href="agenda.php?p=6">NR -  06: Equipamentos de Proteção Individual – EPI</a><br></li>
                            <li><a class="linkQuemSomos" href="agenda.php?p=10">NR – 10: Segurança em instalações e serviços em eletricidade (básico)</a><br></li>
                          </ul>
                          
                          
                       	<?php
							if(isset($_REQUEST["p"])){
								
							switch ($_REQUEST["p"]){
								case "b":
									include("brigadista_agenda.php");
									break;
								case "c":
									include("capacitacao_agenda.php");
									break;
								case "s":
									include("socorrista_agenda.php");
									break;
								case "d":
									include("dea_agenda.php");
									break;
								case "v":
									include("voluntario_agenda.php");
									break;
								case "p":
									include("socorros_agenda.php");
									break;
								case "a":
									include("aquatico_agenda.php");
									break;
								case "5":
									include("cipa_agenda.php");
									break;	
								case "6":
									include("protecao_agenda.php");
									break;
								case "10":
									include("eletricidade_agenda.php");
									break;	
								}
							}
						
						?>
                          

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