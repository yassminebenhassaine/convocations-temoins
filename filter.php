<?php
require_once "config.php";

$all  = isset($_GET["all"]);
$date = $_GET["date"] ?? date("Y-m-d");

$sql = "SELECT a.num_dossier, a.date_affaire, a.type_affaire, a.code_affaire,
               t.num_temoin, t.nom_complet, t.adresse
        FROM Affaires a
        JOIN Temoins t ON a.num_dossier = t.num_dossier";

if ($all) {
    $stmt = $pdo->prepare($sql . " ORDER BY a.date_affaire DESC, a.num_dossier");
    $stmt->execute();
} else {
    $stmt = $pdo->prepare($sql . " WHERE a.date_affaire = ? ORDER BY a.num_dossier");
    $stmt->execute([$date]);
}
$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>ملفات المناقشة</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>📋 ملفات المناقشة</h1>
        <a href="index.php" class="btn btn-secondary">⬅ العودة للنموذج</a>

        <form method="GET" style="margin-top:16px; display:flex; gap:8px; align-items:center;">
            <input type="date" name="date" value="<?= htmlspecialchars($date) ?>">
            <button type="submit" class="btn btn-primary" style="width:auto; margin:0;">🔍 تصفية</button>
            <a href="filter.php?all=1" class="btn btn-secondary" style="margin:0;">عرض الكل</a>
        </form>

        <p class="subtitle" style="margin-top:12px;">
            <?= $all ? "جميع القضايا" : "قضايا يوم " . date("d/m/Y", strtotime($date)) ?>
        </p>

        <?php if (count($resultats) === 0): ?>
            <p class="empty">لا توجد قضايا مبرمجة لهذا التاريخ.</p>
        <?php else: ?>
            <table class="result-table">
                <tr>
                    <th>رقم الملف</th>
                    <th>التاريخ</th>
                    <th>نوع القضية</th>
                    <th>رمز القضية</th>
                    <th>الشاهد</th>
                    <th>العنوان</th>
                    <th>إجراء</th>
                </tr>
                <?php foreach ($resultats as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['num_dossier']) ?></td>
                        <td><?= date("d/m/Y", strtotime($row['date_affaire'])) ?></td>
                        <td><?= htmlspecialchars($row['type_affaire']) ?></td>
                        <td><?= htmlspecialchars($row['code_affaire']) ?></td>
                        <td><?= htmlspecialchars($row['nom_complet']) ?></td>
                        <td><?= htmlspecialchars($row['adresse']) ?></td>
                        <td>
                            <a class="btn btn-print"
                                href="print_order.php?temoin_id=<?= $row['num_temoin'] ?>"
                                target="_blank">🖨️ طباعة أمر الإحضار</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>