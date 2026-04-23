<?php
$deflargura =$_REQUEST[l];
$defaltura =$_REQUEST[a];

# Pega onde está a imagem 
$image_path = $_REQUEST["img"];

# Carrega a imagem 
$img = null; 

$extensao = strtolower(end(explode('.', $image_path))); 

if ($extensao == 'jpg' || $extensao == 'jpeg') 
{ 
$img = @imagecreatefromjpeg($image_path); 

} else {
if ($extensao == 'gif') { 
$img = @imagecreatefromgif($image_path);
} elseif($extensao == 'png') {
	
$img = @imagecreatefrompng($image_path);
}
} 

//Pegar tamanho original
$larg = imagesx($img);
$altu = imagesy($img);

if($larg < $deflargura OR $altu < $defaltura) { 
$erro .= "A Resoluçao dessa imagem é menor do que o tamanho especificado ".$deflargura."x".$defaltura."";
} else {

if($altu>$larg) {
$nlargura=$deflargura;
$naltura=round(($altu*$deflargura)/$larg);
$centro=($naltura - $defaltura)/2;
}
else {
if(($deflargura/$defaltura) > ($larg/$altu)) {
$nlargura=$deflargura;
$naltura=round(($altu*$deflargura)/$larg);
$centro=($naltura - $defaltura)/2;
}
else {
$naltura=$defaltura;
$nlargura=round(($larg*$defaltura)/$altu);
$centro=0;
}
}
$imgred=imagecreatetruecolor($nlargura,$naltura);
imagecopyresampled($imgred, $img, 0, 0, 0, 0, $nlargura, $naltura, $larg, $altu);
$img2=imagecreatetruecolor($deflargura,$defaltura);
imagecopy($img2,$imgred, 0, 0, 0, $centro, $deflargura, $defaltura);




switch ($extensao) {
case "jpg":
header('Content-type: image/jpeg');
imagejpeg($img2);
break;

case "jpeg":
header('Content-type: image/jpeg');
imagejpeg($img2);
break;

case "gif":
header('Content-type: image/gif');
imagegif($img2);
break;

case "png":
header('Content-type: image/png');
imagepng($img2);
break;
}

}
?>