<nav class="navbar navbar-expand-md header_title mt-3 mb-3">
        <div class="container">
            <button
             class="navbar-toggler" 
             type="button" 
             data-bs-toggle="collapse" 
             data-bs-target="#mainmune">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainmune">
                <ul class="navbar-nav">
                    <li class="nav-item ms-3">
                        <a href="homePage.php" class="nav-link <?=$current_page =='homePage.php' ?
                        'active' : '' ?>">الرئيسية</a></li>
                    <li class="nav-item ms-3">
                        <a href="#contact" class="nav-link <?=$current_page =='contact.php' ?
                        'active' : '' ?>">اتصل بنا</a></li>
                    <li class="nav-item ms-3">
                        <a href="logout.php" class="nav-link <?=$current_page == 'logout.php' ?
                        'active' : '' ?>"> تسجيل الخروج </a></li>
                </ul>
            </div>
        </div>
    </nav>
    

        