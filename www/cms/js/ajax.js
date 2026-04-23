// JavaScript Document

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
    loading.innerHTML='<div align="center" style="color:#000033;">Carregando...</div>'
	loading.style.background = "#FFFFFF";
	loading.style.border = "1px none #000000";
	loading.style.display = "block";
	
    //Abre a url
    xmlhttp.open("GET", "includes/aplicacoes.php?"+ref,true);
	
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