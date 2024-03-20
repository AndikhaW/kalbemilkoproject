<!-- app/Views/penilaian/show_departments.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Departments</title>

    <!-- Custom fonts for this template -->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('show_audits') ?>">
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

        <!-- Main Content -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h2 class="h3 mb-2 text-gray-800 mt-3">Departments</h2>
                    <!-- Display departments -->
                    <ul>
                        <?php foreach ($departments as $department) : ?>
                            <?php if ($department['department_name'] !== $userData['department_name']) : ?>
                                <li>
                                    <a href="<?= base_url("penilaian/showQuestions/{$department['department_id']}") ?>">
                                        <?= esc($department['department_name']) ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </ul>
                    <!-- Sub-Departments Container -->
                    <div id="subDepartmentsContainer">
                        <h2>Sub-Departments</h2>
                        <!-- Display sub-departments -->
                        <ul id="subDepartmentsList"></ul>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->


    </div>
    <!-- End of Page Wrapper -->

    <!-- JavaScript for fetching and displaying sub-departments -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subDepartmentsList = document.getElementById('subDepartmentsList');

            document.querySelectorAll('ul li a').forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    const departmentId = this.getAttribute('href').split('/').pop();

                    fetch(`<?= base_url('penilaian/getSubDepartments/') ?>${departmentId}`)
                        .then(response => response.json())
                        .then(subDepartments => {
                            subDepartmentsList.innerHTML = subDepartments.length > 0 ?
                                subDepartments.map(subDepartment => `<li><a href="<?= base_url('penilaian/showQuestions/') ?>${subDepartment.sub_department_id}">${subDepartment.sub_department_name}</a></li>`).join('') :
                                'No sub-departments found.';
                        })
                        .catch(error => console.error('Error fetching sub-departments:', error));
                });
            });
        });
    </script>

</body>

</html>