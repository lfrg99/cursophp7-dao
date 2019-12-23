<?php 
// no gitbash
// $ git add --all                             (tudo que foi criado , renomeado, deletado seja adicionado ao stage area do git )
// $ git commit -m  "Iniciamos o projeto !!!"  (commitar o que está no stage area com um comentario do que foi alterado entre aspas ) 
// $ git push origin master                    ( agora empurrar (push) esses arquivos para o github q está na nuvem )
// usuario e senha  no github ---->    lfrg99 @Glglevi99

class Usuario {

    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    public function setIdusuario($value){
        $this->idusuario = $value;
    }
    public function setDeslogin($value){
        $this->deslogin = $value;
    }
    public function setDessenha($value){
        $this->dessenha = $value;
    }
    public function setDtcadastro($value){
        $this->dtcadastro = $value;
    }

    public function getIdusuario(){
        return $this->idusuario;
    }
    public function getDeslogin(){
        return $this->deslogin;
    }
    public function getDessenha(){
        return $this->dessenha;
    }
    public function getDtcadastro(){
        return $this->dtcadastro;
    }

    public function loadById($id){    
                                     // para fazer um select simples, criar uma instancia da classe Sql
        $sql = new Sql();           // o PDO vai retornar um array de array mesmo só tendo uma linha pra retornar no caso o id do usuario
       
        $results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id )); //array com nossos parametros  chave (:ID) que é 
                                                                                                        //a identificação desse parametro  e valor que é a variavel ($id) que está 
              // sendo recebida neste método

        if (count($results) > 0){
            $row = $results[0];
            
            $this->setIdusuario($row['idusuario']);
            $this->setDeslogin($row['deslogin']);
            $this->setDessenha($row['dessenha']);
            $this->setDtcadastro(new DateTime($row['dtcadastro']));  //classe DateTime construtor que vai estanciar a classe coloca já no padrão de data e hora
 

        }
    
    }


    // método __toString() quando dá um echo no objeto , não mostra a estrutura do objeto e sim executa o que estiver dentro desse método

    public function __toString(){
         return json_encode(array(     // com os nomes q queremos que exiba
               "idusuario"=>$this->getIdusuario(),
               "deslogin"=>$this->getDeslogin(),
               "dessenha"=>$this->getDessenha(),
               "dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")       //o objeto DateTime tem o método format   
        ));    
    } 
}


?>