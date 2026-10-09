<?php
ob_start();
session_start();

$pageTitle  = "متابعة الشكوى";
$current_page = basename($_SERVER['PHP_SELF']);
include "includes/func/function.php";
include "includes/header.php";
include "includes/nav.php";
include "conect.php";

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$maxAttempt  = 3;
$lockoutTime = 3600;
if (!isset($_SESSION['attempt'])) {
    $_SESSION['attempt'] = 0;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], (string) ($_POST['csrf_token'] ?? ''))) {
        $theMsg = '<div class="alert alert-danger">انتهت صلاحية الجلسة — أعد المحاولة</div>';
    } elseif (isset($_SESSION['lockouts']) && time() < $_SESSION['lockouts']) {
        $remaining = $_SESSION['lockouts'] - time();
        $theMsg = '<div class="alert alert-warning">تجاوزت عدد المحاولات — حاول بعد ' . floor($remaining / 60) . ' دقيقة</div>';
    } else {
        $name = trim(strip_tags((string) ($_POST['user'] ?? '')));
        $code = (int) preg_replace('/\D+/', '', (string) ($_POST['code'] ?? ''));

        $stFollow = $con->prepare("SELECT information.* FROM information WHERE ID_Complaints = ? AND P_Name = ?");
        $stFollow->execute([$code, $name]);
        $found = $stFollow->fetch(PDO::FETCH_ASSOC);

        if ($found && $_SESSION['attempt'] < $maxAttempt) {
            $_SESSION['attempt'] = 0;
            $_SESSION['userName'] = $name;
            $_SESSION['ID'] = $code;
            header('Location: client.php');
            exit();
        }

        $_SESSION['attempt']++;
        if ($_SESSION['attempt'] >= $maxAttempt) {
            $_SESSION['lockouts'] = time() + $lockoutTime;
            $theMsg = '<div class="alert alert-danger">تجاوزت العدد المحدد للمحاولات — يجب المحاولة بعد ساعة</div>';
        } else {
            $remaining = $maxAttempt - $_SESSION['attempt'];
            $theMsg = '<div class="alert alert-danger">اسم المستخدم أو رقم الشكوى غير صحيح — تبقت لك ' . $remaining . ' محاولات</div>';
        }
    }
    if (isset($theMsg)) {
        echo '<div class="container mt-3" style="max-width:680px">' . $theMsg . '</div>';
    }
}
?>
<div class="page-head">
    <div class="container">
        <h2>متابعة الشكوى</h2>
        <p>أدخل اسمك الرباعي ورقم المتابعة الذي حصلت عليه عند التقديم</p>
    </div>
</div>

<div class="container">
    <form class="form-card" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
        <div class="mb-3">
            <label for="f-user" class="form-label">الاسم رباعي <span class="req">*</span></label>
            <input id="f-user" class="form-control" type="text" name="user" placeholder="الاسم كما كتبته عند التقديم" autocomplete="name" required>
        </div>
        <div class="mb-3">
            <label for="f-code" class="form-label">رقم الشكوى <span class="req">*</span></label>
            <input id="f-code" class="form-control" type="text" name="code" pattern="^\d+$" placeholder="مثال: 125" inputmode="numeric" dir="ltr" required>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn-gov">متابعة</button>
        </div>
    </form>
</div>

<?php
include "includes/footer.php";
ob_end_flush();
?>
