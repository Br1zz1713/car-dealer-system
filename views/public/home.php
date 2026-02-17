<?php
ob_start();
?>

<!-- New Hero Section -->
<div class="hero-section">
    <div class="container hero-content">
        <h1 class="hero-title">Find Your Perfect Drive</h1>
        <p class="hero-subtitle">Explore our premium selection of quality pre-owned vehicles.</p>
    </div>
</div>

<div class="container">
    <!-- Search/Filter Form (Overlapping Hero) -->
    <div class="search-container">
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
                <button type="submit" class="btn btn-primary btn-block">Search Inventory</button>
                <?php if(!empty($_GET)): ?>
                    <a href="/" class="btn btn-secondary btn-block" style="text-align:center">Clear Filters</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Vehicle Grid -->
    <?php if (empty($vehicles)): ?>
        <div class="empty-state">
            <div class="empty-icon">🚗</div>
            <h3>No vehicles match your search</h3>
            <p>Try adjusting your filters or check back later for new arrivals.</p>
            <a href="/" class="btn btn-primary">View All Vehicles</a>
        </div>
    <?php else: ?>
        <div class="vehicle-grid">
            <?php foreach ($vehicles as $vehicle): ?>
                <?php
                $mediaUrls = json_decode($vehicle['media_urls'], true) ?? [];
                // Handle both relative paths specific to this app structure
                $primaryImage = !empty($mediaUrls) ? '/' . ltrim($mediaUrls[0], '/') : '/css/placeholder-car.svg';
                ?>
                <a href="/vehicle/<?= $vehicle['id'] ?>" class="vehicle-card-link">
                    <div class="vehicle-card">
                        <div class="vehicle-image">
                            <img src="<?= htmlspecialchars($primaryImage) ?>" 
                                 alt="<?= htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']) ?>"
                                 loading="lazy"
                                 onerror="this.src='https://placehold.co/600x400?text=No+Image'">
                        </div>
                        <div class="vehicle-info">
                            <div class="vehicle-meta">
                                <span><?= htmlspecialchars($vehicle['year']) ?></span>
                                <span>•</span>
                                <span><?= htmlspecialchars($vehicle['make']) ?></span>
                            </div>
                            <h3 class="vehicle-title">
                                <?= htmlspecialchars($vehicle['model']) ?>
                            </h3>
                            <span class="vehicle-price">$<?= number_format($vehicle['price'], 0) ?></span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
$title = 'Inventory - Car Dealer';
require __DIR__ . '/../layout.php';
?>
