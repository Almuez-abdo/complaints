<?php
ob_start();
session_start();

$pageTitle  = "الرئيسية";
$current_page = basename($_SERVER['PHP_SELF']);
include "includes/func/function.php";
include "includes/header.php";
include "includes/nav.php";
include "conect.php";

$sec = [];
$secCount = 0;
$complaintCount = 0;
try {
    $stSec = $con->prepare("SELECT * FROM sections ORDER BY Name");
    $stSec->execute();
    $sec = $stSec->fetchAll(PDO::FETCH_ASSOC);
    $secCount = count($sec);
    $stC = $con->query("SELECT COUNT(*) AS c FROM information");
    $complaintCount = (int) $stC->fetch(PDO::FETCH_ASSOC)['c'];
} catch (PDOException $e) {
    $sec = [];
}
?>
    <section class="hero">
        <div class="container">
            <h2>الإدارة العامة للسجل المدني</h2>
            <p>بوابتك الرسمية لتقديم الشكاوى والمقترحات ومتابعتها — نخدمك بسرية واهتمام</p>
            <div class="hero-actions">
                <a href="help.php" class="btn btn-light">تقديم شكوى جديدة</a>
                <a href="follow.php" class="btn btn-outline-light">متابعة الشكوى برقمها</a>
            </div>
            <div class="hero-stats">
                <div><b><?php echo $secCount; ?>+</b><span>مركز خدمات</span></div>
                <div><b><?php echo $complaintCount; ?>+</b><span>شكوى مستلمة</span></div>
                <div><b>100%</b><span>سرية البيانات</span></div>
            </div>
        </div>
    </section>

    <div class="container">
        <h3 class="section-title">كيف تتبع شكواك؟</h3>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="step-card">
                    <span class="step-num">1</span>
                    <h5>قدّم شكواك</h5>
                    <p class="text-muted mb-0">املأ الاستمارة باسمك ورقم هاتفك واختر الفرع الأقرب إليك.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <span class="step-num">2</span>
                    <h5>احفظ رقم الشكوى</h5>
                    <p class="text-muted mb-0">ستحصل على رقم متابعة فوري — احتفظ به لمتابعة حالتك لاحقا.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <span class="step-num">3</span>
                    <h5>تابع الرد</h5>
                    <p class="text-muted mb-0">أدخل اسمك ورقم الشكوى في صفحة المتابعة لمعرفة حالة المعالجة.</p>
                </div>
            </div>
        </div>

        <div class="row home-grid">
            <div class="news col-lg-8 col-md-7">
                <h3 class="section-title">آخر الأخبار</h3>
                <article class="news-card">
                    <img src="layout/images/1.jpg" alt="صورة خبر" loading="lazy">
                    <div class="news-body">
                        <span class="news-date">أخبار الوزارة</span>
                        <h3 class="mainT">بابكر سمرة وزير الداخلية في "حكومة الأمل" السودانية</h3>
                        <p>
                            عين السيد كامل إدريس رئيس الوزراء السوداني الفريق شرطة بابكر سمرة وزيرا للداخلية في حكومته،
                            على أن يباشر مهامه مباشرة بعد أداء القسم.
                        </p>
                    </div>
                </article>
                <article class="news-card">
                    <img src="layout/images/2.webp" alt="صورة خبر" loading="lazy">
                    <div class="news-body">
                        <span class="news-date">خدمات الجمهور</span>
                        <h3 class="mainT">الشرطة السودانية تباشر أعمالها في الخرطوم</h3>
                        <p>
                            بدأت قوات الشرطة السودانية بكل كياناتها العمل داخل ولاية الخرطوم، ويقوم وزير الداخلية
                            بصيانة مجمعات خدمات الجمهور لتباشر أعمالها في أسرع وقت ممكن.
                        </p>
                    </div>
                </article>
            </div>
            <aside class="services col-lg-4 col-md-5">
                <div class="services-card mb-3">
                    <h3 class="mainT">مراكز خدمات الجمهور</h3>
                    <?php if ($sec): ?>
                    <ul>
                        <?php foreach ($sec as $one): ?>
                            <li><?php echo htmlspecialchars($one['Name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <p class="text-muted mb-0">تُعلن المراكز هنا قريبا.</p>
                    <?php endif; ?>
                </div>
                <div class="services-card">
                    <h3 class="mainT">روابط سريعة</h3>
                    <ul>
                        <li><a href="help.php">تقديم شكوى جديدة</a></li>
                        <li><a href="follow.php">متابعة الشكوى</a></li>
                        <li><a href="info.php">عن الإدارة والرقم الوطني</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>

<?php
include "includes/footer.php";
ob_end_flush();
?>
