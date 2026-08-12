<?php
session_start();
include 'koneksi.php';

// Cek Login Admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* ================= LOGIKA CRUD ================= */
if (isset($_POST['tambah'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];
    $q = mysqli_query($conn, "INSERT INTO users (nama_lengkap, username, password, role, created_at) VALUES ('$nama', '$username', '$password', '$role', NOW())");
    if($q) { $_SESSION['notif'] = "User berhasil ditambahkan!"; $_SESSION['type'] = "success"; }
    header("Location: manajemen_user.php"); exit;
}

if (isset($_POST['edit'])) {
    $id       = intval($_POST['id_user']);
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role     = $_POST['role'];
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE users SET nama_lengkap='$nama', username='$username', password='$password', role='$role' WHERE id_user='$id'";
    } else {
        $sql = "UPDATE users SET nama_lengkap='$nama', username='$username', role='$role' WHERE id_user='$id'";
    }
    if(mysqli_query($conn, $sql)) { $_SESSION['notif'] = "User berhasil diperbarui!"; $_SESSION['type'] = "info"; }
    header("Location: manajemen_user.php"); exit;
}

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    if ($id == $_SESSION['id_user']) {
        $_SESSION['notif'] = "Tidak bisa hapus akun sendiri!"; $_SESSION['type'] = "danger";
    } else {
        mysqli_query($conn, "DELETE FROM users WHERE id_user='$id'");
        $_SESSION['notif'] = "User berhasil dihapus!"; $_SESSION['type'] = "warning";
    }
    header("Location: manajemen_user.php"); exit;
}

