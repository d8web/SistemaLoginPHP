<?php
/*
| Puxando os arquivos config
| Puxando o model de usuario que ['classe de usuário e a interface'].
*/
require_once 'config.php';
require_once 'models/User.php';

// Classe do daoMysql do usuário.
class UserDaoMysql implements UserDAO
{
    private $pdo;

    // Construtor recebe a conexão PDO e armazena na variável privada [$this->pdo].
    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    // Método para montar um objeto de usuário recebendo um array como parâmetro.
    private function generateUser($array)
    {
        $user = new User();

        $user->id = $array['id'] ?? 0;
        $user->email = $array['email'] ?? '';
        $user->password = $array['password'] ?? '';
        $user->name = $array['name'] ?? '';
        $user->birthdate = $array['birthdate'] ?? '';
        $user->token = $array['token'] ?? '';

        return $user;
    }

    /*
    | Encontrar usuário pelo token, implementado da interface de userDAO.
    | Se não encontrar, retorna falso 'como padrão'.
    | Se encontrar retorna o objeto de usuário.
    */
    public function findByToken($token)
    {
        if(!empty($token))
        {
            $sql = $this->pdo->prepare('SELECT * FROM users WHERE token = :token');
            $sql->bindValue('token', $token);
            $sql->execute();

            if($sql->rowCount() > 0)
            {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $this->generateUser($data);

                return $user;
            }
        }
        
        return false;
    }

    /*
    | Encontrar usuário pelo email, implementado da interface de userDAO.
    | Se não encontrar, retorna falso 'como padrão'.
    | Se encontrar retorna o objeto de usuário.
    */
    public function findByEmail($email)
    {
        if(!empty($email))
        {
            $sql = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
            $sql->bindValue('email', $email);
            $sql->execute();

            if($sql->rowCount() > 0)
            {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $this->generateUser($data);

                return $user;
            }
        }
        
        return false;
    }

    // Método para atualizar o usuário, incluindo o token.
    public function update(User $user)
    {
        $sql = $this->pdo->prepare("UPDATE users SET
            email = :email,
            password = :password,
            name = :name,
            birthdate = :birthdate,
            token = :token
            WHERE id = :id
        ");

        $sql->bindValue(':email', $user->email);
        $sql->bindValue(':password', $user->password);
        $sql->bindValue(':name', $user->name);
        $sql->bindValue(':birthdate', $user->birthdate);
        $sql->bindValue(':token', $user->token);
        $sql->bindValue(':id', $user->id);
        $sql->execute();

        return true;
    }

    // Método para inserir um usuário.
    public function insert(User $user)
    {
        $sql = $this->pdo->prepare('INSERT INTO users (
            email, password, name, birthdate, token
        ) VALUES (
            :email, :password, :name, :birthdate, :token
        )');
        $sql->bindValue(':email', $user->email);
        $sql->bindValue('password', $user->password);
        $sql->bindValue('name', $user->name);
        $sql->bindValue(':birthdate', $user->birthdate);
        $sql->bindValue(':token', $user->token);
        $sql->execute();

        return true;
    }
}