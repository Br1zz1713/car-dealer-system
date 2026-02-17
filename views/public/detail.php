<?php
ob_start();
$mediaUrls = json_decode($vehicle['media_urls'], true) ?? [];
// Prepare JSON for JS
$jsImages = json_encode(array_map(function($url) { return '/' . ltrim($url, '/'); }, $mediaUrls));
?>

<div class="container" style="padding-top: 2rem;">
    <div class="breadcrumb" style="margin-bottom: 1rem;">
        <a href="/" class="btn btn-secondary btn-small">← Back to Inventory</a>
    </div>

    <div class="vehicle-detail">
        <!-- Gallery Section -->
        <div class="detail-gallery">
            <?php if (empty($mediaUrls)): ?>
                <div class="gallery-main">
                    <img src="https://placehold.co/800x600?text=No+Image" alt="No image available">
                </div>
            <?php else: ?>
                <div class="gallery-main" onclick="openLightbox(0)">
                    <img src="/<?= ltrim($mediaUrls[0], '/') ?>" 
                         alt="<?= htmlspecialchars($vehicle['make']) ?>"
                         id="mainImage">
                    <div class="expand-hint">
                        Click to Expand ⤢
                    </div>
                </div>

                <?php if (count($mediaUrls) > 1): ?>
                    <div class="gallery-thumbs">
                        <?php foreach ($mediaUrls as $index => $url): ?>
                            <img src="/<?= ltrim($url, '/') ?>" 
                                 alt="View <?= $index + 1 ?>"
                                 class="thumb <?= $index === 0 ? 'active' : '' ?>"
                                 onclick="updateMainImage(<?= $index ?>)">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Description Section (Moved under gallery for better flow on some layouts) -->
             <div class="description-box">
                <h3>Vehicle Description</h3>
                <div class="description-content">
                    <?= empty($vehicle['description']) ? 'No description available.' : nl2br(htmlspecialchars($vehicle['description'])) ?>
                </div>
            </div>
        </div>

        <!-- Info & Contact Section -->
        <div class="detail-info">
            <h1 class="vehicle-title-large">
                <?= htmlspecialchars($vehicle['make']) ?> <?= htmlspecialchars($vehicle['model']) ?>
            </h1>
            <p class="vehicle-year-large">
                <?= htmlspecialchars($vehicle['year']) ?> Model
            </p>

            <div class="detail-price-large">
                $<?= number_format($vehicle['price'], 0) ?>
            </div>

            <!-- Contact Form -->
            <div class="contact-card">
                <h3>Contact Seller</h3>
                <form onsubmit="event.preventDefault(); alert('Message sent! (Demo)');">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" placeholder="your@email.com" required>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea rows="3" placeholder="I am interested in this vehicle..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- LIGHTBOX OVERLAY -->
<div id="lightbox" class="lightbox-overlay" onclick="if(event.target === this) closeLightbox()">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    
    <div class="lightbox-nav nav-prev" onclick="changeSlide(-1)">&#10094;</div>
    
    <div class="lightbox-content">
        <img id="lightbox-img" class="lightbox-img" src="" alt="Full screen view">
    </div>
    
    <div class="lightbox-nav nav-next" onclick="changeSlide(1)">&#10095;</div>
</div>

<script>
    // Image Data from PHP
    const images = <?= $jsImages ?>;
    let currentIndex = 0;
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');

    // Update the inline display (non-lightbox)
    function updateMainImage(index) {
        if(images.length > 0) {
            document.getElementById('mainImage').src = images[index];
            // Update active thumb
            document.querySelectorAll('.thumb').forEach((thumb, i) => {
                thumb.classList.toggle('active', i === index);
            });
        }
    }

    // Lightbox Logic
    function openLightbox(index) {
        if(images.length === 0) return;
        currentIndex = index;
        lightboxImg.src = images[currentIndex];
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scrolling bg
    }

    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }

    function changeSlide(step) {
        if(images.length === 0) return;
        
        // Endless Carousel Logic
        currentIndex += step;
        
        if (currentIndex >= images.length) {
            currentIndex = 0; // Loop back to start
        } else if (currentIndex < 0) {
            currentIndex = images.length - 1; // Loop to end
        }
        
        // Fade effect for smoother transition
        lightboxImg.style.opacity = 0;
        setTimeout(() => {
            lightboxImg.src = images[currentIndex];
            lightboxImg.onload = () => { lightboxImg.style.opacity = 1; };
        }, 150);
    }

    // Keyboard Navigation
    document.addEventListener('keydown', function(e) {
        if (!lightbox.classList.contains('active')) return;
        
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') changeSlide(-1);
        if (e.key === 'ArrowRight') changeSlide(1);
    });
</script>

<?php
$content = ob_get_clean();
$title = htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']) . ' - Details';
require __DIR__ . '/../layout.php';
?>
