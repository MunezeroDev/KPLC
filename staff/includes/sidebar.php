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
                <a href="../staff/staff_dashboard.php" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                        <path
                            d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z" />
                    </svg>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <div class="drop-item">
                    <a href="connections.php" class="nav-link dropmenu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                            <path
                                d="M300-360h60v-160h-60v50h-60v60h60v50Zm100-50h320v-60H400v60Zm200-110h60v-50h60v-60h-60v-50h-60v160Zm-360-50h320v-60H240v60Zm80 450v-80H160q-33 0-56.5-23.5T80-280v-480q0-33 23.5-56.5T160-840h640q33 0 56.5 23.5T880-760v480q0 33-23.5 56.5T800-200H640v80H320ZM160-280h640v-480H160v480Zm0 0v-480 480Z" />
                        </svg>
                        <span class="text">Connections</span>
                    </a>
                </div>
            </li>

            <li class="nav-item">
                <div class="drop-item">
                    <a href="faults.php" class="nav-link dropmenu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                            <path
                                d="M300-360h60v-160h-60v50h-60v60h60v50Zm100-50h320v-60H400v60Zm200-110h60v-50h60v-60h-60v-50h-60v160Zm-360-50h320v-60H240v60Zm80 450v-80H160q-33 0-56.5-23.5T80-280v-480q0-33 23.5-56.5T160-840h640q33 0 56.5 23.5T880-760v480q0 33-23.5 56.5T800-200H640v80H320ZM160-280h640v-480H160v480Zm0 0v-480 480Z" />
                        </svg>
                        <span class="text">Faults</span>
                    </a>
                </div>
            </li>

            <li class="nav-item">
                <div class="drop-item">
                    <a href="outage.php" class="nav-link dropmenu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                            <path
                                d="M300-360h60v-160h-60v50h-60v60h60v50Zm100-50h320v-60H400v60Zm200-110h60v-50h60v-60h-60v-50h-60v160Zm-360-50h320v-60H240v60Zm80 450v-80H160q-33 0-56.5-23.5T80-280v-480q0-33 23.5-56.5T160-840h640q33 0 56.5 23.5T880-760v480q0 33-23.5 56.5T800-200H640v80H320ZM160-280h640v-480H160v480Zm0 0v-480 480Z" />
                        </svg>
                        <span class="text">Outage</span>
                    </a>
                </div>
            </li>

            <li class="nav-item">
                <div class="drop-item">
                    <a href="frauds.php" class="nav-link dropmenu-link">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                            <path
                                d="M300-360h60v-160h-60v50h-60v60h60v50Zm100-50h320v-60H400v60Zm200-110h60v-50h60v-60h-60v-50h-60v160Zm-360-50h320v-60H240v60Zm80 450v-80H160q-33 0-56.5-23.5T80-280v-480q0-33 23.5-56.5T160-840h640q33 0 56.5 23.5T880-760v480q0 33-23.5 56.5T800-200H640v80H320ZM160-280h640v-480H160v480Zm0 0v-480 480Z" />
                        </svg>
                        <span class="text">Fraud</span>
                    </a>
                </div>
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