<?php
ob_start();
session_start();

$pageTitle  = "الشكاوى والمقترحات";
$current_page = basename($_SERVER['PHP_SELF']);
include "includes/func/function.php";
include "includes/header.php";
include "includes/nav.php";
include "conect.php";

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$parts = [];
try {
    $stmt = $con->prepare("SELECT ID, Name FROM sections ORDER BY Name");
    $stmt->execute();
    $parts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $parts = [];
}
?>
<div class="page-head">
    <div class="container">
        <h2>تقديم شكوى جديدة</h2>
        <p>املأ البيانات التالية بدقة — الحقول المميزة <span class="req">*</span> مطلوبة</p>
    </div>
</div>

<div class="container">
    <form class="form-card" action="update.php" method="POST" novalidate>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
        <div class="mb-3">
            <label for="f-user" class="form-label">الاسم رباعي <span class="req">*</span></label>
            <input id="f-user" class="form-control" type="text" name="user" placeholder="مثال: محمد أحمد علي إبراهيم" autocomplete="name" minlength="11" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="f-email" class="form-label">البريد الإلكتروني (اختياري)</label>
                <input id="f-email" class="form-control" type="email" name="email" placeholder="example@email.com" autocomplete="email" dir="ltr">
            </div>
            <div class="col-md-6 mb-3">
                <label for="f-age" class="form-label">العمر <span class="req">*</span></label>
                <input id="f-age" class="form-control" type="number" name="age" placeholder="مثال: 30" min="18" max="120" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="f-phone" class="form-label">رقم الهاتف <span class="req">*</span></label>
            <input id="f-phone" class="form-control" type="tel" name="phone" pattern="^249[19][0-9]{8}$" placeholder="249xxxxxxxxx" autocomplete="tel" dir="ltr" required>
            <div class="form-text">بالصيغة الدولية بدون + : 249 ثم 9 أرقام تبدأ بـ 1 أو 9</div>
        </div>
        <div class="mb-3">
            <label for="f-sec" class="form-label">الفرع <span class="req">*</span></label>
            <select id="f-sec" name="sec" class="form-select" required>
                <option value="">— اختر الفرع —</option>
                <?php foreach ($parts as $part): ?>
                    <option value="<?php echo (int) $part['ID']; ?>"><?php echo htmlspecialchars($part['Name'], ENT_QUOTES, 'UTF-8'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="f-message" class="form-label">نص الشكوى <span class="req">*</span></label>
            <textarea id="f-message" class="form-control" name="message" rows="6" placeholder="اشرح شكواك أو مقترحك بوضوح (10 أحرف على الأقل)" minlength="10" required></textarea>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn-gov">إرسال الشكوى</button>
        </div>
        <p class="text-muted mt-3 mb-0 small">بتقديمك الشكوى سيصلك رقم متابعة — احتفظ به للاستعلام لاحقا من صفحة متابعة الشكوى.</p>
    </form>
</div>

<?php
include "includes/footer.php";
ob_end_flush();
?>
