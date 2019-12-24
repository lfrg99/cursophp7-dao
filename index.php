<?php
// no browser apenas informar o diretorio do arquivo index.php sem a necessidade de escreve-lo na linha de endereço
 require_once("config.php");


 //Select simples de todos os dados
 // $sql = new Sql();
 // $usuarios = $sql-> select("SELECT * from tb_usuarios");
 // echo json_encode($usuarios);

 // nesse momento só será usada a classe Usuario

// traz apenas 1 usuario com a data formatada
 /* $root = new Usuario();
 $root->loadById(3);
 echo $root;  */  // como é um objeto vai chamar o metodo __toString() e vai gerar um JSON
 
// carrega uma lista de usuários
//vantagem do método ser static é q não preciso estanciar objeto
//$lista = Usuario::getList();
//echo json_encode($lista);

// Carrega uma lista de usuários buscando pelo login
//$search = Usuario::search("ri");   //traz todos os registros cujo login começa com as letras "sa"
//echo json_encode($search);

//Carrega um usuário usando o login e a senha
//$usuario = new Usuario();
//$usuario->login("Rita","99858");
//echo $usuario;

/* // Insert de um usuário novo
$aluno = new Usuario("aluno", "12334");   // aqui utilizando o método construtor
//$aluno->setDeslogin("aluno");
//$aluno->setDessenha("12345");
$aluno->insert();   //pra salvar no banco, o insert traz o id e a data de cadastro via Procedure
echo $aluno;
 */

 // Update de um registro  carrega pelo loadById e atualiza com o método update()
 $usuario = new Usuario();
 $usuario->loadById(8);
 $usuario->update("alunoAtual","999998");
 echo $usuario;



 ?>