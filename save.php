<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $num_dossier  = trim($_POST["num_dossier"]);
    $date_affaire = trim($_POST["date_affaire"]);
    $type_affaire = trim($_POST["type_affaire"]);
    $code_affaire = trim($_POST["code_affaire"]);
    $nom_complet  = trim($_POST["nom_complet"]);
    $adresse      = trim($_POST["adresse"]);

    try {
        $check = $pdo->prepare("SELECT num_dossier FROM Affaires WHERE num_dossier = ?");
        $check->execute([$num_dossier]);

        if ($check->rowCount() === 0) {
            $stmt = $pdo->prepare(
                "INSERT INTO Affaires (num_dossier, date_affaire, type_affaire, code_affaire)
                 VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([$num_dossier, $date_affaire, $type_affaire, $code_affaire]);
        }

        $stmt2 = $pdo->prepare(
            "INSERT INTO Temoins (nom_complet, adresse, num_dossier) VALUES (?, ?, ?)"
        );
        $stmt2->execute([$nom_complet, $adresse, $num_dossier]);

        header("Location: index.php?success=1");
        exit;
    } catch (PDOException $e) {
        die("خطأ أثناء الحفظ: " . $e->getMessage());
    }
}
?>
