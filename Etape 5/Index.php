<?php
require("Connexion.php");

$dbname = "ciec2024"; // Nom de la base de données

// Sélectionner la base de données
$conn->select_db($dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['submit']) && $_POST['submit'] != "") {
    // Préparation de la chaîne de caractère pour éviter les attaques XSS
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

    // Préparation de la requête SQL pour éviter les injections SQL
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password = hash('sha256', $password);

        if ($password == $row["password"]) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: Accueil.php");
            exit();
        } else {
            $msg = "Mot de passe incorrect.";
        }
    } elseif ($result->num_rows == 0) {
        $msg = "Utilisateur introuvable.";
    } else {
        $msg = "Erreur....";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Connexion au championnat</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <section class="vh-100" style="background-color: #9A616D;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form method="post" action="">
                                        
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
                                            <span class="h1 fw-bold mb-0">Bienvenue au CIEC</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Connectez-vous au Championnat</h5>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="username">Nom d'Utlilisateur : </label>
                                            <input type="text" id="username" name="username" class="form-control form-control-lg" required pattern="[A-Za-z0-9\s]+" title="Veuillez entrer uniquement des lettres et des chiffres, sans caractères spéciaux." />
                                        </div>
                                        
                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="password">Mot de passe : </label>    
                                            <input type="password" id="password" name="password" class="form-control form-control-lg" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).{8,}" title="Le mot de passe doit contenir au moins 8 caractères, incluant une majuscule, une minuscule, un chiffre et un caractère spécial (@#$%^&+=)" />
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <input data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-lg btn-block" type="submit" name="submit" value="Se connecter">
                                        </div>

                                        <?php if(isset($msg)) { echo "<p style='color: #ff0000;'>".$msg."</p>"; } ?>
                                        <a class="small text-muted" href="#!">Mot de passe oublié ?</a>
                                        <p class="mb-5 pb-lg-2" style="color: #393f81;">Vous n'êtes pas administarteur ? <a href="#!" style="color: #393f81;">Voir les classements</a></p>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>