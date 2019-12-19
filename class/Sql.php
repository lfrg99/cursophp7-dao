<?php


// =========== CONECTANDO O PHP7 COM MYSQL USANDO PDO ( PHP DATA OBJECT )===============================
//                   DAO : DATA ACESS OBJECT 

// Começando com a classe SQL

// criar um repositorio em C:\wamp\www\CursoPHP\DAO que vai criar a pasta oculta do .git (comando git bash)
// criar um repositorio no gitHub

/* 
luiz.gonzalez@FNSD276424 MINGW64 /c
$ cd /c/wamp/www/CursoPHP/DAO

luiz.gonzalez@FNSD276424 MINGW64 /c/wamp/www/CursoPHP/DAO
$ git init
Initialized empty Git repository in C:/wamp/www/CursoPHP/DAO/.git/

luiz.gonzalez@FNSD276424 MINGW64 /c/wamp/www/CursoPHP/DAO (master)
$ git remote add origin https://github.com/lfrg99/cursophp7-dao.git

luiz.gonzalez@FNSD276424 MINGW64 /c/wamp/www/CursoPHP/DAO (master)
$ git pull origin master  //não vai encontrar nada na primeira vez */


class Sql extends PDO {    // PDO classe nativa do sistema  PHP
    
    private  $conn;
    
    public function __construct(){ //conect automaticamente num banco de dados pelo metodo construtor
                                    // algo que fará toda vez que a classe é 'instanciada'
        $this->conn =  new PDO("mysql:host=localhost;dbname=dbphp7","root",""); // parametros de conexão
    } 

    // para reutilizar por outros métodos que necessitem dos parametros
    private function setParams($statment, $parameters=array()){  //vai receber o statment e os dados
     
        foreach ($parameters as $key => $value){
            $this ->setParam($key, $value);
        }

    }

    // para fazer um bind de um parametro não precisa passar todos os dados, apenas chave e valor obrigatórios
    private function setParam($statment, $key, $value){ 
        $statment ->bindParam($key, $value);
    }

    
    public function query($rawQuery, $params = array()) {   // função para executar comandos no banco de dados, recebe 2 parametros
                                                            // rowquery ---> (comando sql)
            //variavel que funciona sómente dentro
            //desse método mesmo não tem o this             // params   ---> que por padrão vai receber um array de parametros (dados)

         $stmt = $this->conn->prepare($rawQuery);                    // classe extendida tem acesso ao prepare
                                                                     // associar os parametros a esse comando

        $this->setParams($stmt,$params);   //aqui ele vai saber como fazer o set de cada um dos  parametros
       
         $stmt->execute();   // faz a query execução no banco de dados o retorno é tratado em outo método
     
         return $stmt; 
              
    }

    public function select ($rawQuery, $params= array()):array{     //:array , diz que retorna um return do tipo array

        $stmt = $this->query($rawQuery, $params);
                                                  // fetch(): Retorna uma unica row da consulta, ideal para poder utilizar em consultas como login, que retorna somente um resultado.
        return $stmt->fetchAll(PDO::FETCH_ASSOC);   //Retorna um array com todas as linhas da consulta, ideal para uma busca por nome ou por endereço.
    }

    //  Estilos de retorno
    //  Um estilo de retorno é o PDO::FETCH_ASSOC, ou seja, ele retornará um array associativo exemplo:  (sem indices)
    //  [“nome”=>”Marcio Lucas”, “login” => “doidera123”, “senha” => “pamonha321”];

    
}

?>