<?php

include_once("db.php");

class Auth {
    private $conn; // SQL connection variable.

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login(int $member_id, string $password) {
        $errors = [];

        [$result, $row] = $this->getUser($member_id);

        if (!$result->num_rows > 0) {
            array_push($errors, "Member not found.");
        }
        
        if (!password_verify($password, $row["password"])) {
            array_push($errors, "Incorrect password.");
        }

        if ($row["membership"] !== "admin") {
            array_push($errors, "Only admins can login.");
        }
        
        if (count($errors) === 0) {
            unset($row["password"]);
            $_SESSION["user"] = $row;

            header("Location: ../home.php");
            exit;
        }
        
        return $errors;
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: login.php");

        exit;
    }
    
    public function change_password(string $old_password, string $new_password) {
        $errors = [];

        $member_id = $_SESSION['user']['member_id'];

        [$result, $row] = $this->getUser($member_id);

        if (!password_verify($old_password, $row["password"])) {
            array_push($errors, "Incorrect old password.");
        }

        if (count($errors) === 0) {
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            $sql_update = "UPDATE members SET password = ? WHERE member_id = ?";
            $stmt_update = mysqli_prepare($this->conn, $sql_update);
            mysqli_stmt_bind_param($stmt_update, "si", $hashed_new_password, $member_id);
            
            if (mysqli_stmt_execute($stmt_update)) {
                header("Location: home.php");
                exit;
            }
        }

        return $errors;
    }

    private function getUser(int $member_id) {
        $sql = "SELECT * FROM members WHERE member_id = $member_id";
        $result = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_assoc($result);

        return [$result, $row];
    }
}

$auth = new Auth($conn);