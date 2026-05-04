<!--
    Author: Khoo Lay Bin
    Date: 2026-1-5
    Description: A carousel section for pinned events - like advertisements
-->

<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

    $sql = "SELECT e.id, e.title, e.image_path, c.name as club_name, c.logo_path as club_logo FROM events e LEFT JOIN clubs c ON e.club_id = c.id WHERE e.pinned = 1 ORDER BY e.start_date DESC";
    $result = mysqli_query($conn, $sql);


    $events = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
    $total = count($events);
?>


<?php if ($total > 0): ?>

    <section class="slider-box" id="slider">


        <div class="slider-bg">
            <img src="/GoGreen-APU/assets/images/event/<?php echo $events[0]['image_path']; ?>" alt="" id="bg-img" class="show">
            <div class="slider-dark"></div>
        </div>


        <div class="slider-info">
            <h1 class="slider-title" id="slider-title"><?php echo $events[0]['title']; ?></h1>
            <div class="slider-club">
                <img src="/GoGreen-APU/assets/images/club/<?php echo $events[0]['club_logo']; ?>" alt="" id="club-logo">
                <span id="club-name"><?php echo $events[0]['club_name']; ?></span>
            </div>
            <a href="/GoGreen-APU/frontend/student/explore/event/index.php?id=<?php echo $events[0]['id']; ?>" class="slider-btn glass-effect-border" id="slider-link">Learn More</a>
        </div>

        <div class="slider-cards-box">


            <div class="slider-cards" id="slider-cards">
                <?php for ($i = 0; $i < $total; $i++): ?>

                    <?php $event = $events[$i]; ?>

                    <div class="thumb-card <?php echo ($i == 0) ? 'active' : ''; ?>" data-index="<?php echo $i; ?>"
                        data-img="/GoGreen-APU/assets/images/event/<?php echo $event['image_path']; ?>"
                        data-title="<?php echo htmlspecialchars($event['title']); ?>"
                        data-club="<?php echo htmlspecialchars($event['club_name']); ?>"
                        data-club-logo="/GoGreen-APU/assets/images/club/<?php echo $event['club_logo']; ?>"
                        data-link="/GoGreen-APU/frontend/student/explore/event/index.php?id=<?php echo $event['id']; ?>">
                        
                        
                        <div class="thumb-img">
                            <img src="/GoGreen-APU/assets/images/event/<?php echo $event['image_path']; ?>" alt="">
                        </div>

                        <span class="thumb-title"><?php echo $event['title']; ?></span>
                        
                    </div>

                <?php endfor; ?>
            </div>

        </div>

    </section>

    <script src="/GoGreen-APU/assets/js/student/home/hero.js"></script>

<?php endif; ?>