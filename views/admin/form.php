<?php
ob_start();
$isEdit = isset($vehicle);
$formTitle = $isEdit ? 'Edit Vehicle' : 'Add New Vehicle';
$formAction = $isEdit ? "/admin/vehicle/update/{$vehicle['id']}" : '/admin/vehicle/store';
?>

<div class="container">
    <div class="form-header">
        <h2><?= $formTitle ?></h2>
        <a href="/admin/dashboard" class="btn btn-secondary">← Back to Dashboard</a>
    </div>

    <div class="form-wrapper">
        <form method="POST" action="<?= $formAction ?>" enctype="multipart/form-data" class="vehicle-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="make">Make *</label>
                    <input type="text" id="make" name="make" required 
                           placeholder="e.g., Toyota"
                           value="<?= htmlspecialchars($vehicle['make'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="model">Model *</label>
                    <input type="text" id="model" name="model" required 
                           placeholder="e.g., Camry"
                           value="<?= htmlspecialchars($vehicle['model'] ?? '') ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="year">Year *</label>
                    <input type="number" id="year" name="year" required 
                           min="1900" max="<?= date('Y') + 1 ?>"
                           placeholder="<?= date('Y') ?>"
                           value="<?= htmlspecialchars($vehicle['year'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="price">Price ($) *</label>
                    <input type="number" id="price" name="price" required 
                           min="0" step="0.01"
                           placeholder="25000.00"
                           value="<?= htmlspecialchars($vehicle['price'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" 
                          placeholder="Enter vehicle description, features, condition, etc."><?= htmlspecialchars($vehicle['description'] ?? '') ?></textarea>
            </div>

            <?php if ($isEdit): ?>
                <?php
                $existingMedia = json_decode($vehicle['media_urls'], true) ?? [];
                ?>
                <?php if (!empty($existingMedia)): ?>
                    <div class="form-group">
                        <label>Current Images</label>
                        <div class="existing-images">
                            <?php foreach ($existingMedia as $url): ?>
                                <img src="/<?= htmlspecialchars($url) ?>" alt="Vehicle image" class="existing-thumb">
                            <?php endforeach; ?>
                        </div>
                        <p class="form-help">Uploading new images will add to existing ones</p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="form-group">
                <label for="media">
                    <?= $isEdit ? 'Add More Images' : 'Upload Images' ?>
                </label>
                <input type="file" id="media" name="media[]" multiple accept="image/*">
                <p class="form-help">You can select multiple images. Accepted formats: JPG, PNG, GIF</p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large">
                    <?= $isEdit ? 'Update Vehicle' : 'Add Vehicle' ?>
                </button>
                <a href="/admin/dashboard" class="btn btn-secondary btn-large">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = $formTitle . ' - Car Dealer Admin';
require __DIR__ . '/../layout.php';
?>
