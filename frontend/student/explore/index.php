<!--
    Author: Khoo Lay Bin
    Date: 2026-01-22
    Description: Student Explore Events Page
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/student/explore/explore.css">
    <title>GoGreen@APU - Explore Events</title>
</head>

<body>
    <?php
    $page_name = 'explore';
    include('../nav.php');


    if (isset($_GET['club'])) {
        $selected_club = intval($_GET['club']);
    } else {
        $selected_club = 0;
    }


    if (isset($_GET['paid'])) {
        $filter_paid = $_GET['paid'];
    } else {
        $filter_paid = 'all';
    }


    if (isset($_GET['transport'])) {
        $filter_transport = $_GET['transport'];
    } else {
        $filter_transport = 'all';
    }


    if (isset($_GET['sort'])) {
        $sort_by = $_GET['sort'];
    } else {
        $sort_by = 'date';
    }


    if (isset($_GET['search'])) {
        $search_query = trim($_GET['search']);
    } else {
        $search_query = '';
    }


    if (isset($_GET['start_date'])) {
        $start_date = $_GET['start_date'];
    } else {
        $start_date = '';
    }

    if (isset($_GET['end_date'])) {
        $end_date = $_GET['end_date'];
    } else {
        $end_date = '';
    }


    if (isset($_GET['past'])) {
        $show_past = $_GET['past'];
    } else {
        $show_past = '0';
    }


    $sdg1_selected = (isset($_GET['sdg1']) && $_GET['sdg1'] == '1');
    $sdg2_selected = (isset($_GET['sdg2']) && $_GET['sdg2'] == '1');
    $sdg3_selected = (isset($_GET['sdg3']) && $_GET['sdg3'] == '1');
    $sdg4_selected = (isset($_GET['sdg4']) && $_GET['sdg4'] == '1');
    $sdg5_selected = (isset($_GET['sdg5']) && $_GET['sdg5'] == '1');
    $sdg6_selected = (isset($_GET['sdg6']) && $_GET['sdg6'] == '1');
    $sdg7_selected = (isset($_GET['sdg7']) && $_GET['sdg7'] == '1');
    $sdg8_selected = (isset($_GET['sdg8']) && $_GET['sdg8'] == '1');
    $sdg9_selected = (isset($_GET['sdg9']) && $_GET['sdg9'] == '1');
    $sdg10_selected = (isset($_GET['sdg10']) && $_GET['sdg10'] == '1');
    $sdg11_selected = (isset($_GET['sdg11']) && $_GET['sdg11'] == '1');
    $sdg12_selected = (isset($_GET['sdg12']) && $_GET['sdg12'] == '1');
    $sdg13_selected = (isset($_GET['sdg13']) && $_GET['sdg13'] == '1');
    $sdg14_selected = (isset($_GET['sdg14']) && $_GET['sdg14'] == '1');
    $sdg15_selected = (isset($_GET['sdg15']) && $_GET['sdg15'] == '1');
    $sdg16_selected = (isset($_GET['sdg16']) && $_GET['sdg16'] == '1');
    $sdg17_selected = (isset($_GET['sdg17']) && $_GET['sdg17'] == '1');


    $any_sdg_selected = $sdg1_selected || $sdg2_selected || $sdg3_selected || $sdg4_selected || $sdg5_selected || $sdg6_selected || $sdg7_selected || $sdg8_selected || $sdg9_selected || $sdg10_selected || $sdg11_selected || $sdg12_selected || $sdg13_selected || $sdg14_selected || $sdg15_selected || $sdg16_selected || $sdg17_selected;


    $clubs_sql = "SELECT id, name, description, logo_path, email, website_link FROM clubs ORDER BY name";
    $clubs_result = mysqli_query($conn, $clubs_sql);


    $events_sql = "SELECT e.*, c.name as club_name, c.logo_path as club_logo FROM events e JOIN clubs c ON e.club_id = c.id WHERE e.is_approved = 1";



    if ($show_past == '1') {
        $events_sql = $events_sql . " AND e.start_date < CURDATE()";
    } else {
        $events_sql = $events_sql . " AND e.start_date >= CURDATE()";
    }


    if ($selected_club > 0) {
        $events_sql = $events_sql . " AND e.club_id = " . $selected_club;
    }


    if ($search_query != '') {
        $search_escaped = mysqli_real_escape_string($conn, $search_query);
        $events_sql = $events_sql . " AND e.title LIKE '%" . $search_escaped . "%'";
    }


    if ($start_date != '') {
        $events_sql = $events_sql . " AND e.start_date >= '" . mysqli_real_escape_string($conn, $start_date) . "'";
    }
    if ($end_date != '') {
        $events_sql = $events_sql . " AND e.start_date <= '" . mysqli_real_escape_string($conn, $end_date) . "'";
    }


    if ($filter_paid == 'free') {
        $events_sql = $events_sql . " AND e.is_paid = 0";
    }
    if ($filter_paid == 'paid') {
        $events_sql = $events_sql . " AND e.is_paid = 1";
    }


    if ($filter_transport == 'yes') {
        $events_sql = $events_sql . " AND e.transportation = 1";
    }
    if ($filter_transport == 'no') {
        $events_sql = $events_sql . " AND e.transportation = 0";
    }


    if ($any_sdg_selected) {
        $sdg_conditions = "";
        if ($sdg1_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg1 = 1 OR ";
        }
        if ($sdg2_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg2 = 1 OR ";
        }
        if ($sdg3_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg3 = 1 OR ";
        }
        if ($sdg4_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg4 = 1 OR ";
        }
        if ($sdg5_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg5 = 1 OR ";
        }
        if ($sdg6_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg6 = 1 OR ";
        }
        if ($sdg7_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg7 = 1 OR ";
        }
        if ($sdg8_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg8 = 1 OR ";
        }
        if ($sdg9_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg9 = 1 OR ";
        }
        if ($sdg10_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg10 = 1 OR ";
        }
        if ($sdg11_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg11 = 1 OR ";
        }
        if ($sdg12_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg12 = 1 OR ";
        }
        if ($sdg13_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg13 = 1 OR ";
        }
        if ($sdg14_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg14 = 1 OR ";
        }
        if ($sdg15_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg15 = 1 OR ";
        }
        if ($sdg16_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg16 = 1 OR ";
        }
        if ($sdg17_selected) {
            $sdg_conditions = $sdg_conditions . "e.sdg17 = 1 OR ";
        }

        $sdg_conditions = substr($sdg_conditions, 0, -4);
        $events_sql = $events_sql . " AND (" . $sdg_conditions . ")";
    }


    if ($sort_by == 'likes') {
        $events_sql = $events_sql . " ORDER BY e.like_count DESC";
    } else {
        $events_sql = $events_sql . " ORDER BY e.start_date ASC";
    }


    $events_result = mysqli_query($conn, $events_sql);
    $total_events = mysqli_num_rows($events_result);


    $base_params = "search=" . $search_query . "&club=" . $selected_club . "&past=" . $show_past . "&paid=" . $filter_paid . "&transport=" . $filter_transport . "&sort=" . $sort_by . "&start_date=" . $start_date . "&end_date=" . $end_date;


    if ($sdg1_selected)
        $base_params .= "&sdg1=1";
    if ($sdg2_selected)
        $base_params .= "&sdg2=1";
    if ($sdg3_selected)
        $base_params .= "&sdg3=1";
    if ($sdg4_selected)
        $base_params .= "&sdg4=1";
    if ($sdg5_selected)
        $base_params .= "&sdg5=1";
    if ($sdg6_selected)
        $base_params .= "&sdg6=1";
    if ($sdg7_selected)
        $base_params .= "&sdg7=1";
    if ($sdg8_selected)
        $base_params .= "&sdg8=1";
    if ($sdg9_selected)
        $base_params .= "&sdg9=1";
    if ($sdg10_selected)
        $base_params .= "&sdg10=1";
    if ($sdg11_selected)
        $base_params .= "&sdg11=1";
    if ($sdg12_selected)
        $base_params .= "&sdg12=1";
    if ($sdg13_selected)
        $base_params .= "&sdg13=1";
    if ($sdg14_selected)
        $base_params .= "&sdg14=1";
    if ($sdg15_selected)
        $base_params .= "&sdg15=1";
    if ($sdg16_selected)
        $base_params .= "&sdg16=1";
    if ($sdg17_selected)
        $base_params .= "&sdg17=1";
    ?>


    <main class="main-content">
        <div class="explore-page">


            <div class="mobile-search-row">
                <form method="GET" class="desktop-search-bar mobile-explore-search">
                    <?php if ($selected_club > 0): ?>
                        <input type="hidden" name="club" value="<?php echo $selected_club; ?>">
                    <?php endif; ?>

                    <?php if ($sdg1_selected)
                        echo '<input type="hidden" name="sdg1" value="1">'; ?>
                    <?php if ($sdg2_selected)
                        echo '<input type="hidden" name="sdg2" value="1">'; ?>
                    <?php if ($sdg3_selected)
                        echo '<input type="hidden" name="sdg3" value="1">'; ?>
                    <?php if ($sdg4_selected)
                        echo '<input type="hidden" name="sdg4" value="1">'; ?>
                    <?php if ($sdg5_selected)
                        echo '<input type="hidden" name="sdg5" value="1">'; ?>
                    <?php if ($sdg6_selected)
                        echo '<input type="hidden" name="sdg6" value="1">'; ?>
                    <?php if ($sdg7_selected)
                        echo '<input type="hidden" name="sdg7" value="1">'; ?>
                    <?php if ($sdg8_selected)
                        echo '<input type="hidden" name="sdg8" value="1">'; ?>
                    <?php if ($sdg9_selected)
                        echo '<input type="hidden" name="sdg9" value="1">'; ?>
                    <?php if ($sdg10_selected)
                        echo '<input type="hidden" name="sdg10" value="1">'; ?>
                    <?php if ($sdg11_selected)
                        echo '<input type="hidden" name="sdg11" value="1">'; ?>
                    <?php if ($sdg12_selected)
                        echo '<input type="hidden" name="sdg12" value="1">'; ?>
                    <?php if ($sdg13_selected)
                        echo '<input type="hidden" name="sdg13" value="1">'; ?>
                    <?php if ($sdg14_selected)
                        echo '<input type="hidden" name="sdg14" value="1">'; ?>
                    <?php if ($sdg15_selected)
                        echo '<input type="hidden" name="sdg15" value="1">'; ?>
                    <?php if ($sdg16_selected)
                        echo '<input type="hidden" name="sdg16" value="1">'; ?>
                    <?php if ($sdg17_selected)
                        echo '<input type="hidden" name="sdg17" value="1">'; ?>


                    <input type="text" name="search" id="mobile-search-input" class="desktop-search-input" placeholder="Search events..." value="<?php echo htmlspecialchars($search_query); ?>">

                    <button type="button" class="desktop-clear-btn clear-btn" id="mobile-clear-btn" data-target="mobile-search-input">
                        <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                    </button>


                    <button type="submit" class="desktop-search-btn">
                        <img src="/GoGreen-APU/assets/icons/navigation/search.svg" alt="Search" class="search-icon">
                        <span class="search-text">Search</span>
                    </button>
                </form>



                <button type="button" class="filter-toggle-btn" id="filter-toggle-btn">
                    <img src="/GoGreen-APU/assets/icons/slider.horizontal.3.svg" alt="Filter">
                </button>
            </div>


            <?php
            $clubs_mobile_sql = "SELECT id, name, description, logo_path, email, website_link FROM clubs ORDER BY name";
            $clubs_mobile_result = mysqli_query($conn, $clubs_mobile_sql);
            $selected_club_data = null;
            $clubs_for_dropdown = [];
            while ($c = mysqli_fetch_assoc($clubs_mobile_result)) {
                $clubs_for_dropdown[] = $c;
                if ($selected_club == $c['id']) {
                    $selected_club_data = $c;
                }
            }
            ?>

            <div class="mobile-club-filter">
                <?php if ($selected_club_data): ?>
                    <div class="mobile-club-info">
                        <img src="/GoGreen-APU/assets/images/club/<?php echo $selected_club_data['logo_path']; ?>" class="mobile-club-logo">

                        <div class="mobile-club-text">
                            <select onchange="window.location.href='?club=' + this.value">
                                <?php foreach ($clubs_for_dropdown as $c): ?>
                                    <option value="<?php echo $c['id']; ?>" <?php if ($selected_club == $c['id']) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($c['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <p class="mobile-club-desc"><?php echo htmlspecialchars($selected_club_data['description']); ?></p>

                            <div class="mobile-club-btns">
                                <?php if ($selected_club_data['email']): ?>
                                    <a href="mailto:<?php echo $selected_club_data['email']; ?>" class="club-btn">
                                        <img src="/GoGreen-APU/assets/icons/envelope.svg">
                                    </a>
                                <?php endif; ?>


                                <?php if ($selected_club_data['website_link']): ?>
                                    <a href="<?php echo $selected_club_data['website_link']; ?>" class="club-btn" target="_blank">
                                        <img src="/GoGreen-APU/assets/icons/globe.svg">
                                    </a>
                                <?php endif; ?>
                                <a href="?" class="mobile-club-clear">Clear</a>
                            </div>
                        </div>
                    </div>


                <?php else: ?>
                    <select onchange="window.location.href='?club=' + this.value">
                        <option value="0" selected>All Clubs</option>
                        <?php foreach ($clubs_for_dropdown as $c): ?>
                            <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>

            <div class="explore-layout">

                <aside class="explore-sidebar">
                    <div class="sidebar-header">
                        <h2 class="sidebar-title">Clubs</h2>

                        <?php if ($selected_club > 0): ?>
                            <a href="?" class="sidebar-clear-btn">Clear</a>
                        <?php endif; ?>
                    </div>

                    <div class="club-list">
                        <?php while ($club = mysqli_fetch_assoc($clubs_result)): ?>
                            <?php $is_active = ($selected_club == $club['id']); ?>
                            <div class="club-card <?php if ($is_active) echo 'active'; ?>">
                                <a href="?club=<?php echo $club['id']; ?>" class="club-header">
                                    <img src="/GoGreen-APU/assets/images/club/<?php echo $club['logo_path']; ?>" class="club-logo">

                                    <span class="club-name"><?php echo htmlspecialchars($club['name']); ?></span>
                                </a>


                                <?php if ($is_active): ?>
                                    <div class="club-details">
                                        <p class="club-desc"><?php echo htmlspecialchars($club['description']); ?></p>

                                        <div class="club-actions">
                                            <?php if ($club['email']): ?>
                                                <a href="mailto:<?php echo $club['email']; ?>" class="club-btn">
                                                    <img src="/GoGreen-APU/assets/icons/envelope.svg">
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($club['website_link']): ?>
                                                <a href="<?php echo $club['website_link']; ?>" class="club-btn" target="_blank">
                                                    <img src="/GoGreen-APU/assets/icons/globe.svg">
                                                </a>
                                            <?php endif; ?>


                                            <a href="?" class="club-btn clear">Clear</a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </aside>


                <div class="explore-main">

                    <div id="filter-wrapper" class="filter-wrapper filter-hidden-mobile">

                        <div class="filter-section">
                            <div class="filter-group glass-effect-border">
                                <label>Events</label>

                                <select name="past" onchange="this.form.submit()" form="filter-form">
                                    <option value="0" <?php if ($show_past != '1') {
                                                            echo 'selected';
                                                        } ?>>Upcoming
                                    </option>

                                    <option value="1" <?php if ($show_past == '1') {
                                                            echo 'selected';
                                                        } ?>>Past</option>
                                </select>
                            </div>


                            <div class="filter-group glass-effect-border">
                                <label>Start</label>

                                <input type="date" name="start_date" value="<?php echo $start_date; ?>" form="filter-form" onchange="this.form.submit()">
                            </div>


                            <div class="filter-group glass-effect-border">
                                <label>End</label>

                                <input type="date" name="end_date" value="<?php echo $end_date; ?>" form="filter-form" onchange="this.form.submit()">
                            </div>


                            <div class="filter-group glass-effect-border">
                                <label>Price</label>


                                <select name="paid" onchange="this.form.submit()" form="filter-form">
                                    <option value="all" <?php if ($filter_paid == 'all') {
                                                            echo 'selected';
                                                        } ?>>All
                                    </option>

                                    <option value="free" <?php if ($filter_paid == 'free') {
                                                                echo 'selected';
                                                            } ?>>Free
                                    </option>

                                    <option value="paid" <?php if ($filter_paid == 'paid') {
                                                                echo 'selected';
                                                            } ?>>Paid
                                    </option>
                                </select>
                            </div>


                            <div class="filter-group glass-effect-border">
                                <label>Transport</label>


                                <select name="transport" onchange="this.form.submit()" form="filter-form">
                                    <option value="all" <?php if ($filter_transport == 'all') {
                                                            echo 'selected';
                                                        } ?>>Any
                                    </option>

                                    <option value="yes" <?php if ($filter_transport == 'yes') {
                                                            echo 'selected';
                                                        } ?>>Yes
                                    </option>

                                    <option value="no" <?php if ($filter_transport == 'no') {
                                                            echo 'selected';
                                                        } ?>>No
                                    </option>
                                </select>
                            </div>


                            <div class="filter-group glass-effect-border">
                                <label>Sort</label>


                                <select name="sort" onchange="this.form.submit()" form="filter-form">
                                    <option value="date" <?php if ($sort_by == 'date') {
                                                                echo 'selected';
                                                            } ?>>Date
                                    </option>

                                    <option value="likes" <?php if ($sort_by == 'likes') {
                                                                echo 'selected';
                                                            } ?>>Likes
                                    </option>
                                </select>
                            </div>


                            <form id="filter-form" method="GET" style="display:none;">
                                <?php if ($selected_club > 0): ?>
                                    <input type="hidden" name="club" value="<?php echo $selected_club; ?>">
                                <?php endif; ?>


                                <?php if ($sdg1_selected)
                                    echo '<input type="hidden" name="sdg1" value="1">'; ?>
                                <?php if ($sdg2_selected)
                                    echo '<input type="hidden" name="sdg2" value="1">'; ?>
                                <?php if ($sdg3_selected)
                                    echo '<input type="hidden" name="sdg3" value="1">'; ?>
                                <?php if ($sdg4_selected)
                                    echo '<input type="hidden" name="sdg4" value="1">'; ?>
                                <?php if ($sdg5_selected)
                                    echo '<input type="hidden" name="sdg5" value="1">'; ?>
                                <?php if ($sdg6_selected)
                                    echo '<input type="hidden" name="sdg6" value="1">'; ?>
                                <?php if ($sdg7_selected)
                                    echo '<input type="hidden" name="sdg7" value="1">'; ?>
                                <?php if ($sdg8_selected)
                                    echo '<input type="hidden" name="sdg8" value="1">'; ?>
                                <?php if ($sdg9_selected)
                                    echo '<input type="hidden" name="sdg9" value="1">'; ?>
                                <?php if ($sdg10_selected)
                                    echo '<input type="hidden" name="sdg10" value="1">'; ?>
                                <?php if ($sdg11_selected)
                                    echo '<input type="hidden" name="sdg11" value="1">'; ?>
                                <?php if ($sdg12_selected)
                                    echo '<input type="hidden" name="sdg12" value="1">'; ?>
                                <?php if ($sdg13_selected)
                                    echo '<input type="hidden" name="sdg13" value="1">'; ?>
                                <?php if ($sdg14_selected)
                                    echo '<input type="hidden" name="sdg14" value="1">'; ?>
                                <?php if ($sdg15_selected)
                                    echo '<input type="hidden" name="sdg15" value="1">'; ?>
                                <?php if ($sdg16_selected)
                                    echo '<input type="hidden" name="sdg16" value="1">'; ?>
                                <?php if ($sdg17_selected)
                                    echo '<input type="hidden" name="sdg17" value="1">'; ?>
                            </form>
                        </div>



                        <div class="sdg-section">
                            <div class="sdg-header">
                                <span class="sdg-label">Filter by SDG</span>

                                <?php if ($any_sdg_selected): ?>
                                    <a href="?" class="sdg-clear">Clear</a>
                                <?php endif; ?>
                            </div>


                            <div class="sdg-row">
                                <a href="?<?php echo $base_params; ?>&sdg1=1" class="sdg-btn sdg1 <?php if ($sdg1_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/1.svg" alt=""><span>1. Poverty</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg2=1" class="sdg-btn sdg2 <?php if ($sdg2_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/2.svg" alt=""><span>2. Hunger</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg3=1" class="sdg-btn sdg3 <?php if ($sdg3_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/3.svg" alt=""><span>3. Health</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg4=1" class="sdg-btn sdg4 <?php if ($sdg4_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/4.svg" alt=""><span>4. Education</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg5=1" class="sdg-btn sdg5 <?php if ($sdg5_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/5.svg" alt=""><span>5. Equality</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg6=1" class="sdg-btn sdg6 <?php if ($sdg6_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/6.svg" alt=""><span>6. Water</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg7=1" class="sdg-btn sdg7 <?php if ($sdg7_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/7.svg" alt=""><span>7. Energy</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg8=1" class="sdg-btn sdg8 <?php if ($sdg8_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/8.svg" alt=""><span>8. Work</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg9=1" class="sdg-btn sdg9 <?php if ($sdg9_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/9.svg" alt=""><span>9. Industry</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg10=1" class="sdg-btn sdg10 <?php if ($sdg10_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/10.svg" alt=""><span>10. Inequality</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg11=1" class="sdg-btn sdg11 <?php if ($sdg11_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/11.svg" alt=""><span>11. Cities</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg12=1" class="sdg-btn sdg12 <?php if ($sdg12_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/12.svg" alt=""><span>12. Consumption</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg13=1" class="sdg-btn sdg13 <?php if ($sdg13_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/13.svg" alt=""><span>13. Climate</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg14=1" class="sdg-btn sdg14 <?php if ($sdg14_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/14.svg" alt=""><span>14. Ocean</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg15=1" class="sdg-btn sdg15 <?php if ($sdg15_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/15.svg" alt=""><span>15. Land</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg16=1" class="sdg-btn sdg16 <?php if ($sdg16_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/16.svg" alt=""><span>16. Peace</span>
                                </a>
                                <a href="?<?php echo $base_params; ?>&sdg17=1" class="sdg-btn sdg17 <?php if ($sdg17_selected) echo 'active'; ?>">
                                    <img src="/GoGreen-APU/assets/icons/sdg/17.svg" alt=""><span>17. Partnership</span>
                                </a>
                            </div>
                        </div>

                    </div>



                    <div class="results-info">
                        <strong><?php echo $total_events; ?></strong> events found
                    </div>



                    <?php if ($total_events > 0): ?>
                        <div class="event-grid">
                            <?php while ($event = mysqli_fetch_assoc($events_result)):
                                $event_sdg1 = ($event['sdg1'] == 1);
                                $event_sdg2 = ($event['sdg2'] == 1);
                                $event_sdg3 = ($event['sdg3'] == 1);
                                $event_sdg4 = ($event['sdg4'] == 1);
                                $event_sdg5 = ($event['sdg5'] == 1);
                                $event_sdg6 = ($event['sdg6'] == 1);
                                $event_sdg7 = ($event['sdg7'] == 1);
                                $event_sdg8 = ($event['sdg8'] == 1);
                                $event_sdg9 = ($event['sdg9'] == 1);
                                $event_sdg10 = ($event['sdg10'] == 1);
                                $event_sdg11 = ($event['sdg11'] == 1);
                                $event_sdg12 = ($event['sdg12'] == 1);
                                $event_sdg13 = ($event['sdg13'] == 1);
                                $event_sdg14 = ($event['sdg14'] == 1);
                                $event_sdg15 = ($event['sdg15'] == 1);
                                $event_sdg16 = ($event['sdg16'] == 1);
                                $event_sdg17 = ($event['sdg17'] == 1);


                                $start_day = date('j', strtotime($event['start_date']));
                            ?>


                                <div class="event-card">
                                    <div class="card-image">
                                        <img src="/GoGreen-APU/assets/images/event/<?php echo $event['image_path']; ?>" alt="">


                                        <div class="like-badge">
                                            <img src="/GoGreen-APU/assets/icons/hand.thumbsup.svg" alt="">

                                            <?php echo $event['like_count']; ?>
                                        </div>
                                    </div>


                                    <div class="card-content">
                                        <div class="sdg-pills">
                                            <?php if ($event_sdg1) {
                                                echo '<span class="sdg-pill">SDG 1</span>';
                                            } ?>
                                            <?php if ($event_sdg2) {
                                                echo '<span class="sdg-pill">SDG 2</span>';
                                            } ?>
                                            <?php if ($event_sdg3) {
                                                echo '<span class="sdg-pill">SDG 3</span>';
                                            } ?>
                                            <?php if ($event_sdg4) {
                                                echo '<span class="sdg-pill">SDG 4</span>';
                                            } ?>
                                            <?php if ($event_sdg5) {
                                                echo '<span class="sdg-pill">SDG 5</span>';
                                            } ?>
                                            <?php if ($event_sdg6) {
                                                echo '<span class="sdg-pill">SDG 6</span>';
                                            } ?>
                                            <?php if ($event_sdg7) {
                                                echo '<span class="sdg-pill">SDG 7</span>';
                                            } ?>
                                            <?php if ($event_sdg8) {
                                                echo '<span class="sdg-pill">SDG 8</span>';
                                            } ?>
                                            <?php if ($event_sdg9) {
                                                echo '<span class="sdg-pill">SDG 9</span>';
                                            } ?>
                                            <?php if ($event_sdg10) {
                                                echo '<span class="sdg-pill">SDG 10</span>';
                                            } ?>
                                            <?php if ($event_sdg11) {
                                                echo '<span class="sdg-pill">SDG 11</span>';
                                            } ?>
                                            <?php if ($event_sdg12) {
                                                echo '<span class="sdg-pill">SDG 12</span>';
                                            } ?>
                                            <?php if ($event_sdg13) {
                                                echo '<span class="sdg-pill">SDG 13</span>';
                                            } ?>
                                            <?php if ($event_sdg14) {
                                                echo '<span class="sdg-pill">SDG 14</span>';
                                            } ?>
                                            <?php if ($event_sdg15) {
                                                echo '<span class="sdg-pill">SDG 15</span>';
                                            } ?>
                                            <?php if ($event_sdg16) {
                                                echo '<span class="sdg-pill">SDG 16</span>';
                                            } ?>
                                            <?php if ($event_sdg17) {
                                                echo '<span class="sdg-pill">SDG 17</span>';
                                            } ?>
                                        </div>


                                        <h3 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h3>


                                        <div class="card-meta">
                                            <img src="/GoGreen-APU/assets/icons/date/<?php echo $start_day; ?>.calendar.svg" alt="">

                                            <?php echo date('D, j M Y', strtotime($event['start_date'])); ?>


                                            <?php if ($event['end_date'] && $event['end_date'] != $event['start_date']):
                                                $end_day = date('j', strtotime($event['end_date']));
                                            ?> -
                                                <img src="/GoGreen-APU/assets/icons/date/<?php echo $end_day; ?>.calendar.svg" alt="" style="margin-left: 4px;">

                                                <?php echo date('D, j M Y', strtotime($event['end_date'])); ?>
                                            <?php endif; ?>
                                        </div>


                                        <div class="card-meta">
                                            <img src="/GoGreen-APU/assets/icons/clock.svg" alt="">

                                            <?php echo date('g:i A', strtotime($event['start_time'])); ?> -

                                            <?php echo date('g:i A', strtotime($event['end_time'])); ?>
                                        </div>


                                        <div class="card-meta">
                                            <img src="/GoGreen-APU/assets/icons/mappin.and.ellipse.svg" alt="">

                                            <?php echo htmlspecialchars($event['location']); ?>
                                        </div>


                                        <p class="card-desc"><?php echo htmlspecialchars($event['short_description']); ?></p>


                                        <div class="price-row">
                                            <span class="price">
                                                <?php
                                                if ($event['is_paid']) {
                                                    echo 'RM ' . number_format($event['price'], 2);
                                                } else {
                                                    echo 'FREE';
                                                }
                                                ?>
                                            </span>


                                            <span class="coins">+<?php echo $event['coins_earned']; ?> AP Coins</span>
                                        </div>


                                        <div class="card-footer">
                                            <span class="transport-mini">
                                                <img src="/GoGreen-APU/assets/icons/bus.svg" alt="">

                                                <?php
                                                if ($event['transportation']) {
                                                    echo 'Transport';
                                                } else {
                                                    echo 'Self';
                                                }
                                                ?>
                                            </span>


                                            <a href="/GoGreen-APU/frontend/student/explore/event/index.php?id=<?php echo $event['id']; ?>" class="view-btn">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>

                    <?php else: ?>
                        <div class="empty-state">
                            <h3>No Events Found</h3>

                            <p>Try adjusting your filters or check back later.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/footer.php'; ?>

    <script src="/GoGreen-APU/assets/js/student/explore/filter-toggle.js"></script>

</body>

</html>