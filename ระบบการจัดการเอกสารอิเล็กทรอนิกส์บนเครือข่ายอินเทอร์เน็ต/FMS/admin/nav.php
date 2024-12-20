        <!--========== HEADER ==========-->
        <header class="header">
            <div class="header__container">
            <a href="#" class="header__logo">ระบบการจัดเก็บเอกสารอิเล็กทรอนิกส์</a>
                <a href="#" class="header__logo">Welcome : <?php echo ucwords(htmlentities($m_username)); ?></a>
                <div class="header__toggle">
                    <i class='bx bx-menu' id="header-toggle"></i>
                </div>
            </div>
        </header>

        <!--========== NAV ==========-->
        <div class="nav" id="navbar">
            <nav class="nav__container">
                <div>
                    <a href="#" class="nav__link nav__logo">
                        <i class='bx bx-file nav__icon' ></i>
                        <span class="nav__logo-name">E-Document</span>
                    </a>
    
                    <div class="nav__list">
                        <div class="nav__items">
                            <h3 class="nav__subtitle">DashBoard</h3>
    
                            <a href="index.php" class="nav__link active">
                                <i class='bx bxs-dashboard nav__icon' ></i>
                                <span class="nav__name">Home</span>
                            </a>
                            <a href="adduser.php" class="nav__link">
                                <i class='bx bx-user nav__icon' ></i>
                                <span class="nav__name">Account</span>
                            </a>

                            <a href="file.php" class="nav__link">
                                <i class='bx bx-file-find nav__icon' ></i>
                                <span class="nav__name">File</span>
                            </a>
                        </div>
    
                        <div class="nav__items">
                            <h3 class="nav__subtitle">Logs</h3>
    
                            <!-- <a href="History_log.php" class="nav__link">
                                <i class='bx bx-compass nav__icon' ></i>
                                <span class="nav__name">Explore</span>
                            </a> -->

                            <a href="History_log.php" class="nav__link">
                                <i class='bx bxs-dock-top nav__icon'></i>
                                <span class="nav__name">Authen Log</span>
                            </a>
                            <a href="file_log.php" class="nav__link">
                                <i class='bx bxs-file-pdf nav__icon' ></i>
                                <span class="nav__name">File Log</span>
                            </a>

                            <a href="add_log.php" class="nav__link">
                                <i class='bx bxs-user-rectangle nav__icon' ></i>
                                <span class="nav__name">management Log</span>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="..\Authen\logout.php" class="nav__link nav__logout">
                    <i class='bx bx-log-out nav__icon' ></i>
                    <span class="nav__name">Log Out</span>
                </a>
            </nav>
        </div>