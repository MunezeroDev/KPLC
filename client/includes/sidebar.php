<aside class="sidebar">

    <!-- Header Section -->
    <header class="sidebar-header">
        <div class="logo-wrapper">
            <span class="image">
                <?php
                $base_url = '/KPLC_1/';
                ?>
                <img src="<?php echo $base_url; ?>assets/Images/logo.svg" alt="">
            </span>

            <div class="brand">
                <span class="name">KPLC</span>
                <span class="slogan">Power Effeciency</span>
            </div>
        </div>

        <button id="toggle-sidebar">
            <i class="bx bx-chevron-right toggle"></i>
        </button>
    </header>

    <!-- navigation section  -->
    <nav class="sidebar-nav">
        <ul class="sidebar-top-menu">

            <li class="nav-item">
                <a href="../client/user_dashboard.php" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                        <path
                            d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z" />
                    </svg>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <div class="drop-item">
                    <a href="new_connection.php" class="nav-link dropmenu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                            <path
                                d="M300-360h60v-160h-60v50h-60v60h60v50Zm100-50h320v-60H400v60Zm200-110h60v-50h60v-60h-60v-50h-60v160Zm-360-50h320v-60H240v60Zm80 450v-80H160q-33 0-56.5-23.5T80-280v-480q0-33 23.5-56.5T160-840h640q33 0 56.5 23.5T880-760v480q0 33-23.5 56.5T800-200H640v80H320ZM160-280h640v-480H160v480Zm0 0v-480 480Z" />
                        </svg>
                        <span class="text">Services</span>
                    </a>
                    <button class="drop-submenu-button">
                        <i class="bx bx-chevron-right drop-submenu-icon"></i>
                    </button>
                </div>

                <ul class="sub-menu">
                    <li> <a href="new_connection.php" class="sub-menu-link">New Connection</a></li>
                    <li> <a href="connection_view.php" class="sub-menu-link">Connections</a></li>
                    <!-- <li> <a href="" class="sub-menu-link">Cancel Connections </a> </li> -->
                </ul>
            </li>

            <li class="nav-item">
                <div class="drop-item">
                    <a href="" class="nav-link dropmenu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                            <path
                                d="M400-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM80-160v-112q0-33 17-62t47-44q51-26 115-44t141-18h14q6 0 12 2-8 18-13.5 37.5T404-360h-4q-71 0-127.5 18T180-306q-9 5-14.5 14t-5.5 20v32h252q6 21 16 41.5t22 38.5H80Zm560 40-12-60q-12-5-22.5-10.5T584-204l-58 18-40-68 46-40q-2-14-2-26t2-26l-46-40 40-68 58 18q11-8 21.5-13.5T628-460l12-60h80l12 60q12 5 22.5 11t21.5 15l58-20 40 70-46 40q2 12 2 25t-2 25l46 40-40 68-58-18q-11 8-21.5 13.5T732-180l-12 60h-80Zm40-120q33 0 56.5-23.5T760-320q0-33-23.5-56.5T680-400q-33 0-56.5 23.5T600-320q0 33 23.5 56.5T680-240ZM400-560q33 0 56.5-23.5T480-640q0-33-23.5-56.5T400-720q-33 0-56.5 23.5T320-640q0 33 23.5 56.5T400-560Zm0-80Zm12 400Z" />
                        </svg>
                        <span class="text">Faults</span>
                    </a>
                    <button class="drop-submenu-button">
                        <i class="bx bx-chevron-right drop-submenu-icon"></i>
                    </button>
                </div>

                <ul class="sub-menu">
                    <li> <a href="report_fault.php" class="sub-menu-link">Report Fault </a> </li>
                    <li> <a href="report_outage.php" class="sub-menu-link">Report Outage</a></li>
                    <li> <a href="outage_history.php" class="sub-menu-link">Reports History</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <div class="drop-item">
                    <a href="report-fraud.php" class="nav-link dropmenu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                            <path
                                d="M400-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM80-160v-112q0-33 17-62t47-44q51-26 115-44t141-18h14q6 0 12 2-8 18-13.5 37.5T404-360h-4q-71 0-127.5 18T180-306q-9 5-14.5 14t-5.5 20v32h252q6 21 16 41.5t22 38.5H80Zm560 40-12-60q-12-5-22.5-10.5T584-204l-58 18-40-68 46-40q-2-14-2-26t2-26l-46-40 40-68 58 18q11-8 21.5-13.5T628-460l12-60h80l12 60q12 5 22.5 11t21.5 15l58-20 40 70-46 40q2 12 2 25t-2 25l46 40-40 68-58-18q-11 8-21.5 13.5T732-180l-12 60h-80Zm40-120q33 0 56.5-23.5T760-320q0-33-23.5-56.5T680-400q-33 0-56.5 23.5T600-320q0 33 23.5 56.5T680-240ZM400-560q33 0 56.5-23.5T480-640q0-33-23.5-56.5T400-720q-33 0-56.5 23.5T320-640q0 33 23.5 56.5T400-560Zm0-80Zm12 400Z" />
                        </svg>
                        <span class="text">Fraud</span>
                    </a>
                    <button class="drop-submenu-button">
                        <i class="bx bx-chevron-right drop-submenu-icon"></i>
                    </button>
                </div>

                <ul class="sub-menu">
                    <li> <a href="report-fraud.php" class="sub-menu-link">Report Fraud </a> </li>
                    <li> <a href="fraud_history.php" class="sub-menu-link">Fraud History</a></li>
                </ul>
            </li>


            <li class="nav-item">
                <a href="profile_details.php" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                        <path d="M560-680v-80h320v80H560Zm0 160v-80h320v80H560Zm0 160v-80h320v80H560Zm-240-40q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM80-160v-76q0-21 10-40t28-30q45-27 95.5-40.5T320-360q56 0 106.5 13.5T522-306q18 11 28 30t10 40v76H80Zm86-80h308q-35-20-74-30t-80-10q-41 0-80 10t-74 30Zm154-240q17 0 28.5-11.5T360-520q0-17-11.5-28.5T320-560q-17 0-28.5 11.5T280-520q0 17 11.5 28.5T320-480Zm0-40Zm0 280Z" />
                    </svg>
                    <span class="text">User Profile</span>
                </a>
            </li>
        </ul>

        <ul class="sidebar-bottom-menu">
            <li class="nav-item">
                <a href="" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                        <path
                            d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z" />
                    </svg>
                    <span class="text">Setting</span>
                </a>
            </li>
        </ul>
    </nav>

</aside>