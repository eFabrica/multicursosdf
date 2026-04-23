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

function AJAX(){
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
	
	return xmlhttp;
}
function validaDate(date) {
   var err = 0
   string = date.value
   var valid = "0123456789/"
   var ok = "yes";
   var temp;
   for (var i=0; i< string.length; i++) {
     temp = "" + string.substring(i, i+1);
     if (valid.indexOf(temp) == "-1") err = 1;
   }
   if (string.length != 10) err=1
   b = string.substring(3, 5)		// month
   c = string.substring(2, 3)		// '/'
   d = string.substring(0, 2)		// day 
   e = string.substring(5, 6)		// '/'
   f = string.substring(6, 10)	// year
   if (b<1 || b>12) err = 1
   if (c != '/') err = 1
   if (d<1 || d>31) err = 1
   if (e != '/') err = 1
   if (f<1850 || f>2050) err = 1
   if (b==4 || b==6 || b==9 || b==11){
     if (d==31) err=1
   }
   if (b==2){
     var g=parseInt(f/4)
     if (isNaN(g)) {
         err=1 
     }
     if (d>29) err=1
     if (d==29 && ((f/4)!=parseInt(f/4))) err=1
   }
   if (err==1) {
   	alert("Data inválida");
   	date.value = '';
   	date.focus();
    return false;
   }
   else {
   return true;
   }
}

// AJAX
function AJAX(){
	
	try{
	    return new XMLHttpRequest();
	}catch(ee){
	    try{
	        return new ActiveXObject("Msxml2.XMLHTTP");
	    }catch(e){
	        try{
	            return new ActiveXObject("Microsoft.XMLHTTP");
	        }catch(E){
	            return false;
	        }
	    }
	}
	
}

Object.extend(Event, {
    KEY_HOME:     36,
    KEY_END:      35
});

var MaskedInput = Class.create();

MaskedInput.ranges = {
    numeric: [48, 57],
    padnum: [96, 105],
    characteres: [65, 90],
    all: [0, 255]
};

MaskedInput.inRange = function(n, range) {
    return n >= range[0] && n <= range[1];
};

MaskedInput.validRange = function(char) {
    switch(char) {
        case '!':
            return [MaskedInput.ranges.characteres];
        case '#':
            return [MaskedInput.ranges.numeric];
        case '?':
            return [MaskedInput.ranges.characteres, MaskedInput.ranges.numeric];
        case '*':
            return [MaskedInput.ranges.all];
    }
    
    return null;
};

MaskedInput.isMaskChar = function(chr) {
    return MaskedInput.validRange(chr) != null;
};

