 <!--
    Author: Chong Jun Yoong
    Date: 2026-1-8
    Description: Admin interface for editing detailed information about a specific event.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>Information - My Events | GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/hero.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/information.css">
</head>

<body>
    <?php
    $page_name = 'event_info';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');

    $event_id = intval($_GET['id']);

    $sql = "SELECT * FROM events WHERE id = $event_id";
    $result = mysqli_query($conn, $sql);
    $event = mysqli_fetch_assoc($result);

    $club_sql = "SELECT * FROM clubs WHERE id = {$event['club_id']}";
    $club_result = mysqli_query($conn, $club_sql);
    $club = mysqli_fetch_assoc($club_result);
    ?>

    <main>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/event/hero.php'); ?>

        <section class="page-content">

            <form action="/GoGreen-APU/actions/organizer/my_events/information.php" method="post" enctype="multipart/form-data" id="event-info-form">
                <div class="page-header">
                    <h2>Event Information</h2>
                    <div class="header-actions">
                        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                        <button type="reset" class="btn-discard" value="Discard Changes">
                            <img src="/GoGreen-APU/assets/icons/x.circle.fill.svg" alt="">
                            <span>Discard Changes</span>
                        </button>
                        <button type="submit" class="btn-save" value="Save Changes">
                            <img src="/GoGreen-APU/assets/icons/text.document.svg" alt="">
                            <span>Save Changes</span>
                        </button>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/info.circle.svg" alt=""></span>
                        <h3>Basic Details</h3>
                    </div>

                    <div class="form-part-content">
                        <div class="form-field">
                            <label for="event_title">Event Title</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" name="event_title" id="event_title" value="<?php echo htmlspecialchars($event['title']); ?>" required>
                                <button type="button" class="clear-btn" data-target="event_title">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt=""></button>
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="description">Description</label>
                            <div class="txt-container glass-effect-border">
                                <textarea name="description" id="description" required><?php echo htmlspecialchars($event['short_description']); ?></textarea>
                                <button type="button" class="clear-btn" data-target="description">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt=""></button>
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="details">Details</label>
                            <div class="txt-container glass-effect-border">
                                <textarea name="details" id="details" required><?php echo $event['details']; ?></textarea>
                                <button type="button" class="clear-btn" data-target="details">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt=""></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-subpart">
                    <div class="form-subpart-container">
                        <div class="form-part-header">
                            <span><img src="/GoGreen-APU/assets/icons/calendar.badge.clock.svg" alt=""></span>
                            <h3>Date & Time</h3>
                        </div>

                        <div class="form-part-content">

                            <table>
                                <tr>
                                    <td>
                                        <div class="form-field">
                                            <label for="start_date">Start Date</label>
                                            <div class="txt-container glass-effect-border">
                                                <input type="date" name="start_date" id="start_date" value="<?php echo $event['start_date']; ?>" required>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-field">
                                            <label for="start_time">Start Time</label>
                                            <div class="txt-container glass-effect-border">
                                                <input type="time" name="start_time" id="start_time" value="<?php echo substr($event['start_time'], 0, 5); ?>" required>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="form-field">
                                            <label for="end_date">End Date</label>
                                            <div class="txt-container glass-effect-border">
                                                <input type="date" name="end_date" id="end_date" value="<?php echo $event['end_date']; ?>">
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-field">
                                            <label for="end_time">End Time</label>
                                            <div class="txt-container glass-effect-border">
                                                <input type="time" name="end_time" id="end_time" value="<?php echo $event['end_time'] ? substr($event['end_time'], 0, 5) : ''; ?>">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="form-subpart-container">
                        <div class="form-part-header">
                            <span><img src="/GoGreen-APU/assets/icons/mappin.and.ellipse.svg" alt=""></span>
                            <h3>Location</h3>
                        </div>

                        <div class="form-part-content">
                            <div class="form-field">
                                <label for="address">Address</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($event['location']); ?>" required>
                                    <button type="button" class="clear-btn" data-target="address">
                                        <img src="/GoGreen-APU/assets/icons/xmark.svg" alt=""></button>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="embed_map">Google Maps embed code</label>
                                <div class="txt-container glass-effect-border">
                                    <textarea name="embed_map" id="embed_map"><?php echo isset($event['embed_map']) ? $event['embed_map'] : ''; ?></textarea>
                                    <button type="button" class="clear-btn" data-target="embed_map">
                                        <img src="/GoGreen-APU/assets/icons/xmark.svg" alt=""></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-subpart">
                    <div class="form-part">
                        <div class="form-part-header">
                            <span><img src="/GoGreen-APU/assets/icons/car.svg" alt=""></span>
                            <h3>Transportation</h3>
                        </div>

                        <div class="form-part-content">
                            <div class="form-field">
                                <label for="transportation">Transportation Provided</label>
                                <div class="form-switch">
                                    <div class="checkbox-switch">
                                        <input type="checkbox" name="transportation" id="transportation" <?php echo $event['transportation'] ? 'checked' : ''; ?>>
                                        <label for="transportation"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="transportation_details">Details</label>
                                <div class="txt-container glass-effect-border">
                                    <textarea name="transportation_details" id="transportation_details"><?php echo htmlspecialchars($event['transport_details'] ?? ''); ?></textarea>
                                    <button type="button" class="clear-btn" data-target="transportation_details">
                                        <img src="/GoGreen-APU/assets/icons/xmark.svg" alt=""></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-part">
                        <div class="form-part-header">
                            <span><img src="/GoGreen-APU/assets/icons/person.3.svg" alt=""></span>
                            <h3>Participation & Fees</h3>
                        </div>

                        <div class="form-part-content">
                            <div class="form-field">
                                <label for="coins_earned">AP Coins Awarded</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="number" name="coins_earned" id="coins_earned" step="1" value="<?php echo $event['coins_earned']; ?>" required>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="max_participants">Max Participants</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="number" name="max_participants" id="max_participants" step="1" value="<?php echo $event['max_participants']; ?>" required>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="registration_deadline">Registration Deadline</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="datetime-local" name="registration_deadline" id="registration_deadline" value="<?php echo date('Y-m-d\TH:i', strtotime($event['registration_deadline'])); ?>" required>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="fee">Paid Event</label>
                                <div class="form-switch">
                                    <div class="checkbox-switch">
                                        <input type="checkbox" name="is_paid" id="fee" <?php echo $event['is_paid'] ? 'checked' : ''; ?>>
                                        <label for="fee"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="price">Price</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="number" name="price" id="price" step="0.01" value="<?php echo $event['price'] ?? '0.00'; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/leaf.svg" alt=""></span>
                        <h3>Sustainable Development Goals (SDGs)</h3>
                    </div>

                    <div class="form-part-content">
                        <table>
                            <tr>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-1">SDG 1</span>No Poverty</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg1" id="sdg_1" <?php echo $event['sdg1'] ? 'checked' : ''; ?>>
                                            <label for="sdg_1"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-10">SDG 10</span>Reduced Inequality</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg10" id="sdg_10" <?php echo $event['sdg10'] ? 'checked' : ''; ?>>
                                            <label for="sdg_10"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-2">SDG 2</span>Zero Hunger</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg2" id="sdg_2" <?php echo $event['sdg2'] ? 'checked' : ''; ?>>
                                            <label for="sdg_2"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-11">SDG 11</span>Sustainable Cities and Communities</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg11" id="sdg_11" <?php echo $event['sdg11'] ? 'checked' : ''; ?>>
                                            <label for="sdg_11"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-3">SDG 3</span>Good Health and Well-being</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg3" id="sdg_3" <?php echo $event['sdg3'] ? 'checked' : ''; ?>>
                                            <label for="sdg_3"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-12">SDG 12</span>Responsible Consumption and Production</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg12" id="sdg_12" <?php echo $event['sdg12'] ? 'checked' : ''; ?>>
                                            <label for="sdg_12"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-4">SDG 4</span>Quality Education</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg4" id="sdg_4" <?php echo $event['sdg4'] ? 'checked' : ''; ?>>
                                            <label for="sdg_4"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-13">SDG 13</span>Climate Action</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg13" id="sdg_13" <?php echo $event['sdg13'] ? 'checked' : ''; ?>>
                                            <label for="sdg_13"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-5">SDG 5</span>Gender Equality</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg5" id="sdg_5" <?php echo $event['sdg5'] ? 'checked' : ''; ?>>
                                            <label for="sdg_5"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-14">SDG 14</span>Life Below Water</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg14" id="sdg_14" <?php echo $event['sdg14'] ? 'checked' : ''; ?>>
                                            <label for="sdg_14"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-6">SDG 6</span>Clean Water and Sanitation</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg6" id="sdg_6" <?php echo $event['sdg6'] ? 'checked' : ''; ?>>
                                            <label for="sdg_6"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-15">SDG 15</span>Life on Land</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg15" id="sdg_15" <?php echo $event['sdg15'] ? 'checked' : ''; ?>>
                                            <label for="sdg_15"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-7">SDG 7</span>Affordable and Clean Energy</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg7" id="sdg_7" <?php echo $event['sdg7'] ? 'checked' : ''; ?>>
                                            <label for="sdg_7"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-16">SDG 16</span>Peace, Justice and Strong Institutions</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg16" id="sdg_16" <?php echo $event['sdg16'] ? 'checked' : ''; ?>>
                                            <label for="sdg_16"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-8">SDG 8</span>Decent Work and Economic Growth</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg8" id="sdg_8" <?php echo $event['sdg8'] ? 'checked' : ''; ?>>
                                            <label for="sdg_8"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-17">SDG 17</span>Partnerships for the Goals</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg17" id="sdg_17" <?php echo $event['sdg17'] ? 'checked' : ''; ?>>
                                            <label for="sdg_17"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-9">SDG 9</span>Industry, Innovation and Infrastructure</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg9" id="sdg_9" <?php echo $event['sdg9'] ? 'checked' : ''; ?>>
                                            <label for="sdg_9"></label>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/antenna.radiowaves.left.and.right.svg" alt=""></span>
                        <h3>Contact</h3>
                    </div>

                    <div class="form-part-content">
                        <div class="form-field">
                            <label for="phone_number">Phone Number</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($event['phone_no'] ?? ''); ?>">
                                <button type="button" class="clear-btn" data-target="phone_number">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear"></button>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="whatsapp">WhatsApp</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" id="whatsapp" name="whatsapp" value="<?php echo htmlspecialchars($event['whatsapp'] ?? ''); ?>">
                                <button type="button" class="clear-btn" data-target="whatsapp">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear"></button>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="facebook">Facebook</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" id="facebook" name="facebook" value="<?php echo htmlspecialchars($event['facebook'] ?? ''); ?>">
                                <button type="button" class="clear-btn" data-target="facebook">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear"></button>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="instagram">Instagram</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" id="instagram" name="instagram" value="<?php echo htmlspecialchars($event['instagram'] ?? ''); ?>">
                                <button type="button" class="clear-btn" data-target="instagram">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear"></button>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="discord">Discord</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" id="discord" name="discord" value="<?php echo htmlspecialchars($event['discord'] ?? ''); ?>">
                                <button type="button" class="clear-btn" data-target="discord">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear"></button>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="teams">Microsoft Teams</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" id="teams" name="teams" value="<?php echo htmlspecialchars($event['teams'] ?? ''); ?>">
                                <button type="button" class="clear-btn" data-target="teams">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </section>
    </main>

</body>

</html>