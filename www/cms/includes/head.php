<title>SGE - Sistema de Gerenciamento Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<?php print($pathInc);?>

css/estilos.css" rel="stylesheet" type="text/css">
<link href="<?php print($pathInc);?>css/menu.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="<?php print($pathInc);?>js/mm_menu.js"></script>
<script language="javascript" type="text/javascript" src="<?php print($pathInc);?>js/menu.js"></script>
<script language="javascript" type="text/javascript" src="<?php print($pathInc);?>js/prototype.js"></script>
<script language="javascript" type="text/javascript" src="<?php print($pathInc);?>js/uteis.js"></script>
<script language="javascript" type="text/javascript" src="<?php print($pathInc);?>js/executores.js"></script>
<script language="javascript" type="text/javascript">
try{
    xmlhttp = new XMLHttpRequest();
}catch(ee){
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch(E){
            xmlhttp = false;
        }
    }
}

function foco(objid){
	obj = document.getElementById(objid);
	obj.focus();
}

// url_decode version 1.0 
function url_decode(str) { 
    var n, strCode, strDecode = ""; 

    for (n = 0; n < str.length; n++) { 
        if (str.charAt(n) == "%") { 
            strCode = str.charAt(n + 1) + str.charAt(n + 2); 
            strDecode += String.fromCharCode(parseInt(strCode, 16)); 
            n += 2; 
        } else { 
            strDecode += str.charAt(n); 
        } 
    } 
    return strDecode; 
} 


function carrega(ref){

    // Obejtos
    var main = document.getElementById("main");
	var loading = document.getElementById("loading");
	
	//Carregando
    loading.innerHTML="<img src='<?=$pathInc?>imagens/icones/load.gif'>";
	
    //Abre a url
    xmlhttp.open("GET", "<?=$pathInc?>includes/aplicacoes.php?ref="+ref,true);
	
	//evita amarzenamento em cache
	xmlhttp.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate"); 
    xmlhttp.setRequestHeader("Cache-Control", "post-check=0, pre-check=0"); 
    xmlhttp.setRequestHeader("Pragma", "no-cache");

    //Executada quando o navegador obtiver o código
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4){
			if (xmlhttp.status == 200) {
				//Lê o texto
				var texto=xmlhttp.responseText
				
				//Tira o carregando
				loading.style.display = "none";
				
				//Exibe o texto no div conteúdo
				main.innerHTML = url_decode(texto);
				
			}
        }
    }
    xmlhttp.send(null)
}

function carregasl(ref, mains){

    // Obejtos
    var main = document.getElementById("" + mains);
	
    //Abre a url
    xmlhttp.open("GET", "<?=$pathInc?>includes/aplicacoes.php?ref="+ref,true);
	
	//evita amarzenamento em cache
	xmlhttp.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate"); 
    xmlhttp.setRequestHeader("Cache-Control", "post-check=0, pre-check=0"); 
    xmlhttp.setRequestHeader("Pragma", "no-cache");

    //Executada quando o navegador obtiver o código
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4){
			if (xmlhttp.status == 200) {
				//Lê o texto
				var texto1=xmlhttp.responseText
				
				//Exibe o texto no div conteúdo
				main.innerHTML = url_decode(texto1);
				
			}
        }
    }
    xmlhttp.send(null)
}
</script>