<?php
require_once "config.php";

$temoin_id = $_GET["temoin_id"] ?? null;
if (!$temoin_id) { die("رقم الشاهد غير محدد."); }

$stmt = $pdo->prepare(
    "SELECT a.num_dossier, a.date_affaire, a.type_affaire, a.code_affaire,
            t.nom_complet, t.adresse
     FROM Temoins t
     JOIN Affaires a ON t.num_dossier = a.num_dossier
     WHERE t.num_temoin = ?"
);
$stmt->execute([$temoin_id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) { die("لم يتم العثور على بيانات الشاهد."); }

$date_jour = date("d/m/Y");
$date_affaire_fmt = date("d/m/Y", strtotime($data['date_affaire']));
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>أمر بإحضار شاهد - <?= htmlspecialchars($data['num_dossier']) ?></title>
<link rel="stylesheet" href="style.css">
</head>
<body class="print-body">
<div class="order-sheet">

    <div class="order-header">
        <p class="kingdom">المملكة المغربية</p>
        <p class="ministry">وزارة العدل</p>
        <p class="court">المحكمة الابتدائية بسوق الأربعاء الغرب</p>
        <hr>
        <p class="dossier-line">
            ملف عدد: <strong><?= htmlspecialchars($data['num_dossier']) ?></strong>
            &nbsp;|&nbsp;
            الرمز: <strong><?= htmlspecialchars($data['code_affaire']) ?></strong>
        </p>
    </div>

    <h1 class="order-title">أمر بإحضار شاهد</h1>

    <div class="order-body">
        <p>
            بناءً على مقتضيات قانون المسطرة المدنية / الجنائية، وحيث إن القضية عدد
            <strong><?= htmlspecialchars($data['num_dossier']) ?></strong>
            من نوع <strong><?= htmlspecialchars($data['type_affaire']) ?></strong>
            محددة للنظر فيها بتاريخ <strong><?= $date_affaire_fmt ?></strong>؛
        </p>

        <p>
            فإنه يُؤمر السيد(ة):
            <strong class="highlight"><?= htmlspecialchars($data['nom_complet']) ?></strong>،
            الساكن(ة) بـ: <strong><?= htmlspecialchars($data['adresse']) ?></strong>،
        </p>

        <p>
            بالحضور شخصياً أمام هذه المحكمة الابتدائية بصفته شاهداً في القضية المذكورة أعلاه،
            وذلك تحت طائلة الجزاءات القانونية المترتبة عن التخلف عن الحضور دون عذر مقبول.
        </p>
    </div>

    <div class="order-footer">
        <p>حرر بسوق الأربعاء الغرب في: <?= $date_jour ?></p>
        <div class="signature">
            <p>توقيع كتابة الضبط</p>
            <div class="sign-box"></div>
        </div>
    </div>

</div>

<div class="no-print" style="text-align:center; margin-top:20px;">
    <button onclick="window.print()" class="btn btn-print">🖨️ طباعة</button>
    <a href="filter.php" class="btn btn-secondary">⬅ العودة</a>
</div>

</body>
</html>
