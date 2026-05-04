 <!--
    Author: Chong Jun Yoong
    Date: 2026-1-11
    Description: Admin interface for generating event reports for current event.
-->
<?php

include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($event_id === 0)
    die("Invalid Event ID");

$sql = "SELECT e.*, c.logo_path as club_logo FROM events e 
        LEFT JOIN clubs c ON e.club_id = c.id 
        WHERE e.id = $event_id";
$result = mysqli_query($conn, $sql);
$event = mysqli_fetch_assoc($result);
if (!$event)
    die("Event not found");

$sql_total = "SELECT COUNT(*) as count FROM event_participants WHERE event_id = $event_id";
$res_total = mysqli_query($conn, $sql_total);
$total_registered = mysqli_fetch_assoc($res_total)['count'];

$sql_attended = "SELECT COUNT(*) as count FROM event_participants WHERE event_id = $event_id AND status = 'attended'";
$res_attended = mysqli_query($conn, $sql_attended);
$attended_count = mysqli_fetch_assoc($res_attended)['count'];

$absent_count = $total_registered - $attended_count;

$start_date_formatted = date('d F Y', strtotime($event['start_date']));
$time_formatted = date('h:i A', strtotime($event['start_time'])) . ' - ' .
    ($event['end_time'] ? date('h:i A', strtotime($event['end_time'])) : 'End');

$sdg_labels = [
    'sdg1' => 'SDG 1 No Poverty',
    'sdg2' => 'SDG 2 Zero Hunger',
    'sdg3' => 'SDG 3 Good Health and Well-being',
    'sdg4' => 'SDG 4 Quality Education',
    'sdg5' => 'SDG 5 Gender Equality',
    'sdg6' => 'SDG 6 Clean Water and Sanitation',
    'sdg7' => 'SDG 7 Affordable and Clean Energy',
    'sdg8' => 'SDG 8 Decent Work and Economic Growth',
    'sdg9' => 'SDG 9 Industry, Innovation and Infrastructure',
    'sdg10' => 'SDG 10 Reduced Inequalities',
    'sdg11' => 'SDG 11 Sustainable Cities and Communities',
    'sdg12' => 'SDG 12 Responsible Consumption and Production',
    'sdg13' => 'SDG 13 Climate Action',
    'sdg14' => 'SDG 14 Life Below Water',
    'sdg15' => 'SDG 15 Life on Land',
    'sdg16' => 'SDG 16 Peace, Justice and Strong Institutions',
    'sdg17' => 'SDG 17 Partnerships for the Goals'
];

$selected_sdgs = [];
foreach ($sdg_labels as $key => $label) {
    if ($event[$key] == 1) {
        $selected_sdgs[] = $label;
    }
}
$sdg_list = !empty($selected_sdgs) ? implode(', ', $selected_sdgs) : 'Not specified';

$club_icon_path = $event['club_logo'] ? "/GoGreen-APU/assets/images/club/" . $event['club_logo'] : "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>Report - <?php echo htmlspecialchars($event['title']); ?></title>

    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/hero.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/information.css">

    <style>
        #print-layout {
            display: none;
        }

        .activities-input {
            min-height: 150px;
            font-size: 16px;
        }

        @media print {
            @page {
                size: A4;
                margin: 0 !important;
            }

            html,
            body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
                height: 100%;
                overflow: hidden;
            }

            body * {
                visibility: hidden;
            }

            .sidebar,
            #events-hero,
            .page-header,
            .form-part,
            header,
            nav,
            button {
                display: none !important;
            }

            #print-layout,
            #print-layout * {
                visibility: visible;
            }

            #print-layout {
                display: block !important;
                width: 210mm;
                height: 297mm;
                padding: 2cm 2.5cm;
                margin: 0;
                box-sizing: border-box;
                position: absolute;
                top: 0;
                left: 0;
                color: black;
                font-family: "Times New Roman", Times, serif !important;
            }

            #print-layout>table {
                width: 100%;
                height: 100%;
                border-collapse: collapse;
                font-size: 13pt;
                line-height: 1.4;
                border: none !important;
                table-layout: fixed;
            }

            #print-layout table,
            #print-layout tr,
            #print-layout td {
                border: none !important;
            }

            #print-layout td {
                padding: 6px 15px;
                vertical-align: top;
                color: black !important;
            }

            #print-layout .header-row {
                text-align: center;
            }

            #print-layout .header-row td {
                padding: 4px;
            }

            #print-layout .icon-title-row td {
                vertical-align: middle;
                text-align: center;
            }

            #print-layout .club-icon {
                width: 70px;
                height: auto;
                vertical-align: middle;
            }

            #print-layout .report-title {
                font-weight: bold;
                font-size: 20pt;
                text-decoration: underline;
                display: inline;
                margin-left: 15px;
            }

            #print-layout .event-name {
                font-weight: bold;
                font-size: 15pt;
                text-align: center;
            }

            #print-layout .label-cell {
                width: 32%;
                font-weight: normal;
            }

            #print-layout .indent-cell {
                padding-left: 50px !important;
            }

            #print-layout .activities-content {
                white-space: pre-wrap;
                text-align: justify;
                margin-top: 8px;
            }

            #print-layout .sdg-cell {
                word-wrap: break-word;
                max-width: 400px;
            }
        }
    </style>
</head>

