<?
// Sessão
session_start();

// path
$pathInc = "../";

// Mes get
$_GET["mes"] = (($_GET["mes"] < 10) ? "0".$_GET["mes"] : $_GET["mes"] );

// Nome completo dos meses
$mesCompleto =  array("1" => "Janeiro", 
					  "2" => "Fevereiro",
					  "3" => "Março",
					  "4" => "Abril",
					  "5" => "Maio",
					  "6" => "Junho",
					  "7" => "Julho",
					  "8" => "Agosto",
					  "9" => "Setembro",
					  "10" => "Outubro",
					  "11" => "Novembro",
					  "12" => "Dezembro");

// Verifica datas
if($_GET["mes"] > 12){
	
	// Verifica ano
	$ano = $_GET["ano"] + 1;
	
	// Verifica mes
	$mes = 1;
	
}elseif($_GET["mes"] == 0){

	// Verifica ano
	$ano = $_GET["ano"] - 1;
	
	// Verifica mes
	$mes = 12;
	
}else{

	// Verifica se foi indicado o mes e ano
	$mes = (($_GET["mes"] == "")? date("m") : $_GET["mes"] );
	$mes = (($mes < 10)? str_replace("0", "", $mes) : $mes );
	$ano = (($_GET["ano"] == "")? date("Y") : $_GET["ano"] );
	
}
?>
<html>
	<head>
		<title>Calendário</title>
		<style type="text/css" lang="br">

			body{

				font-family:Verdana, Arial, Helvetica, sans-serif;
				font-size:xx-small;
				color:#FFFFFF;
				background:#FFFFFF;
			
			}
			
			td{
			
				font-family:Verdana, Arial, Helvetica, sans-serif;
				font-size:xx-small;
				color:#FFFFFF;
			
			}
			
			a:link,a:visited,a:active{
			
				font-family:Verdana, Arial, Helvetica, sans-serif;
				font-size:xx-small;
				color:#FFFFFF;
				text-decoration: none;
			
			}
			
			a:hover{
				
				font-family:Verdana, Arial, Helvetica, sans-serif;
				font-size:xx-small;
				color:#FFFFFF;
				text-decoration: none;
			
			}
		</style>
	</head>

	<body>
		<table border="0" cellpadding="1" cellspacing="1" width="300" align="center">
			<tr bgcolor="#5668D1">
				<td align="center">
					<a href="?mes=<?=$mes-1?>

&ano=<?=$ano?>&idCampo=<?=$_GET["idCampo"]?>"><img src="<?=$pathInc?>imagens/icones/b_anterior.png" border="0"></a>
				</td>
				<td colspan="5" align="center">
					<strong><?=$mesCompleto[$mes]?></strong><br>
					<?=$ano?>
				</td>
				<td align="center">
					<a href="?mes=<?=$mes+1?>&ano=<?=$ano?>&idCampo=<?=$_GET["idCampo"]?>"><img src="<?=$pathInc?>imagens/icones/b_proximo.png" border="0"></a>
				</td>
			</tr>
			<tr bgcolor="#5668D1">
				<td align="center" width="43"><strong>Dom.</strong></td>
				<td align="center" width="43"><strong>Seg.</strong></td>
				<td align="center" width="43"><strong>Ter.</strong></td>
				<td align="center" width="43"><strong>Qua.</strong></td>
				<td align="center" width="43"><strong>Qui.</strong></td>
				<td align="center" width="43"><strong>Sex.</strong></td>
				<td align="center" width="43"><strong>Sab.</strong></td>
			</tr>
			<?
			// Interruptor
			$inter = true;
			
			// Início do mês
			$dia = 1;
			
			// Traz dias do mês
			while($dia <= cal_days_in_month(1, $mes, $ano)){
			
				// Parte da tabela
				print("<tr bgcolor=\"#808DDB\">");
				
				// Semanas
				for($i=0; $i <= 6;$i++){
					
					// Dias da semana
					if($dia <= cal_days_in_month(1, $mes, $ano)){
					
						// Verifica data
						if(date("w", mktime(0,0,0, $mes, $dia, $ano)) == $i){
						
							// Dia
							 $dia = strlen($dia) <= 1 ? 0 . $dia : $dia;
							 
							 // Mês
							 $mes = strlen($mes) <= 1 ? 0 . $mes : $mes;
							 
							 // data
							 $data = $dia . "/" . $mes . "/" . $ano;
							 ?>
							 <td <?=($dia == date("d"))?"bgcolor=\"#1D286B\" style=\"font-weight:bold;\"":" bgcolor=\"" . (($inter)?"#818EDC":"#A6AFE6") . "\""?> align="center"><a href="#" onClick="opener.document.getElementById('<?=$_GET["idCampo"]?>').value = '<?=$data?>';window.close();"><?=$dia++?></a></td>
							 <?
						}else{
						
							print("<td align='left'>&nbsp;</td>");	
							
						}
						
					}else{
						
						print("<td align='left'>&nbsp;</td>");	
						
					}
					
					// Interruptor
					$inter = !$inter;
					
				}
				
				print("</tr>");
				
			}
			?>
		</table>
	</body>
</html>