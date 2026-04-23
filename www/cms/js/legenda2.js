//Borda
var borda = 0;

//Cor de fundo
var corFundo = "EEEEEE";

//Cor do texto
var textcolor = "000000";

//Posições
var tempPosx = 20;
var tempPosy = -110;

//Função que seta o texto
function legend(text, tpx, tpy){
	//Largura da tabela
	var largura = 300;
	
	document.onmousemove = movimentoMouse;
	var tempPosx = tpx;
	var tempPosy = tpy;
	document.getElementById('legendaLink').innerHTML = text;
}

//Função que seta o texto
function legendFotoUser(text, tpx, tpy){
	//Largura da tabela
	var largura = 80;
	document.onmousemove = movimentoMouse;
	var tempPosx = tpx;
	var tempPosy = tpy;
	document.getElementById('legendaLink').innerHTML = text;
}

//Função que verifica visibilidade
function setVisibilidade(tipo){
		if(tipo == 1){
			document.getElementById('legendaLink').style.left = 0;
			document.getElementById('legendaLink').style.top = 0;
			document.getElementById('legendaLink').style.visibility = "hidden";
			document.onmousemove = null;
		}else if(tipo == 2)
			document.getElementById('legendaLink').style.visibility = "visible";
}

//Captura o movimento do mouse
function movimentoMouse(e) {
	var posx = 0; // Posição x
	var posy = 0; // Posição y
	if (!e) var e = window.event; // Captura o evento do mouse
	if (e.pageX || e.pageY) 	{ // Verifica a existência da pageX ou pageY
		posx = e.pageX; // Atribui a posição x
		posy = e.pageY; // Atribui a posição y
	}
	else if (e.clientX || e.clientY) 	{ // Verifica a existência do clienteX e clienteY
		posx = e.clientX + document.body.scrollLeft // Atribui a posição x
			+ document.documentElement.scrollLeft;
		posy = e.clientY + document.body.scrollTop // Atribui a posição y
			+ document.documentElement.scrollTop;
	}
	
	//Se visibilidade
	setVisibilidade(2);
	
	// document.getElementById('legendaLink').offsetHeight
	// document.getElementById("div_id").offsetWidth 
	
	//Seta os movimentos do objeto
	setMove(posx + tempPosx, posy + tempPosy);
}

//Altera movimento do objeto
function setMove(moveLeft, moveTop){
	//Altera posicao do objeto
	document.getElementById('legendaLink').style.left = moveLeft;
	document.getElementById('legendaLink').style.top = moveTop;
}