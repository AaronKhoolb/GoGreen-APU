<!--
    Author: Damian Loh Yi Feng
    Date: 2026-1-9
    Description: OrganizerAttendance Management Page 
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

$current_user_id = 0;
if (isset($_SESSION['user_id'])) {
    $current_user_id = $_SESSION['user_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['toggle_id'])) {
        $p_id = intval($_POST['toggle_id']);
        
        $sql_part = "SELECT * FROM event_participants WHERE id = $p_id";
        $res_part = mysqli_query($conn, $sql_part);
        $part_data = mysqli_fetch_assoc($res_part);

        if ($part_data) {
            $student_id = $part_data['user_id'];
            $current_status = $part_data['status'];
            $this_event_id = $part_data['event_id'];

            $sql_event = "SELECT coins_earned FROM events WHERE id = $this_event_id";
            $res_event = mysqli_query($conn, $sql_event);
            $event_data = mysqli_fetch_assoc($res_event);
            $coins = intval($event_data['coins_earned']);

            if ($current_status == 'attended') {
                $sql_update_ep = "UPDATE event_participants 
                                  SET status = 'absent', check_in_time = NULL, coins_earned = 0, marked_by = NULL 
                                  WHERE id = $p_id";
                
                $sql_update_student = "UPDATE students SET ap_coins = ap_coins - $coins WHERE user_id = $student_id";
            } else {
                $sql_update_ep = "UPDATE event_participants 
                                  SET status = 'attended', check_in_time = NOW(), coins_earned = $coins, marked_by = $current_user_id 
                                  WHERE id = $p_id";
                
                $sql_update_student = "UPDATE students SET ap_coins = ap_coins + $coins WHERE user_id = $student_id";
            }

            mysqli_query($conn, $sql_update_ep);
            mysqli_query($conn, $sql_update_student);
        }

        header("Location: attendance.php?id=$event_id&filter=$filter");
        exit();
    }

    if (isset($_POST['delete_id'])) {
        $del_id = intval($_POST['delete_id']);
        $sql_del = "DELETE FROM event_participants WHERE id = $del_id";
        mysqli_query($conn, $sql_del);

        header("Location: attendance.php?id=$event_id&filter=$filter");
        exit();
    }
}

$participants = array();
$checked_in_count = 0;
$total_students = 0;

if ($event_id > 0) {
    $sql_get = "SELECT * FROM event_participants WHERE event_id = $event_id";
    
    if ($filter == 'present') {
        $sql_get .= " AND status = 'attended'";
    } elseif ($filter == 'absent') {
        $sql_get .= " AND status = 'absent'";
    }
    
    $sql_get .= " ORDER BY status DESC";

    $result = mysqli_query($conn, $sql_get);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['status'] == 'attended') {
                $checked_in_count++;
            }

            $user_id = $row['user_id'];
            $sql_user = "SELECT first_name, last_name, apkey, avatar_path FROM users WHERE id = $user_id";
            $res_user = mysqli_query($conn, $sql_user);
            $user_data = mysqli_fetch_assoc($res_user);

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
                $sql_marker = "SELECT first_name, avatar_path FROM users WHERE id = $marker_id";
                $res_marker = mysqli_query($conn, $sql_marker);
                $marker_data = mysqli_fetch_assoc($res_marker);

                if ($marker_data) {
                    $row['marker_name'] = $marker_data['first_name'];
                    $row['marker_avatar'] = $marker_data['avatar_path'];
                }
            }

            $participants[] = $row;
        }
    }

    $sql_count = "SELECT COUNT(*) as total FROM event_participants WHERE event_id = $event_id";
    $res_count = mysqli_query($conn, $sql_count);
    $row_count = mysqli_fetch_assoc($res_count);
    $total_students = $row_count['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>Attendance - My Events | GoGreen@APU</title>
    
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
            padding: 0; 
            cursor: pointer; 
            opacity: 0.8; 
            transition: 0.2s; 
        }
        .trash-btn:hover { 
            opacity: 1; 
            transform: scale(1.1); 
        }
        .code-display { 
            font-family: monospace; 
            font-size: 2rem; 
            letter-spacing: 5px; 
            font-weight: bold; 
            margin: 15px 0; 
        }
    </style>
</head>