Object.extend(MaskedInput.prototype, {
    initialize: function(obj, mask, fillSpace) {
        this.obj = $(obj);
        this.mask = mask;
        this.fillSpace = fillSpace || '_';
        
        this.obj.onkeydown = this.keytest.bindAsEventListener(this);
        this.obj.onkeypress = Event.stop.bindAsEventListener(this);
        this.obj.onkeyup = Event.stop.bindAsEventListener(this);
        this.obj.onfocus = this.doSelection.bind(this);
        this.obj.onclick = this.doSelection.bind(this);
        
        if(!this.obj.value)
            this.obj.value = this.defaultString();
    },
    
    keytest: function(evt) {
        var e = evt || event;
        var code = e.keyCode || e.which || e.charCode;
        
        switch(code) {
            case Event.KEY_BACKSPACE:
                this.doBackspace();
                break;
            case Event.KEY_DELETE:
                this.doDelete();
                break;
            case Event.KEY_LEFT:
                this.moveCursor(-1);
                break;
            case Event.KEY_RIGHT:
                this.moveCursor(1);
                break;
            case Event.KEY_HOME:
                this.setSelection(0);
                break;
            case Event.KEY_END:
                this.setSelection(this.obj.value.length - 1);
                break;
            case Event.KEY_TAB:
            case Event.KEY_RETURN:
                return;
            default:
                this.maskTest(code);
        }
        
        Event.stop(e);
    },
    
    doBackspace: function() {
        this.moveCursor(-1);
        this.doDelete();
    },
    
    doDelete: function() {
        var pos = this.getCursor().left;
        
        var left = this.obj.value.substr(0, pos);
        var right = this.obj.value.substr(pos + 1, this.obj.value.length - 1);
        
        this.obj.value = left + this.fillSpace + right;
        this.setSelection(pos);
    },
    
    doSelection: function() {
        var pos = this.getCursor().left;
        
        if(pos == this.obj.value.length)
            pos--;
        
        if(!MaskedInput.isMaskChar(this.mask.charAt(pos))) {
            if(!this.moveCursor(1))
                this.moveCursor(-1);
        } else {
            this.setSelection(pos);
        }
    },
    
    moveCursor: function(step, left) {
        var pos = left || this.getCursor().left;
        
        if(step == 0)
            return false;
        
        if(pos == 0 && step < 0)
            return false;
        
        if(pos >= (this.obj.value.length - 1) && step > 0)
            return false;
        
        do {
            pos += step;
        } while(!MaskedInput.isMaskChar(this.mask.charAt(pos)) && pos > 0 && pos < this.obj.value.length);
        
        if(!MaskedInput.isMaskChar(this.mask.charAt(pos)))
            return false;
        
        this.setSelection(pos);
        return true;
    },
    
    maskTest: function(code) {
        if(MaskedInput.inRange(code, MaskedInput.ranges.padnum))
            code -= 48;
        
        var pos = this.getCursor().left;
        var chr = this.mask.charAt(pos);
        
        var ranges = MaskedInput.validRange(chr);
        var valid = false;
        
        for(var i = 0; i < ranges.length; i++) {
            if(MaskedInput.inRange(code, ranges[i])) {
                valid = true;
                break;
            }
        }
        
        if(valid) {
            var left = this.obj.value.substr(0, pos);
            var right = this.obj.value.substr(pos + 1, this.obj.value.length - 1);
            
            this.obj.value = left + String.fromCharCode(code) + right;
            
            var oldpos = pos;
            
            do {
                pos++;
            } while(!MaskedInput.isMaskChar(this.mask.charAt(pos)) && pos < this.obj.value.length);
            
            if(MaskedInput.isMaskChar(this.mask.charAt(pos)))
                this.setSelection(pos);
            else
                this.setSelection(oldpos);
        }
    },
    
    getCursor: function() {
        var left, right;
        
        if(this.obj.createTextRange) {
            var range;
            
            range = document.selection.createRange().duplicate();
            range.moveEnd("character", this.obj.value.length);
            
            if(!range.text)
                left = this.obj.value.length;
            else
                left = this.obj.value.lastIndexOf(range.text);
            
            range = document.selection.createRange().duplicate();
            range.moveStart("character", -this.obj.value.length);
            
            right = range.text.length;
        } else {
            left = this.obj.selectionStart;
            right = this.obj.selectionEnd;
        }
        
        return {left: left, right: right};
    },
    
    setSelection: function(left, rightPos) {
        var right = rightPos || left + 1;
        
        if(this.obj.createTextRange) {
            var range = this.obj.createTextRange();
            range.moveStart("character", left);
            range.moveEnd("character", right - this.obj.value.length);
            range.select();
        } else {
            this.obj.setSelectionRange(left, right);
        }
    },
    
    defaultString: function() {
        var str = '';
        
        for(var i = 0; i < this.mask.length; i++) {
            var chr = this.mask.charAt(i);
            str += MaskedInput.isMaskChar(chr) ? this.fillSpace : chr;
        }
        
        return str;
    }
});

// Mask CEP
function maskCEP(cep, red){
	
	if(cep.value.length == 5){
		cep.value += "-";
	}
	if(cep.value.length == 9){
		//red.focus();
		//red.select();
	}
	
}

