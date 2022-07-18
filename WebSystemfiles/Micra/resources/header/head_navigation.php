<?php
    
    $ongoing="";
    
    switch($_SESSION['position']){
        case 'Crime Head':
            $ongoing = '../view/incident.php';
            break;
        case 'Waste Head':
            $ongoing = '../view/waste.php';
            break;
        case 'Infrastructure Head':
            $ongoing = '../view/infrastructure.php';
            break;
    }

?>
<header class="shadow mb-5 sticky-top">
    <nav class="navbar navbar-expand-lg navbar-light" id="main-nav">
        <div class="container">
            <a class="navbar-brand text-white fs-3 fw-bolder" href="../view/pending_report.php">MICRA</a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navCollapse" aria-controls="navCollapse" aria-expanded="false" aria-label="Toggle Navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse justify-content-end" id="navCollapse">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown pe-3">
                        <a class="nav-link text-white" href="#" id="accountDropDown" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-megaphone"></i>&nbsp;&nbsp;Announcement </a>
                        <ul class="dropdown-menu" aria-labelledby="accountDropDown">
                            <li class="border-bottom"><a class="dropdown-item" href="../view/manage_announcement.php"><i class="bi bi-megaphone"></i> Manage Announcement</a></li>
                            <li><a class="dropdown-item" href="../view/create_announcement.php"><i class="bi bi-file-earmark-plus"></i> Create New Announcement</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown pe-3">
                        <a class="nav-link text-white" href="#" id="reportDropDown" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-clipboard-check"></i> &nbsp;Reports</a>
                        <ul class="dropdown-menu" aria-labelledby="reportDropDown">
                            <li class="border-bottom"><a class="dropdown-item" href="../view/pending_report.php"><i class="bi bi-hourglass"></i> Pending Reports</a></li>
                            <li><a class="dropdown-item" href="<?=$ongoing?>"><i class="bi bi-cone-striped"></i> Ongoing Reports</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-circle"></i> <?= $_SESSION['username']?></a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="../view/profile_head.php"><i class="bi bi-key"></i> Profile</a></li>
                            <li><hr class="dropdown-divider text-white"></li>
                            <li><a class="dropdown-item" href="../process/logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>