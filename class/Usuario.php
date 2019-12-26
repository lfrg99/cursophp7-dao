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
            $this->setData($results[0]);
        }
    
    }

    public static function getList(){  //vantagem desse método ser static não preciso estanciar esse objeto
       $sql = new Sql();
       return $results = $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");     


    }

    public static function search($login){  //vantagem desse método ser static não preciso estanciar esse objeto
        $sql = new Sql();
        return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
            ':SEARCH'=>"%".$login."%"
        ));     
 
     }

      public function login($login, $password){  // obter os dados do usuário autenticad passando o login e senha
                                                   // como será usado os gets e setters para poder definir no contexto do objeto não pode ser static  
                                                   // pq não vai usar o $this , amarrar na classe
 
        $sql = new Sql();          
       
        $results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
                 ":LOGIN"=>$login,
                 ":PASSWORD"=>$password ));  
                                           
        if (count($results) > 0){
                        
            $this->setData($results[0]);
           
        }else{

           throw new Exception("Login e/ou senha inválidos");
        }
     }


     //==============================  USANDO INSERT COM PROCEDURE DENTRO DO BANCO DE DADOS MYSQL

     public function insert(){  //criar um usuário novo apartir da classe Usuario
        $sql = new Sql();
        // porque com select, porque qdo a procedure executar,por ultimo ela irá chamar uma função do banco de dados que retorna qual foi o ID gerado na tabela
        $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)" , array(   // criado uma Procedure dentro do mysql
            ":LOGIN"=>$this->getDeslogin(),
            ":PASSWORD"=>$this->getDessenha()  
        ));
        if (count($results) > 0){
                        
            $this->setData($results[0]);
        }
     }


    //============================ USANDO INSERT SEM USAR PROCEDURE

    /* Na classe Usuários:
    
    //METODOS  insert
    
    public function insert($login, $password) {
    $this->setDeslogin($login);
    $this->setDessenha($password);
    $sql = new Sql();
    
    $sql->query("INSERT INTO tb_usuarios (deslogin, dessenha) VALUES (:LOGIN, :PASSWORD)", array(
    
    'LOGIN' => $this->getDeslogin(),
    'PASSWORD' => $this->getDessenha(),
    ));
    
    }
    
       
    INDEX.PHP
    
    // CHAMA INSERT
    $usuario = new Usuario();
    $usuario->insert("CADASTRO NOVO", "SENHANOVA");
    
    ///MOSTRA LISTA ATUALIZADA
    $lista = Usuario::getList();
    echo json_encode($lista);
 */
  
 
     public function setData($data){
        $this->setIdusuario($data['idusuario']);
        $this->setDeslogin($data['deslogin']);
        $this->setDessenha($data['dessenha']);
        $this->setDtcadastro(new DateTime($data['dtcadastro']));  //classe DateTime construtor que vai estanciar a classe coloca já no padrão de data e hora
     }
    
 
   // Método update

   public function update($login, $password){  // o que eu quero alterar
   
    $this->setDeslogin($login);
    $this->setDessenha($password);

    $sql = new Sql();
    
    $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(    
            'LOGIN' => $this->getDeslogin(),
            'PASSWORD' => $this->getDessenha(),
            ':ID'=>$this->getIdusuario()
    ));
  }

  public function delete(){

     
    $sql = new Sql();
       
    $sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(    
        ":ID"=>$this->getIdusuario() 
       ));

       //após apagar do banco refletir no objeto zerando completamente

       $this->setIdusuario(0);
       $this->setDeslogin("");
       $this->setDessenha("");
       $this->setDtcadastro(new DateTime());

    }
      
      // método construtor - parametros com as vazias não vai dar erro caso não passe os parametros
     public function __construct($login="", $password=""){
        $this->setDeslogin($login);
        $this->setDessenha($password);

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