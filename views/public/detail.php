<?php
ob_start();
$mediaUrls = json_decode($vehicle['media_urls'], true) ?? [];
?>

<div class="container">
    <div class="breadcrumb">
        <a href="/">← Back to Inventory</a>
    </div>

    <div class="vehicle-detail">
        <div class="detail-gallery">
            <?php if (empty($mediaUrls)): ?>
                <div class="gallery-main">
                    <img src="/css/placeholder-car.svg" alt="No image available">
                </div>
            <?php else: ?>
                <div class="gallery-main">
                    <img src="/<?= htmlspecialchars($mediaUrls[0]) ?>" 
                         alt="<?= htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']) ?>"
                         id="mainImage">
                </div>
                <?php if (count($mediaUrls) > 1): ?>
                    <div class="gallery-thumbs">
                        <?php foreach ($mediaUrls as $index => $url): ?>
                            <img src="/<?= htmlspecialchars($url) ?>" 
                                 alt="Image <?= $index + 1 ?>"
                                 class="thumb <?= $index === 0 ? 'active' : '' ?>"
                                 onclick="document.getElementById('mainImage').src = this.src; 
                                          document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active')); 
                                          this.classList.add('active');">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="detail-info">
            <h2 class="detail-title">
                <?= htmlspecialchars($vehicle['make']) ?> 
                <?= htmlspecialchars($vehicle['model']) ?>
            </h2>
            
            <div class="detail-specs">
                <div class="spec-item">
                    <span class="spec-label">Year</span>
                    <span class="spec-value"><?= htmlspecialchars($vehicle['year']) ?></span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Make</span>
                    <span class="spec-value"><?= htmlspecialchars($vehicle['make']) ?></span>
                </div>
                <div class="spec-item">
                    <span class="spec-label">Model</span>
                    <span class="spec-value"><?= htmlspecialchars($vehicle['model']) ?></span>
                </div>
            </div>

            <div class="detail-price">
                <span class="price-label">Price</span>
                <span class="price-value">$<?= number_format($vehicle['price'], 2) ?></span>
            </div>

            <?php if (!empty($vehicle['description'])): ?>
                <div class="detail-description">
                    <h3>Description</h3>
                    <p><?= nl2br(htmlspecialchars($vehicle['description'])) ?></p>
                </div>
            <?php endif; ?>

            <div class="detail-actions">
                <button class="btn btn-primary btn-large" onclick="alert('Contact feature coming soon!')">
                    Contact Us About This Vehicle
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']) . ' - Car Dealer';
require __DIR__ . '/../layout.php';
?>
