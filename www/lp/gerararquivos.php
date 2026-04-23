<?php 
/**
 * listarArrayArquivos
 * Criar  o arquivo com os caminhos dos arquivos e pastas para a desinstalação dos arquivos no instalador automatico.
 */ 
function listarArrayArquivos(){
  //self::cout(__FUNCTION__);
  //$StCaminho = '/home/richardferreira/www/mibew';
  $StCaminho = '/home/modeloshostnet/www/instalador';
  $ArArquivo = @file("{$StCaminho}/arquivo.txt");
  
  //if( !is_array($ArArquivo) ){
   #listarArrayArquivos();
   
  //}
  
  #Gerando lista de arquivos.
  $ArSaida[] = "<?php\n";
  $ArSaida[] = "\$ArArquivo = array\n";
  $ArSaida[] = "(\n";
  $ArSaida[] = "    'Arquivo' => array\n";
  $ArSaida[] = "    (\n";
  foreach($ArArquivo as $StLinha){
   $ArSaida[] = "        '".rtrim(str_replace('./','',$StLinha))."',\n";
  }
  $ArSaida[] = "    ),\n";
  #$ArSaida[] = "  'Arquivo_SSH' => 'hesk.tar.gz',\n"; 
  
  # Gerando lista de diretorios.
  # $ArSaida[] = "  (\n";
  $ArSaida[] = "    'Diretorio' => array\n";
  $ArSaida[] = "    (\n";  
  $ArArquivo = @file("{$StCaminho}/diretorio.txt");
  foreach($ArArquivo as $StLinha){
  	$ArSaida[] = "        '".rtrim(str_replace('./','',$StLinha))."',\n";
  }
  
  $ArSaida[] = "    ),\n";
  $ArSaida[] = "    'Arquivo_SSH' => 'wordpresspadrao.tar.gz',\n";
  $ArSaida[] = ");\n";
  $ArSaida[] = "?>\n";
  
  echo "<pre>";
  print_R($ArSaida);
  $StCaminho = $StCaminho;
  file_put_contents("{$StCaminho}/arquivos.php", $ArSaida);
 }
 
 listarArrayArquivos();
