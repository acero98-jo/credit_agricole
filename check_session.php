<?php
session_start();

// Vérifier si l'utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Vérifier le timeout de session (30 minutes)
function checkSessionTimeout() {
    $timeout = 1800; // 30 minutes en secondes
    
    if (isset($_SESSION['login_time'])) {
        $elapsed = time() - $_SESSION['login_time'];
        
        if ($elapsed > $timeout) {
            session_destroy();
            return false;
        }
        
        // Mettre à jour le temps de dernière activité
        $_SESSION['login_time'] = time();
    }
    
    return true;
}

// Protéger une page
function requireLogin() {
    if (!isLoggedIn() || !checkSessionTimeout()) {
        header('Location: index.html?error=session_expired');
        exit();
    }
}

// Déconnexion
function logout() {
    session_destroy();
    header('Location: index.html?message=logged_out');
    exit();
}
?>