// Mask CNPJ
function maskCNPJ(cnpj, red){
	
	if(cnpj.value.length == 2){
		cnpj.value += ".";
	}
	if(cnpj.value.length == 6){
		cnpj.value += ".";
	}
	if(cnpj.value.length == 10){
		cnpj.value += "/";
	}
	if(cnpj.value.length == 15){
		cnpj.value += "-";
	}
	if(cnpj.value.length == 18){
		//red.focus();
		//red.select();
	}
	
}

// Mask CPF
function maskCPF(cpf, red){
	
	if(cpf.value.length == 3){
		cpf.value += ".";
	}
	if(cpf.value.length == 7){
		cpf.value += ".";
	}
	if(cpf.value.length == 11){
		cpf.value += "-";
	}
	if(cpf.value.length == 14){
		//red.focus();
		//red.select();
	}
	
}

var comPontos;

function randomiza(n) 
{
    var ranNum = Math.round(Math.random()*n);
    return ranNum;
}

function mod(dividendo,divisor) 
{
	return Math.round(dividendo - (Math.floor(dividendo/divisor)*divisor));
}

function cpf()
{
	var n = 9;
	var n1 = randomiza(n);
 	var n2 = randomiza(n);
 	var n3 = randomiza(n);
 	var n4 = randomiza(n);
 	var n5 = randomiza(n);
 	var n6 = randomiza(n);
 	var n7 = randomiza(n);
 	var n8 = randomiza(n);
 	var n9 = randomiza(n);
 	var d1 = n9*2+n8*3+n7*4+n6*5+n5*6+n4*7+n3*8+n2*9+n1*10;
 	d1 = 11 - ( mod(d1,11) );
 	if (d1>=10) d1 = 0;
 	var d2 = d1*2+n9*3+n8*4+n7*5+n6*6+n5*7+n4*8+n3*9+n2*10+n1*11;
 	d2 = 11 - ( mod(d2,11) );
 	if (d2>=10) d2 = 0;
	retorno = '';
	if (comPontos) retorno = ''+n1+n2+n3+'.'+n4+n5+n6+'.'+n7+n8+n9+'-'+d1+d2;
	else retorno = ''+n1+n2+n3+n4+n5+n6+n7+n8+n9+d1+d2;
 	return retorno;
}

function faz()
{
	if (document.form1.tipo[0].checked)
		document.form1.numero.value = cpf();
	else
		document.form1.numero.value = cnpj();
}
// Botão de Submit
function buttonSubmit(obj, form){
	
	// Efetua o Submit
	form.submit(); 
	
	// Altera Valor
	obj.value = 'Aguarde...';
	
	// Altera Estado
	obj.disabled = true;
	
}

function checkedDisable(i){
	i.checked = false;
}

function checkedEnable(i){
	i.checked = true;
}

function disen(i){
	if(i.disabled == true){
		i.disabled = false;
	}else{
		i.disabled = true;
	}
}

function enable(i){
	 i.disabled = false;
}

function disable(i){
	 i.disabled = true;
}

function limpaValue(campo){
		campo.value = "";
}

function subForm1(form, url, target, msg){
	c = confirm(msg);
	if(c){
		form.action=url;
		if(target){
			form.target = target;
		}
		form.submit();
	}
}

function subFormP(form, url, msg, prt){
	var time=new Date();
	var date=time.getDate()
	var mes = (time.getMonth()+1);
	var year=time.getYear();
	var text = confirm("" + msg);
	if(text==true){
		data = prompt(prt, ((date < 10)?"0":"") + date + "/" + ((mes < 10)?"0":"") + mes + "/" + year);
		if ((data != null) && (data != "undefined" )){
			form.action=url+"&data="+data;
			form.submit();
		}
	}
}

function subForm(form, url, msg){
	c = confirm(msg);
	if(c){
		form.action=url;
		form.submit();
	}
}

function restaura(obj, dado){
	if(obj.value == "")
		obj.value = dado;
}

function hrefb(url){
	window.open(url,"print");
	return false;
}

function red(url, target){
	eval(target+".location='"+url+"'");
}

//Verifica se o campo está vazio
function campoBlanco(campo){
	if(campo.value = "")
		return true;
	else
		return false;
}