$users = mysqli_query($conn, "SELECT * FROM users ORDER BY id_user DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        body { background: #f4f7f6; font-family: 'Poppins', sans-serif; }

        /* SIDEBAR */
        .sidebar { width: 240px; position: fixed; top: 0; bottom: 0; background: #1a1c23; z-index: 1001; }
        .sidebar .brand { padding: 20px; color: white; font-weight: 600; font-size: 1.1rem; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; }
        .menu-label { font-size: 0.65rem; text-transform: uppercase; color: #4e5d78; padding: 25px 25px 10px; font-weight: 700; letter-spacing: 1px; }
        .sidebar .nav-link { color: #9ea4b0; padding: 12px 25px; display: flex; align-items: center; text-decoration: none; transition: 0.3s; font-size: 0.9rem; }
        .sidebar .nav-link i { margin-right: 15px; font-size: 1.2rem; }
        .sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,0.05); }
        .sidebar .nav-link.active { background: #0d6efd; color: #fff; }

        /* TOPBAR */
        .topbar { background: #0d6efd; height: 60px; position: fixed; top: 0; right: 0; left: 240px; padding: 0 30px; display: flex; justify-content: space-between; align-items: center; z-index: 1000; }
        .topbar .title { color: white; font-weight: 600; font-size: 1rem; }
        .user-info { display: flex; align-items: center; gap: 15px; color: white; }
        .btn-logout { background: #ffc107; color: #000 !important; font-weight: 700; padding: 5px 15px; border-radius: 6px; font-size: 0.8rem; text-decoration: none; }

        /* CONTENT */
        .main-content { margin-left: 240px; padding-top: 60px; }
        .page-header { padding: 30px; }
        .content-body { padding: 0 30px 30px; }

        .card-custom { background: white; border-radius: 15px; border: none; box-shadow: 0 5px 20px rgba(0,0,0,0.03); }
        .table thead th { background: #fff; color: #0d6efd; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 15px; border-bottom: 1px solid #f1f1f1; }
        .table td { padding: 15px; vertical-align: middle; font-size: 0.85rem; }

        /* MODAL STYLING */
        .modal-content { border-radius: 20px !important; border: none; }
        .form-label-custom { font-size: 0.75rem; font-weight: 700; color: #4e5d78; text-transform: uppercase; margin-bottom: 5px; }
        .input-group-text { border: none; background: #f8f9fa; color: #6c757d; }
        .box-warning-pw { background: #fff5f5; border: 1px dashed #feb2b2; border-radius: 12px; padding: 15px; }

        /* BADGES */
        .badge-role { padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.75rem; }
        .badge-admin { background: rgba(220, 38, 38, 0.1); color: #dc2626; }
        .badge-bendahara { background: rgba(217, 119, 6, 0.1); color: #d97706; }
        .badge-warga { background: rgba(2, 132, 199, 0.1); color: #0284c7; }
        .btn-action { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="brand"><i class="bi bi-wallet2 me-2"></i> Master Data Iuran</div>
    <div class="menu-label">Menu Utama</div>
    <a href="dashboard_admin.php" class="nav-link"><i class="bi bi-grid"></i> Dashboard</a>
    <a href="manajemen_user.php" class="nav-link active"><i class="bi bi-people"></i> Manajemen User</a>
    <a href="data_kk.php" class="nav-link"><i class="bi bi-journal-bookmark"></i> Data KK</a>
</div>

<div class="topbar">
    <div class="title">Pengaturan Pengguna</div>
    <div class="user-info">
        <span class="small"><i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($_SESSION['nama']) ?></span>
        <a href="logout.php" class="btn-logout" onclick="return confirm('Logout?')">Logout</a>
    </div>
</div>

<div class="main-content">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold m-0">Manajemen User</h2>
            <p class="text-muted small mb-0">Atur hak akses Admin, Bendahara, dan Warga.</p>
        </div>
        <button class="btn btn-primary px-4 py-2 fw-bold shadow-sm" style="border-radius:10px" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah User
        </button>
    </div>

    <div class="content-body">
        <?php if(isset($_SESSION['notif'])): ?>
            <div class="alert alert-<?= $_SESSION['type'] ?> border-0 shadow-sm mb-4">
                <i class="bi bi-info-circle-fill me-2"></i> <?= $_SESSION['notif']; unset($_SESSION['notif'], $_SESSION['type']); ?>
            </div>
        <?php endif; ?>

        <div class="card-custom p-3 mb-4">
            <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" id="searchUser" class="form-control bg-light border-0" placeholder="Cari nama atau username...">
            </div>
        </div>

        <div class="card-custom overflow-hidden">
            <div class="table-responsive">
                <table class="table m-0" id="userTable">
                    <thead>
                        <tr>
                            <th class="text-center">NO</th>
                            <th>NAMA PENGGUNA</th>
                            <th>USERNAME</th>
                            <th>HAK AKSES</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php $no=1; while($u=mysqli_fetch_assoc($users)): ?>
    <tr>
        <td class="text-center text-muted small"><?= $no++ ?></td>
        <td>
            <div class="fw-bold text-dark"><?= htmlspecialchars($u['nama_lengkap']) ?></div>
            <div style="font-size: 0.7rem;" class="text-muted">Sejak: <?= date('d M Y', strtotime($u['created_at'])) ?></div>
        </td>
        <td><code class="text-primary fw-bold"><?= htmlspecialchars($u['username']) ?></code></td>
        <td>
            <span class="badge-role badge-<?= $u['role'] ?>">
                <i class="bi bi-shield-lock me-1"></i> <?= strtoupper($u['role']) ?>
            </span>
        </td>
        <td class="text-center">
            <div class="d-flex justify-content-center gap-1">
                <button type="button" class="btn btn-outline-primary btn-action" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $u['id_user'] ?>">
                    <i class="bi bi-pencil"></i>
                </button>
                <a href="?hapus=<?= $u['id_user'] ?>" class="btn btn-outline-danger btn-action" onclick="return confirm('Hapus user ini?')">
                    <i class="bi bi-trash"></i>
                </a>
            </div>

            <div class="modal fade" id="modalEdit<?= $u['id_user'] ?>" tabindex="-1" aria-labelledby="modalEditLabel<?= $u['id_user'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form method="POST" class="modal-content shadow-lg text-start">
                        <div class="modal-header border-0 pt-4 px-4 pb-2">
                            <h5 class="fw-bold m-0"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Akun</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <input type="hidden" name="id_user" value="<?= $u['id_user'] ?>">

                            <div class="mb-3">
                                <label class="form-label-custom">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input name="nama" class="form-control bg-light border-0 py-2" value="<?= htmlspecialchars($u['nama_lengkap']) ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label-custom">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-at"></i></span>
                                    <input name="username" class="form-control bg-light border-0 py-2" value="<?= htmlspecialchars($u['username']) ?>" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label-custom">Role Akses</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                    <select name="role" class="form-select bg-light border-0 py-2">
                                        <option value="admin" <?= $u['role']=='admin'?'selected':'' ?>>Admin</option>
                                        <option value="bendahara" <?= $u['role']=='bendahara'?'selected':'' ?>>Bendahara</option>
                                        <option value="warga" <?= $u['role']=='warga'?'selected':'' ?>>Warga</option>
                                    </select>
                                </div>
                            </div>

                            <div class="box-warning-pw">
                                <label class="form-label small fw-bold text-danger"><i class="bi bi-key me-1"></i> Ganti Password?</label>
                                <input type="password" name="password" class="form-control border-0 mt-1" placeholder="Kosongkan jika tidak diganti">
                                <small class="text-muted" style="font-size: 0.65rem;">Biarkan kosong jika tetap menggunakan password lama.</small>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="submit" name="edit" class="btn btn-primary w-100 py-2 fw-bold" style="border-radius:12px">SIMPAN PERUBAHAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </td>
    </tr>
    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" class="modal-content shadow-lg">
            <div class="modal-header border-0 pt-4 px-4 pb-2">
                <h5 class="fw-bold m-0 text-primary"><i class="bi bi-person-plus-fill me-2"></i>User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label-custom">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input name="nama" class="form-control bg-light border-0 py-2" placeholder="Nama asli" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-at"></i></span>
                        <input name="username" class="form-control bg-light border-0 py-2" placeholder="Untuk login" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" name="password" class="form-control bg-light border-0 py-2" placeholder="Min. 6 karakter" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Role</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                        <select name="role" class="form-select bg-light border-0 py-2" required>
                            <option value="admin">Admin</option>
                            <option value="bendahara">Bendahara</option>
                            <option value="warga">Warga</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button name="tambah" class="btn btn-primary w-100 py-2 fw-bold" style="border-radius:12px">DAFTARKAN SEKARANG</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById("searchUser").addEventListener("keyup", function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll("#userTable tbody tr");
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(value) ? "" : "none";
        });
    });
</script>
</body>
</html>
