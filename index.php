<?php
// no browser apenas informar o diretorio do arquivo index.php sem a necessidade de escreve-lo na linha de endereço
 require_once("config.php");

 $sql = new Sql();
 
 $usuarios = $sql-> select("SELECT * from tb_usuarios");

 echo json_encode($usuarios);

 
 
 ?>