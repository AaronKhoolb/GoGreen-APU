 <!--
    Author: Damian Loh Yi Feng
    Date: 2026-1-15
    Description: Admin Attendance Management Page
-->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

$event_id = 0;
if (isset($_GET['id'])) {
    $event_id = intval($_GET['id']);
}

$filter = 'all';
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['toggle_id'])) {
        $p_id = intval($_POST['toggle_id']);
        $current_status = $_POST['current_status'];
        
        $marker_id = "NULL"; 
        if (isset($_SESSION['user_id'])) {
            $marker_id = intval($_SESSION['user_id']);
        }

        $sql_info = "SELECT user_id, event_id FROM event_participants WHERE id = $p_id";
        $res_info = mysqli_query($conn, $sql_info);
        $info = mysqli_fetch_assoc($res_info);
        
        if ($info) {
            $student_user_id = $info['user_id'];
            $this_event_id = $info['event_id'];

            $sql_event = "SELECT coins_earned FROM events WHERE id = $this_event_id";
            $res_event = mysqli_query($conn, $sql_event);
            $event_data = mysqli_fetch_assoc($res_event);
            $coins_reward = intval($event_data['coins_earned']);

            $new_status = ($current_status == 'attended') ? 'absent' : 'attended';

            if ($new_status == 'attended') {
                $update_ep = "UPDATE event_participants 
                              SET status = 'attended', 
                                  check_in_time = NOW(), 
                                  coins_earned = $coins_reward,
                                  marked_by = $marker_id 
                              WHERE id = $p_id";
                
                $update_student = "UPDATE students 
                                   SET ap_coins = ap_coins + $coins_reward 
                                   WHERE user_id = $student_user_id";
            } else {
                $update_ep = "UPDATE event_participants 
                              SET status = 'absent', 
                                  check_in_time = NULL, 
                                  coins_earned = 0,
                                  marked_by = NULL 
                              WHERE id = $p_id";
                
                $update_student = "UPDATE students 
                                   SET ap_coins = ap_coins - $coins_reward 
                                   WHERE user_id = $student_user_id";
            }

            mysqli_query($conn, $update_ep);
            mysqli_query($conn, $update_student);
        }
        
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $event_id . "&filter=" . $filter);
        exit;
    }

    if (isset($_POST['delete_participant_id'])) {
        $del_id = intval($_POST['delete_participant_id']);
        $del_event_id = intval($_POST['event_id']);
        
        $del_sql = "DELETE FROM event_participants WHERE id = $del_id";
        mysqli_query($conn, $del_sql);
        
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $del_event_id . "&filter=" . $filter);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>Attendance - Manage Events | GoGreen@APU</title>
    
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/hero.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/global/table.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/global/checkbox_switch.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/participants.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/home.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/global/attendance.css">
    
    <style>
        .trash-btn { 
            background: none; 
            border: none;
        }
    </style>
</head>