function newReg(obj, url,  popName, popWidth, popHeight, popScroll){
	vaObj = obj.value;
	popup(popName, "" + url + "?value=" + vaObj, popWidth, popHeight, popScroll);
}

function trocaOpcao(valor, objSel) {
    for (i=0; i < objSel.length; i++){
    qtd = valor.length;
        if (objSel.options[i].text.substring(0, qtd).toUpperCase() == valor.toUpperCase()) {
        objSel.selectedIndex = i;
            break;
        }
    }
}
function jump(targ,selObj){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
}

function jumpMenuEncaminhar(targ,selObj,restore, msg){ //v3.0
  confirma(msg,""+selObj.options[selObj.selectedIndex].value,'#');
  selObj.selectedIndex=0;
}

function exc(file, msg, idserv, d){
	c = confirm(msg);
	if(c){
		location.href= file + "?idserv=" + idserv + "&d=" + d;
	}
}
function select_all(form, e){
	for(x=0; x < document.forms[''+form].elements[e].length; x++){
		if(document.forms[''+form].elements[e][x].checked)
			document.forms[''+form].elements[e][x].checked = false;
		else
			document.forms[''+form].elements[e][x].checked = true;
	}
}

function preencheCampo(obj, valor){
	if(obj.value.length == ""){
		obj.value = valor;
	}
}
function limpaCampo(obj){
	if(obj.value.length = 10){
		obj.value = "";
	}
}

function LC(objId){
	document.getElementById(objId).value = "";
}

function confirma_opener(msg,link_sim,link_nao)
{
	var text=confirm("" + msg);
	if(text==true)
	{
		opener.location.href = "" + link_sim;
	}else if(text==false){
		opener.location.href = "" + link_nao;
	}
}

function confirma_opener2(msg,link_sim,link_nao)
{
	var text=confirm("" + msg);
	if(text==true)
	{
		opener.location.href = "" + link_sim;
		window.close();
	}else if(text==false){
		location.href = "" + link_nao;
	}
}


function confirmap(msg, link_sim, link_nao, prt, date){
	var text = confirm("" + msg);
	if(text==true){
		data = prompt(prt, date);
		if ((data != null) && (data != "undefined" ))
			location.href = "" + link_sim + "&data=" + data;
	}else if(text==false){
		location.href = "" + link_nao;
	}
}

function confirma(msg,link_sim,link_nao)
{
	var text=confirm("" + msg);
	if(text==true)
	{
		location.href = "" + link_sim;
	}else if(text==false){
		location.href = "" + link_nao;
	}
}

function popupTemp(name, url)
{
		window.open(url,name,'toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=no'); 
		return false;
}


function popup(name, url, width, height, scrol)
{
		window.open(url,name,'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars='+scrol+',resizable=yes,width='+width+',height='+height); 
		return false;
}

