<!--
    Author: Khoo Lay Bin
    Date: 2026-1-23
    Description: Add pinned post to student hero section carousel
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>GoGreen@APU - Admin - Pinned Posts</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/home.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/participants.css">
</head>

<?php
    $sql = "SELECT e.id, e.title, e.image_path, e.start_date, e.pinned, c.name as club_name, c.logo_path as club_logo FROM events e LEFT JOIN clubs c ON e.club_id = c.id WHERE e.is_approved = 1 ORDER BY e.pinned DESC, e.start_date DESC";
    $result = mysqli_query($conn, $sql);


    $events = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
?>

<body>
    <?php
        $page_name = 'settings_pinned_post';
        include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
    ?>

    <main>
        <div class="page-header">
            <div class="page-header-text">
                <h1>Pinned Posts</h1>

                <p>Manage pinned events that appear on the homepage.</p>
            </div>
        </div>


        <div class="table-manage-container glass-effect-border">
            <?php if (count($events) > 0): ?>
                <div class="table-left-container" style="width: calc(100% - 120px);">
                    <table>
                        <thead>
                            <tr>
                                <th>NO.</th>
                                <th>EVENT NAME</th>
                                <th>CLUB</th>
                                <th>DATE</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($events as $event):
                                ?>
                                <tr>
                                    <td><?php echo $no; ?></td>


                                    <td class="event-title">
                                        <span class="event-image"><img src="/GoGreen-APU/assets/images/event/<?php echo $event['image_path']; ?>" alt=""></span>

                                        <span><?php echo $event['title']; ?></span>
                                    </td>


                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <span class="user-avatar"><img src="/GoGreen-APU/assets/images/club/<?php echo $event['club_logo']; ?>" alt=""></span>

                                            <span><?php echo $event['club_name']; ?></span>
                                        </div>
                                    </td>


                                    <td>
                                        <?php echo date('Y-m-d', strtotime($event['start_date'])); ?>
                                    </td>
                                </tr>

                                <?php
                                $no++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>



                <div class="table-right-container glass-effect" style="width: 120px;">
                    <table>
                        <thead>
                            <tr>
                                <th>PINNED</th>
                            </tr>
                        </thead>



                        <tbody>
                            <?php
                            foreach ($events as $event):

                                if ($event['pinned'] == 1) {
                                    $is_checked = 'checked';
                                } else {
                                    $is_checked = '';
                                }
                            ?>
                                <tr>
                                    <td>
                                        <form method="POST" action="/GoGreen-APU/actions/admin/system_setting/update_pinned.php">
                                            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">

                                            
                                            <div class="checkbox-switch" style="justify-content: center;">
                                                <input type="checkbox" name="pinned" id="pin_<?php echo $event['id']; ?>" onchange="this.form.submit()" <?php echo $is_checked; ?>>
                                                <label for="pin_<?php echo $event['id']; ?>"></label>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php else: ?>
                <div style="text-align: center; padding: 60px 40px;">
                    <h3 style="color: rgba(255, 255, 255, 0.8);">No Approved Events</h3>

                    <p style="color: rgba(255, 255, 255, 0.5);">There are no approved events to pin.</p>
                </div>
            <?php endif; ?>
        </div>

    </main>
</body>

</html>