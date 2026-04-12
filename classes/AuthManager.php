<?php
require_once __DIR__ . "/DatabaseManager.php";

class AuthManager
{

    public static function loginCustomer($username, $password): bool
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT password_hash FROM clienti WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            return password_verify($password, $row['password_hash']);
        }
        return false;
    }

    public static function loginDipendente($username, $password): bool
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT password_hash FROM dipendenti WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            return password_verify($password, $row['password_hash']);
        }
        return false;
    }

    public static function registerCustomer($username, $password, $email, $name, $surname, $phone): bool
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT username FROM clienti WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0)
            return false;

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO clienti (username, email, password_hash, nome, cognome, telefono) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $email, $hash, $name, $surname, $phone);
        return $stmt->execute();
    }

    public static function registerDipendente($username, $password, $role): bool
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT username FROM dipendenti WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0)
            return false;

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO dipendenti (username, password_hash, ruolo) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hash, $role);
        return $stmt->execute();
    }

    public static function getCustomerData($customerUsername)
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT username, email, nome, cognome, telefono FROM clienti WHERE username = ?");
        $stmt->bind_param("s", $customerUsername);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // public static function getDipendenteData($username){
    //     return ["username"=>$username, "role"=>"admin"];
    // }

    public static function getDipendenteData($username)
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT username, ruolo FROM dipendenti WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}