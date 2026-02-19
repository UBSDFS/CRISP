<?php
$role = $_SESSION['role'] ?? '';
$backAction = match ($role) {
    'admin' => 'admindashboard',
    'technician' => 'techdashboard',
    default => 'dashboard',
};


// Validate complaint data with response code and error message if not valid
if (!isset($complaint) || !is_array($complaint)) {
    http_response_code(500);
    echo "Complaint data not available.";
    exit;
}

// Extract fields with fallbacks
$complaintId = $complaint['complaint_id'] ?? $complaint['id'] ?? '';
$status      = $complaint['status'] ?? '';
$details     = $complaint['details'] ?? '';
$createdAt   = $complaint['created_at'] ?? $complaint['createdAt'] ?? '';
$typeName    = $complaint['complaint_type'] ?? $complaint['type_name'] ?? $complaint['type'] ?? '';
$productName = $complaint['product_name'] ?? $complaint['product'] ?? '';

// Handle image path 
$image = $complaint['imagePath'] ?? $complaint['image_path'] ?? $complaint['image'] ?? '';

if ($image && $image[0] !== '/' && !str_starts_with($image, 'http')) {
    $image = '/uploads/' . ltrim($image, '/');
}
?>

<div class="page">
    <div class="card">
        <div class="card-header">
            <h1>Complaint #<?= htmlspecialchars((string)$complaintId) ?></h1>
            <?php if ($status): ?>
                <span class="badge"><?= htmlspecialchars((string)$status) ?></span>
            <?php endif; ?>
        </div>

        <div class="grid">
            <div>
                <?php if ($typeName): ?>
                    <p><strong>Type:</strong> <?= htmlspecialchars((string)$typeName) ?></p>
                <?php endif; ?>

                <?php if ($productName): ?>
                    <p><strong>Product:</strong> <?= htmlspecialchars((string)$productName) ?></p>
                <?php endif; ?>

                <?php if ($createdAt): ?>
                    <p><strong>Created:</strong> <?= htmlspecialchars((string)$createdAt) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <p><strong>Details:</strong></p>
                <div class="details">
                    <?= nl2br(htmlspecialchars((string)$details)) ?>
                </div>
            </div>
        </div>

        <hr>

        <h2>Attached Image</h2>
        <?php if (!empty($image)): ?>
            <div class="image-wrap">
                <img
                    src="<?= htmlspecialchars((string)$image) ?>"
                    alt="Complaint image">
            </div>
        <?php else: ?>
            <p><em>No image uploaded for this complaint.</em></p>
        <?php endif; ?>

        <div class="actions">
            <a class="link" href="index.php?action=<?= urlencode($backAction) ?>">Back</a>


            <?php if (($complaint['status'] ?? '') !== 'resolved'): ?>
                <a class="link" href="index.php?action=editComplaint&id=<?= urlencode((string)$complaintId) ?>">
                    Edit
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

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