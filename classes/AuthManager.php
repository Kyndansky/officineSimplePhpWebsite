<?php
require_once __DIR__ . "/DatabaseManager.php";
require_once __DIR__ . "/../config/config.php";
define('APP_NAMESPACE', '0239cc42-d5ff-480a-bf43-a8009e81212b');
class AuthManager
{

    public static function loginCustomer($email, $password): bool
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT password_hash FROM clienti WHERE email = ?");
        $stmt->bind_param("s", $email);
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

    public static function registerCustomer($password, $email, $name, $surname, $phone): bool
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $uuid = AuthManager::generate_uuid_v5(APP_NAMESPACE, $email . time());
        AuthManager::sendAccountVerificationEmail($email, $uuid);
        $stmt = $conn->prepare("INSERT INTO clienti (email, password_hash, nome, cognome, telefono, uuid) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $email, $hash, $name, $surname, $phone, $uuid);
        return $stmt->execute();
    }

    public static function customersEmailRegistered($email): bool
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT email FROM clienti WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public static function generate_uuid_v5($namespace, $name)
    {
        // 1. Convertiamo il namespace (che è un UUID) in binario
        $nhex = str_replace(array('-', '{', '}'), '', $namespace);
        $nstr = '';
        for ($i = 0; $i < strlen($nhex); $i += 2) {
            $nstr .= chr(hexdec($nhex[$i] . $nhex[$i + 1]));
        }

        // 2. Calcoliamo l'hash SHA-1 del namespace combinato con il nome
        $hash = sha1($nstr . $name);

        // 3. Formattiamo l'hash secondo le specifiche dell'UUID v5
        return sprintf(
            '%08s-%04s-%04x-%04x-%12s',
            substr($hash, 0, 8),
            substr($hash, 8, 4),
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000, // Imposta la versione a 5
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000, // Imposta la variante
            substr($hash, 20, 12)
        );
    }


    public static function sendAccountVerificationEmail($emailAddress, $uuid): bool
    {

        $url = "https://agora.ismonnet.it/sendMail/send.php";

        $data = [
            "mail_invio" => "esercizio-5binf@ismonnet.eu",
            "mail_destinazione" => $emailAddress,
            "oggetto" => "Account verification for officine",
            "body" => "Hello, this mail was sent automatically.<br>" .
                 "Press the following link to verify your email: <br>" .
                 "<a href='http://".Config::$domain."/api/auth/verifyCustomerEmail.php?uuid=" . $uuid . "&email=" . urlencode($emailAddress) . "'>Verify Account</a>"
        ];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo "Errore cURL: " . curl_error($ch);
            return false;
        } else {
            return true;
        }
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

    public static function getCustomerData($customerEmail)
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT email, nome, cognome, telefono FROM clienti WHERE email = ?");
        $stmt->bind_param("s", $customerEmail);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    public static function getDipendenteData($username)
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT username, ruolo FROM dipendenti WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function verifyCustomerEmailAddress($emailAddress, $uuid): bool
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("UPDATE clienti SET email_verified = 1 WHERE email = ? AND uuid = ?");
        $stmt->bind_param("ss", $emailAddress, $uuid);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public static function isCustomerEmailVerified($emailAddress): bool
    {
        $db = new DatabaseManager();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT email_verified FROM clienti WHERE email = ?");
        $stmt->bind_param("s", $emailAddress);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return (bool) $row['email_verified'];
        }

        return false;
    }
}