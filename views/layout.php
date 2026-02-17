<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Car Dealer Inventory' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <h1 class="site-logo">
                    <a href="/">🚗 Car Dealer</a>
                </h1>
                <nav class="main-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/admin/dashboard" class="nav-link">Dashboard</a>
                        <a href="/admin/logout" class="nav-link">Logout</a>
                    <?php else: ?>
                        <a href="/" class="nav-link">Inventory</a>
                        <a href="/admin/login" class="nav-link">Admin</a>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </header>

    <main class="main-content">
        <?= $content ?? '' ?>
    </main>

    <footer class="site-footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> Car Dealer Inventory System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
