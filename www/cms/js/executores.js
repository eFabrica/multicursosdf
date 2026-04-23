// AJAX
var reqAjax = Array(5);

// Dados do CPF
function dadosCPF (cpf){	
	
	// Requesição AJAX
	reqAjax[0] = AJAX();
	
	//Abre a url
    reqAjax[0].open("GET", "includes/aplicacoes.php?ref=consultaCPF&cpf="+cpf,true);
	
	//evita amarzenamento em cache
	reqAjax[0].setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate"); 
    reqAjax[0].setRequestHeader("Cache-Control", "post-check=0, pre-check=0"); 
    reqAjax[0].setRequestHeader("Pragma", "no-cache");

    //Executada quando o navegador obtiver o código
    reqAjax[0].onreadystatechange=function() {
        if (reqAjax[0].readyState==4){
			if (reqAjax[0].status == 200) {
				
				// Lê o texto
				var texto = reqAjax[0].responseText;
				texto = url_decode(texto);
				textoSeparado = texto.split("|$$|");
				
				// Objetos
				nome = document.formCobranca.nome;
				endereco = document.formCobranca.endereco;
				telefone = document.formCobranca.telefone;
				
				// Exibe Conteúdo
				if (textoSeparado[0] != "" && nome.value == "") 	nome.value = textoSeparado[0];
				if (textoSeparado[1] != "" && endereco.value == "") endereco.value = textoSeparado[1];
				if (textoSeparado[2] != "" && telefone.value == "") telefone.value = textoSeparado[2];
				
			}
			
        }
        
    }
    
    reqAjax[0].send(null);
	
}

// Consulta
function consulta (ref, div, load, pc, table, extra, path){
	
	// Obejtos
    var main = document.getElementById("" + div);
	var loading = document.getElementById("" + load);
	var tabela = document.getElementById("" + table);
	
	// Tira o Conteúdo
	main.style.display = "none";
	
	// Exibe Conteúdo
	loading.style.display = "block";
	
	// Carregando
    loading.innerHTML="<img src='"+path+"imagens/icones/load.gif'>";
	
	// Requesição AJAX
	reqAjax[1] = AJAX();
	
	// Abre a url
    reqAjax[1].open("GET", path+"includes/aplicacoes.php?ref="+ref+"&pc="+pc+"&"+extra,true);
	
	// Evita amarzenamento em cache
	reqAjax[1].setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate"); 
    reqAjax[1].setRequestHeader("Cache-Control", "post-check=0, pre-check=0"); 
    reqAjax[1].setRequestHeader("Pragma", "no-cache");

    // Executada quando o navegador obtiver o código
    reqAjax[1].onreadystatechange=function() {
        if (reqAjax[1].readyState==4){
			if (reqAjax[1].status == 200) {
				
				// Lê o texto
				var texto = reqAjax[1].responseText;
				
				// Tira o Loading
				loading.style.display = "none";
				
				// Exibe Conteúdo
				main.style.display = "block";
    			main.innerHTML = url_decode(texto);
				
			}
			
        }
        
    }
    
    reqAjax[1].send(null);
	
}

// Seleciona Aba
function selecionaAba (aba){
	
	// Todas as Abas
	if(document.getElementById('inicio')) 				var inicio 			= document.getElementById('inicio');
	if(document.getElementById('gerenciamentos')) 		var gerenciamentos 	= document.getElementById('gerenciamentos');
	if(document.getElementById('financeiro')) 			var financeiro 		= document.getElementById('financeiro');
	if(document.getElementById('manutencao')) 			var manutencao		= document.getElementById('manutencao');
	if(document.getElementById('relatorios'))			var relatorios 		= document.getElementById('relatorios');
	if(document.getElementById('site')) 				var site 			= document.getElementById('site');
	if(document.getElementById(aba)) 					var selecionada		= document.getElementById(aba);
	
	// Tira o Selecionamento das outras abas
	if(document.getElementById('inicio')) 				inicio.className = '';
	if(document.getElementById('gerenciamentos')) 		gerenciamentos.className = '';
	if(document.getElementById('financeiro')) 			financeiro.className = '';
	if(document.getElementById('manutencao')) 			manutencao.className = '';
	if(document.getElementById('relatorios')) 			relatorios.className = '';
	if(document.getElementById('site')) 				site.className = '';
	
	// Seleciona a Atual
	selecionada.className = 'current';
	
	// Todas os Conteúdos
	if(document.getElementById('menu_inicio')) 			var inicio 			= document.getElementById('menu_inicio');
	if(document.getElementById('menu_gerenciamentos')) 	var gerenciamentos 	= document.getElementById('menu_gerenciamentos');
	if(document.getElementById('menu_financeiro')) 		var financeiro 		= document.getElementById('menu_financeiro');
	if(document.getElementById('menu_manutencao')) 		var manutencao		= document.getElementById('menu_manutencao');
	if(document.getElementById('menu_relatorios'))		var relatorios 		= document.getElementById('menu_relatorios');
	if(document.getElementById('menu_site'))			var site 			= document.getElementById('menu_site');
	if(document.getElementById('menu_' + aba)) 			var selecionada		= document.getElementById('menu_' + aba);
	
	// Tira o Selecionamento dos conteúdos
	if(document.getElementById('menu_inicio')) 			inicio.style.display = 'none';
	if(document.getElementById('menu_gerenciamentos')) 	gerenciamentos.style.display = 'none';
	if(document.getElementById('menu_financeiro')) 		financeiro.style.display = 'none';
	if(document.getElementById('menu_manutencao')) 		manutencao.style.display = 'none';
	if(document.getElementById('menu_relatorios')) 		relatorios.style.display = 'none';
	if(document.getElementById('menu_site')) 			site.style.display = 'none';
	
	// Seleciona o Conteúdo Selecionado
	selecionada.style.display = 'block';
	
}