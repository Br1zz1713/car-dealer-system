<?php
ob_start();
?>

<div class="container">
    <div class="page-header">
        <h2>Available Vehicles</h2>
        <p class="subtitle">Browse our current inventory</p>
    </div>

    <!-- Search/Filter Form -->
    <form method="GET" action="/" class="filter-form">
        <div class="filter-grid">
            <div class="form-group">
                <label for="make">Make</label>
                <input type="text" id="make" name="make" placeholder="e.g., Toyota" 
                       value="<?= htmlspecialchars($filters['make'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="model">Model</label>
                <input type="text" id="model" name="model" placeholder="e.g., Camry" 
                       value="<?= htmlspecialchars($filters['model'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="min_price">Min Price</label>
                <input type="number" id="min_price" name="min_price" placeholder="0" 
                       value="<?= htmlspecialchars($filters['min_price'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="max_price">Max Price</label>
                <input type="number" id="max_price" name="max_price" placeholder="100000" 
                       value="<?= htmlspecialchars($filters['max_price'] ?? '') ?>">
            </div>
        </div>
        <div class="filter-actions">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="/" class="btn btn-secondary">Clear</a>
        </div>
    </form>

    <!-- Vehicle Grid -->
    <?php if (empty($vehicles)): ?>
        <div class="empty-state">
            <div class="empty-icon">🚗</div>
            <h3>No vehicles found</h3>
            <p>Try adjusting your search filters or check back later for new inventory.</p>
        </div>
    <?php else: ?>
        <div class="vehicle-grid">
            <?php foreach ($vehicles as $vehicle): ?>
                <?php
                $mediaUrls = json_decode($vehicle['media_urls'], true) ?? [];
                $primaryImage = !empty($mediaUrls) ? '/' . $mediaUrls[0] : '/css/placeholder-car.svg';
                ?>
                <div class="vehicle-card">
                    <div class="vehicle-image">
                        <img src="<?= htmlspecialchars($primaryImage) ?>" 
                             alt="<?= htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']) ?>"
                             onerror="this.src='/css/placeholder-car.svg'">
                    </div>
                    <div class="vehicle-info">
                        <h3 class="vehicle-title">
                            <?= htmlspecialchars($vehicle['make']) ?> 
                            <?= htmlspecialchars($vehicle['model']) ?>
                        </h3>
                        <p class="vehicle-year"><?= htmlspecialchars($vehicle['year']) ?></p>
                        <p class="vehicle-price">$<?= number_format($vehicle['price'], 2) ?></p>
                        <a href="/vehicle/<?= $vehicle['id'] ?>" class="btn btn-primary btn-block">
                            View Details
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
$title = 'Inventory - Car Dealer';
require __DIR__ . '/../layout.php';
?>
