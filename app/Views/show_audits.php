<!-- app/Views/show_audits.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Audits</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <!-- Custom styles for the Show Audits page -->
    <style>
        /* Add your custom styles for the Show Audits page here */
        table {
            width: 90%;
            /* Adjust the width as needed */
            margin: 20px auto;
            /* Add margin to center the table and provide spacing */
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;

            padding: 8px;

            text-align: left;

        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            margin: 20px;
            /* Add margin to the bottom of the heading */
        }


        /* Add more styles as needed */
    </style>
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

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- ... (Remaining HTML code) ... -->

                <h2>Audits</h2>

                <table border="1">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Department</th>
                            <th>Area Audit</th>
                            <th>Nama Auditor</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        <?php foreach ($audits as $audit) : ?>
                            <tr>
                                <td><?= $counter++ ?></td>
                                <td><?= esc($audit['department_name']) ?></td>
                                <td><?= isset($audit['sub_department_name']) ? esc($audit['sub_department_name']) : 'N/A' ?></td>
                                <td><?= esc($audit['nama_auditor']) ?></td>
                                <td><?= esc($audit['status']) ?></td>
                                <td><a href="<?= base_url("show_audits/getAuditDetails/{$audit['auditfssc_id']}") ?>">
                                        Isi Capa
                                    </a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>

                <!-- Add your additional content here -->


                <!-- ... (Remaining HTML code) ... -->

            </div>
            <!-- End of Main Content -->

            <!-- ... (Remaining HTML code) ... -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- ... (Remaining HTML code) ... -->

</body>

</html>