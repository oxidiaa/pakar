<?php
// File: functions.php

/**
 * Mengambil semua data barang dari database.
 * @return array
 */
function getAllItems()
{
    $conn = getDbConnection();
    $stmt = $conn->prepare("SELECT * FROM items ORDER BY nama_barang ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Menyimpan barang baru ke database.
 * @param array $data Data barang
 * @return bool
 */
function addItem($data)
{
    $conn = getDbConnection();
    $sql = "INSERT INTO items (nama_barang, stok, rata_pemakaian, lead_time, minimum_stok) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([
        $data['nama_barang'],
        $data['stok'],
        $data['rata_pemakaian'],
        $data['lead_time'],
        $data['minimum_stok']
    ]);
}

/**
 * Menghitung status rekomendasi stok berdasarkan logika.
 * @param array $item Data satu barang
 * @return string HTML badge untuk rekomendasi
 */
function getStockRecommendation($item)
{
    $stok = (int) $item['stok'];
    $pemakaian = (float) $item['rata_pemakaian'];
    $leadTime = (int) $item['lead_time'];
    $minStok = (int) $item['minimum_stok'];

    // Safety stock: Kebutuhan selama lead time
    $kebutuhan = $pemakaian * $leadTime;

    // Titik pemesanan ulang (Reorder Point)
    $reorderPoint = $kebutuhan + $minStok;

    if ($stok <= $reorderPoint) {
        return "<span class='badge bg-danger'>Segera Pesan Ulang</span>";
    } elseif ($stok <= $reorderPoint + ($pemakaian * 3)) { // Buffer 3 hari
        return "<span class='badge bg-warning text-dark'>Stok Menipis</span>";
    } else {
        return "<span class='badge bg-success'>Stok Aman</span>";
    }
}

/**
 * Menetapkan pesan flash untuk ditampilkan di halaman berikutnya.
 * @param string $type Tipe pesan (e.g., 'success', 'danger')
 * @param string $message Pesan yang akan ditampilkan
 */
function setFlashMessage($type, $message)
{
    $_SESSION['flash_message'] = ['type' => $type, 'message' => $message];
}

/**
 * Menampilkan dan menghapus pesan flash.
 */
function displayFlashMessage()
{
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        echo '<div class="alert alert-' . htmlspecialchars($flash['type']) . '" role="alert">' . htmlspecialchars($flash['message']) . '</div>';
        unset($_SESSION['flash_message']);
    }
}


/**
 * Mengambil satu data barang berdasarkan ID-nya.
 * @param int $id ID barang
 * @return array|false Data barang atau false jika tidak ditemukan
 */
function getItemById($id)
{
    $conn = getDbConnection();
    $stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Memperbarui data barang di database.
 * @param array $data Data barang yang akan diupdate (termasuk id)
 * @return bool
 */
function updateItem($data)
{
    $conn = getDbConnection();
    $sql = "UPDATE items SET 
                nama_barang = ?, 
                stok = ?, 
                rata_pemakaian = ?, 
                lead_time = ?, 
                minimum_stok = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    return $stmt->execute([
        $data['nama_barang'],
        $data['stok'],
        $data['rata_pemakaian'],
        $data['lead_time'],
        $data['minimum_stok'],
        $data['id']
    ]);
}

/**
 * Menghapus data barang dari database berdasarkan ID.
 * @param int $id ID barang
 * @return bool
 */
function deleteItem($id)
{
    $conn = getDbConnection();
    $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
    return $stmt->execute([$id]);
}

/**
 * Verifikasi login user.
 * @param string $username Username
 * @param string $password Password
 * @return array|false Data user jika sukses, false jika gagal
 */
function loginUser($username, $password)
{
    $conn = getDbConnection();
    // Hanya ambil user dengan role admin
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = 'admin'");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}
?>