<?php

class Auth {
    public function __construct() {}

    public function login($user_id, $password) {
        $errors = [];

        $user = $this->getUser();

        if ($user["user_id"] !== $user_id) {
            array_push($errors, "User not found.");
        }
        
        if ($user["password"] !== $password) {
            array_push($errors, "Incorrect password.");
        }
        
        if (count($errors) === 0) {
            unset($user["password"]);
            
            $_SESSION["user"] = $user;

            header("Location: dashboard.php");
            exit;
        }
        
        return $errors;
    }
    
    private function getUser() {
        $user = [
            "user_id" => "U00001",
            "password" => "methupa"
        ];

        return $user;
    }
}

$auth = new Auth();