<?php
session_start();

// Configuration de la base de données
$host = 'localhost';
$dbname = 'banking_app';
$username = 'root';
$password = '';

// Identifiants de test (à remplacer par une vraie base de données)
$valid_credentials = [
    '4521367894' => 'password123',
    '67890' => 'test456'
];

// Fonction de connexion sécurisée
function connectDatabase($host, $dbname, $username, $password) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        // En production, ne pas afficher les détails de l'erreur
        error_log("Erreur de connexion : " . $e->getMessage());
        return null;
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientNumber = filter_input(INPUT_POST, 'clientNumber', FILTER_SANITIZE_STRING);
    $remember = isset($_POST['remember']) ? true : false;
    
    // Validation
    if (empty($clientNumber)) {
        header('Location: index.html?error=empty');
        exit();
    }
    
    if (strlen($clientNumber) < 2 || strlen($clientNumber) > 10) {
        header('Location: index.html?error=invalid_length');
        exit();
    }
    
    // Vérification des identifiants (version simplifiée)
    // Dans un vrai système, vérifier contre une base de données avec mot de passe hashé
    if (isset($valid_credentials[$clientNumber])) {
        // Connexion réussie
        $_SESSION['client_number'] = $clientNumber;
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();
        
        // Redirection vers le dashboard
        header('Location: dashboard.html');
        exit();
    } else {
        // Identifiant invalide
        header('Location: index.html?error=invalid_credentials');
        exit();
    }
}

// Si accès direct au fichier PHP
header('Location: index.html');
exit();
?>
