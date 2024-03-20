<!-- app/Views/login_view.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>">

    <!-- Debugging statements -->
    <script>
        console.log('Base URL:', '<?= base_url(); ?>');
        console.log('CSS URL:', '<?= base_url("assets/css/sb-admin-2.min.css"); ?>');
        console.log('JS URL:', '<?= base_url("assets/js/sb-admin-2.min.js"); ?>');
    </script>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>

                                    <?php if (session()->getFlashdata('error')) : ?>
                                        <p style="color: red;"><?= session()->getFlashdata('error') ?></p>
                                    <?php endif; ?>

                                    <?= \Config\Services::validation()->listErrors(); ?>

                                    <?= form_open('process-login', 'class="user"') ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" name="username" placeholder="Enter Username..." required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password" placeholder="Password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                    <?= form_close() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/js/sb-admin-2.min.js'); ?>"></script>
</body>

</html>