<?php
// no browser apenas informar o diretorio do arquivo index.php sem a necessidade de escreve-lo na linha de endereço
 require_once("config.php");


 //Select simples de todos os dados
 // $sql = new Sql();
 // $usuarios = $sql-> select("SELECT * from tb_usuarios");
 // echo json_encode($usuarios);

 // nesse momento só será usada a classe Usuario

 $root = new Usuario();

 $root->loadById(3);

 echo $root;   // como é um objeto vai chamar o metodo __toString() e vai gerar um JSON
 
 ?>