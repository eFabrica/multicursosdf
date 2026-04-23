<h2>NR-06 EPI</h2>

<table width="100%" class="myTable">

<?php require_once("php7_mysql_shim.php"); 

		//seleciona a tabela
		$sql = "Select id, curso, turno, mes_curso, data_inicio, data_fim,"
		." hora_inicioh, hora_iniciom, hora_fimh, hora_fimm, turma "
		." from `agenda` where curso = 'epi' order by abs(mes_curso), abs(data_inicio)";		
		$query = mysql_query($sql);						
		while($row = mysql_fetch_array($query)){
			
			echo "<tr align='center'>";
			echo "<td>".$row["turno"]."</td>";
			switch ($row["mes_curso"]){
				case 1:
					echo "<td>Janeiro</td>";
					break;
				case 2:
					echo "<td>Fevereiro</td>";
					break;
				case 3:
					echo "<td>Mar&ccedil;o</td>";
					break;
				case 4:
					echo "<td>Abril</td>";
					break;
				case 5:
					echo "<td>Maio</td>";
					break;
				case 6:
					echo "<td>Junho</td>";
					break;
				case 7:
					echo "<td>Julho</td>";
					break;
				case 8:
					echo "<td>Agosto</td>";
					break;	
				case 9:
					echo "<td>Setembro</td>";
					break;
				case 10:
					echo "<td>Outubro</td>";
					break;	
				case 11:
					echo "<td>Novembro</td>";
					break;	
				case 12:
					echo "<td>Dezembro</td>";
					break;					
			}

			echo "<td>Data Inicio: ".$row["data_inicio"]."</td>";
			echo "<td>Data Final: ".$row["data_fim"]."</td>";
			echo "<td>Hora Inicio: ".$row["hora_inicioh"].":".$row["hora_iniciom"]."</td>";
			echo "<td>Hora Final: ".$row["hora_fimh"].":".$row["hora_fimm"]."</td>";
			echo "<td>".$row["turma"]."</td>";
			echo "<td onClick='deletar(".$row["id"].");' style='cursor:pointer'><strong>X</strong></td>";
			echo "</tr>";
			
			
			
		}



?>
</table>

