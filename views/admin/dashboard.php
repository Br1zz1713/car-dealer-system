<?php
ob_start();
?>

<div class="container">
    <div class="dashboard-header">
        <h2>Vehicle Inventory Dashboard</h2>
        <a href="/admin/vehicle/add" class="btn btn-primary">+ Add New Vehicle</a>
    </div>

    <?php if (empty($vehicles)): ?>
        <div class="empty-state">
            <div class="empty-icon">📋</div>
            <h3>No vehicles in inventory</h3>
            <p>Get started by adding your first vehicle to the system.</p>
            <a href="/admin/vehicle/add" class="btn btn-primary">Add Vehicle</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <?php
                        $mediaUrls = json_decode($vehicle['media_urls'], true) ?? [];
                        $thumbnail = !empty($mediaUrls) ? '/' . $mediaUrls[0] : '/css/placeholder-car.svg';
                        ?>
                        <tr>
                            <td>
                                <img src="<?= htmlspecialchars($thumbnail) ?>" 
                                     alt="<?= htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']) ?>"
                                     class="table-thumb"
                                     onerror="this.src='/css/placeholder-car.svg'">
                            </td>
                            <td><?= htmlspecialchars($vehicle['make']) ?></td>
                            <td><?= htmlspecialchars($vehicle['model']) ?></td>
                            <td><?= htmlspecialchars($vehicle['year']) ?></td>
                            <td class="price-cell">$<?= number_format($vehicle['price'], 2) ?></td>
                            <td class="actions-cell">
                                <a href="/admin/vehicle/edit/<?= $vehicle['id'] ?>" 
                                   class="btn btn-small btn-secondary">Edit</a>
                                <form method="POST" action="/admin/vehicle/delete/<?= $vehicle['id'] ?>" 
                                      style="display: inline;"
                                      onsubmit="return confirm('Are you sure you want to delete this vehicle?');">
                                    <button type="submit" class="btn btn-small btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="dashboard-stats">
            <p>Total vehicles: <strong><?= count($vehicles) ?></strong></p>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
$title = 'Dashboard - Car Dealer Admin';
require __DIR__ . '/../layout.php';
?>
