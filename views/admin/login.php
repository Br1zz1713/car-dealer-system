<?php
ob_start();
?>

<div class="container">
    <div class="login-wrapper">
        <div class="login-card">
            <h2 class="login-title">Admin Login</h2>
            <p class="login-subtitle">Access the inventory management dashboard</p>

            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/admin/login" class="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required autofocus 
                           placeholder="Enter your username">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required 
                           placeholder="Enter your password">
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-large">
                    Login
                </button>
            </form>

            <div class="login-footer">
                <a href="/" class="text-link">← Back to Inventory</a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = 'Admin Login - Car Dealer';
require __DIR__ . '/../layout.php';
?>
