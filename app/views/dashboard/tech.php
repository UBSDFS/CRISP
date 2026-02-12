<?php
// views/dashboard/tech.php
// UI-FIRST scaffold (placeholders). Wire DB + controllers later.

// --- Placeholder "logged-in tech" profile ---
$tech = [
    'name'  => 'Technician Name',
    'email' => 'tech@example.com',
    'role'  => 'Tech',
];

// --- Placeholder assigned complaints list (left sidebar queue) ---
$assignedComplaints = [
    ['id' => 1024, 'title' => 'Duplicate charge on account', 'submitted' => '2026-02-04', 'status' => 'open'],
    ['id' => 1025, 'title' => 'App crashes on login',        'submitted' => '2026-02-05', 'status' => 'in_progress'],
    ['id' => 1026, 'title' => 'Warranty status mismatch',    'submitted' => '2026-02-01', 'status' => 'resolved'],
];

// Which complaint is "selected" (right panel)
$selectedId = isset($_GET['id']) ? (int)$_GET['id'] : $assignedComplaints[0]['id'];

// --- Placeholder selected complaint detail (customer input + tech fields) ---
$selectedComplaint = [
    'id'            => $selectedId,
    'status'        => 'open',
    'submitted_at'  => '2026-02-04 09:14',
    'customer_name' => 'J. Smith',
    'customer_email' => 'jsmith@email.com',
    'category'      => 'Billing',
    'description'   => 'I was charged twice for my subscription. Please refund the duplicate charge and confirm my account is in good standing.',
    'resolved_at'   => null, // display only; later set when resolved
];

function statusLabel(string $status): string
{
    return match ($status) {
        'open' => 'Open',
        'in_progress' => 'In Progress',
        'resolved' => 'Resolved',
        default => ucfirst($status),
    };
}

function statusBadgeClass(string $status): string
{
    return match ($status) {
        'open' => 'badge-open',
        'in_progress' => 'badge-progress',
        'resolved' => 'badge-resolved',
        default => 'badge-default',
    };
}

// Optional UI filter (GET only for now)
$filterStatus = $_GET['status'] ?? '';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tech Dashboard</title>

    <link rel=" stylesheet" href="/customer-complaint-tracking-system/public/assets/css/dashboard.css">
    ">
</head>

