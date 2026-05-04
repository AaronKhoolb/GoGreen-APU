<!--
    Author: Chong Jun Yoong
    Date: 2026-1-11
    Description: Collaborator interface for viewing an overview of a specific event, including general information, contact details, participant growth chart, and event timeline.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');

    $user_id = $_SESSION['user_id'];

    $event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($event_id === 0) {
        $collab_sql = "SELECT event_id FROM collaborators WHERE user_id = $user_id LIMIT 1";
        $collab_result = mysqli_query($conn, $collab_sql);
        
        if ($collab_result && mysqli_num_rows($collab_result) > 0) {
            $row = mysqli_fetch_assoc($collab_result);
            $event_id = intval($row['event_id']);
            header("Location: /GoGreen-APU/frontend/collaborator/index.php?id=$event_id");
            exit();
        } else {
            header("Location: /GoGreen-APU/frontend/collaborator/my_events/index.php");
            exit();
        }
    }

    $collab_sql = "SELECT * FROM collaborators WHERE user_id = $user_id AND event_id = $event_id";
    $collab_result = mysqli_query($conn, $collab_sql);

    if (mysqli_num_rows($collab_result) == 0) {
        header("Location: /GoGreen-APU/frontend/collaborator/index.php");
        exit();
    }
    ?>
    <title>Overview - My Events | GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/hero.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/overview.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php
    $page_name = 'dashboard';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/collaborator/sidebar.php');
    ?>

    <main>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/collaborator/hero.php'); ?>

        <section class="page-content">
            <?php
            $event = null;
            $created_by_name = '-';

            $sql = "SELECT e.*, u.first_name, u.last_name
                    FROM events e
                    LEFT JOIN users u ON e.created_by = u.id
                    WHERE e.id = $event_id";
            $res = mysqli_query($conn, $sql);
            if ($res && mysqli_num_rows($res) > 0) {
                $event = mysqli_fetch_assoc($res);
                $created_by_name = trim(($event['last_name'] ?? '') . ' ' . ($event['first_name'] ?? '')) ?: '-';
            }

            if (!$event) {
                echo '<h2>Event not found</h2>';
            } else {
                $format_val = function ($v) {
                    $clean = trim((string)($v ?? ''));
                    return $clean === '' ? '<span class="empty">-</span>' : htmlspecialchars($clean);
                };

                $approved_by_name = '-';
                if ($event['approved_by']) {
                    $sql_approver = "SELECT first_name, last_name FROM users WHERE id = " . intval($event['approved_by']);
                    $res_approver = mysqli_query($conn, $sql_approver);
                    if ($res_approver && mysqli_num_rows($res_approver) > 0) {
                        $approver = mysqli_fetch_assoc($res_approver);
                        $approved_by_name = trim(($approver['last_name'] ?? '') . ' ' . ($approver['first_name'] ?? '')) ?: '-';
                    }
                }

                $participant_sql = "SELECT COUNT(*) as total FROM event_participants WHERE event_id = $event_id";
                $participant_res = mysqli_query($conn, $participant_sql);
                $participant_count = 0;
                if ($participant_res) {
                    $participant_data = mysqli_fetch_assoc($participant_res);
                    $participant_count = $participant_data['total'];
                }

                $updated_by_name = '-';
                if ($event['updated_by']) {
                    $sql_updater = "SELECT first_name, last_name FROM users WHERE id = " . intval($event['updated_by']);
                    $res_updater = mysqli_query($conn, $sql_updater);
                    if ($res_updater && mysqli_num_rows($res_updater) > 0) {
                        $updater = mysqli_fetch_assoc($res_updater);
                        $updated_by_name = trim(($updater['last_name'] ?? '') . ' ' . ($updater['first_name'] ?? '')) ?: '-';
                    }
                }

                $approval_status = 'Pending';
                if ($event['is_approved'] === '1') {
                    $approval_status = 'Approved';
                } elseif ($event['is_approved'] === '0') {
                    $approval_status = 'Rejected';
                }

                $growth_sql = "SELECT DATE(registered_at) as reg_date, COUNT(*) as count 
                              FROM event_participants 
                              WHERE event_id = $event_id 
                              GROUP BY DATE(registered_at) 
                              ORDER BY reg_date ASC";
                $growth_res = mysqli_query($conn, $growth_sql);
                
                $dates = [];
                $counts = [];
                $cumulative = 0;
                
                while ($row = mysqli_fetch_assoc($growth_res)) {
                    $cumulative += $row['count'];
                    $dates[] = date('M d', strtotime($row['reg_date']));
                    $counts[] = $cumulative;
                }
            ?>

            <h2>Event Overview</h2>

            <div class="content-wrapper">
                <div class="left-section">
                    <div class="overview-section">
                        <h3><img src="/GoGreen-APU/assets/icons/info.circle.svg" alt="">General Information</h3>
                        <div class="info-row">
                            <div class="info-item">
                                <span class="info-label">Title</span>
                                <span class="info-value"><?php echo htmlspecialchars($event['title']); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Like Count</span>
                                <span class="info-value"><?php echo (int)$event['like_count']; ?></span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-item">
                                <span class="info-label">Event Date</span>
                                <span class="info-value"><?php 
                                    $start = htmlspecialchars($event['start_date']);
                                    $end = htmlspecialchars($event['end_date'] ?? '');
                                    echo ($start === $end && !empty($end)) ? $start : $start . ' - ' . ($end ?: '-');
                                ?></span>
                            </div>

                            <div class="info-item">
                                <span class="info-label">Event Time</span>
                                <span class="info-value"><?php echo htmlspecialchars($event['start_time']) . ' - ' . htmlspecialchars($event['end_time']); ?></span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-item">
                                <span class="info-label">Location</span>
                                <span class="info-value"><?php echo htmlspecialchars($event['location']); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Transportation Provided</span>
                                <span class="info-value"><?php echo $event['transportation'] ? 'Yes' : 'No'; ?></span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-item">
                                <span class="info-label">Participants</span>
                                <span class="info-value"><?php echo $participant_count . ' / ' . (int)$event['max_participants']; ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Registration Deadline</span>
                                <span class="info-value"><?php echo htmlspecialchars($event['registration_deadline']); ?></span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-item">
                                <span class="info-label">Is Paid</span>
                                <span class="info-value"><?php echo $event['is_paid'] ? 'Yes' : 'No'; ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Price</span>
                                <span class="info-value"><?php echo $event['is_paid'] ? 'RM ' . number_format((float)$event['price'], 2) : '-'; ?></span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-item">
                                <span class="info-label">Updated By</span>
                                <span class="info-value"><?php echo htmlspecialchars($updated_by_name); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Updated At</span>
                                <span class="info-value"><?php echo $event['updated_at'] ? htmlspecialchars($event['updated_at']) : '-'; ?></span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-item">
                                <span class="info-label">Approval Status</span>
                                <span class="info-value status-<?php echo strtolower($approval_status); ?>"><?php echo $approval_status; ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Approved At</span>
                                <span class="info-value"><?php echo $event['approved_at'] ? htmlspecialchars($event['approved_at']) : '-'; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="overview-section">
                        <h3><img src="/GoGreen-APU/assets/icons/person.2.badge.gearshape.fill.svg" alt="">Contact & Social</h3>
                        <div class="info-row">
                            <div class="info-item">
                                <span class="info-label">Phone</span>
                                <span class="info-value"><?php echo $format_val($event['phone_no']); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">WhatsApp</span>
                                <span class="info-value"><?php echo $format_val($event['whatsapp']); ?></span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-item">
                                <span class="info-label">Facebook</span>
                                <span class="info-value"><?php echo $format_val($event['facebook']); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Instagram</span>
                                <span class="info-value"><?php echo $format_val($event['instagram']); ?></span>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-item">
                                <span class="info-label">Discord</span>
                                <span class="info-value"><?php echo $format_val($event['discord']); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Teams</span>
                                <span class="info-value"><?php echo $format_val($event['teams']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="right-section">
                    <div class="chart-container">
                        <h3><img src="/GoGreen-APU/assets/icons/person.2.badge.gearshape.fill.svg" alt="">Participants Registration Growth</h3>
                        <canvas id="participantChart"></canvas>
                    </div>

                    <div class="timeline-container">
                        <h3><img src="/GoGreen-APU/assets/icons/person.2.badge.gearshape.fill.svg" alt="">Event Timeline</h3>
                        <div class="timeline">
                            <?php 
                            $event_date = strtotime($event['start_date']);
                            $now = time();
                            if ($event_date <= $now): 
                            ?>
                            <div class="timeline-item">
                                <div class="timeline-date active"><?php echo date('M d, Y', strtotime($event['start_date'])); ?></div>
                                <div class="timeline-dot active"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title active">Event Started</div>
                                    <div class="timeline-user active">-</div>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="timeline-item">
                                <div class="timeline-date"><?php echo date('M d, Y', strtotime($event['start_date'])); ?></div>
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Event Start</div>
                                    <div class="timeline-user">Upcoming</div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if ($event['is_approved'] === '1' && $event['approved_at']): ?>
                            <div class="timeline-item">
                                <div class="timeline-date active"><?php echo date('M d, Y h:i A', strtotime($event['approved_at'])); ?></div>
                                <div class="timeline-dot active"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title active">Approved</div>
                                    <div class="timeline-user active">By: <?php echo htmlspecialchars($approved_by_name); ?></div>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="timeline-item">
                                <div class="timeline-date">-</div>
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Pending Approval</div>
                                    <div class="timeline-user">-</div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="timeline-item">
                                <div class="timeline-date active"><?php echo date('M d, Y h:i A', strtotime($event['created_at'])); ?></div>
                                <div class="timeline-dot active"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title active">Created</div>
                                    <div class="timeline-user active">By: <?php echo htmlspecialchars($created_by_name); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php } ?>
        </section>
    </main>

    <script>
        var ctx = document.getElementById('participantChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($dates); ?>,
                datasets: [{
                    label: 'Total Participants',
                    data: <?php echo json_encode($counts); ?>,
                    borderColor: '#4CAF50',
                    backgroundColor: 'rgba(76, 175, 80, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#fff'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#fff',
                            stepSize: 1
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#fff'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>