<!-- show_questions.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Questions</title>

    <!-- Custom fonts -->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles -->
    <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <style>
        /* Additional styles for better spacing and organization */

        #content {
            /* margin-left: 15px; Adjust the margin based on your sidebar width */
            padding: 20px;
            flex: 1;
        }

        .question-container {
            border: 1px solid #d1d3e2;
            /* Adjust the border color based on your design */
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
            /* Clear float */
        }

        h3 {
            color: #4e73df;
            /* Adjust the color based on your design */
            margin-top: 30px;
        }

        .answer-container {
            margin-top: 20px;
        }

        /* Set a fixed width for better consistency */
        textarea {
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .answer-buttons {
            margin-bottom: 10px;
        }

        .answer-buttons label {
            margin-right: 20px;
        }

        .answer-image {
            margin-bottom: 10px;
        }

        .submit-button {
            margin-top: 20px;
        }

        .text-center {
            text-align: center;
        }

        /* Fixed sidebar */
        #wrapper {
            position: relative;
        }

        #content {
            width: calc(100% - 250px);
            /* Adjust the width based on your sidebar width */
        }

        .fixed-sidebar {
            position: fixed;
            height: 100%;
            overflow-y: auto;
            z-index: 1;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper" class="fixed-sidebar">

        <!-- Sidebar -->
        <!-- <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"> -->
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
        <div id="content" class="bg-gray-100">

            <!-- Main Content -->
            <div class="container-fluid">

                <!-- ... (your existing code) ... -->

                <h2 class="mt-4">Audit <?= esc($subDepartmentName) ?></h2>


                <form method="post" action="<?= site_url("penilaian/showQuestions/processAnswers/{$subDepartmentId}") ?>">
                    <?php
                    $currentMateriTitle = null;
                    $questionNumber = 1;

                    foreach ($questions as $question) :
                        // Check if the question has associated Materi
                        if (!empty($question['materi'])) {
                            $materiTitle = esc($question['materi'][0]['materi_title']);
                            // If a new Materi is encountered, update the current Materi title and reset the question number
                            if ($materiTitle !== $currentMateriTitle) {
                                $currentMateriTitle = $materiTitle;
                                echo "<h3><strong>Materi: $currentMateriTitle</strong></h3>";
                                $questionNumber = 1; // Reset question number for a new Materi
                            }
                        }

                        // Display the question with its number
                        echo "<div class='answer-container'><p>{$questionNumber}. " . esc($question['question_text']) . "</p>";

                        if (isset($question['sub_klausuls']) && is_array($question['sub_klausuls'])) {
                            // Display sub_klausuls as an unordered list
                            echo '<ul>';
                            foreach ($question['sub_klausuls'] as $subKlausul) {
                                if (isset($subKlausul['sub_klausul_name'])) {
                                    echo '<li>' . esc($subKlausul['sub_klausul_name']) . '</li>';
                                }
                            }
                            echo '</ul>';
                        }

                        // Display answers for the question
                        echo '<div class="answer-buttons">';

                        // Form for submitting answers
                        echo '<input type="hidden" name="question_id[]" value="' . $question['question_id'] . '">';

                        // Label for answer
                        echo '<label for="answer_text">Jawaban:</label><br>';

                        // Textarea for answer
                        echo '<textarea name="answer_text_' . $question['question_id'] . '" rows="4" cols="50" required></textarea>';

                        // Radio buttons for answer types
                        echo '<div class="answer-buttons">';
                        echo '<label><input type="radio" name="answer_type_' . $question['question_id'] . '" value="critical" required>Critical</label>';
                        echo '<label><input type="radio" name="answer_type_' . $question['question_id'] . '" value="major" required>Major</label>';
                        echo '<label><input type="radio" name="answer_type_' . $question['question_id'] . '" value="minor" required>Minor</label>';
                        echo '<label><input type="radio" name="answer_type_' . $question['question_id'] . '" value="observasi" required>Observasi</label>';
                        echo '</div>';

                        // File upload for image
                        echo '<div class="answer-image">';
                        echo '<label for="answer_image">Unggah Gambar:</label>';
                        echo '<input type="file" name="answer_image_' . $question['question_id'] . '">';
                        echo '</div>';

                        echo '</div>';
                        $questionNumber++;
                    endforeach;
                    ?>

                    <!-- Submit button at the end -->
                    <div class="submit-button">
                        <input type="submit" value="Submit Jawaban" class="btn btn-primary">
                    </div>
                </form>

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