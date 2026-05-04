<!--
    Author: Chong Ray Han
    Date: 2026-01-30
    Description: Admin interface for managing clubs, including viewing club details, editing, and deleting clubs.
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>GoGreen@APU - Admin - Manage Clubs</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/admin/club.css">
</head>

<?php
$search = $_GET['search'] ?? '';

// Initialize counters
$total_clubs = 0;
$total_events = 0;
$total_organizers = 0;
$clubs = [];

// Fetch all clubs with their event count and organizer count
$clubs_query = "
    SELECT 
        c.id, 
        c.name, 
        c.description, 
        c.logo_path, 
        c.email, 
        c.website_link,
        (SELECT COUNT(*) FROM events e WHERE e.club_id = c.id) as event_count,
        (SELECT COUNT(*) FROM organizers o WHERE o.club_id = c.id) as organizer_count
    FROM clubs c
    ORDER BY c.name ASC
";

$clubs_result = mysqli_query($conn, $clubs_query);

$counter = 1;
while ($club = mysqli_fetch_assoc($clubs_result)) {
    $club['no'] = $counter++;
    $clubs[] = $club;
    $total_clubs++;
    $total_events += $club['event_count'];
    $total_organizers += $club['organizer_count'];
}
?>

<body>
    <?php
    $page_name = 'club';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');
    ?>

    <main>
        <div class="page-header">
            <div class="page-header-text">
                <h1>Manage Clubs</h1>
                <p>View and manage registered clubs on the platform.</p>
            </div>
            <a href="/GoGreen-APU/frontend/admin/club/create_club.php" class="create-club-btn green-glass-effect-border">
                <img src="/GoGreen-APU/assets/icons/diversity_3_1000dp_1F1F1F_FILL0_wght400_GRAD0_opsz48.svg" alt="Create">
                <span>Create Club</span>
            </a>
        </div>

        <div class="stats-container">
            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/diversity_3_1000dp_1F1F1F_FILL0_wght400_GRAD0_opsz48.svg" alt="Clubs"></div>
                <div class="stat-content">
                    <span class="stat-label">Total Clubs</span>
                    <span class="stat-value"><?php echo $total_clubs; ?></span>
                    <span class="stat-subtitle">Registered on platform</span>
                </div>
            </div>

            <div class="stat-card glass-effect-border">
                <div class="stat-icon"><img src="/GoGreen-APU/assets/icons/my_events.svg" alt="Events"></div>
                <div class="stat-content">
                    <span class="stat-label">Total Events</span>
                    <span class="stat-value"><?php echo $total_events; ?></span>
                    <span class="stat-subtitle">Organized by all clubs</span>
                </div>
            </div>


        </div>

        <div class="table-actions-container glass-effect">
            <form class="table-search-bar <?php if ($search != '') echo 'has-text'; ?>" method="GET">
                <input type="text" name="search" id="club-search-input" class="table-search-input" placeholder="Search clubs..." value="<?php echo htmlspecialchars($search); ?>">
                <button class="table-clear-btn clear-btn" type="button" data-target="club-search-input">
                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                </button>
                <button class="table-search-btn" type="submit">
                    <img src="/GoGreen-APU/assets/icons/navigation/search.svg" alt="Search" class="search-icon">
                </button>
            </form>

            <div class="table-manage-container glass-effect-border">
                <?php if (!empty($clubs)): ?>
                    <div class="table-left-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>CLUB NAME</th>
                                    <th>DESCRIPTION</th>
                                    <th style="text-align: center;">EVENTS</th>

                                    <th>WEBSITE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clubs as $club):
                                    // Filter by search
                                    if ($search != '' && stripos($club['name'], $search) === false && stripos($club['email'], $search) === false) continue;
                                ?>
                                    <tr>
                                        <td><?php echo $club['no']; ?></td>
                                        <td>
                                            <div class="club-name-cell">
                                                <span class="club-logo">
                                                    <?php if (!empty($club['logo_path'])): ?>
                                                        <img src="/GoGreen-APU/assets/images/club/<?php echo htmlspecialchars($club['logo_path']); ?>" alt="<?php echo htmlspecialchars($club['name']); ?>">
                                                    <?php else: ?>
                                                        <img src="/GoGreen-APU/assets/icons/diversity_3_1000dp_1F1F1F_FILL0_wght400_GRAD0_opsz48.svg" alt="Default" style="opacity: 0.3;">
                                                    <?php endif; ?>
                                                </span>
                                                <div class="club-name-info">
                                                    <span class="name"><?php echo htmlspecialchars($club['name']); ?></span>
                                                    <span class="email"><?php echo htmlspecialchars($club['email']); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="club-description"><?php echo htmlspecialchars($club['description']); ?></p>
                                        </td>
                                        <td style="text-align: center;">
                                            <span class="events-count-badge <?php echo $club['event_count'] == 0 ? 'zero' : ''; ?>">
                                                <?php echo $club['event_count']; ?>
                                            </span>
                                        </td>

                                        <td>
                                            <?php if (!empty($club['website_link'])): ?>
                                                <a href="<?php echo htmlspecialchars($club['website_link']); ?>" target="_blank" class="club-website-link">
                                                    <img src="/GoGreen-APU/assets/icons/link.svg" alt="Link">
                                                    <span>Visit</span>
                                                </a>
                                            <?php else: ?>
                                                <span class="no-website">No website</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-right-container glass-effect">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clubs as $club):
                                    // Filter by search (same as left table)
                                    if ($search != '' && stripos($club['name'], $search) === false && stripos($club['email'], $search) === false) continue;
                                ?>
                                    <tr>
                                        <td>
                                            <a href="/GoGreen-APU/frontend/admin/club/manage_club.php?id=<?php echo $club['id']; ?>" class="action-btn edit-btn" title="Edit Club">
                                                <img src="/GoGreen-APU/assets/icons/square.and.pencil.svg" alt="Edit">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="/GoGreen-APU/actions/admin/club/delete_club.php?id=<?php echo $club['id']; ?>"
                                                class="action-btn delete-btn"
                                                title="Delete Club"
                                                onclick="return confirm('Are you sure you want to delete this club? This action cannot be undone.');">
                                                <img src="/GoGreen-APU/assets/icons/trash.svg" alt="Delete">
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <img src="/GoGreen-APU/assets/icons/diversity_3_1000dp_1F1F1F_FILL0_wght400_GRAD0_opsz48.svg" alt="No clubs">
                        <h3>No Clubs Found</h3>
                        <p>There are no registered clubs yet. Create your first club to get started.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        // Clear button functionality
        document.querySelectorAll('.table-clear-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                if (input) {
                    input.value = '';
                    input.focus();
                    this.closest('.table-search-bar').classList.remove('has-text');
                }
            });
        });

        // Add has-text class on input
        document.querySelectorAll('.table-search-input').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.length > 0) {
                    this.closest('.table-search-bar').classList.add('has-text');
                } else {
                    this.closest('.table-search-bar').classList.remove('has-text');
                }
            });
        });
    </script>
</body>

</html>