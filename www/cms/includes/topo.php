<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td width="100%" style="background-image: url(<?php print($pathInc);?>

imagens/fundos/topo_f.jpg);">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td align='left'><img src="<?php print($pathInc);?>imagens/diversos/topo_e.jpg"></td>
					<td width="100%" align="right">
						<?php
						// Verifica se está logado
						if($_dadosLogado->logado == "S" && $_dadosUnidade->acesso == "L"){
							?>
							<font color="White">Bem vindo(a) <b><?php print($_ClassUtilitarios->abreviaNome1($_dadosLogado->nome));?></b> 
							<?php
							// Verifica Nível
							if($_dadosLogado->nivel == 100){
								?>
								você está logado(a) na unidade <b><?php print($_dadosUnidade->razaosocial);?></b></font>
								<?php
							}elseif($_dadosLogado->nivel == 94){
								// Dados da empresa
								$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $_dadosLogado->empresa . "'");
								?>
								você está logado(a) na empresa <b><?php print($dadosEmpresa->razaosocial);?></b>
								<?php
							}
							
						}
						?>
					</td>
				</tr>
			</table>
		</td>
		<td align="right"><img src="<?php print($pathInc);?>imagens/diversos/topo_d.jpg"></td>
	</tr>
</table>