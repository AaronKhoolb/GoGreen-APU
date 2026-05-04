 <!--
    Author: Chong Jun Yoong
    Date: 2026-1-10
    Description: Admin interface for creating a new event.
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php');
    $clubs_sql = "SELECT id, name FROM clubs ORDER BY name ASC";
    $clubs_result = mysqli_query($conn, $clubs_sql);
    ?>
    <title>GoGreen@APU - Admin</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/information.css">
    <style>
        .form-hint {
            font-size: 13px;
            color: #aaa;
            margin: -10px 0 15px 0;
            padding-left: 5px;
        }

        .required-star {
            color: #f44336;
            margin-left: 3px;
        }
    </style>
</head>

<body>
    <?php
    $page_name = 'create_event';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
    ?>

    <main>
        <section class="page-content">

            <form action="/GoGreen-APU/actions/admin/event/create_event_admin.php" method="post"
                enctype="multipart/form-data" id="event-info-form">
                <div class="page-header">
                    <h2>Create New Event</h2>
                    <div class="header-actions">
                        <button type="reset" class="btn-discard" value="Discard Changes">
                            <img src="/GoGreen-APU/assets/icons/x.circle.fill.svg" alt="">
                            <span>Discard</span>
                        </button>
                        <button type="submit" class="btn-save" value="Create Event">
                            <img src="/GoGreen-APU/assets/icons/text.document.svg" alt="">
                            <span>Create Event</span>
                        </button>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/info.circle.svg" alt=""></span>
                        <h3>Basic Information</h3>
                    </div>

                    <div class="form-part-content">
                        <div class="form-row">
                            <div class="form-field">
                                <label for="club_id">Club <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <select name="club_id" id="club_id" required
                                        style="background:transparent; color:white; border:none; width:100%; height:100%; padding:10px; outline:none;">
                                        <option value="" style="color:black;">Select Club</option>
                                        <?php
                                        if ($clubs_result && $clubs_result->num_rows > 0) {
                                            while ($club = $clubs_result->fetch_assoc()) {
                                                echo "<option value='{$club['id']}' style='color:black;'>{$club['name']}</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="event_title">Event Title <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" name="event_title" id="event_title" required>
                                    <button type="button" class="clear-btn" data-target="event_title">
                                        <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="">
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="description">Short Description <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border">
                                <textarea name="description" id="description" required></textarea>
                                <button type="button" class="clear-btn" data-target="description"><img
                                        src="/GoGreen-APU/assets/icons/xmark.svg" alt=""></button>
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="details">Detailed Description <span class="required-star">*</span></label>
                            <div class="txt-container glass-effect-border">
                                <textarea name="details" id="details" required></textarea>
                                <button type="button" class="clear-btn" data-target="details"><img
                                        src="/GoGreen-APU/assets/icons/xmark.svg" alt=""></button>
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="event_cover">Event Cover Image (JPG, PNG, GIF, WebP, SVG)</label>
                            <div class="txt-container glass-effect-border">
                                <input type="file" name="event_cover" id="event_cover" accept="image/*">
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
                                            <label for="start_date">Start Date <span
                                                    class="required-star">*</span></label>
                                            <div class="txt-container glass-effect-border">
                                                <input type="date" name="start_date" id="start_date" required>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-field">
                                            <label for="start_time">Start Time <span
                                                    class="required-star">*</span></label>
                                            <div class="txt-container glass-effect-border">
                                                <input type="time" name="start_time" id="start_time" required>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="form-field">
                                            <label for="end_date">End Date</label>
                                            <div class="txt-container glass-effect-border">
                                                <input type="date" name="end_date" id="end_date">
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-field">
                                            <label for="end_time">End Time <span class="required-star">*</span></label>
                                            <div class="txt-container glass-effect-border">
                                                <input type="time" name="end_time" id="end_time" required>
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
                                <label for="address">Address <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <input type="text" name="address" id="address" required>
                                    <button type="button" class="clear-btn" data-target="address"><img
                                            src="/GoGreen-APU/assets/icons/xmark.svg" alt=""></button>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="embed_map">Google Maps Embed Code</label>
                                <div class="txt-container glass-effect-border">
                                    <textarea name="embed_map" id="embed_map"></textarea>
                                    <button type="button" class="clear-btn" data-target="embed_map"><img
                                            src="/GoGreen-APU/assets/icons/xmark.svg" alt=""></button>
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
                                <label for="transportation">Provide Transportation</label>
                                <div class="form-switch">
                                    <div class="checkbox-switch">
                                        <input type="checkbox" name="transportation" id="transportation">
                                        <label for="transportation"></label>
                                    </div>
                                    <label for="transportation" id="transportation-label">Not Provided</label>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="transportation_details">Transportation Details</label>
                                <div class="txt-container glass-effect-border">
                                    <textarea name="transportation_details" id="transportation_details"></textarea>
                                    <button type="button" class="clear-btn" data-target="transportation_details"><img
                                            src="/GoGreen-APU/assets/icons/xmark.svg" alt=""></button>
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
                                <label for="coins_earned">AP Coins Awarded <span class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <input type="number" name="coins_earned" id="coins_earned" step="1" value="0"
                                        required>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="max_participants">Maximum Participants <span
                                        class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <input type="number" name="max_participants" id="max_participants" step="1"
                                        value="50" required>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="registration_deadline">Registration Deadline <span
                                        class="required-star">*</span></label>
                                <div class="txt-container glass-effect-border">
                                    <input type="datetime-local" name="registration_deadline" id="registration_deadline"
                                        required>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="fee">Fee</label>
                                <div class="form-switch">
                                    <div class="checkbox-switch">
                                        <input type="checkbox" name="is_paid" id="fee">
                                        <label for="fee"></label>
                                    </div>
                                    <label for="fee" id="fee-label">Free</label>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="price">Price</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="number" name="price" id="price" step="0.01" value="0.00" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/leaf.svg" alt=""></span>
                        <h3>Sustainable Development Goals (SDGs) </h3>
                    </div>

                    <div class="form-part-content">
                        <table>
                            <tr>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-1">SDG 1</span>No Poverty</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg1" id="sdg_1">
                                            <label for="sdg_1"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-10">SDG 10</span>Reduced Inequality</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg10" id="sdg_10">
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
                                            <input type="checkbox" name="sdg2" id="sdg_2">
                                            <label for="sdg_2"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-11">SDG 11</span>Sustainable Cities and
                                            Communities</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg11" id="sdg_11">
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
                                            <input type="checkbox" name="sdg3" id="sdg_3">
                                            <label for="sdg_3"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-12">SDG 12</span>Responsible Consumption and
                                            Production</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg12" id="sdg_12">
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
                                            <input type="checkbox" name="sdg4" id="sdg_4">
                                            <label for="sdg_4"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-13">SDG 13</span>Climate Action</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg13" id="sdg_13">
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
                                            <input type="checkbox" name="sdg5" id="sdg_5">
                                            <label for="sdg_5"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-14">SDG 14</span>Life Below Water</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg14" id="sdg_14">
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
                                            <input type="checkbox" name="sdg6" id="sdg_6">
                                            <label for="sdg_6"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-15">SDG 15</span>Life on Land</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg15" id="sdg_15">
                                            <label for="sdg_15"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-7">SDG 7</span>Affordable and Clean
                                            Energy</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg7" id="sdg_7">
                                            <label for="sdg_7"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-16">SDG 16</span>Peace, Justice and Strong
                                            Institutions</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg16" id="sdg_16">
                                            <label for="sdg_16"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-8">SDG 8</span>Decent Work and Economic
                                            Growth</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg8" id="sdg_8">
                                            <label for="sdg_8"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-17">SDG 17</span>Partnerships for the
                                            Goals</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg17" id="sdg_17">
                                            <label for="sdg_17"></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-field">
                                        <label for=""><span class="sdg-9">SDG 9</span>Industry, Innovation and
                                            Infrastructure</label>
                                        <div class="checkbox-switch">
                                            <input type="checkbox" name="sdg9" id="sdg_9">
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
                                <input type="text" id="phone_number" name="phone_number">
                                <button type="button" class="clear-btn" data-target="phone_number">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                                </button>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="whatsapp">WhatsApp</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" id="whatsapp" name="whatsapp">
                                <button type="button" class="clear-btn" data-target="whatsapp">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                                </button>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="facebook">Facebook</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" id="facebook" name="facebook">
                                <button type="button" class="clear-btn" data-target="facebook">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                                </button>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="instagram">Instagram</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" id="instagram" name="instagram">
                                <button type="button" class="clear-btn" data-target="instagram">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                                </button>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="discord">Discord</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" id="discord" name="discord">
                                <button type="button" class="clear-btn" data-target="discord">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                                </button>
                            </div>
                        </div>
                        <div class="form-field">
                            <label for="teams">Microsoft Teams</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" id="teams" name="teams">
                                <button type="button" class="clear-btn" data-target="teams">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </section>
    </main>

    <script>
        <?php if (isset($_SESSION['success_message'])): ?>
            alert('<?php echo addslashes($_SESSION['success_message']); ?>');
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            alert('<?php echo addslashes($_SESSION['error_message']); ?>');
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    </script>
    <script src="/GoGreen-APU/assets/js/organizer/information.js"></script>
</body>

</html>