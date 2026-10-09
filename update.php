<?php
ob_start();
session_start();

$pageTitle = "إرسال الشكوى";
include "includes/func/function.php";
include "includes/header.php";
include "includes/nav.php";
include "conect.php";

echo '<div class="container my-4" style="max-width:680px">';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectHome('<div class="alert alert-danger">لا يمكن الدخول إلى هذه الصفحة مباشرة</div>', 4);
}

// CSRF
if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], (string) $_POST['csrf_token'])) {
    redirectHome('<div class="alert alert-danger">انتهت صلاحية الجلسة — أعد تعبئة الاستمارة</div>', 4, 'help.php');
}

// Sanitize (PHP 8.1+ safe — no deprecated filters)
$name    = trim(strip_tags((string) ($_POST['user'] ?? '')));
$emailIn = trim((string) ($_POST['email'] ?? ''));
$age     = (int) ($_POST['age'] ?? 0);
$phone   = preg_replace('/\D+/', '', (string) ($_POST['phone'] ?? ''));
$section = (int) ($_POST['sec'] ?? 0);
$mess    = trim(strip_tags((string) ($_POST['message'] ?? '')));

$formError = [];
if (mb_strlen($name, 'UTF-8') < 11) {
    $formError[] = 'الاسم يجب ألا يقل عن <strong>11 حرفا</strong> (الاسم رباعي)';
}
if (!preg_match("/^[\p{L}\s]+$/u", $name)) {
    $formError[] = 'الاسم يجب أن يحتوي على أحرف فقط';
}
$email = null;
if ($emailIn !== '') {
    $email = filter_var($emailIn, FILTER_VALIDATE_EMAIL);
    if ($email === false) {
        $formError[] = 'البريد الإلكتروني غير صحيح';
    }
}
if ($age < 18 || $age > 120) {
    $formError[] = 'يجب أن يكون العمر بين <strong>18 و 120 سنة</strong>';
}
if (!preg_match('/^249[19][0-9]{8}$/', $phone)) {
    $formError[] = 'رقم الهاتف غير صحيح (مثال: 2499xxxxxxxx)';
}
try {
    $stS = $con->prepare("SELECT ID FROM sections WHERE ID = ?");
    $stS->execute([$section]);
    if (!$stS->fetch()) {
        $formError[] = 'الفرع المختار غير موجود';
    }
} catch (PDOException $e) {
    $formError[] = 'تعذر التحقق من الفرع — حاول لاحقا';
}
if (mb_strlen($mess, 'UTF-8') < 10) {
    $formError[] = 'نص الشكوى قصير جدا (10 أحرف على الأقل)';
}

if (!empty($formError)) {
    foreach ($formError as $error) {
        echo '<div class="alert alert-danger">' . $error . '</div>';
    }
    echo '<a href="help.php" class="btn-gov text-decoration-none d-inline-block">العودة للاستمارة</a>';
} else {
    $stmt = $con->prepare("INSERT INTO information (P_Name, P_Email, P_Age, P_PHone, Section_Id, Complaint_Area, Date, State)
                           VALUES (:zname, :zmail, :zage, :zphone, :zsec, :zarea, NOW(), 0)");
    $stmt->execute([
        'zname'  => $name,
        'zmail'  => $email,
        'zage'   => $age,
        'zphone' => $phone,
        'zsec'   => $section,
        'zarea'  => $mess,
    ]);
    $code = (int) $con->lastInsertId();
    unset($_SESSION['csrf_token']);
    $theMsg = '<div class="alert alert-success">تم رفع شكواك بنجاح — رقم المتابعة الخاص بك هو <strong>' . $code . '</strong><br>احتفظ بهذا الرقم مع اسمك لمتابعة الشكوى لاحقا.</div>';
    redirectHome($theMsg, 8, 'follow.php');
}

echo '</div>';

include "includes/footer.php";
ob_end_flush();
?>
