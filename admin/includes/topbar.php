<header class="top-bar">
    <!-- -----breadcrumb--- -->
    <ol class="breadcrumb">
        <!-- <li class="breadcrumb-item"><a href="">User Portal</a></li> -->
        <li class="breadcrumb-item active" aria-current="page"><a href="">Admin Portal</a></li>
    </ol>

    <!-- topbar-navigation  -->
    <nav class="top-bar-nav">
        <button type="button" class="theme-toggle-btn" aria-label="Toggle theme">
            <i id="lights" class="bx bx-moon"></i>
        </button>

        <!-- notifications -->
        <div class="notifications">
            <button class="notification-btn" aria-label="View notifications" type="button">
                <i class="bx bxs-bell"></i>
                <span class="badge">4</span>
            </button>

            <div class="alerts-panel" hidden>
                <header>ALERTS CENTER</header>
                <ul class="alerts-list">
                    <li class="alert">
                        <i class="bx bx-file blue"></i>
                        <div>
                            <time datetime="2019-12-12">December 12, 2019</time>
                            <p>A new monthly report is ready to download!</p>
                        </div>
                    </li>
                    <li class="alert">
                        <i class="bx bx-user green"></i>
                        <div>
                            <time datetime="2019-12-07">December 7, 2019</time>
                            <p>$290.29 has been deposited into your account!</p>
                        </div>
                    </li>
                    <li class="alert">
                        <i class="bx bx-error yellow"></i>
                        <div>
                            <time datetime="2019-12-02">December 2, 2019</time>
                            <p>Spending Alert: We've noticed unusually high spending for your account.</p>
                        </div>
                    </li>
                </ul>
                <button class="show-all" type="button">Show All Alerts</button>
            </div>
        </div>

        <div class="user-profile">
            <button type="button" class="user-profile-btn">
                <span class="avatar">M</span>
                <div class="user-info">
                    <!-- <span>Farida Mutwa</span> -->
                    <span><?php echo $obj->first_name, ' ',  $obj->last_name; ?></span>
                    <!-- <h1> Welcome  </h1> -->
                    <!-- <span>Admin for KPLC LTD</span> -->
                    <span><?php echo $obj->role, ' '; ?> for KPLC LTD</span>
                </div>
                <i class="bx bx-chevron-down"></i>
            </button>

            <ul class="user-profile-dropdown" hidden>
                <li><a href="profile_details.php"><i class="bx bx-user"></i>Profile</a></li>
                <li><a href="#activity"><i class="bx bx-history"></i>Activity Log</a></li>
                <li><a href="log_out.php"><i class="bx bx-log-out"></i>Logout</a></li>
            </ul>
        </div>
    </nav>
</header>