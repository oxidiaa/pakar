<?php
// File: templates/form_barang.php

include 'header.php';
?>

<div class="row justify-content-center">
  <div class="col-lg-8">

    <a href="index.php" class="btn btn-link text-secondary text-decoration-none mb-3">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Barang
    </a>

    <?php
    // Tampilkan pesan flash (notifikasi) jika ada
    displayFlashMessage();
    ?>

    <div class="card">
      <div class="card-header bg-white">
        <h4 class="mb-0">Formulir Data Barang</h4>
      </div>
      <div class="card-body">
        <form action="index.php?action=save" method="POST">
          <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Contoh: Kertas A4 70gsm" required>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="stok" class="form-label">Stok Saat Ini</label>
              <input type="number" class="form-control" id="stok" name="stok" min="0" placeholder="Jumlah unit saat ini" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="rata_pemakaian" class="form-label">Rata-rata Pemakaian / Hari</label>
              <input type="number" step="0.1" class="form-control" id="rata_pemakaian" name="rata_pemakaian" min="0" placeholder="Contoh: 5.5" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="lead_time" class="form-label">Lead Time (Hari)</label>
              <input type="number" class="form-control" id="lead_time" name="lead_time" min="0" placeholder="Waktu tunggu pesanan" required>
              <small class="form-text text-muted">Estimasi waktu (dalam hari) dari pemesanan hingga barang diterima.</small>
            </div>
            <div class="col-md-6 mb-3">
              <label for="minimum_stok" class="form-label">Stok Minimum</label>
              <input type="number" class="form-control" id="minimum_stok" name="minimum_stok" min="0" placeholder="Jumlah stok pengaman" required>
              <small class="form-text text-muted">Jumlah stok minimal yang harus selalu ada sebagai pengaman.</small>
            </div>
          </div>
          <hr class="my-4">
          <div class="d-flex justify-content-end">
            <a href="index.php" class="btn btn-secondary me-2">
                <i class="fas fa-times me-2"></i>Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Simpan Barang
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>