<body>
    <?php
    $page_name = 'event_attendance';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
    
    $participants = array();
    $checked_in_count = 0;
    $total_students = 0;

    if ($event_id > 0) {
        $ep_sql = "SELECT * FROM event_participants WHERE event_id = $event_id ORDER BY registered_at DESC";
        $ep_res = mysqli_query($conn, $ep_sql);
        
        if ($ep_res) {
            while ($row = mysqli_fetch_assoc($ep_res)) {
                $total_students++;
                $row_status = ($row['status'] == 'attended') ? 'present' : 'absent';
                
                if ($row_status == 'present') {
                    $checked_in_count++;
                }

                if ($filter != 'all' && $filter != $row_status) {
                    continue; 
                }

                $user_id = $row['user_id'];
                $user_sql = "SELECT first_name, last_name, apkey, avatar_path FROM users WHERE id = $user_id";
                $user_res = mysqli_query($conn, $user_sql);
                $user_data = mysqli_fetch_assoc($user_res);

                if ($user_data) {
                    $row['first_name'] = $user_data['first_name'];
                    $row['last_name'] = $user_data['last_name'];
                    $row['apkey'] = $user_data['apkey'];
                    $row['avatar_path'] = $user_data['avatar_path'];
                } else {
                    $row['first_name'] = 'Unknown';
                    $row['last_name'] = '';
                    $row['apkey'] = '-';
                    $row['avatar_path'] = 'default.png';
                }

                if ($row['marked_by']) {
                    $marker_id = $row['marked_by'];
                    $marker_sql = "SELECT first_name, avatar_path FROM users WHERE id = $marker_id";
                    $marker_res = mysqli_query($conn, $marker_sql);
                    $marker_data = mysqli_fetch_assoc($marker_res);
                    
                    if ($marker_data) {
                        $row['marker_name'] = $marker_data['first_name'];
                        $row['marker_avatar'] = $marker_data['avatar_path'];
                    }
                }

                $participants[] = $row;
            }
        }
    }
    ?>

    <main>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/event/hero.php'); ?>

        <section class="page-content">
            <?php if ($event_id === 0) { ?>
                <div style="text-align:center; padding:50px; color:#ff4d4d;"><h3>Error: Invalid Event ID</h3></div>
            <?php } else { ?>
                
                <div class="attendance-wrapper">
                
                    <div class="code-card glass-effect-border">
                        <div id="start-view">
                            <img src="/GoGreen-APU/assets/icons/lock.fill.svg" style="width: 50px; opacity: 0.5; margin-bottom: 15px; filter: invert(1);">
                            <h3>Attendance Session</h3>
                            <p style="color:#aaa; margin-bottom: 30px; font-size: 0.9rem;">Click below to generate live codes.</p>
                            <button class="btn-start" onclick="startSession()">Start Session</button>
                        </div>
                        <div id="live-session">
                            <p style="color:#aaa; margin:0;">Student Entry Code:</p>
                            <div class="code-display" id="code-box">---</div>
                            <div class="timer-circle">
                                <svg class="timer-svg">
                                    <circle class="timer-circle-bg" cx="40" cy="40" r="32"></circle>
                                    <circle class="timer-circle-progress" cx="40" cy="40" r="32" id="progress-ring"></circle>
                                </svg>
                                <div class="timer-text" id="timer-text">--</div>
                            </div>
                        </div>
                    </div>

                    <div class="table-actions-container glass-effect">
                        <div class="section-header">
                            <h3>Participants (<?php echo $checked_in_count; ?>/<?php echo $total_students; ?>)</h3>
                            <div class="section-subtitle">Real-time attendance and approval management</div>
                        </div>

                        <div class="table-filters">
                            <div class="filter-group glass-effect-border">
                                <label for="filter-status">Status</label>
                                <select id="filter-status" onchange="location.href='?id=<?php echo $event_id; ?>&filter=' + this.value">
                                    <option value="all" <?php if ($filter == 'all') echo 'selected'; ?>>All</option>
                                    <option value="present" <?php if ($filter == 'present') echo 'selected'; ?>>Present</option>
                                    <option value="absent" <?php if ($filter == 'absent') echo 'selected'; ?>>Absent</option>
                                </select>
                            </div>
                            <div class="custom-search-bar">
                                <input type="text" id="search-input" class="custom-search-input" placeholder="Search..." onkeyup="filterTable()">
                                <img src="/GoGreen-APU/assets/icons/navigation/search.svg" style="width:16px; opacity:0.5;">
                            </div>
                        </div>

                        <div class="table-manage-container glass-effect-border">
                            <?php if (count($participants) > 0) { ?>
                                <div class="table-left-container">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>NAME</th>
                                                <th>STATUS</th>
                                                <th>MARKED BY</th>
                                                <th>CHECK-IN TIME</th>
                                                <th>AP COINS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($participants as $p) { 
                                                $is_attended = ($p['status'] == 'attended');
                                                $status_class = $is_attended ? 'status-present' : 'status-absent';
                                                $status_text = $is_attended ? 'Present' : 'Absent';
                                                
                                                $p_name = strtolower($p['first_name'] . ' ' . $p['last_name']);
                                            ?>
                                            <tr class="searchable-row" data-name="<?php echo $p_name; ?>">
                                                <td class="event-title">
                                                    <div style="display: flex; align-items: center; gap: 12px;">
                                                        <span class="user-avatar">
                                                            <img src="/GoGreen-APU/assets/images/profile/<?php echo $p['avatar_path']; ?>" onerror="this.src='/GoGreen-APU/assets/images/profile/default.png'">
                                                        </span>
                                                        <div class="user-info">
                                                            <span><?php echo htmlspecialchars($p['last_name'] . ' ' . $p['first_name']); ?></span>
                                                            <span class="user-apkey"><?php echo $p['apkey']; ?></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                                                <td>
                                                    <?php if (isset($p['marker_name'])) { ?>
                                                        <div class="approver-info">
                                                            <span class="user-avatar-small">
                                                                <img src="/GoGreen-APU/assets/images/profile/<?php echo $p['marker_avatar']; ?>">
                                                            </span>
                                                            <div class="user-info">
                                                                <span class="approver-name"><?php echo htmlspecialchars($p['marker_name']); ?></span>
                                                            </div>
                                                        </div>
                                                    <?php } else { echo "-"; } ?>
                                                </td>
                                                <td style="color:#aaa; font-size:12px;">
                                                    <?php echo $p['check_in_time'] ? date('d M Y, H:i', strtotime($p['check_in_time'])) : '-'; ?>
                                                </td>
                                                <td class="coins"><?php echo $p['coins_earned']; ?> AP</td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="table-right-container glass-effect">
                                    <table>
                                        <thead><tr><th>Actions</th></tr></thead>
                                        <tbody>
                                            <?php foreach ($participants as $p) { 
                                                $p_name = strtolower($p['first_name'] . ' ' . $p['last_name']);
                                            ?>
                                            <tr class="searchable-row" data-name="<?php echo $p_name; ?>">
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 10px; justify-content: flex-end; margin-right:50px; gap:30px;">
                                                        <form method="POST" style="margin:0;">
                                                            <input type="hidden" name="toggle_id" value="<?php echo $p['id']; ?>">
                                                            <input type="hidden" name="current_status" value="<?php echo $p['status']; ?>">
                                                            <div class="checkbox-switch">
                                                                <input type="checkbox" id="cb_<?php echo $p['id']; ?>" <?php echo ($p['status'] == 'attended') ? 'checked' : ''; ?> onchange="this.form.submit()">
                                                                <label for="cb_<?php echo $p['id']; ?>"></label>
                                                            </div>
                                                        </form>
                                                        
                                                        <form method="POST" style="margin:0;" onsubmit="return confirm('Remove this student?');">
                                                            <input type="hidden" name="delete_participant_id" value="<?php echo $p['id']; ?>">
                                                            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                                                            <button type="submit" class="trash-btn">
                                                                <img src="/GoGreen-APU/assets/icons/trash.svg" alt="Del">
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } else { ?>
                                <div style="text-align:center; padding:100px; color:#666; margin-left:500px;">
                                    <img src="/GoGreen-APU/assets/icons/person.3.svg" style="width:60px; opacity:0.2; filter:invert(1); margin-bottom:15px;">
                                    <p>No participants found.</p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            <?php } ?>
        </section>
    </main>

    <script>
        function filterTable() {
            var input = document.getElementById('search-input');
            var filter = input.value.toLowerCase();
            var leftRows = document.querySelectorAll('.table-left-container .searchable-row');
            var rightRows = document.querySelectorAll('.table-right-container .searchable-row');
            
            for (var i = 0; i < leftRows.length; i++) {
                var row = leftRows[i];
                var name = row.getAttribute('data-name');
                
                if (name.indexOf(filter) > -1) {
                    row.style.display = "";
                    if (rightRows[i]) {
                        rightRows[i].style.display = "";
                    }
                } else {
                    row.style.display = "none";
                    if (rightRows[i]) {
                        rightRows[i].style.display = "none";
                    }
                }
            }
        }

        var eventId = <?php echo $event_id; ?>;
        var startView = document.getElementById('start-view');
        var liveSession = document.getElementById('live-session');
        var codeBox = document.getElementById('code-box');
        var timerText = document.getElementById('timer-text');
        var progressRing = document.getElementById('progress-ring');
        var circumference = 2 * Math.PI * 32;

        if(progressRing) {
            progressRing.style.strokeDasharray = circumference + ' ' + circumference;
            progressRing.style.strokeDashoffset = 0;
        }

        var timeLeft = 0;
        var totalDuration = 120;
        var timerInterval = null;

        function startSession() {
            startView.style.display = 'none';
            liveSession.style.display = 'flex';
            fetchCode();
            timerInterval = setInterval(function() {
                if (timeLeft > 0) {
                    timeLeft--;
                    updateTimerDisplay();
                } else {
                    if (timeLeft === 0) {
                        timeLeft = -1; fetchCode();
                    }
                }
            }, 1000);
        }

        function fetchCode() {
            fetch('/GoGreen-APU/actions/admin/event/get_attendance_code.php?event_id=' + eventId)
                .then(function(response) {
                    return response.text();
                })
                .then(function(text) {
                    var data = text.trim().split('|');
                    if (data[0] === 'success') {
                        codeBox.innerText = data[1]; 
                        timeLeft = parseInt(data[2]); 
                        updateTimerDisplay();
                    } else {
                        codeBox.innerText = "Err";
                    }
                });
        }

        function updateTimerDisplay() {
            timerText.innerText = timeLeft;
            var percent = (timeLeft / totalDuration) * 100;
            var offset = circumference - (percent / 100) * circumference;
            progressRing.style.strokeDashoffset = offset;
            
            if(timeLeft <= 10) {
                progressRing.style.stroke = '#ff4d4d'; 
                timerText.style.color = '#ff4d4d';
            } else {
                progressRing.style.stroke = '#4ade80'; 
                timerText.style.color = '#fff';
            }
        }
    </script>
</body>
</html>