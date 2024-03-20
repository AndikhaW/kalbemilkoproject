<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
                <div class="sidebar-brand-logo mx-3">
                    <img src="<?= base_url('assets/img/kalbemilko_logo.png') ?>" alt="Logo" height="50">
                </div>
            </a>

            <!-- User Information and Dashboard Content -->
            <li class="nav-item">
                <div class="nav-link">
                    <h5 class="text-white mb-4">Welcome, <?= esc($userData['username']) ?>!</h5>
                    <p>Department: <?= esc($userData['department_name']) ?></p>
                    <a href="<?= base_url('penilaian') ?>" class="btn btn-primary btn-block">Go to Penilaian</a>
                    <a href="<?= base_url('show_audits') ?>" class="btn btn-primary btn-block">Show Audits</a>
                    <a href="<?= base_url('logout') ?>" class="btn btn-danger btn-block">Logout</a>
                </div>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- ... (Remaining HTML code) ... -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- ... (Remaining HTML code) ... -->

</body>

</html>
