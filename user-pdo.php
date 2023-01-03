<?php
session_start();
class Userpdo{
    private $id;
    public $login;
    public $password;
    public $email;
    public $firstname;
    public $lastname;
    public $bdd;

    public function __construct(){
        $bdd = new PDO("mysql:host=localhost;dbname=classes",'root','');
        $bdd->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->bdd = $bdd;
        return $bdd;
    }
    public function register($login, $password, $email, $firstname, $lastname){

        $requete = "INSERT INTO `utilisateurs`( `login`, `password`, `email`, `firstname`, `lastname`) VALUES (:login, :password, :email, :firstname, :lastname)";
        //var_dump($requete);
        $result = $this->bdd->prepare($requete);
        $result->bindValue(':login', $login, PDO::PARAM_STR);
        $result->bindValue(':password', $password, PDO::PARAM_STR);
        $result->bindValue(':email', $email, PDO::PARAM_STR);
        $result->bindValue(':firstname', $firstname, PDO::PARAM_STR);
        $result->bindValue(':lastname', $lastname, PDO::PARAM_STR);
        $result->execute();
        echo'<table>
        <thead>
            <th>login</th>
            <th>password</th>
            <th>email</th>
            <th>Firstname</th>
            <th>Lastname</th>
        </thead>
        <tbody>
            <td>'.$login.'</td>
            <td>'.$password.'</td>
            <td>'.$email.'</td>
            <td>'.$firstname.'</td>
            <td>'.$lastname.'</td>
        </tbody>
    </table>';
    }
    public function connect($login, $password){
        $requete2 = "SELECT * FROM utilisateurs WHERE login = ':login' AND password = ':password'";
        var_dump($requete2);
        $result2 = $this->bdd->prepare($requete2);
        $result2->bindValue(':login', $login, PDO::PARAM_STR);
        $result2->bindValue(':password', $password, PDO::PARAM_STR);
        $result2->execute();
        $fetch = $result2->fetchAll();
        return $fetch;
        if(count($fetch) > 0){
            $_SESSION['utilisateur'] = [
                'id' => $fetch[0]['id'],
                'login' => $fetch[0]['login'],
                'password' => $fetch[0]['password'],
                'email' => $fetch[0]['email'],
                'firstname' => $fetch[0]['firstname'],
                'lastname' => $fetch[0]['lastname'],
            ];
        }

    }
    public function disconnect(){
        session_destroy();
    }
    public function delete(){
        $requete3 = "DELETE FROM `utilisateurs` WHERE id = :id";
        $result3 = $this->bdd->prepare($requete3);
        $result3->bindValue(':id',$this->id, PDO::PARAM_STR);
        $result3->execute();
    }
    public function update($login, $password, $email, $firstname, $lastname){
        $requete4 = "UPDATE `utilisateurs` SET `login`= :login,`password`= :password,`email`= :email,`firstname`= :firstname,`lastname`= :lastname";
        $result4 = $this->bdd->prepare($requete4);
        $result4->bindValue(':password', $password, PDO::PARAM_STR);
        $result4->bindValue(':login', $login, PDO::PARAM_STR);
        $result4->bindValue(':email', $email, PDO::PARAM_STR);
        $result4->bindValue(':firstname', $firstname, PDO::PARAM_STR);
        $result4->bindValue(':lastname', $lastname, PDO::PARAM_STR);
        $result4->execute();
    }
    public function isConnected(){
        if(!empty($_SESSION['utilisateur'])){
            return true;
        }
        else{
            return false;
        }
    }
    public function getAllinfos(){
        echo'<table>
                <thead>
                    <th>login</th>
                    <th>password</th>
                    <th>email</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                </thead>
                <tbody>
                    <td>'.$_SESSION['utilisateur']['login'].'</td>
                    <td>'.$_SESSION['utilisateur']['password'].'</td>
                    <td>'.$_SESSION['utilisateur']['email'].'</td>
                    <td>'.$_SESSION['utilisateur']['firstname'].'</td>
                    <td>'.$_SESSION['utilisateur']['lastname'].'</td>
                </tbody>
            </table>';
    }
    public function getLogin(){
        return $this -> login;
    }
    public function getPassword(){
        return $this -> password;
    }
    public function getEmail(){
        return $this -> email;
    }
    public function getFirstname(){
        return $this -> firstname;
    }
    public function getLastname(){
        return $this -> lastname;
    }
}

$UserPdo = new USerpdo();
$UserPdo->register('jc','dudu','jc@gmail.com','jc','jc');
/*echo $UserPdo->isConnected();
echo $UserPdo->getAllinfos().'<br>';
echo $UserPdo->getLogin().'<br>';
echo $UserPdo->getEmail().'<br>';
echo $UserPdo->getLogin().'<br>';
echo $UserPdo->getFirstname().'<br>';
echo $UserPdo->getLastname();*/