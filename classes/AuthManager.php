<?php
require_once __DIR__ . "/DatabaseManager.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__.'/vendor/PHPMailer-master/src/Exception.php';
require __DIR__.'/vendor/PHPMailer-master/src/PHPMailer.php';
require __DIR__.'/vendor/PHPMailer-master/src/SMTP.php';

define('APP_NAMESPACE', '0239cc42-d5ff-480a-bf43-a8009e81212b');
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
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $uuid=AuthManager::generate_uuid_v5(APP_NAMESPACE, $email.time());
        // AuthManager::sendAccountVerificationEmail($email,$uuid);
        $stmt = $conn->prepare("INSERT INTO clienti (username, email, password_hash, nome, cognome, telefono, uuid) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $username, $email, $hash, $name, $surname, $phone, $uuid);
        return $stmt->execute();
    }

    public static function customersEmailRegistered($email):bool{
        $db = new DatabaseManager();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT email FROM clienti WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public static function customersUsernameRegistered($username):bool{
        $db = new DatabaseManager();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT username FROM clienti WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public static function generate_uuid_v5($namespace, $name) {
    // 1. Convertiamo il namespace (che è un UUID) in binario
    $nhex = str_replace(array('-','{','}'), '', $namespace);
    $nstr = '';
    for($i = 0; $i < strlen($nhex); $i+=2) {
        $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
    }

    // 2. Calcoliamo l'hash SHA-1 del namespace combinato con il nome
    $hash = sha1($nstr . $name);

    // 3. Formattiamo l'hash secondo le specifiche dell'UUID v5
    return sprintf('%08s-%04s-%04x-%04x-%12s',
        substr($hash, 0, 8),
        substr($hash, 8, 4),
        (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000, // Imposta la versione a 5
        (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000, // Imposta la variante
        substr($hash, 20, 12)
    );
}


public static function sendAccountVerificationEmail($emailAddress, $uuid):bool{

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'esercizio-5binf@ismonnet.eu';                     //SMTP username
    $mail->Password   = 'hjmr bcab tegm oshp';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('esercizio-5binf@ismonnet.eu', 'NoReply');
    $mail->addAddress($emailAddress);     //Add a recipient
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Account verification for officine';
    $mailBody='Hello, this mail was sent automatically to see if this works, uuid is the following: '.$uuid;
    $mail->Body    = $mailBody;
    $mail->AltBody = $mailBody;

    $mail->send();
    return true;
} catch (Exception $e) {
    return false;
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