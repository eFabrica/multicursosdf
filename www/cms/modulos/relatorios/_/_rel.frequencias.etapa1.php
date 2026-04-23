<?php require_once("php7_mysql_shim.php");
// Limpa Sessão
unset($_SESSION["frequenciasalunos"]);

// Verifica ação
if($_REQUEST["act"] == "salvar"){
	
	// Verifica se foi informado alguma turma
	if($_REQUEST["turma"] > 0){
		
		// Cadastra Registro na Sessão
		$_SESSION["frequenciasalunos"]["idTurma"] = $_REQUEST["turma"];
		
		// Redireicona
		print($_ClassUtilitarios->redirecionarJS("?sessao=rel_frequencias&etapa=2"));
		
	}else{
		
		// Redireicona
		print($_ClassUtilitarios->redirecionarJS("?sessao=rel_frequencias&etapa=1&submenu=buscar&curso=" . $_REQUEST["curso"], 1, array("É necessário escolher uma Turma.")));
		
	}
	
}
?>
<tr>
	<td style='height:5px';>&nbsp;</td>
</tr>
<tr>
	<td align='left'><div id="border-top"><div><div></div></div></div></td>
</tr>
<tr>
	<td class="table_main">
		<form action="" method="POST" name="formFrequenciasAlunos">
            <input type="hidden" name="act" value="salvar">
            <input type="hidden" name="curso" value="<?php print($_REQUEST["curso"]);?>">
            <table border="0" cellpadding="2" cellspacing="2" align="center">
                <tr>
                    <td align="right" width="15%"><b>Filtrar Turmas:</b></td>
                    <td width='85%' align='left'><input name="procura" type="text" size="30" onKeyUp="trocaOpcao(this.value, document.formFrequenciasAlunos.turma);"></td>
                </tr>
                <tr>
                    <td align="right"><b>Turmas:</b></td>
                    <td align='left'>
                        <select name="turma">
                            <?php
                            // Busca Turmas
                            $buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N' ORDER BY concluido ASC");

                            // Traz Turmas
                            while($trazTurmas = mysql_fetch_object($buscaTurmas)){

                                // Dados do Curso
                                $dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $trazTurmas->curso . "'");
                                ?>
                                <option value="<?php print($trazTurmas->id);?>"><?php print($dadosCurso->sigla . $trazTurmas->numero . " (" . $_ClassData->transformaData($trazTurmas->datainicio, 2) . ")");?></option>
                                <?php

                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align='left'>&nbsp;</td>
                    <td align='left'><?php print($_ClassUtilitarios->criaMenu("Selecionar", "#", "document.formFrequenciasAlunos.submit();", "esq", "007", $pathInc)); ?></td>
                </tr>
            </table>
        </form>
	</td>
</tr>
<tr>
	<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
</tr>