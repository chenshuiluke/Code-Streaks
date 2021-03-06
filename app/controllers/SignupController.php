<?php
namespace App\Controllers;

use App\Views\SignupView;
use App\Util\DatabaseUtilities;
use App\Config;
use OAuth\OAuth2\Service\GitHub;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;

class SignupController extends BaseController
{
    public function showSignupPage(){

    }

    public static function processSignup(){
        $email = $_POST['email'];
        $password = $_POST['password'];

        var_dump($email);
        var_dump($password);

        $pdo = DatabaseUtilities::getPDOInstance();

        $statement = $pdo->prepare("CALL create_user(:email, :password)");
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $password);
        $result = $statement->execute();

        var_dump($result);

        self::getAllSignups();
    }
    public static function getAllSignups(){
        $pdo = DatabaseUtilities::getPDOInstance();
        $statement = $pdo->prepare('CALL find_user_by_email(:email)');
        $email = "chenshuiluke@gmail.com";
        $statement->bindParam(':email', $email);

        $result = $statement->execute();
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)){
            echo "{$row['email']} - {$row['password']}";
            echo "<br />";
        }
    }    
}
?>