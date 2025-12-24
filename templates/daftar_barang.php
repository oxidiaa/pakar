<?php
// File: templates/daftar_barang.php

include 'header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="mb-1">Manajemen Stok Barang</h2>
    <p class="text-muted">Daftar semua barang habis pakai yang tersimpan dalam sistem.</p>
  </div>
</div>

<?php
// Tampilkan pesan flash (notifikasi) jika ada
displayFlashMessage();
?>

<div class="card">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Daftar Barang</h5>
    <a href="index.php?action=add" class="btn btn-primary btn-sm">
      <i class="fas fa-plus me-2"></i>Tambah Barang
    </a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">Nama Barang</th>
            <th>Stok</th>
            <th>Pemakaian/Hari</th>
            <th>Lead Time</th>
            <th>Min. Stok</th>
            <th>Rekomendasi Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($items)): ?>
            <tr>
              <td colspan="7" class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-0">Belum ada data barang. Silakan tambahkan barang baru.</p>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($items as $item): ?>
              <tr>
                <td class="ps-4 fw-medium"><?= htmlspecialchars($item['nama_barang']); ?></td>
                <td><?= htmlspecialchars($item['stok']); ?></td>
                <td><?= htmlspecialchars($item['rata_pemakaian']); ?></td>
                <td><?= htmlspecialchars($item['lead_time']); ?> hari</td>
                <td><?= htmlspecialchars($item['minimum_stok']); ?></td>
                <td><?= getStockRecommendation($item); ?></td>
                <td>
                  <a href="index.php?action=edit&id=<?= $item['id']; ?>" class="btn btn-warning btn-sm" title="Edit">
                    <i class="fas fa-pencil-alt"></i>
                  </a>
                  <a href="index.php?action=delete&id=<?= $item['id']; ?>" class="btn btn-danger btn-sm" title="Hapus"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>