function redSel(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function verData(campoData){
	var data = new Date();
	var dia = data.getDate();
	var mes = data.getMonth()+1 ;
	if(campoData.value == ""){
		if(dia < 10){dia = "0" + data.getDate();}
		if(mes < 10){mes = "0" + (data.getMonth() + 1);}
		campoData.value = dia + "/" + mes + "/" + data.getFullYear();
	}
}

function moveFoco (length, focoAtual, proximoFoco) {
		if(focoAtual.value.length == length){
				proximoFoco.focus();
				proximoFoco.select();
		}
}

function maskData(campoData, campoRed, ano){
	campoData.maxlength = 10;
	if(campoData.value.length == 2){
		campoData.value += "/";
	}
	if(campoData.value.length == 5){
		campoData.value += "/";
	}
	if(campoData.value.length == 10){
		validaDate(campoData);
		//campoRed.focus();
		//campoRed.select();
	}
}

function move(id){
  if(id)
    id = numero;
	var tecla=window.event.keyCode;
	if (tecla==65) {
	  elemento = document.getElementById(id);
	  elemento.style.background='#eeeeee';
	  }
	}

function fncMoveFoco(qtd ,campo1, campo2)
{
	if (campo1.value.length == qtd){
	    campo2.focus();
	    campo2.select();
	}
}

function see(i)
{
  i = document.getElementById(i);
  if(!i)
  {
	return false;
  }else{
	if(i.style.display=='' || i.style.display=='none')
    {
		i.style.display = 'block';
 	}else{
		i.style.display = 'none';
  	}
  }
}

function sumir(i)
{
  i = document.getElementById(i);
  if(!i)
  {
	return false;
  }else{
	if(i.style.display == 'block')
    {
		i.style.display = 'none';
 	}
  }
}

function aparecer(i)
{
  i = document.getElementById(i);
  if(!i)
  {
	return false;
  }else{
	if(i.style.display == 'none')
    {
		i.style.display = 'block';
 	}
  }
}
function Limpar(valor, validos) {
// retira caracteres invalidos da string
var result = "";
var aux;
for (var i=0; i < valor.length; i++) {
aux = validos.indexOf(valor.substring(i, i+1));
if (aux>=0) {
result += aux;
}
}
return result;
}


//Formata número tipo moeda usando o evento onKeyDown

function Formata(campo,tammax,teclapres,decimal) {
var tecla = teclapres.keyCode;
vr = Limpar(campo.value,"0123456789");
tam = vr.length;
dec=decimal

if (tam < tammax && tecla != 8){ tam = vr.length + 1 ; }

if (tecla == 8 )
{ tam = tam - 1 ; }

if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 )
{

if ( tam <= dec )
{ campo.value = vr ; }

if ( (tam > dec) && (tam <= 5) ){
campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam ) ; }
if ( (tam >= 6) && (tam <= 8) ){
campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
}
if ( (tam >= 9) && (tam <= 11) ){
campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }
if ( (tam >= 12) && (tam <= 14) ){
campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }
if ( (tam >= 15) && (tam <= 17) ){
campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14, 3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;}
} 

}

//// Formata Campos

