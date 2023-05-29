<?php
    // Controlla che ilclogin sia già stato effettuato
    require_once 'dbconfig.php';
    session_start();

    function checkAuth() {
        // Restituisce la sessione se esiste
        if(isset($_SESSION['_agora_user_id'])) {
            return $_SESSION['_agora_user_id'];
        } else 
            return 0;
    }
?>