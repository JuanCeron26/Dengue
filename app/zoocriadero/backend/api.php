<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['cerrar_sesion'])) {
        session_destroy();
        $_SESSION = [];
        header("Content-Type: text/html; charset=utf-8");
        echo "<script>window.location.replace('../../login')</script>";
    }
}
