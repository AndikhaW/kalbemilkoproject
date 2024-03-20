<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Penilaian - Select Audit Type</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <style>
        /* Add your custom styles here */
        body {
            background-color: #f8f9fc;
        }

        h2 {
            color: #4e73df;
            margin-top: 20px;
        }


        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            color: #1cc88a;
            text-decoration: none;
        }

        a:hover {
            color: #2e59d9;
        }

        a.active {
            background-color: #4e73df;
            color: #ffffff;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .audit-button {
            display: block;
            width: 100%;
            padding: 20px;
            text-align: center;
            background-color: #4e73df;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .audit-button:hover {
            background-color: #2e59d9;
        }

        .back-button {
            display: block;
            width: 100%;
            padding: 20px;
            text-align: center;
            background-color: #858796;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #6c757d;
        }

        .btn-square {
            width: 150px;
            /* Set a fixed width for the buttons */
            height: 150px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Center the text within the button */
        .btn-square .btn-text {
            text-align: center;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("penilaianBtn").addEventListener("click", function() {
                // Change color when clicked
                this.classList.toggle("active");
            });
        });
    </script>

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
                    <a id="penilaianBtn" href="<?= base_url('penilaian') ?>" class="btn btn-primary btn-block">Go to Penilaian</a>
                    <a href="<?= base_url('show_audits') ?>" class="btn btn-primary btn-block">Show Audits</a>
                    <a href="<?= base_url('logout') ?>" class="btn btn-danger btn-block">Logout</a>
                </div>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h2 class="h3 mb-2 text-gray-800 mt-3">Select Audit Type</h2>

                    <!-- Display available audit types as square buttons -->
                    <div class="row">
                        <?php foreach ($auditTypes as $auditType) : ?>
                            <div class="col-md-2 mb-3"> <!-- Reduced margin from mb-3 to mb-2 -->
                                <a href="/penilaian/<?= $auditType['audit_type_id'] ?>" class="btn btn-primary btn-block btn-square">
                                    <div class="btn-text"><?= $auditType['audit_type_name'] ?></div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Page Wrapper -->

</body>

</html>