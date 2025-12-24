<?php
// File: templates/form_edit_barang.php

include 'header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <a href="index.php" class="btn btn-link text-secondary text-decoration-none mb-3">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Barang
        </a>

        <?php displayFlashMessage(); ?>

        <div class="card">
            <div class="card-header bg-white">
                <h4 class="mb-0">Formulir Edit Barang</h4>
            </div>
            <div class="card-body">
                <form action="index.php?action=update" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']); ?>">

                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                            value="<?= htmlspecialchars($item['nama_barang']); ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stok" class="form-label">Stok Saat Ini</label>
                            <input type="number" class="form-control" id="stok" name="stok" min="0"
                                value="<?= htmlspecialchars($item['stok']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rata_pemakaian" class="form-label">Rata-rata Pemakaian / Hari</label>
                            <input type="number" step="0.1" class="form-control" id="rata_pemakaian"
                                name="rata_pemakaian" min="0" value="<?= htmlspecialchars($item['rata_pemakaian']); ?>"
                                required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="lead_time" class="form-label">Lead Time (Hari)</label>
                            <input type="number" class="form-control" id="lead_time" name="lead_time" min="0"
                                value="<?= htmlspecialchars($item['lead_time']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="minimum_stok" class="form-label">Stok Minimum</label>
                            <input type="number" class="form-control" id="minimum_stok" name="minimum_stok" min="0"
                                value="<?= htmlspecialchars($item['minimum_stok']); ?>" required>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="d-flex justify-content-end">
                        <a href="index.php" class="btn btn-secondary me-2">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-sync-alt me-2"></i>Update Barang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>