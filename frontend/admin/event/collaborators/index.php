 <!--
    Author: Chong Jun Yoong
    Date: 2026-1-8
    Description: Admin interface for managing event collaborators.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>Collaborators - My Events | GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/hero.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/home.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/global/table.css">
</head>

<body>
    <?php
    $page_name = 'event_collaborators';
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php');

    $event_id = intval($_GET['id']);

    $sql = "SELECT c.*, u.first_name, u.last_name, u.apkey, u.avatar_path 
            FROM collaborators c
            JOIN users u ON c.user_id = u.id
            WHERE c.event_id = $event_id
            ORDER BY c.type, u.first_name";
    $result = mysqli_query($conn, $sql);
    
    $collaborators = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $collaborators[] = $row;
        }
    }
    ?>

    <main>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/event/hero.php'); ?>

        <div class="page-header">
            <div class="page-header-text">
                <h1>Collaborators</h1>
                <p>Manage team members who help organize this event.</p>
            </div>
                        <a href="/GoGreen-APU/frontend/admin/event/collaborators/create.php?id=<?php echo $event_id; ?>" 
                           class="create-event-btn green-glass-effect-border">
                            <span>Add Collaborator</span>
                        </a>
        </div>

        <div class="table-actions-container glass-effect">
            <div class="table-search-bar">
                <input type="text" name="search" id="collaborator-search-input" class="table-search-input"
                    placeholder="Search collaborators...">
                <button class="table-clear-btn clear-btn" type="button" data-target="collaborator-search-input">
                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                </button>
                <button class="table-search-btn" type="button">
                    <img src="/GoGreen-APU/assets/icons/navigation/search.svg" alt="Search" class="search-icon">
                    <span class="search-text">Search</span>
                </button>
            </div>

            <div class="table-filters">
                <div class="filter-group glass-effect-border">
                    <label for="filter-type">Type</label>
                    <select name="filter-type" id="filter-type">
                        <option value="all">All</option>
                        <option value="internal">Internal</option>
                        <option value="external">External</option>
                    </select>
                </div>
            </div>

            <div class="table-manage-container glass-effect-border">
                <?php if (!empty($collaborators)): ?>
                    <div class="table-left-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>NAME</th>
                                    <th>AP KEY</th>
                                    <th>TYPE</th>
                                    <th>POSITION</th>
                                    <th>NGO NAME</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($collaborators as $collaborator): ?>
                                    <tr data-type="<?php echo strtolower($collaborator['type']); ?>">
                                        <td class="event-title">
                                            <span class="event-image" style="width: 45px; height: 45px; border-radius: 50%; overflow: hidden;">
                                                <img src="/GoGreen-APU/assets/images/profile/<?php echo $collaborator['avatar_path']; ?>" 
                                                     alt="Avatar" 
                                                     style="width: 100%; height: 100%; object-fit: cover;">
                                            </span>
                                            <span><?php echo htmlspecialchars($collaborator['first_name'] . ' ' . $collaborator['last_name']); ?></span>
                                        </td>
                                        <td><?php echo htmlspecialchars($collaborator['apkey']); ?></td>
                                        <td>
                                            <?php if ($collaborator['type'] === 'internal'): ?>
                                                <span class="status-badge status-approved">Internal</span>
                                            <?php else: ?>
                                                <span class="status-badge status-pending">External</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($collaborator['positions'] ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($collaborator['ngo_name'] ?? '-'); ?></td>
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
                                <?php foreach ($collaborators as $collaborator): ?>
                                    <tr>
                                        <td>
                                            <a href="edit.php?id=<?php echo $event_id; ?>&user_id=<?php echo $collaborator['user_id']; ?>" 
                                               title="Edit User">
                                                <span><img src="/GoGreen-APU/assets/icons/square.and.pencil.svg" alt="Edit"></span>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" 
                                               onclick="deleteCollaborator(<?php echo $collaborator['user_id']; ?>, <?php echo $event_id; ?>, '<?php echo htmlspecialchars($collaborator['first_name'] . ' ' . $collaborator['last_name']); ?>')"
                                               title="Delete">
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
                        <img src="/GoGreen-APU/assets/icons/person.2.badge.gearshape.fill.svg" alt="No collaborators" 
                             style="width: 80px; height: 80px; filter: invert(1); opacity: 0.3; margin-bottom: 20px;">
                        <h3 style="font-size: 22px; margin-bottom: 10px; color: rgba(255, 255, 255, 0.8);">No Collaborators Yet</h3>
                        <p style="font-size: 15px; color: rgba(255, 255, 255, 0.5); margin-bottom: 30px;">Add collaborators to help manage this event</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </main>

    <script>
        function deleteCollaborator(userId, eventId, name) {
            if (confirm('Are you sure you want to remove "' + name + '" as a collaborator?\n\nThis action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/GoGreen-APU/actions/organizer/my_events/delete_collaborator.php';
                
                const userIdInput = document.createElement('input');
                userIdInput.type = 'hidden';
                userIdInput.name = 'user_id';
                userIdInput.value = userId;
                
                const eventIdInput = document.createElement('input');
                eventIdInput.type = 'hidden';
                eventIdInput.name = 'event_id';
                eventIdInput.value = eventId;
                
                form.appendChild(userIdInput);
                form.appendChild(eventIdInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        const filterType = document.getElementById('filter-type');
        const searchInput = document.getElementById('collaborator-search-input');
        const tableRows = document.querySelectorAll('.table-left-container tbody tr');
        const actionRows = document.querySelectorAll('.table-right-container tbody tr');

        function filterTable() {
            const typeValue = filterType.value.toLowerCase();
            const searchValue = searchInput.value.toLowerCase();

            tableRows.forEach((row, index) => {
                const rowType = row.dataset.type;
                const rowText = row.textContent.toLowerCase();

                const matchesType = typeValue === 'all' || rowType === typeValue;
                const matchesSearch = rowText.includes(searchValue);

                if (matchesType && matchesSearch) {
                    row.style.display = '';
                    if (actionRows[index]) actionRows[index].style.display = '';
                } else {
                    row.style.display = 'none';
                    if (actionRows[index]) actionRows[index].style.display = 'none';
                }
            });
        }

        if(filterType && searchInput) {
            filterType.addEventListener('change', filterTable);
            searchInput.addEventListener('input', filterTable);
        }
        
        const clearBtn = document.querySelector('.table-clear-btn');
        if(clearBtn) {
            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                filterTable();
            });
        }

        <?php if (isset($_SESSION['success_message'])): ?>
            alert('<?php echo addslashes($_SESSION['success_message']); ?>');
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            alert('<?php echo addslashes($_SESSION['error_message']); ?>');
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    </script>
</body>
</html>