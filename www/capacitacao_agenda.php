<?php require_once("php7_mysql_shim.php"); 

	include("conexao.php");
					
		echo "<h2><font color='#666666'>.: Pr&oacute;ximas Turmas :.</font></h2>";
		
		//JANEIRO
		$sql = "Select id, curso, turno, mes_curso, data_inicio, data_fim,"
		." hora_inicioh, hora_iniciom, hora_fimh, hora_fimm, turma "
		." from `agenda` where curso = 'reciclagem_brigadista' and mes_curso = '1' order by abs(mes_curso), abs(data_inicio)";		
		$query = mysql_query($sql);	
		echo "<h3><strong>Janeiro</strong></h3>";
			while($row = mysql_fetch_array($query)){
				echo "Período: ".$row["data_inicio"]." a ".$row["data_fim"]. " - Turno: ".$row["turno"]. " - Horário: "
				.$row["hora_inicioh"].":".$row["hora_iniciom"]." as ".$row["hora_fimh"].":".$row["hora_fimm"];
				if($row["turma"]=="fds"){echo " - Turma: Final de semana <br>";	}else{echo " - Turma: Regular <br>";}
				}
				
		//FEVEREIRO
		$sql = "Select id, curso, turno, mes_curso, data_inicio, data_fim,"
		." hora_inicioh, hora_iniciom, hora_fimh, hora_fimm, turma "
		." from `agenda` where curso = 'reciclagem_brigadista' and mes_curso = '2' order by abs(mes_curso), abs(data_inicio)";		
		$query = mysql_query($sql);	
		echo "<h3><strong>Fevereiro</strong></h3>";			
			while($row = mysql_fetch_array($query)){
				echo "Período: ".$row["data_inicio"]." a ".$row["data_fim"]. " - Turno: ".$row["turno"]. " - Horário: "
				.$row["hora_inicioh"].":".$row["hora_iniciom"]." as ".$row["hora_fimh"].":".$row["hora_fimm"];
				if($row["turma"]=="fds"){echo " - Turma: Final de semana <br>";	}else{echo " - Turma: Regular <br>";}
				}
	
		//MARÇO
		$sql = "Select id, curso, turno, mes_curso, data_inicio, data_fim,"
		." hora_inicioh, hora_iniciom, hora_fimh, hora_fimm, turma "
		." from `agenda` where curso = 'reciclagem_brigadista' and mes_curso = '3' order by abs(mes_curso), abs(data_inicio)";		
		$query = mysql_query($sql);	
		echo "<h3><strong>Mar&ccedil;o</strong></h3>";
			while($row = mysql_fetch_array($query)){
				echo "Período: ".$row["data_inicio"]." a ".$row["data_fim"]. " - Turno: ".$row["turno"]. " - Horário: "
				.$row["hora_inicioh"].":".$row["hora_iniciom"]." as ".$row["hora_fimh"].":".$row["hora_fimm"];
				if($row["turma"]=="fds"){echo " - Turma: Final de semana <br>";	}else{echo " - Turma: Regular <br>";}
				}		
	
		//ABRIL
		$sql = "Select id, curso, turno, mes_curso, data_inicio, data_fim,"
		." hora_inicioh, hora_iniciom, hora_fimh, hora_fimm, turma "
		." from `agenda` where curso = 'reciclagem_brigadista' and mes_curso = '4' order by abs(mes_curso), abs(data_inicio)";		
		$query = mysql_query($sql);	
		echo "<h3><strong>Abril</strong></h3>";
			while($row = mysql_fetch_array($query)){
				echo "Período: ".$row["data_inicio"]." a ".$row["data_fim"]. " - Turno: ".$row["turno"]. " - Horário: "
				.$row["hora_inicioh"].":".$row["hora_iniciom"]." as ".$row["hora_fimh"].":".$row["hora_fimm"];
				if($row["turma"]=="fds"){echo " - Turma: Final de semana <br>";	}else{echo " - Turma: Regular <br>";}
				}
	
		//MAIO
		$sql = "Select id, curso, turno, mes_curso, data_inicio, data_fim,"
		." hora_inicioh, hora_iniciom, hora_fimh, hora_fimm, turma "
		." from `agenda` where curso = 'reciclagem_brigadista' and mes_curso = '5' order by abs(mes_curso), abs(data_inicio)";		
		$query = mysql_query($sql);	
		echo "<h3><strong>Maio</strong></h3>";
			while($row = mysql_fetch_array($query)){
				echo "Período: ".$row["data_inicio"]." a ".$row["data_fim"]. " - Turno: ".$row["turno"]. " - Horário: "
				.$row["hora_inicioh"].":".$row["hora_iniciom"]." as ".$row["hora_fimh"].":".$row["hora_fimm"];
				if($row["turma"]=="fds"){echo " - Turma: Final de semana <br>";	}else{echo " - Turma: Regular <br>";}
				}
				
		//JUNHO
		$sql = "Select id, curso, turno, mes_curso, data_inicio, data_fim,"
		." hora_inicioh, hora_iniciom, hora_fimh, hora_fimm, turma "
		." from `agenda` where curso = 'reciclagem_brigadista' and mes_curso = '6' order by abs(mes_curso), abs(data_inicio)";		
		$query = mysql_query($sql);	
		echo "<h3><strong>Junho</strong></h3>";
			while($row = mysql_fetch_array($query)){
				echo "Período: ".$row["data_inicio"]." a ".$row["data_fim"]. " - Turno: ".$row["turno"]. " - Horário: "
				.$row["hora_inicioh"].":".$row["hora_iniciom"]." as ".$row["hora_fimh"].":".$row["hora_fimm"];
				if($row["turma"]=="fds"){echo " - Turma: Final de semana <br>";	}else{echo " - Turma: Regular <br>";}
				}				


		//JULHO
		$sql = "Select id, curso, turno, mes_curso, data_inicio, data_fim,"
		." hora_inicioh, hora_iniciom, hora_fimh, hora_fimm, turma "
		." from `agenda` where curso = 'reciclagem_brigadista' and mes_curso = '7' order by abs(mes_curso), abs(data_inicio)";		
		$query = mysql_query($sql);	
		echo "<h3><strong>Julho</strong></h3>";
			while($row = mysql_fetch_array($query)){
				echo "Período: ".$row["data_inicio"]." a ".$row["data_fim"]. " - Turno: ".$row["turno"]. " - Horário: "
				.$row["hora_inicioh"].":".$row["hora_iniciom"]." as ".$row["hora_fimh"].":".$row["hora_fimm"];
				if($row["turma"]=="fds"){echo " - Turma: Final de semana <br>";	}else{echo " - Turma: Regular <br>";}
				}
				
				
		//AGOSTO
		$sql = "Select id, curso, turno, mes_curso, data_inicio, data_fim,"
		." hora_inicioh, hora_iniciom, hora_fimh, hora_fimm, turma "
		." from `agenda` where curso = 'reciclagem_brigadista' and mes_curso = '8' order by abs(mes_curso), abs(data_inicio)";		
		$query = mysql_query($sql);	
		echo "<h3><strong>Agosto</strong></h3>";
			while($row = mysql_fetch_array($query)){
				echo "Período: ".$row["data_inicio"]." a ".$row["data_fim"]. " - Turno: ".$row["turno"]. " - Horário: "
				.$row["hora_inicioh"].":".$row["hora_iniciom"]." as ".$row["hora_fimh"].":".$row["hora_fimm"];
				if($row["turma"]=="fds"){echo " - Turma: Final de semana <br>";	}else{echo " - Turma: Regular <br>";}
				}
				
				
		//SETEMBRO
		$sql = "Select id, curso, turno, mes_curso, data_inicio, data_fim,"
		." hora_inicioh, hora_iniciom, hora_fimh, hora_fimm, turma "
		." from `agenda` where curso = 'reciclagem_brigadista' and mes_curso = '9' order by abs(mes_curso), abs(data_inicio)";		
		$query = mysql_query($sql);	
		echo "<h3><strong>Setembro</strong></h3>";
			while($row = mysql_fetch_array($query)){
				echo "Período: ".$row["data_inicio"]." a ".$row["data_fim"]. " - Turno: ".$row["turno"]. " - Horário: "
				.$row["hora_inicioh"].":".$row["hora_iniciom"]." as ".$row["hora_fimh"].":".$row["hora_fimm"];
				if($row["turma"]=="fds"){echo " - Turma: Final de semana <br>";	}else{echo " - Turma: Regular <br>";}
				}								

		//OUTUBRO
		$sql = "Select id, curso, turno, mes_curso, data_inicio, data_fim,"
		." hora_inicioh, hora_iniciom, hora_fimh, hora_fimm, turma "
		." from `agenda` where curso = 'reciclagem_brigadista' and mes_curso = '10' order by abs(mes_curso), abs(data_inicio)";		
		$query = mysql_query($sql);	
		echo "<h3><strong>Outubro</strong></h3>";
			while($row = mysql_fetch_array($query)){
				echo "Período: ".$row["data_inicio"]." a ".$row["data_fim"]. " - Turno: ".$row["turno"]. " - Horário: "
				.$row["hora_inicioh"].":".$row["hora_iniciom"]." as ".$row["hora_fimh"].":".$row["hora_fimm"];
				if($row["turma"]=="fds"){echo " - Turma: Final de semana <br>";	}else{echo " - Turma: Regular <br>";}
				}
				
		//NOVEMBRO
		$sql = "Select id, curso, turno, mes_curso, data_inicio, data_fim,"
		." hora_inicioh, hora_iniciom, hora_fimh, hora_fimm, turma "
		." from `agenda` where curso = 'reciclagem_brigadista' and mes_curso = '11' order by abs(mes_curso), abs(data_inicio)";		
		$query = mysql_query($sql);	
		echo "<h3><strong>Novembro</strong></h3>";
			while($row = mysql_fetch_array($query)){
				echo "Período: ".$row["data_inicio"]." a ".$row["data_fim"]. " - Turno: ".$row["turno"]. " - Horário: "
				.$row["hora_inicioh"].":".$row["hora_iniciom"]." as ".$row["hora_fimh"].":".$row["hora_fimm"];
				if($row["turma"]=="fds"){echo " - Turma: Final de semana <br>";	}else{echo " - Turma: Regular <br>";}
				}
				
		//DEZEMBRO
		$sql = "Select id, curso, turno, mes_curso, data_inicio, data_fim,"
		." hora_inicioh, hora_iniciom, hora_fimh, hora_fimm, turma "
		." from `agenda` where curso = 'reciclagem_brigadista' and mes_curso = '12' order by abs(mes_curso), abs(data_inicio)";		
		$query = mysql_query($sql);	
		echo "<h3><strong>Dezembro</strong></h3>";
			while($row = mysql_fetch_array($query)){
				echo "Período: ".$row["data_inicio"]." a ".$row["data_fim"]. " - Turno: ".$row["turno"]. " - Horário: "
				.$row["hora_inicioh"].":".$row["hora_iniciom"]." as ".$row["hora_fimh"].":".$row["hora_fimm"];
				if($row["turma"]=="fds"){echo " - Turma: Final de semana <br>";	}else{echo " - Turma: Regular <br>";}
				}								

?>
