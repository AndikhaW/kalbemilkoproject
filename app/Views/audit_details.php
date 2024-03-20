<!-- audit_details.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Audit Details</title>

    <!-- Custom fonts -->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles -->
    <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <style>
        /* Additional styles for better spacing and organization */

        #content {
            padding: 20px;
            flex: 1;
        }

        .question-container {
            border: 1px solid #d1d3e2;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        h3 {
            color: #4e73df;
            margin-top: 30px;
        }

        .answer-container {
            margin-top: 20px;
        }

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

        #wrapper {
            position: relative;
        }

        #content {
            width: calc(100% - 250px);
        }

        .fixed-sidebar {
            position: fixed;
            height: 100%;
            overflow-y: auto;
            z-index: 1;
        }

        .audit-detail {
            color: #000;
        }
    </style>
</head>

<body id="page-top">

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
        <div id="content" class="bg-gray-100">
            <div class="container-fluid">
                <h2 class="mt-4">Audits</h2>

                <form action="<?= base_url('show_audits/submitAuditDetails') ?>" method="post" enctype="multipart/form-data">
                    <?php
                    $displayedMateriIds = [];
                    foreach ($auditDetails as $materiId => $details) : ?>
                        <?php if (isset($details[0]['materi_name']) && !in_array($materiId, $displayedMateriIds)) : ?>
                            <?php $displayedMateriIds[] = $materiId; ?>
                            <h2><?= esc($details[0]['materi_name']) ?></h2>
                        <?php endif; ?>

                        <div>
                            <!-- Display the details for each audit -->
                            <?php foreach ($details as $index => $detail) : ?>
                                <?php
                                $questionId = isset($detail['question_id']) ? $detail['question_id'] : '';
                                $answerText = isset($detail['answer_text']) ? $detail['answer_text'] : '';
                                $answerType = isset($detail['answer_type']) ? $detail['answer_type'] : '';
                                $rootCauseAnalysisValue = isset($detail['rootCauseAnalysisValue']) ? $detail['rootCauseAnalysisValue'] : '';
                                $correctionValue = isset($detail['correctionValue']) ? $detail['correctionValue'] : '';
                                $correctiveActionPlanValue = isset($detail['correctiveActionPlanValue']) ? $detail['correctiveActionPlanValue'] : '';
                                $dueDateValue = isset($detail['dueDateValue']) ? $detail['dueDateValue'] : '';
                                ?>

                                <h3>Question <?= $index + 1 ?>: <?= esc($detail['question_text']) ?></h3>
                                <p>* <?= esc($detail['answer_text']) ?></p>
                                <p>Answer Type: <?= esc($detail['answer_type']) ?></p>

                                <!-- Input fields for RootCauseAnalysis -->
                                <div>
                                    <label for="root_cause_analysis[<?= $questionId ?>]">Root Cause Analysis:</label><br>
                                    <?php if ($viewOnly) : ?>
                                        <p><span class="audit-detail"><?= esc($rootCauseAnalysisValue) ?></span></p>
                                    <?php else : ?>
                                        <textarea name="root_cause_analysis[<?= $questionId ?>]" rows="4" cols="50" required><?= esc($rootCauseAnalysisValue) ?></textarea>
                                    <?php endif; ?>
                                </div>

                                <!-- Input fields for Correction -->
                                <div>
                                    <label for="correction[<?= $questionId ?>]">Correction:</label><br>
                                    <?php if ($viewOnly) : ?>
                                        <p><span class="audit-detail"><?= esc($correctionValue) ?></span></p>
                                    <?php else : ?>
                                        <textarea name="correction[<?= $questionId ?>]" rows="4" cols="50" required><?= esc($correctionValue) ?></textarea>
                                    <?php endif; ?>
                                </div>

                                <!-- Input fields for CorrectiveActionPlan -->
                                <div>
                                    <label for="corrective_action_plan[<?= $questionId ?>]">Corrective Action Plan:</label><br>
                                    <?php if ($viewOnly) : ?>
                                        <p><span class="audit-detail"><?= esc($correctiveActionPlanValue) ?></span></p>
                                    <?php else : ?>
                                        <textarea name="corrective_action_plan[<?= $questionId ?>]" rows="4" cols="50" required><?= esc($correctiveActionPlanValue) ?></textarea>
                                    <?php endif; ?>
                                </div>

                                <!-- Input field for Date -->
                                <div>
                                    <label for="due_date[<?= $questionId ?>]">Due Date:</label>
                                    <?php if ($viewOnly) : ?>
                                        <?php
                                        // Convert the due date to the desired format
                                        $formattedDueDate = date('d-m-Y', strtotime($dueDateValue));
                                        ?>
                                        <p><span class="audit-detail"><?= esc($formattedDueDate) ?></span></p>
                                    <?php else : ?>
                                        <input type="date" name="due_date[<?= $questionId ?>]" required value="<?= esc($dueDateValue) ?>">
                                    <?php endif; ?>
                                </div>



                                <!-- File upload for image -->
                                <div>
                                    <label for="evidence_<?= $questionId ?>">Upload Image:</label>
                                    <?php if (!$viewOnly) : ?>
                                        <input type="file" name="evidence_<?= $questionId ?>">
                                    <?php endif; ?>
                                </div>

                            <?php endforeach; ?>




                            <input type="hidden" name="auditfssc_id" value="<?= isset($auditfsscId) ? esc($auditfsscId) : '' ?>">
                        </div>

                    <?php endforeach; ?>

                    <h3>Auditor:</h3>
                    <p><?= esc($auditorName) ?></p>

                    <div>
                        <?php if (!$viewOnly) : ?>
                            <div>
                                <input type="submit" value="Submit Audit Details" class="btn btn-primary">
                            </div>
                        <?php endif; ?>

                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>