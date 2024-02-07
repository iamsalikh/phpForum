<?php
namespace phpForum\Model;

class User {
    private $dbConnection;
    private $id;

    public function __construct(Connection $dbConnection) {
        $this->dbConnection = $dbConnection->conn;
    }

    public function register($name, $username, $email, $password, $confirmPassword) {
        $stmt = $this->dbConnection->prepare("SELECT * FROM tb_user WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            return 10;
        } else {
            if($password==$confirmPassword) {
                $pepper = 'salikh';
                $pwd_peppered = hash_hmac("sha256", $password, $pepper);
                $pwd_hashed = password_hash($pwd_peppered, PASSWORD_DEFAULT);

                $insertStmt = $this->dbConnection->prepare("INSERT INTO tb_user (name, username, email, password) VALUES (?, ?, ?, ?)");
                $insertStmt->bind_param("ssss", $name, $username, $email, $pwd_hashed);
                $insertStmt->execute();

                $this->id = $this->dbConnection->insert_id;
                return 1;
            } else {
                return 100;
            }
        }
    }

    public function login($usernameemail, $password){
        $stmt = $this->dbConnection->prepare("SELECT * FROM tb_user WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $usernameemail, $usernameemail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            $user = $result->fetch_assoc();
            $storedPasswordHash = $user['password'];

            $pepper = 'salikh';
            $pwd_peppered = hash_hmac("sha256", $password, $pepper);

            if (password_verify($pwd_peppered, $storedPasswordHash)){
                $this->id=$user['id'];
                return 1;
            } else {
                return 10;
            }
        } else {
            return 100;
        }
    }

    public function idUser(){
        return $this->id;
    }

    public function selectUserById($id){
        $stmt = $this->dbConnection->prepare("SELECT * FROM tb_user WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function getUsernameByUserId($userId){
        $stmt = $this->dbConnection->prepare("SELECT username FROM tb_user WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result && $result->num_rows > 0){
            $row = $result->fetch_assoc();
            return $row['username'];
        } else {
            return false;
        }
    }
}
