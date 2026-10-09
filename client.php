<?php
ob_start();
session_start();

$pageTitle  = "متابعة الشكوى";
$current_page = basename($_SERVER['PHP_SELF']);
include "includes/func/function.php";
include "includes/header.php";
include "includes/nav.php";
include "conect.php";

if (empty($_SESSION['userName']) || empty($_SESSION['ID'])) {
    header('Location: follow.php');
    exit();
}

$name = (string) $_SESSION['userName'];
$code = (int) $_SESSION['ID'];

$stFollow = $con->prepare("SELECT i.*, s.Name AS section_name
                           FROM information i
                           INNER JOIN sections s ON s.ID = i.Section_Id
                           WHERE i.ID_Complaints = ? AND i.P_Name = ?");
$stFollow->execute([$code, $name]);
$fol = $stFollow->fetch(PDO::FETCH_ASSOC);

if (!$fol) {
    echo '<div class="container my-4"><div class="alert alert-danger">لم يتم العثور على الشكوى</div></div>';
    include "includes/footer.php";
    ob_end_flush();
    exit();
}

$done = ((int) $fol['State']) === 1;
function esc($v) { return htmlspecialchars((string) ($v ?? ''), ENT_QUOTES, 'UTF-8'); }
?>
<div class="page-head">
    <div class="container">
        <h2>متابعة الشكوى رقم <?php echo $code; ?></h2>
        <p>تفاصيل الشكوى وحالة المعالجة أولا بأول</p>
    </div>
</div>

<div class="container" style="max-width:820px">
    <div class="card-pro p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <h4 class="mb-0">بطاقة الشكوى</h4>
            <?php if ($done): ?>
                <span class="badge bg-success badge-state">تمت المعالجة</span>
            <?php else: ?>
                <span class="badge bg-warning text-dark badge-state">قيد المعالجة</span>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-md-6 mb-2"><b>الاسم:</b> <?php echo esc($fol['P_Name']); ?></div>
            <div class="col-md-6 mb-2"><b>العمر:</b> <?php echo esc($fol['P_Age']); ?></div>
            <div class="col-md-6 mb-2"><b>رقم الهاتف:</b> <span dir="ltr"><?php echo esc($fol['P_PHone']); ?></span></div>
            <div class="col-md-6 mb-2"><b>الفرع:</b> <?php echo esc($fol['section_name']); ?></div>
            <div class="col-md-6 mb-2"><b>تاريخ التقديم:</b> <?php echo esc($fol['Date']); ?></div>
            <div class="col-md-6 mb-2"><b>نص الشكوى:</b> <?php echo esc($fol['Complaint_Area']); ?></div>
        </div>
    </div>

    <div class="card-pro p-4 mb-4">
        <h4 class="mb-3">مسار المعالجة</h4>
        <ul class="timeline">
            <li class="done"><b>تم الاستلام</b><small><?php echo esc($fol['Date']); ?> — وصلت شكواك للإدارة بنجاح</small></li>
            <li class="<?php echo $done ? 'done' : 'now'; ?>"><b>قيد المعالجة</b><small>فريق الإدارة يراجع الشكوى حاليا</small></li>
            <li class="<?php echo $done ? 'done' : ''; ?>"><b>تم الرد</b><small><?php echo $done ? 'اكتملت معالجة شكواك' : 'سيظهر الرد هنا فور اكتماله'; ?></small></li>
        </ul>
    </div>

    <a href="index.php" class="btn-gov text-decoration-none d-inline-block mb-4">العودة للرئيسية</a>
</div>

<?php
include "includes/footer.php";
ob_end_flush();
?>
