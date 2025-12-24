<?php
// File: index.php

require_once 'config.php';
require_once 'database.php';
require_once 'functions.php';

// Tentukan aksi yang akan dilakukan, defaultnya adalah 'list'
$action = $_GET['action'] ?? 'list';

// Public routes yang tidak butuh login
$publicRoutes = ['login', 'authenticate'];

// Cek apakah user sudah login
if (!isset($_SESSION['user_id']) && !in_array($action, $publicRoutes)) {
    // Jika belum login dan mengakses halaman protected, redirect ke login
    header('Location: index.php?action=login');
    exit;
}

switch ($action) {
    case 'login':
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }
        include 'templates/login.php';
        break;

    case 'authenticate':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = loginUser($username, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                setFlashMessage('success', 'Selamat datang, ' . htmlspecialchars($user['username']));
                header('Location: index.php');
                exit;
            } else {
                setFlashMessage('danger', 'Username atau password salah.');
                header('Location: index.php?action=login');
                exit;
            }
        }
        header('Location: index.php?action=login');
        exit;

    case 'logout':
        session_destroy();
        header('Location: index.php?action=login');
        exit;

    case 'add':
        // Menampilkan form untuk menambah barang
        include 'templates/form_barang.php';
        break;

    case 'save':
        // Hanya proses jika metode request adalah POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_barang' => trim($_POST['nama_barang'] ?? ''),
                'stok' => (int) ($_POST['stok'] ?? 0),
                'rata_pemakaian' => (float) ($_POST['rata_pemakaian'] ?? 0),
                'lead_time' => (int) ($_POST['lead_time'] ?? 0),
                'minimum_stok' => (int) ($_POST['minimum_stok'] ?? 0),
            ];

            if (empty($data['nama_barang'])) {
                setFlashMessage('danger', 'Nama barang tidak boleh kosong.');
                header('Location: index.php?action=add');
                exit;
            }

            if (addItem($data)) {
                setFlashMessage('success', 'Barang berhasil ditambahkan.');
            } else {
                setFlashMessage('danger', 'Gagal menambahkan barang.');
            }
        }
        header('Location: index.php');
        exit;

    case 'edit':
        $id = (int) ($_GET['id'] ?? 0);
        $item = getItemById($id);
        if (!$item) {
            setFlashMessage('danger', 'Barang tidak ditemukan.');
            header('Location: index.php');
            exit;
        }
        include 'templates/form_edit_barang.php';
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => (int) ($_POST['id'] ?? 0),
                'nama_barang' => trim($_POST['nama_barang'] ?? ''),
                'stok' => (int) ($_POST['stok'] ?? 0),
                'rata_pemakaian' => (float) ($_POST['rata_pemakaian'] ?? 0),
                'lead_time' => (int) ($_POST['lead_time'] ?? 0),
                'minimum_stok' => (int) ($_POST['minimum_stok'] ?? 0),
            ];

            if (empty($data['nama_barang']) || $data['id'] === 0) {
                setFlashMessage('danger', 'Data tidak valid untuk diupdate.');
                header('Location: index.php');
                exit;
            }

            if (updateItem($data)) {
                setFlashMessage('success', 'Data barang berhasil diupdate.');
            } else {
                setFlashMessage('danger', 'Gagal mengupdate data barang.');
            }
        }
        header('Location: index.php');
        exit;

    case 'delete':
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            if (deleteItem($id)) {
                setFlashMessage('success', 'Barang berhasil dihapus.');
            } else {
                setFlashMessage('danger', 'Gagal menghapus barang.');
            }
        } else {
            setFlashMessage('danger', 'ID barang tidak valid.');
        }
        header('Location: index.php');
        exit;

    case 'list':
    default:
        // Menampilkan daftar semua barang
        $items = getAllItems();
        include 'templates/daftar_barang.php';
        break;
}