<body>
    <?php
    $page_name = 'event_report';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
    ?>

    <main>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/event/hero.php'); ?>

        <section class="page-content">
            <div id="report-edit-form">

                <div class="page-header">
                    <h2>Generate Event Report</h2>
                    <div class="header-actions">
                        <button type="button" class="btn-save" onclick="prepareAndPrint()">
                            <img src="/GoGreen-APU/assets/icons/printer.svg" alt="" style="filter: invert(1);">
                            <span>Print Report</span>
                        </button>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/info.circle.svg" alt=""></span>
                        <h3>Event Details (Edit for Report)</h3>
                    </div>

                    <div class="form-part-content">
                        <div class="form-field">
                            <label>Event Name</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" id="input_title"
                                    value="<?php echo htmlspecialchars($event['title']); ?>">
                            </div>
                        </div>

                        <div style="display: flex; gap: 20px;">
                            <div class="form-field" style="flex: 1;">
                                <label>Date</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" id="input_date" value="<?php echo $start_date_formatted; ?>">
                                </div>
                            </div>
                            <div class="form-field" style="flex: 1;">
                                <label>Time</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" id="input_time" value="<?php echo $time_formatted; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-field">
                            <label>Location</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" id="input_location"
                                    value="<?php echo htmlspecialchars($event['location']); ?>">
                            </div>
                        </div>

                        <div class="form-field">
                            <label>Event SDG</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" id="input_sdg" value="<?php echo htmlspecialchars($sdg_list); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/person.3.svg" alt=""></span>
                        <h3>Attendance Statistics</h3>
                    </div>
                    <div class="form-part-content">
                        <div class="form-field">
                            <label>Number of Participant Present</label>
                            <div class="txt-container glass-effect-border">
                                <input type="number" id="input_present" value="<?php echo $attended_count; ?>">
                            </div>
                        </div>
                        <div class="form-field">
                            <label>Number of Participant Absent</label>
                            <div class="txt-container glass-effect-border">
                                <input type="number" id="input_absent" value="<?php echo $absent_count; ?>">
                            </div>
                        </div>
                        <div class="form-field">
                            <label>Number of Registered Participant</label>
                            <div class="txt-container glass-effect-border">
                                <input type="number" id="input_registered" value="<?php echo $total_registered; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/text.document.svg" alt=""></span>
                        <h3>Report Content</h3>
                    </div>
                    <div class="form-part-content">
                        <div class="form-field">
                            <label>Activities carried out (Please list briefly):</label>
                            <p style="color: #aaa; font-size: 13px; margin-bottom: 10px;">Enter the summary of
                                activities here. This will appear on the final Report.</p>
                            <div class="txt-container glass-effect-border">
                                <textarea id="input_activities" class="activities-input"
                                    placeholder="e.g.&#10;- Opening Ceremony&#10;- Beach Cleaning Activity&#10;- Waste Sorting Workshop&#10;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <div id="print-layout">

        <?php if ($club_icon_path): ?>
            <div style="position: absolute; top: 2cm; left: 2.5cm;">
                <img src="<?php echo $club_icon_path; ?>" alt="Club Icon" style="width: 70px; height: auto;">
            </div>
        <?php endif; ?>

        <div style="text-align: center; padding-top: 20px; margin-bottom: 15px;">
            <div style="font-weight: bold; font-size: 20pt; text-decoration: underline;">EVENT ACTIVITY REPORT</div>
        </div>


        <div style="text-align: center; font-weight: bold; font-size: 15pt; margin-bottom: 30px;">
            Event Name: <span id="print_title"></span>
        </div>

        <div style="padding: 0 20px;">
            <div style="margin-bottom: 15px;">
                <strong>1. Date:</strong> <span id="print_date" style="margin-left: 20px;"></span>
            </div>

            <div style="margin-bottom: 15px;">
                <strong>2. Time:</strong> <span id="print_time" style="margin-left: 20px;"></span>
            </div>

            <div style="margin-bottom: 15px;">
                <strong>3. Location:</strong> <span id="print_location" style="margin-left: 20px;"></span>
            </div>

            <div style="margin-bottom: 15px;">
                <strong>4. Number of Participant Present:</strong> <span id="print_present"
                    style="margin-left: 20px;"></span>
            </div>

            <div style="margin-bottom: 15px; padding-left: 30px;">
                <strong>Number of Participant Absent:</strong> <span id="print_absent"
                    style="margin-left: 20px;"></span>
            </div>

            <div style="margin-bottom: 15px; padding-left: 30px;">
                <strong>Number of Registered Participant:</strong> <span id="print_registered"
                    style="margin-left: 20px;"></span>
            </div>

            <div style="margin-bottom: 20px;">
                <strong>5. Event SDG:</strong>
                <div id="print_sdg" style="margin-left: 30px; margin-top: 8px; line-height: 1.6;"></div>
            </div>

            <div style="margin-bottom: 20px;">
                <strong>6. Activities carried out (Please List Briefly):</strong>
                <div id="print_activities"
                    style="margin-left: 30px; margin-top: 8px; white-space: pre-wrap; text-align: justify; line-height: 1.6;">
                </div>
            </div>
        </div>

        <div style="position: absolute; bottom: 2cm; right: 2.5cm; text-align: center;">
            <div style="width: 200px; border-top: 2px solid black; padding-top: 8px;">
                <strong>Prepared By (Admin)</strong>
            </div>
        </div>
    </div>

    <script>
        function prepareAndPrint() {
            document.getElementById('print_title').innerText = document.getElementById('input_title').value;
            document.getElementById('print_date').innerText = document.getElementById('input_date').value;
            document.getElementById('print_time').innerText = document.getElementById('input_time').value;
            document.getElementById('print_location').innerText = document.getElementById('input_location').value;
            document.getElementById('print_present').innerText = document.getElementById('input_present').value;
            document.getElementById('print_absent').innerText = document.getElementById('input_absent').value;
            document.getElementById('print_registered').innerText = document.getElementById('input_registered').value;
            document.getElementById('print_sdg').innerText = document.getElementById('input_sdg').value;
            document.getElementById('print_activities').innerText = document.getElementById('input_activities').value;
            window.print();
        }
    </script>
</body>

</html>