Mascaras = {
IsIE: navigator.appName.toLowerCase().indexOf('microsoft')!=-1,
AZ: /[A-Z]/i,
Acentos: /[À-ÿ]/i,
Num: /[0-9]/,
carregar: function(parte){
 var Tags = ['input','textarea'];
 if (typeof parte == "undefined") parte = document;
 for(var z=0;z<Tags.length;z++){
  Inputs=parte.getElementsByTagName(Tags[z]);
  for(var i=0;i<Inputs.length;i++)
   if(('button,image,hidden,submit,reset').indexOf(Inputs[i].type.toLowerCase())==-1)
    this.aplicar(Inputs[i]);
 }
},
aplicar: function(campo){
 tipo = campo.getAttribute('tipo');
 if (!tipo || campo.type == "select-one") return;
 orientacao = campo.getAttribute('orientacao');
 mascara = campo.getAttribute('mascara');
 if (tipo.toLowerCase() == "decimal"){
  orientacao = "esquerda";
  casasdecimais = campo.getAttribute('casasdecimais');
  tamanho = campo.getAttribute('maxLength');
  if (!tamanho || tamanho > 50)
   tamanho = 10;
  if (!casasdecimais)
   casasdecimais = 2;
  campo.setAttribute("mascara", this.geraMascaraDecimal(tamanho, casasdecimais));
  campo.setAttribute("tipo", "numerico");
  campo.setAttribute("orientacao", orientacao);
 }
 if (orientacao && orientacao.toLowerCase() == "esquerda") campo.style.textAlign = "right";
 if (mascara) campo.setAttribute("maxLength", mascara.length);
 if (tipo){
  campo.onkeypress = function(e){ return Mascaras.onkeypress(e?e:event); };
  campo.onkeyup = function(e){ Mascaras.onkeyup(e?e:event, campo) };
 }
 campo.setAttribute("snegativo", ((campo.value).substr(0,1) == "-" ? "s" : "n"));
},
onkeypress: function(e){
 KeyCode = this.IsIE ? event.keyCode : e.which;
 campo =  this.IsIE ? event.srcElement : e.target;
 readonly = campo.getAttribute('readonly');
 if (readonly) return;
 maxlength = campo.getAttribute('maxlength');
 pt = campo.getAttribute('pt');
 selecao = this.selecao(campo);
 if (selecao.length > 0 && KeyCode != 0){
  campo.value = ""; return true;
 }
 if (KeyCode == 0) return true;
 Char = String.fromCharCode(KeyCode);
 valor = campo.value;
 mascara = campo.getAttribute('mascara');
 if (KeyCode != 8){
  tipo = campo.getAttribute('tipo').toLowerCase();
  negativo = campo.getAttribute('negativo');
  if(negativo && KeyCode == 45){
   snegativo = campo.getAttribute('snegativo');
   snegativo = (snegativo == "s" ? "n" : "s");
   campo.setAttribute("snegativo", snegativo);
  }else{
   valor += Char
   if (tipo == "numerico" && Char.search(this.Num) == -1) return false;
   if (KeyCode != 32 && tipo == "caracter" && Char.search(this.AZ) == -1 && Char.search(this.Acentos) == -1) return false;
  }
 }
 if (mascara){
  this.aplicarMascara(campo, valor);
  return false;
 }
 return true;
},
onkeyup: function(e, campo){
 KeyCode = this.IsIE ? event.keyCode : e.which;
 if (KeyCode != 9 && KeyCode != 16 && KeyCode != 109){
  valor = campo.value;
  if (KeyCode == 8 && !this.IsIE) valor = valor.substr(0,valor.length-1);
  this.aplicarMascara(campo, valor);
 }
},
aplicarMascara: function(campo, valor){
 mascara = campo.getAttribute('mascara');
 if (!mascara) return;
 negativo = campo.getAttribute('negativo');
 snegativo = campo.getAttribute('snegativo');
 if (negativo && valor.substr(0,1) == "-")
  valor = valor.substr(1,valor.length-1);
 orientacao = campo.getAttribute('orientacao');
 var i = 0;
 for(i=0;i<mascara.length;i++){
  caracter = mascara.substr(i,1);
  if (caracter != "#") valor = valor.replace(caracter, "");
 }
 retorno = "";
 if (orientacao != "esquerda"){
  contador = 0;
  for(i=0;i<mascara.length;i++){
   caracter = mascara.substr(i,1);
   if (caracter == "#"){
    retorno += valor.substr(contador,1);
    contador++;
   }else
    retorno += caracter;
   if(contador >= valor.length) break;
  }
 }else{
  contador = valor.length-1;
  for(i=mascara.length-1;i>=0;i--){
   if(contador < 0) break;
   caracter = mascara.substr(i,1);
   if (caracter == "#"){
    retorno = valor.substr(contador,1) + retorno;
    contador--;
   }else
    retorno = caracter + retorno;
  }
 }
 if (negativo && snegativo == "s")
  retorno = "-" + retorno;
 campo.value = retorno;
},
geraMascaraDecimal: function(tam, decimais){
 var retorno = ""; var contador = 0; var i = 0;
 decimais = parseInt(decimais);
 for (i=0;i<(tam-(decimais+1));i++){
  retorno = "#" + retorno;
  contador++;
  if (contador == 3){
   retorno = "." + retorno;
   contador=0;
  }
 }
 retorno = retorno + ",";
 for (i=0;i<decimais;i++) retorno += "#";
 return retorno;
},
selecao: function(campo){
 if (this.IsIE)
  return document.selection.createRange().text;
 else
  return (campo.value).substr(campo.selectionStart, (campo.selectionEnd - campo.selectionStart));
},
formataValor: function (valor, decimais){
 valor = valor.split('.');
 if (valor.length == 1) valor[1] = "";
 for(var i=valor[1].length;i<decimais;i++)
  valor[1] += "0";
 valor[1] = valor[1].substr(0,2);
 return (valor[0] + "." + valor[1]);
}
};