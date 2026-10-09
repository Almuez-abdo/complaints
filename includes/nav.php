<?php
// includes/nav.php - القائمة الرئيسية
$nav_page = basename($_SERVER['PHP_SELF']);
function navActive($f){ global $nav_page; return $nav_page === $f ? 'active' : ''; }
?>
<nav class="navbar navbar-expand-md pro-nav sticky-top">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainmenu" aria-label="القائمة">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainmenu">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="index.php" class="nav-link <?php echo navActive('index.php'); ?>">الرئيسية</a></li>
                <li class="nav-item"><a href="help.php" class="nav-link <?php echo navActive('help.php'); ?>">الشكاوى والمقترحات</a></li>
                <li class="nav-item"><a href="info.php" class="nav-link <?php echo navActive('info.php'); ?>">عن الإدارة</a></li>
                <li class="nav-item"><a href="#contact" class="nav-link">اتصل بنا</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="follow.php" class="btn-follow nav-link <?php echo navActive('follow.php'); ?>">متابعة الشكوى</a></li>
            </ul>
        </div>
    </div>
</nav>