<body>
    <main class="dash">

        <!-- LEFT COLUMN -->
        <aside>
            <!-- Profile -->
            <section class="profile-card">
                <div class="avatar">
                    <?php
                    $initials = '';
                    if (!empty($tech['name'])) {
                        $parts = preg_split('/\s+/', trim($tech['name']));
                        $initials = strtoupper(substr($parts[0] ?? 'T', 0, 1) . substr($parts[1] ?? '', 0, 1));
                    }
                    echo htmlspecialchars($initials ?: 'T');
                    ?>
                </div>

                <div class="name"><?php echo htmlspecialchars($tech['name']); ?></div>

                <div class="meta">
                    <div class="meta-row">
                        <span class="meta-label">Email</span>
                        <span class="meta-value"><?php echo htmlspecialchars($tech['email']); ?></span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Role</span>
                        <span class="meta-value"><?php echo htmlspecialchars($tech['role']); ?></span>
                    </div>
                </div>

                <a class="btn secondary" href="#">Change Password</a>
            </section>

            <!-- Assigned complaints -->
            <section class="work-card sidebar-section">
                <div class="work-header">
                    <h1>Assigned Complaints</h1>
                </div>
                <p class="subtext">Select a ticket to work.</p>

                <form method="GET" action="" class="form">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars((string)$selectedId); ?>">

                    <div class="field">
                        <label class="field-label" for="status">Filter</label>
                        <select class="select" id="status" name="status">
                            <option value="" <?php echo $filterStatus === '' ? 'selected' : ''; ?>>All</option>
                            <option value="open" <?php echo $filterStatus === 'open' ? 'selected' : ''; ?>>Open</option>
                            <option value="in_progress" <?php echo $filterStatus === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                            <option value="resolved" <?php echo $filterStatus === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                        </select>
                    </div>

                    <div class="actions">
                        <button class="btn secondary" type="submit">Apply</button>
                    </div>
                </form>

                <div class="complaint-list queue-scroll">
                    <?php foreach ($assignedComplaints as $c): ?>
                        <?php
                        if ($filterStatus !== '' && $c['status'] !== $filterStatus) continue;
                        $active = ((int)$c['id'] === (int)$selectedId);

                        // Badge class mapping to match your CSS
                        // open -> open
                        // in_progress -> in-progress (new)
                        // resolved -> closed (existing) OR resolved (new alias you can use)
                        $badgeStatusClass = match ($c['status']) {
                            'open' => 'open',
                            'in_progress' => 'in-progress',
                            'resolved' => 'closed', // or 'resolved' if you prefer the alias
                            default => 'open',
                        };
                        ?>
                        <div class="complaint-card <?php echo $active ? 'active' : ''; ?>">
                            <div class="card-top">
                                <span class="product">#<?php echo htmlspecialchars((string)$c['id']); ?></span>
                                <span class="badge status <?php echo htmlspecialchars($badgeStatusClass); ?>">
                                    <?php echo htmlspecialchars(statusLabel($c['status'])); ?>
                                </span>
                            </div>

                            <div class="details"><?php echo htmlspecialchars($c['title']); ?></div>

                            <div class="card-bottom">
                                <span class="subtext">Submitted: <?php echo htmlspecialchars($c['submitted']); ?></span>
                                <div class="actions">
                                    <a class="btn secondary"
                                        href="?id=<?php echo urlencode((string)$c['id']); ?>&status=<?php echo urlencode((string)$filterStatus); ?>">
                                        Open
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </aside>

        <!-- RIGHT COLUMN -->
        <section class="work-card">
            <div class="topbar">
                <div class="topbar-title">
                    <h1>Technician Dashboard</h1>
                    <p class="subtext">Review, note, update status, and resolve assigned complaints.</p>
                </div>
                <div class="topbar-actions">
                    <span class="badge role">Tech</span>
                    <a class="btn secondary" href="#">Logout</a>
                </div>
            </div>

            <!-- Summary strip -->
            <?php
            $selectedBadgeStatusClass = match ($selectedComplaint['status']) {
                'open' => 'open',
                'in_progress' => 'in-progress',
                'resolved' => 'closed', // or 'resolved'
                default => 'open',
            };
            ?>
            <div class="summary">
                <div class="summary-item">
                    <span class="summary-label">Ticket</span>
                    <span class="summary-value">#<?php echo htmlspecialchars((string)$selectedComplaint['id']); ?></span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Status</span>
                    <span class="badge status <?php echo htmlspecialchars($selectedBadgeStatusClass); ?>">
                        <?php echo htmlspecialchars(statusLabel($selectedComplaint['status'])); ?>
                    </span>
                </div>

                <div class="summary-item">
                    <span class="summary-label">Resolution Date</span>
                    <span class="summary-value">
                        <?php echo $selectedComplaint['resolved_at'] ? htmlspecialchars($selectedComplaint['resolved_at']) : '—'; ?>
                    </span>
                </div>
            </div>

            <!-- Customer complaint (read-only) -->
            <div class="complaint-card">
                <div class="card-top">
                    <span class="badge type">Customer Input</span>
                    <span class="subtext">Submitted: <?php echo htmlspecialchars($selectedComplaint['submitted_at']); ?></span>
                </div>

                <div class="product"><?php echo htmlspecialchars($selectedComplaint['category']); ?></div>

                <div class="details">
                    <strong><?php echo htmlspecialchars($selectedComplaint['customer_name']); ?></strong>
                    <span class="subtext"> • <?php echo htmlspecialchars($selectedComplaint['customer_email']); ?></span>
                </div>

                <div class="details readonly">
                    <?php echo htmlspecialchars($selectedComplaint['description']); ?>
                </div>
            </div>

            <!-- Technician update -->
            <div class="complaint-card">
                <div class="card-top">
                    <span class="badge type">Technician Update</span>
                    <span class="subtext">Resolution notes required to resolve</span>
                </div>

                <form method="POST" action="#" class="form">
                    <input type="hidden" name="complaint_id" value="<?php echo htmlspecialchars((string)$selectedComplaint['id']); ?>">

                    <div class="field">
                        <label class="field-label" for="tech_notes">Technician Notes / Analysis</label>
                        <textarea class="textarea" id="tech_notes" name="tech_notes" rows="5"
                            placeholder="Enter investigation steps, findings, and internal notes..."></textarea>
                    </div>

                    <div class="grid-2">
                        <div class="field">
                            <label class="field-label" for="status_update">Status</label>
                            <select class="select" id="status_update" name="status">
                                <option value="open">Open</option>
                                <option value="in_progress">In Progress</option>
                                <option value="resolved">Resolved</option>
                            </select>
                        </div>

                        <div class="field">
                            <label class="field-label" for="resolved_at">Resolution Date</label>
                            <input class="input" id="resolved_at" type="text" value="" placeholder="Auto-set when resolved" disabled>
                        </div>
                    </div>

                    <div class="field">
                        <label class="field-label" for="resolution_notes">
                            Resolution Notes <span class="required">*</span>
                        </label>
                        <textarea class="textarea" id="resolution_notes" name="resolution_notes" rows="5"
                            placeholder="Required if setting status to Resolved. What action resolved the complaint?"></textarea>
                        <p class="subtext">This field is required to resolve the complaint.</p>
                    </div>

                    <div class="actions">
                        <button class="btn secondary" type="submit" name="save_changes">Save Changes</button>
                        <button class="btn primary" type="submit" name="resolve">Resolve Complaint</button>
                    </div>
                </form>
            </div>

        </section>
    </main>
</body>

</html>