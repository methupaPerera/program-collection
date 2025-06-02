<?php

include_once("db.php");
include_once("utils.php");

class Member {
    private $conn; // SQL connection variable.

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getMemberData() {
        $sql = "SELECT * FROM members ORDER BY member_id DESC LIMIT 10";

        return mysqli_query($this->conn, $sql);
    }

    public function addNewMember(string $fullName, string $address, string $phone) {
        $sql = "INSERT INTO members (fullName, address, phone) VALUES ('$fullName', '$address', '$phone')";

        if (!mysqli_query($this->conn, $sql)) {
            echo "Something went wrong.";
        }
    }

    public function updateMember(int $member_id, string $fullName, string $address, string $phone) {
        $sql = "UPDATE members SET fullName='$fullName', address='$address', phone='$phone' WHERE member_id=$member_id";

        if (!mysqli_query($this->conn, $sql)) {
            echo "Something went wrong.";
        }
    }

    public function deleteMember(int $member_id) {
        $sql = "DELETE FROM members WHERE member_id = $member_id";

        if (!mysqli_query($this->conn, $sql)) {
            echo "Something went wrong.";
        }
    }

    public function handleSearch(int | string $search) {
        if (startsWith($search, "0")) {
            $sql = "SELECT * FROM members WHERE phone LIKE '$search%'";
            return mysqli_query($this->conn, $sql);
        } else {
            $search = (int) $search;
    
            $sql = "SELECT * FROM members WHERE member_id = $search";
            return mysqli_query($this->conn, $sql);
        }
    }
}

$member = new Member($conn);