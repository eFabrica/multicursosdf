// JavaScript Document
function verifica(){
	if(document.sge.CPF.value==""){
		alert("Informe o CPF");
		document.sge.CPF.focus();
		return false;
		}
	if(document.sge.PASS.value==""){
		alert("Informe a senha");
		document.sge.PASS.focus();
		return false;
		}
	document.sge.submit();		
	}

function validacpf(){
	var i; 
	s = document.forms[0].CPF.value;
	s1 = s.replace('.','');
	s2 = s1.replace('.','');
	s3 = s2.replace('.','');
	s4 = s3.replace('-','');
	s = s4;
	
	var c = s.substr(0,9); 
	var dv = s.substr(9,2); 
	var d1 = 0; 
	for (i = 0; i < 9; i++){ 
		d1 += c.charAt(i)*(10-i); 
	} 
	if (d1 == 0){ 
		alert("CPF Invalido") 
		return false; 
	} 
	d1 = 11 - (d1 % 11); 
	if (d1 > 9) d1 = 0; 
	if (dv.charAt(0) != d1){ 
		alert("CPF Invalido") 
		return false; 
	} 
	d1 *= 2; 
	for (i = 0; i < 9; i++){ 
		d1 += c.charAt(i)*(11-i); 
	} 
	d1 = 11 - (d1 % 11); 
	if (d1 > 9) d1 = 0; 
	if (dv.charAt(1) != d1){ 
		alert("CPF Invalido") 
		return false; 
	} 
	return true; 
} 
function FormataCpf(campo, teclapres)
{
	var tecla = teclapres.keyCode;
	var vr = new String(campo.value);
	vr = vr.replace(".", "");
	vr = vr.replace("/", "");
	vr = vr.replace("-", "");
	tam = vr.length + 1;
	if (tecla != 14)
	{
		if (tam == 4)
			campo.value = vr.substr(0, 3) + '.';
		if (tam == 7)
			campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 6) + '.';
		if (tam == 11)
			campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 3) + '.' + vr.substr(7, 3) + '-' + vr.substr(11, 2);
	}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

jQuery.noConflict();

function easyslider() {
	jQuery("#slider ul li").removeClass("hide_slide");
	jQuery("#slider").easySlider({
	auto: true,
	continuous: true,
	speed: 1000,
	numeric: false            });
}

jQuery(document).ready(function(){
	setTimeout('easyslider()', 0);
});