<body>
    <?php
    $page_name = 'event_attendance';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/organizer/sidebar.php');
    ?>

    <main>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/organizer/my_events/hero.php'); ?>

        <section class="page-content">
            <?php if ($event_id === 0) { ?>
                <div style="text-align:center; padding:50px; color:#ff4d4d;">
                    <h3>Error: Event ID not found</h3>
                </div>
            <?php } else { ?>
                
                <div class="attendance-wrapper">
                    
                    <div class="code-card glass-effect-border">
                        <div id="start-view">
                            <img src="/GoGreen-APU/assets/icons/lock.fill.svg" style="width: 50px; opacity: 0.5; margin-bottom: 15px; filter: invert(1);">
                            <h3>Attendance Session</h3>
                            <p style="color:#aaa; margin-bottom: 30px; font-size: 0.9rem;">Click below to generate live codes.</p>
                            <button class="btn-start" onclick="startSession()">Start Session</button>
                        </div>
                        
                        <div id="live-session" style="display:none;">
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
                                <label>Status</label>
                                <select onchange="location.href='?id=<?php echo $event_id; ?>&filter=' + this.value">
                                    <option value="all" <?php if ($filter == 'all') echo 'selected'; ?>>All</option>
                                    <option value="present" <?php if ($filter == 'present') echo 'selected'; ?>>Present</option>
                                    <option value="absent" <?php if ($filter == 'absent') echo 'selected'; ?>>Absent</option>
                                </select>
                            </div>
                            <div class="table-search-bar">
                                <input type="text" id="search-input" class="custom-search-input" placeholder="Search..." onkeyup="filterTable()">
                                <img src="/GoGreen-APU/assets/icons/navigation/search.svg" style="width:16px; opacity:0.5;">
                            </div>
                        </div>

                        <div class="table-manage-container glass-effect-border">
                            <?php if (count($participants) > 0) { ?>
                                <table style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr style="text-align: left; border-bottom: 1px solid rgba(255,255,255,0.1);">
                                            <th style="padding: 15px;">NAME</th>
                                            <th>STATUS</th>
                                            <th>MARKED BY</th>
                                            <th>TIME</th>
                                            <th>COINS</th>
                                            <th style="text-align: center;">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($participants as $p) { 
                                            $is_attended = ($p['status'] == 'attended');
                                            $status_class = $is_attended ? 'status-present' : 'status-absent';
                                            $status_text = $is_attended ? 'Present' : 'Absent';
                                            $p_name = strtolower($p['first_name'] . ' ' . $p['last_name']);
                                        ?>
                                        <tr class="searchable-row" data-name="<?php echo $p_name; ?>" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                            <td style="padding: 15px;">
                                                <div style="display: flex; align-items: center; gap: 12px;">
                                                    <img src="/GoGreen-APU/assets/images/profile/<?php echo $p['avatar_path']; ?>" onerror="this.src='/GoGreen-APU/assets/images/profile/default.png'" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                                    <div>
                                                        <div style="font-weight: 600;"><?php echo htmlspecialchars($p['last_name'] . ' ' . $p['first_name']); ?></div>
                                                        <div style="font-size: 0.85rem; color: #888;"><?php echo $p['apkey']; ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                                            </td>
                                            <td>
                                                <?php if (isset($p['marker_name'])) { ?>
                                                    <div style="display: flex; align-items: center; gap: 8px;">
                                                        <img src="/GoGreen-APU/assets/images/profile/<?php echo $p['marker_avatar']; ?>" style="width:20px; height:20px; border-radius:50%;">
                                                        <span style="font-size: 0.9rem; color: #ccc;"><?php echo htmlspecialchars($p['marker_name']); ?></span>
                                                    </div>
                                                <?php } else { echo "-"; } ?>
                                            </td>
                                            <td style="color:#aaa; font-size: 0.9rem;">
                                                <?php echo $p['check_in_time'] ? date('H:i', strtotime($p['check_in_time'])) : '-'; ?>
                                            </td>
                                            <td class="coins"><?php echo $p['coins_earned']; ?> AP</td>
                                            <td>
                                                <div style="display: flex; align-items: center; justify-content: center; gap: 15px;">
                                                    <form method="POST" style="margin:0;">
                                                        <input type="hidden" name="toggle_id" value="<?php echo $p['id']; ?>">
                                                        <div class="checkbox-switch">
                                                            <input type="checkbox" id="cb_<?php echo $p['id']; ?>" <?php echo $is_attended ? 'checked' : ''; ?> onchange="this.form.submit()">
                                                            <label for="cb_<?php echo $p['id']; ?>"></label>
                                                        </div>
                                                    </form>
                                                    
                                                    <form method="POST" style="margin:0;" onsubmit="return confirm('Are you sure you want to remove this student?');">
                                                        <input type="hidden" name="delete_id" value="<?php echo $p['id']; ?>">
                                                        <button type="submit" class="trash-btn">
                                                            <img src="/GoGreen-APU/assets/icons/trash.svg" alt="Delete" style="width: 18px;">
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <div style="text-align:center; padding:80px; color:#666;">
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
            var rows = document.getElementsByClassName('searchable-row');

            for (var i = 0; i < rows.length; i++) {
                var name = rows[i].getAttribute('data-name');
                if (name.indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }

        var eventId = <?php echo $event_id; ?>;
        var startView = document.getElementById('start-view');
        var liveSession = document.getElementById('live-session');
        var codeBox = document.getElementById('code-box');
        var timerText = document.getElementById('timer-text');
        var progressRing = document.getElementById('progress-ring');
        
        let timeLeft = 0;
        const totalDuration = 120; 

        if(progressRing) {
            var circumference = 2 * Math.PI * 32;
            progressRing.style.strokeDasharray = `${circumference} ${circumference}`;
            progressRing.style.strokeDashoffset = 0;
        }

        function startSession() {
            startView.style.display = 'none';
            liveSession.style.display = 'flex';
            
            fetchCode(); 
            
            setInterval(function() {
                if (timeLeft > 0) {
                    timeLeft--;
                    updateDisplay();
                } else if (timeLeft === 0) {
                    timeLeft = -1; 
                    fetchCode();
                }
            }, 1000);
        }

        function fetchCode() {
            fetch('/GoGreen-APU/actions/admin/event/get_attendance_code.php?event_id=' + eventId)
                .then(function(response) {
                    return response.text();
                })
                .then(function(text) {
                    var parts = text.trim().split('|');
                    if (parts[0] === 'success') {
                        codeBox.innerText = parts[1];
                        timeLeft = parseInt(parts[2]);
                        updateDisplay();
                    } else {
                        codeBox.innerText = "ERROR";
                    }
                });
        }

        function updateDisplay() {
            timerText.innerText = timeLeft;
            var percent = (timeLeft / totalDuration) * 100;
            var offset = circumference - (percent / 100) * circumference;
            
            if(progressRing) {
                progressRing.style.strokeDashoffset = offset;
                if(timeLeft <= 10) {
                    progressRing.style.stroke = '#ff4d4d';
                } else {
                    progressRing.style.stroke = '#4ade80'; 
                }
            }
        }
    </script>
</body>
</html>