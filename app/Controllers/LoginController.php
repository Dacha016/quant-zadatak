<?php
/**
 * Form data
 *
 * PHP version 8
 *
 * @category Form
 * @package  FormValidation
 * @author   DaliborMarinkovic <dalibor.marinkovic@quantoxtechnology.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://github.com/Dacha016/quant-zadatak
 */
session_start();
require "../Config/Connection.php";
if (isset($_POST["username"]) && isset($_POST["password"])) {
    function validation($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $username = validation($_POST["username"]);
    $password = validation($_POST["password"]);
    if (empty($username)) {
        header("Location:index.php?error= Username is required");
        exit();
    } else if (empty($password)) {
        header("Location:index.php?error= Password is required");
        exit();
    } else {
        $sql= $sql = "SELECT username, email, role, password FROM user WHERE username = :username AND password = :password";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result["username"] === $username && $result["password"] === $password) {
            $_SESSION["username"] = $result["username"];
            $_SESSION["password"] = $result["password"];
            $_SESSION["id"] = $result["is"];
        }
    }

} else {
    header("Location:index.php");
    exit();
}
?>