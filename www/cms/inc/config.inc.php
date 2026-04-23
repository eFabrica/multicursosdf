<?php
// Forca charset ISO-8859-1 no header HTTP (sobrescreve default_charset=UTF-8 do PHP 7.4)
if (!headers_sent()) { header("Content-Type: text/html; charset=ISO-8859-1"); }
require_once(__DIR__ . "/../../php7_mysql_shim.php");
# Lib

	// Importa lib do MYSQL
	require_once($pathInc . "lib/Mysql.class.php");
	
	/* Importa classe de Regra de Negócios */
	require_once($pathInc . "lib/Rn.class.php");
	
	/* Importa classe de Utilitários */
	require_once($pathInc . "lib/Utilitarios.class.php");
	
	/* Importa classe de Mensagens */
	require_once($pathInc . "lib/Mensagens.class.php");
	
	/* Importa classe de Formulários */
	require_once($pathInc . "lib/Form.class.php");
	
	/* Importa classe de Strings */
	require_once($pathInc . "lib/String.class.php");
	
	// Classe de Dinheiro
	require_once($pathInc . "lib/Dinheiro.class.php");
	
	// Classe de Data
	require_once($pathInc . "lib/Data.class.php");
	
	
# Arquivo de Configurações

	/*
	
	// Seta host
	$_ClassMysql->setHost("localhost");
	
	// Seta usuário
	$_ClassMysql->setUser("root");
	
	// Seta senha mysql
	$_ClassMysql->setSenha("");
	
	// Seta banco
	$_ClassMysql->setBanco("multicursos");
	
	*/
	
	// Seta host (usa env var em dev via docker, fallback para produção)
	require_once(__DIR__ . "/db-loader.php"); $_db = db_credentials(); $_ClassMysql->setHost($_db["host"]);

	// Seta usuário
	$_ClassMysql->setUser($_db["user"]);

	// Seta senha mysql
	$_ClassMysql->setSenha($_db["pass"]);

	// Seta banco
	$_ClassMysql->setBanco($_db["name"]);
	
	
	// Efetua a conexão
	$conex1 = $_ClassMysql->conecta();

# Verifica matrículas online

    // Busca Matrículas On-line
    $buscaMatriculasOnline = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE unidade          = '3' AND
                                                                                   online           = 'S' AND
                                                                                   pg_dinheiro      = 'N' AND
                                                                                   pg_desconto      = 'N' AND
                                                                                   pg_cheque        = 'N' AND
                                                                                   pg_cartaocredito = 'N' AND
                                                                                   pg_cartaodebito  = 'N' AND
                                                                                   pg_boleto        = 'N' AND
                                                                                   pg_adicional     = 'N'");

    // Traz Matrículas
    while ($trazMatriculas = mysql_fetch_object($buscaMatriculasOnline)) {

        // Verifica data de criação
        if ((strtotime(date("Y-m-d"))-strtotime(substr($trazMatriculas->vencimento, 0, 10))) >= 432000) {

            // Deleta Matrícula
            $_ClassMysql->query("DELETE FROM `matriculas` WHERE id = '" . $trazMatriculas->id . "'");

            // Deleta Falta de Documentos
            $_ClassMysql->query("DELETE FROM `faltadocumentos` WHERE matricula = '" . $trazMatriculas->id . "'");

            // DesOcupa Vaga
            $_ClassMysql->query("UPDATE `turmas` SET vagasocupadas = (vagasocupadas-1), vagasocupadassite = (vagasocupadassite-1) WHERE id= '" . $trazMatriculas->turma . "'");


        }

    }

# Verifica Reservas

	// Busca Reservas
	$buscaReservas = $_ClassMysql->query("SELECT * FROM `clientes_reservas_matriculas` WHERE deletado = 'N'");
	
	// Traz Reservas
	while($trazReservas = mysql_fetch_object($buscaReservas)){
		
		// Dados da Turma
		$dadosTurmaReserva = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $trazReservas->turma . "'");
		
		// Tempo Restante
		$tempoRestante = ((time()-strtotime($trazReservas->dat_reserva))-3600);
		
		// Verifica Tempo Restante
		if(ceil(((($tempoRestante < 0)?str_replace("-", "", $tempoRestante):0)/60)) == 0){
			
			// Renova as Vagas
			$_ClassMysql->query("UPDATE `turmas` SET vagasocupadas = '" . ($dadosTurmaReserva->vagasocupadas-$trazReservas->qtd) . "' WHERE id = '" . $trazReservas->turma . "'");
			
			// Deleta Reserva
			$_ClassMysql->query("UPDATE `clientes_reservas_matriculas` SET deletado = 'S' WHERE id = '" . $trazReservas->id . "'");
			
		}
		
	}
?>

