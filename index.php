<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>نظام تدبير استدعاءات الشهود</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>⚖️ نظام تدبير استدعاءات الشهود</h1>
        <p class="subtitle">المحكمة الابتدائية بسوق الأربعاء الغرب</p>
        <?php if (isset($_GET['success'])): ?>
            <p class="alert-success">✅ تم تسجيل البيانات بنجاح.</p>
        <?php endif; ?>

        <form action="save.php" method="POST" class="form-card">
            <h2>معلومات القضية</h2>

            <label>رقم الملف</label>
            <input type="text" name="num_dossier" placeholder="مثال: 2026/1502" required>

            <label>تاريخ القضية (تاريخ الجلسة)</label>
            <input type="date" name="date_affaire" required>

            <label>نوع القضية</label>
            <select name="type_affaire" required>
                <option value="">-- اختر --</option>
                <option value="قضية مدنية">قضية مدنية</option>
                <option value="قضية جنائية">قضية جنائية</option>
                <option value="قضية أسرية">قضية أسرية</option>
                <option value="قضية تجارية">قضية تجارية</option>
            </select>

            <label>رمز القضية</label>
            <input type="text" name="code_affaire" placeholder="مثال: C-2026-1502" required>

            <hr>
            <h2>معلومات الشاهد</h2>

            <label>الاسم الكامل</label>
            <input type="text" name="nom_complet" required>

            <label>العنوان</label>
            <input type="text" name="adresse" required>

            <button type="submit" class="btn btn-primary">💾 حفظ</button>
        </form>

        <div class="actions">
            <a href="filter.php" class="btn btn-print">🔍 تصفية ملفات المناقشة (اليوم)</a>
        </div>
    </div>
</body>

</html>