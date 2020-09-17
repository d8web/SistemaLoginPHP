<?php
// Puxando o dao de usuário.
require_once 'dao/UserDAOMysql.php';

class Auth
{
    private $pdo;
    private $base;
    private $dao;

    /*
    | Construtor recebe a conexão PDO e armazena na variável privada [$this->pdo].
    | Também recebe a url $base e armazena na variável privada [$this->base].
    | Por último, instancia o dao UserDAOMysql,
    | mandando o recente pdo como parâmetro no construtor.
    */
    public function __construct(PDO $pdo, $base)
    {
        $this->pdo = $pdo;
        $this->base = $base;

        $this->dao = new UserDAOMysql($this->pdo);
    }

    /*
    | Método que verifica se existe um token do usuario logado.
    | Caso exista retorna o objeto de usuario vindo de findByToken.
    | Caso não exista um token, redirect o usuario para login.php.
    */
    public function checkToken()
    {   
        if(!empty($_SESSION['token']))
        {
            $token = $_SESSION['token'];

            $user = $this->dao->findByToken($token);

            if($user)
            {
                return $user;
            }
        }

        header("Location: ".$this->base."/login.php");
        exit;
    }

    // Método para validar o login do usuário, puxando pelo email depois verificando a senha.
    public function validateLogin($email, $password)
    {
        $user = $this->dao->findByEmail($email);

        if($user)
        {   
            if(password_verify($password, $user->password))
            {
                $token = md5(time().rand(0, 9999));

                $_SESSION['token'] = $token;

                $user->token = $token;

                $this->dao->update($user);

                return true;
            }
        }

        return false;
    }

    /*
    | Método para verificar se existe o email informado pelo usuário.
    | Usado na verificação de cadastrar um novo usuário.
    */
    public function emailExists($email)
    {
        return $this->dao->findByEmail($email) ? true : false;
    }

    /*
    | Método para registar um novo usuário, recebendo vários parâmetros.
    | Montando um objeto e mandando para o dao de usuarios no método insert.
    | Por fim está retornando um token para já cadastrar e logar o usuário.
    */
    public function registerUser($name, $email, $password, $birthdate)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $token = md5(time().rand(0, 9999));

        $newUser = new User();

        $newUser->name = $name;
        $newUser->email = $email;
        $newUser->password = $hash;
        $newUser->birthdate = $birthdate;
        $newUser->token = $token;

        $this->dao->insert($newUser);

        $_SESSION['token'] = $token;
    }

}