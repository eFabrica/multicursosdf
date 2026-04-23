<?php require_once("php7_mysql_shim.php"); include("conexao.php") ; ?>

<?php

	if(isset($_REQUEST["tipo"])){
		
		if($_REQUEST["tipo"] == 'adicionar') {
			
			$sqlinsert = "INSERT INTO `agenda`(curso, turno, mes_curso, data_inicio, data_fim, hora_inicioh, hora_iniciom, hora_fimh, hora_fimm, turma) VALUES ('"
			.$_REQUEST["cboCurso"]."','".$_REQUEST["cboTurno"]."','".$_REQUEST["cboMes"]."','"
			.$_REQUEST["cboDiaInicio"]."','".$_REQUEST["cboDiaFim"]."','".$_REQUEST["cboHoraInicioH"]."','"
			.$_REQUEST["cboHoraInicioM"]."','".$_REQUEST["cboHoraFimH"]."','".$_REQUEST["cboHoraFimM"]."','".$_REQUEST["cboTurma"]."')";							
			mysql_query($sqlinsert);			
			
			}
		}

		
	if(isset($_REQUEST["tipo"])){
		
		if($_REQUEST["tipo"] == 'deletar'){

			$sqldelete = "DELETE FROM `agenda` WHERE id in (".$_REQUEST["apagar"].")";					
			mysql_query($sqldelete);					
			
			}

		}


?>



<html>
<head>
<title>Multicursos - Forma&ccedil;&atilde;o Profissional</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">

<link href="style.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />	

<style type="text/css">
table.myTable { border-collapse:collapse; }
table.myTable td, table.myTable th { border:1px solid black;padding:5px; }
</style>

<script src="js/jquery.js" type="text/javascript"></script> 
<script src="js/easySlider.js" type="text/javascript"></script> 
<script src="js/util.js" type="text/javascript"></script> 

<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js?load=effects" type="text/javascript"></script>
<script src="js/lightbox.js" type="text/javascript"></script>

<script>
function adicionar(){
	doc = document.form1;
	if((doc.cboCurso.value=='') || (doc.cboTurno.value=='') || (doc.cboMes.values=='') 
	|| (doc.cboDiaInicio.values=='') || (doc.cboDiaFim.values=='') || (doc.cboHoraInicioH.values=='') 
	|| (doc.cboHoraInicioM.values=='') || (doc.cboHoraFimH.values=='') || (doc.cboHoraFimM.values=='') || (doc.cboTurma.values=='')){
		alert("Informe todos os campos.");
		return false;
		}
	doc.submit();	
	}

function deletar(id){
	doc = document.form1;
	doc.apagar.value=id;
	doc.tipo.value='deletar';
	doc.submit();
	}

	
</script>


</head>
<body bgcolor="#666666" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
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
		
       	  <table width="985px" align="center" border="0">
            	<tr>
                	<td style="font-family:Verdana, Geneva, sans-serif" align="center">
						
                        <br>
						<h3>Cadastro & Exclusão da Agenda </h3><br>
                        
                        <form name="form1" method="post">
                        	<input type="hidden" value="adicionar" name="tipo">
                            <input type="hidden" name="apagar">
                            
                            <table width="100%" class="myTable">
                                <tr align="center" bgcolor="#CCCCCC">
                                    <td><strong>Curso</strong></td>
                                    <td><strong>Turno</strong></td>
                                    <td><strong>Mês Curso</strong></td>
                                    <td><strong>Dia Inicio</strong></td>
                                    <td><strong>Dia Final</strong></td>
                                    <td><strong>Hora Inicio</strong></td>
                                    <td><strong>Hora Final</strong></td>
                                    <td><strong>Turmas</strong></td>
                                    <td rowspan="2"><input type="button" value="Ok" onClick="adicionar();"></td>
                                </tr>
                                <tr align="center" bgcolor="#999999">
                                	<td>
                                    	<select name="cboCurso">
                                    		<option></option>
                                            <option value="formacao_brigadista">Formação Brigadista</option>
                                            <option value="reciclagem_brigadista">Reciclagem Brigadista</option>
                                            <option value="socorrista">Socorrista</option>
	                                        <option value="dea">D.E.A	</option>
                                            <option value="voluntario">Vontário</option>
                                            <option value="primeiros_socorros">Primeiros Socorros</option>
                                            <option value="salva_vidas">Salva Vidas</option>
                                            <option value="cipa">CIPA</option>
                                            <option value="epi">EPI</option>
                                            <option value="nr10">NR-10</option>
                                    	</select>
                                    </td>
                                    <td>
                                    	<select name="cboTurno">
                                        	<option></option>
                                            <option value="matutino">Matutino</option>
                                            <option value="noturno">Noturno</option>
                                            <option value="integral">Integral</option>                                            
                                        </select>
                                    </td>
                                    <td>
                                    	<select name="cboMes">
                                        	<option></option>
                                            <option value="1">Janeiro</option>
                                            <option value="2">Fevereiro</option>
                                            <option value="3">Março</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Maio</option>
                                            <option value="6">Junho</option>
                                            <option value="7">Julho</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Setembro</option>
                                            <option value="10">Outubro</option>
                                            <option value="11">Novembro</option>
                                            <option value="12">Dezembro</option>                                            
                                        </select>
                                    </td>
                                    <td>
                                        <select name="cboDiaInicio">
                                       		<option></option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                        </select>
                                    </td>
                                    <td>
                                    	<select name="cboDiaFim">
                                       		<option></option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>
                                            <option value="26">26</option>
                                            <option value="27">27</option>
                                            <option value="28">28</option>
                                            <option value="29">29</option>
                                            <option value="30">30</option>
                                            <option value="31">31</option>
                                        </select>
                                    </td>
                                    <td>
                                    	<select name="cboHoraInicioH">
                                        	<option></option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="00">00</option>
                                        </select>
                                        <strong>:</strong>
                                    	<select name="cboHoraInicioM">
                                        	<option></option>
                                            <option value="00">00</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="40">40</option>
                                            <option value="50">50</option>
                                        </select>                                        
                                    </td>
                                    <td>
                                    	<select name="cboHoraFimH">
                                        	<option></option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="00">00</option>
                                        </select>
                                        <strong>:</strong>
                                    	<select name="cboHoraFimM">
                                        	<option></option>
                                            <option value="00">00</option>
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="40">40</option>
                                            <option value="50">50</option>
                                        </select> 
                                    </td>
                                    <td>
                                    	<select name="cboTurma">
                                        	<option></option>
                                            <option value="regular">Regular</option>
                                            <option value="fds">Final de Semana</option>
                                        </select>
                                    </td>
                                    
                                </tr>
                            </table>                        
                        </form>
                        
                        <br>
                        <br>
                        <?php include("brigadista_ag.php"); ?>
                        <br>
                        <br>
                        <?php include("capacitacao_ag.php"); ?>
                        <br>
                        <br>
                        <?php include("socorrista_ag.php"); ?>                        
                        <br>
                        <br>
                        <?php include("dea_ag.php"); ?>
                        <br>
                        <br>
                        <?php include("voluntario_ag.php"); ?>
                        <br>
                        <br>
                        <?php include("socorros_ag.php"); ?>
                        <br>
                        <br>
                        <?php include("aquatico_ag.php"); ?>
                        <br>
                        <br>
                        <?php include("cipa_ag.php"); ?>
                        <br>
                        <br>
                        <?php include("protecao_ag.php"); ?>
                        <br>
                        <br>
                        <?php include("eletricidade_ag.php"); ?>
                        <br>
                        <br>


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