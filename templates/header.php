<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | Inventory Warehouse Consumable</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <i class="fas fa-boxes-stacked me-2"></i> Inventory Manager
      </a>

      <?php if (isset($_SESSION['user_id'])): ?>
        <div class="ms-auto d-flex align-items-center">
          <span class="text-white-50 me-3 small">
            <i class="fas fa-user-circle me-1"></i>
            <?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?>
          </span>
          <a href="index.php?action=logout" class="btn btn-outline-light btn-sm border-0">
            <i class="fas fa-sign-out-alt me-1"></i> Logout
          </a>
        </div>
      <?php endif; ?>
    </div>
  </nav>

  <main class="container my-5">