<!--
    Author: Khoo Lay Bin
    Date: 2026-1-3
    Description: My Events manage participants page - approve, reject, delete
-->
    
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>Participants - Manage Events | GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/hero.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/home.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/participants.css">
</head>

<body>
    <?php
        $page_name = 'event_participants';
        include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');

        $event_id = intval($_GET['id']);
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

        
        $event_result = mysqli_query($conn, "SELECT is_paid FROM events WHERE id = $event_id");
        $event = mysqli_fetch_assoc($event_result);
        $is_paid = $event['is_paid'];

        
        $sql = "SELECT ep.id, ep.user_id, ep.receipt_path, ep.approval_status, ep.approved_by, ep.approved_at, ep.coins_earned, ep.registered_at, u.first_name, u.last_name, u.apkey, u.avatar_path, approver.first_name AS approver_first_name, approver.last_name AS approver_last_name, approver.apkey AS approver_apkey, approver.avatar_path AS approver_avatar FROM event_participants ep JOIN users u ON ep.user_id = u.id LEFT JOIN users approver ON ep.approved_by = approver.id WHERE ep.event_id = $event_id ORDER BY ep.registered_at DESC";
        $result = mysqli_query($conn, $sql);

        $participants = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $participants[] = $row;
        }
    ?>

    <main>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/event/hero.php'); ?>

        <div class="page-header">
            <div class="page-header-text">
                <h1>Participants</h1>

                <p>Manage participants who registered for this event.</p>
            </div>
        </div>

        <div class="table-actions-container glass-effect">
            <div class="table-filters">
                <div class="filter-group glass-effect-border">
                    <label for="filter-status">Status</label>

                    <select id="filter-status" onchange="location.href='?id=<?php echo $event_id; ?>&filter=' + this.value">
                        <option value="all" <?php if ($filter == 'all') { echo 'selected'; } ?>>All</option>

                        <option value="pending" <?php if ($filter == 'pending') { echo 'selected'; } ?>>Pending</option>

                        <option value="approved" <?php if ($filter == 'approved') { echo 'selected'; } ?>>Approved</option>

                        <option value="rejected" <?php if ($filter == 'rejected') { echo 'selected'; } ?>>Rejected</option>
                    </select>
                </div>
            </div>

            <div class="table-manage-container glass-effect-border">
                <?php if (count($participants) > 0): ?>
                    <div class="table-left-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>NAME</th>
                                    <th>STATUS</th>
                                    <th>APPROVED BY</th>
                                    <th>APPROVED AT</th>
                                    <th>AP COINS</th>
                                    <th>REGISTERED AT</th>
                                </tr>
                            </thead>


                            <tbody>
                                <?php foreach ($participants as $p): ?>
                                    <?php
                                        $status = $p['approval_status'] === null ? 'pending' : ($p['approval_status'] == 1 ? 'approved' : 'rejected');

                                        if ($filter != 'all' && $filter != $status) continue;
                                    ?>


                                    <tr>
                                        <td class="event-title">
                                            <span class="user-avatar"><img src="/GoGreen-APU/assets/images/profile/<?php echo $p['avatar_path']; ?>" alt=""></span>

                                            <span class="user-info">
                                                <span><?php echo htmlspecialchars($p['last_name'] . ' ' . $p['first_name']); ?></span>

                                                <span class="user-apkey"><?php echo htmlspecialchars($p['apkey']); ?></span>
                                            </span>
                                        </td>


                                        <td><span class="status-badge status-<?php echo $status; ?>"><?php echo ucfirst($status); ?></span></td>
                                        
                                        
                                        <td>
                                            <?php if ($p['approved_by'] !== null): ?>
                                                <span class="approver-info">
                                                    <span class="user-avatar-small"><img src="/GoGreen-APU/assets/images/profile/<?php echo $p['approver_avatar']; ?>" alt=""></span>


                                                    <span class="user-info">
                                                        <span class="approver-name"><?php echo htmlspecialchars($p['approver_last_name'] . ' ' . $p['approver_first_name']); ?></span>

                                                        <span class="approver-apkey"><?php echo htmlspecialchars($p['approver_apkey']); ?></span>
                                                    </span>
                                                </span>


                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>


                                        <td>
                                            <?php if ($p['approved_at'] !== null): ?>
                                                <?php echo date('d M Y, H:i', strtotime($p['approved_at'])); ?>


                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>


                                        <td class="coins"><?php echo $p['coins_earned']; ?> AP</td>
                                        
                                        
                                        <td><?php echo date('d M Y, H:i', strtotime($p['registered_at'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-right-container glass-effect">
                        <table>
                            <thead>
                                <tr>
                                    <?php if ($is_paid == 1): ?>
                                        <th colspan="3">Actions</th>

                                    <?php else: ?>
                                        <th colspan="2">Actions</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>


                            <tbody>
                                <?php foreach ($participants as $p): ?>
                                    <?php
                                        $status = $p['approval_status'] === null ? 'pending' : ($p['approval_status'] == 1 ? 'approved' : 'rejected');

                                        if ($filter != 'all' && $filter != $status) continue;

                                        $is_checked = $p['approval_status'] == 1 ? 'checked' : '';

                                        $next_action = $p['approval_status'] == 1 ? 'reject' : 'approve';
                                    ?>


                                    <tr>
                                        <?php if ($is_paid == 1): ?>
                                            <td>
                                                <a href="/GoGreen-APU/lib/pdfjs/web/viewer.html?file=../../../uploads/receipt/<?php echo $p['receipt_path']; ?>" target="_blank">
                                                    <img src="/GoGreen-APU/assets/icons/text.document.svg" alt="Receipt">
                                                </a>
                                            </td>
                                        <?php endif; ?>


                                        <td>
                                            <form action="/GoGreen-APU/actions/event/approve_participant.php" method="GET">
                                                <input type="hidden" name="id" value="<?php echo $event_id; ?>">
                                                <input type="hidden" name="participant_id" value="<?php echo $p['id']; ?>">
                                                <input type="hidden" name="action" value="<?php echo $next_action; ?>">


                                                <div class="checkbox-switch">
                                                    <input type="checkbox" id="cb_<?php echo $p['id']; ?>" <?php echo $is_checked; ?> onchange="this.form.submit()">
                                                    <label for="cb_<?php echo $p['id']; ?>"></label>
                                                </div>
                                            </form>
                                        </td>


                                        <td>
                                            <a href="/GoGreen-APU/actions/event/delete_participant.php?id=<?php echo $event_id; ?>&participant_id=<?php echo $p['id']; ?>" onclick="return confirm('Delete this participant?');">
                                                <span class="trash-btn"><img src="/GoGreen-APU/assets/icons/trash.svg" alt="Delete"></span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php else: ?>
                    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 300px; width: 100%;">
                        <img src="/GoGreen-APU/assets/icons/person.3.svg" alt="" style="width: 80px; height: 80px; filter: invert(1); opacity: 0.3; margin-bottom: 20px;">

                        <h3 style="font-size: 22px; margin-bottom: 10px; color: rgba(255,255,255,0.8);">No Participants Yet</h3>

                        <p style="font-size: 15px; color: rgba(255,255,255,0.5);">No one has registered for this event yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>

</html>