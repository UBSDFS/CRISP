<?php
// expects: $complaint_id, $types, $products, $errors, $old
if (!isset($complaint_id)) {
    $complaint_id = (int)($_POST['complaint_id'] ?? 0); // fallback only
}
?>
<h2>Edit Complaint</h2>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="POST" action="index.php?action=updateCustomerComplaint" enctype="multipart/form-data">
    <input type="hidden" name="complaint_id" value="<?= htmlspecialchars((string)$complaint_id) ?>">

    <label>Complaint Type</label><br>
    <select name="complaintTypeId" required>
        <option value="">-- Select --</option>
        <?php foreach ($types as $t): ?>
            <option value="<?= (int)$t['complaint_type_id'] ?>"
                <?= ((int)($old['complaint_type_id'] ?? 0) === (int)$t['complaint_type_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($t['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Product</label><br>
    <select name="productId" required>
        <option value="">-- Select --</option>
        <?php foreach ($products as $p): ?>
            <option value="<?= (int)$p['product_id'] ?>"
                <?= ((int)($old['product_id'] ?? 0) === (int)$p['product_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($p['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Description</label><br>
    <textarea name="details" rows="6" cols="60" required><?= htmlspecialchars($old['details'] ?? '') ?></textarea>
    <br><br>

    <?php if (!empty($old['image_path'])): ?>
        <p>Current image:</p>
        <img src="<?= htmlspecialchars($old['image_path']) ?>" alt="Current complaint image" style="max-width:300px;">
        <br><br>
    <?php endif; ?>

    <label>Replace image (optional)</label><br>
    <input type="file" name="image" accept="image/*">
    <br><br>

    <button type="submit">Save Changes</button>
    <a href="index.php?action=dashboard">Cancel</a>
</form>