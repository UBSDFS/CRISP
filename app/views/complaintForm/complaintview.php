<?php
if (!isset($complaint) || !is_array($complaint)) {
    http_response_code(500);
    echo "Complaint data not available.";
    exit;
}

$complaint_id = (int)($complaint['complaint_id'] ?? 0);
$status       = (string)($complaint['status'] ?? '');
$details      = (string)($complaint['details'] ?? '');
$image_path   = (string)($complaint['image_path'] ?? '');

$type_name    = (string)($complaint['complaint_type_name'] ?? $complaint['type_name'] ?? $complaint['complaint_type'] ?? '');
$product_name = (string)($complaint['product_name'] ?? '');

$role = $_SESSION['role'] ?? '';

$backAction = match ($role) {
    'admin' => 'adminDashboard',
    'technician' => 'techDashboard',
    default => 'dashboard',
};

$editAction = ($role === 'customer') ? 'editComplaintCustomer' : 'editComplaint';
?>

<h2>Complaint #<?= htmlspecialchars((string)$complaint_id) ?></h2>

<?php if ($status !== ''): ?>
    <p><strong>Status:</strong> <?= htmlspecialchars($status) ?></p>
<?php endif; ?>

<?php if ($type_name !== ''): ?>
    <p><strong>Complaint Type:</strong> <?= htmlspecialchars($type_name) ?></p>
<?php endif; ?>

<?php if ($product_name !== ''): ?>
    <p><strong>Product:</strong> <?= htmlspecialchars($product_name) ?></p>
<?php endif; ?>

<p><strong>Description:</strong></p>
<p><?= nl2br(htmlspecialchars($details)) ?></p>

<hr>

<h3>Image</h3>
<?php if ($image_path !== ''): ?>
    <img src="<?= htmlspecialchars($image_path) ?>" alt="Complaint image" style="max-width:600px;width:100%;height:auto;">
<?php else: ?>
    <p><em>No image uploaded.</em></p>
<?php endif; ?>

<hr>

<p>
    <a class="link" href="index.php?action=<?= urlencode($backAction) ?>">Back</a>

    <?php if ($status !== 'resolved'): ?>
        <a class="link" href="index.php?action=<?= urlencode($editAction) ?>&id=<?= urlencode((string)$complaint_id) ?>">
            Edit
        </a>
    <?php endif; ?>
</p>



<style>
    .page {
        max-width: 980px;
        margin: 0 auto;
        padding: 24px;
    }

    .card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 18px;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .badge {
        padding: 6px 10px;
        border-radius: 999px;
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        font-size: 14px;
    }

    .grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-top: 14px;
    }

    .details {
        white-space: normal;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        padding: 12px;
        border-radius: 10px;
        min-height: 80px;
    }

    .image-wrap {
        margin-top: 10px;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 10px;
        background: #fafafa;
    }

    .image-wrap img {
        width: 100%;
        max-width: 720px;
        height: auto;
        display: block;
        border-radius: 10px;
    }

    .actions {
        display: flex;
        gap: 12px;
        margin-top: 18px;
    }

    .link {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #f9fafb;
    }
</style>