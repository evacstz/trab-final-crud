<?php
    session_start();
    unset($_SESSION['iduser']);

    header("Location: pagina-login.php");
?>