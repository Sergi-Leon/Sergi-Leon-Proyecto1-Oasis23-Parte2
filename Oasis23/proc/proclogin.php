<?php
session_start();
include 'conexion.php';

if (!isset($_POST['login'])) {
    header('Location: ../login.php');
} else {
    $user = $_POST['user'];
    $pwd = $_POST['pwd'];

    try {
        // Consulta SQL para seleccionar el nombre de usuario y la contraseña hash de la base de datos
        $sql = $conn->prepare("SELECT id_camarero, username_camarero, pwd_camarero FROM tbl_camareros WHERE username_camarero = :user");
        $sql->bindParam(":user", $user);
        $sql->execute();
        $result = $sql->fetch();

        if ($result) {
            $pwd2_encript = $result['pwd_camarero'];

            // Verificar la contraseña utilizando password_verify
            if (password_verify($pwd, $pwd2_encript)) {
                $_SESSION['user'] = $result['id_camarero'];
                $_SESSION['username'] = $result['username_camarero'];
                header('Location: ../index.php');
            } else {
                header('Location: ../login.php?fallo=0');
            }
        } else {
            header('Location: ../login.php?fallo=0');
        }
    } catch (PDOException $e) {
        // Manejar errores de PDO
        echo "Error: " . $e->getMessage();
    }
    // Cerrar la conexión
    $conn = null;
}
?>
