<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isProdi() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'prodi';
}

function isDosen() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'dosen';
}

function isMahasiswa() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'mahasiswa';
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header('Location: /universitas_hulondalo/pages/login.php');
        exit();
    }
}

function redirectIfNotAdmin() {
    if (!isAdmin()) {
        header('Location: /universitas_hulondalo/index.php');
        exit();
    }
}

function redirectIfNotProdi() {
    if (!isProdi()) {
        header('Location: /universitas_hulondalo/index.php');
        exit();
    }
}

function redirectIfNotDosen() {
    if (!isDosen()) {
        header('Location: /universitas_hulondalo/index.php');
        exit();
    }
}

function redirectIfNotMahasiswa() {
    if (!isMahasiswa()) {
        header('Location: /universitas_hulondalo/index.php');
        exit();
    }
}
?>