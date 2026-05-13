<?php
// ============================================================
//  API.PHP — Backend semua operasi data
// ============================================================
session_start();
header('Content-Type: application/json; charset=utf-8');
require 'db.php';

$action = $_GET['action'] ?? '';
$input  = json_decode(file_get_contents('php://input'), true) ?? [];

function isAuth()    { return isset($_SESSION['mis_user']); }
function isAdmin()   { return isAuth() && $_SESSION['mis_user']['role'] === 'admin'; }
function requireAuth()  { if (!isAuth())  { echo json_encode(['error'=>'Unauthorized']); exit; } }
function requireAdmin() { requireAuth();  if (!isAdmin()) { echo json_encode(['error'=>'Admin only']); exit; } }
function currentUser()  { return $_SESSION['mis_user'] ?? null; }

function setSetting(PDO $pdo, string $key, string $val): void {
    $pdo->prepare("INSERT INTO settings (skey,sval) VALUES (?,?) ON DUPLICATE KEY UPDATE sval=?")->execute([$key,$val,$val]);
}
function addLog(PDO $pdo, string $action, string $detail=''): void {
    $u = currentUser();
    $pdo->prepare("INSERT INTO logs (waktu,username,action,detail) VALUES (?,?,?,?)")
        ->execute([date('d/m/Y H:i:s'), $u ? $u['username'] : 'system', $action, $detail]);
}

switch ($action) {

// ---- GET PUBLIC ----
case 'get_public':
    $rows = $pdo->query("SELECT skey, sval FROM settings")->fetchAll();
    $s = []; foreach ($rows as $r) $s[$r['skey']] = $r['sval'];

    $guru   = $pdo->query("SELECT id,nama,jabatan,foto FROM guru ORDER BY urutan,id")->fetchAll();
    $slider = $pdo->query("SELECT gambar FROM slider ORDER BY urutan,id")->fetchAll();
    $galeri = $pdo->query("SELECT id,gambar,keterangan FROM galeri ORDER BY urutan,id")->fetchAll();
    $berita = $pdo->query("SELECT id,judul,tanggal,kategori,isi,foto FROM berita ORDER BY id DESC")->fetchAll();
    $eskul  = $pdo->query("SELECT id,nama,deskripsi,foto FROM eskul ORDER BY urutan,id")->fetchAll();
    $j12    = $pdo->query("SELECT hari,mapel,jam FROM jadwal WHERE kelas='12' ORDER BY urutan,id")->fetchAll();
    $j36    = $pdo->query("SELECT hari,mapel,jam FROM jadwal WHERE kelas='36' ORDER BY urutan,id")->fetchAll();

    echo json_encode([
        'site' => [
            'title'          => $s['site_title']        ?? 'MIS DARUL IHYA',
            'tagline'        => $s['site_tagline']       ?? 'Akreditasi A',
            'heroTagline'    => $s['site_hero_tagline']  ?? '',
            'tentang'        => $s['site_tentang']       ?? '',
            'sejarah'        => $s['site_sejarah']       ?? '',
            'visi'           => $s['site_visi']          ?? '',
            'misi'           => $s['site_misi']          ?? '',
            'tujuan'         => $s['site_tujuan']        ?? '',
            'fasilitas'      => $s['site_fasilitas']     ?? '',
            'tenagaPendidik' => $s['site_tenaga']        ?? '',
            'penutup'        => $s['site_penutup']       ?? '',
            'kontak' => [
                'alamat' => $s['kontak_alamat'] ?? '',
                'telp'   => $s['kontak_telp']   ?? '',
                'email'  => $s['kontak_email']  ?? '',
                'maps'   => $s['kontak_maps']   ?? '',
            ],
            'waNumber'  => $s['wa_number']    ?? '',
            'waMessage' => $s['wa_message']   ?? '',
            'kepsek' => [
                'nama'  => $s['kepsek_nama']  ?? '',
                'motto' => $s['kepsek_motto'] ?? '',
                'foto'  => $s['kepsek_foto']  ?? '',
            ],
        ],
        'logo'        => $s['logo']         ?? '',
        'heroBg'      => $s['hero_bg']      ?? '',
        'biayaGambar' => $s['biaya_gambar'] ?? '',
        'guru'   => $guru,
        'slider' => array_column($slider, 'gambar'),
        'galeri' => $galeri,
        'berita' => $berita,
        'eskul'  => $eskul,
        'jadwal12' => array_map(fn($r)=>[$r['hari'],$r['mapel'],$r['jam']], $j12),
        'jadwal36' => array_map(fn($r)=>[$r['hari'],$r['mapel'],$r['jam']], $j36),
    ]);
    break;

// ---- VISITOR ----
case 'visitor':
    if (!isset($_SESSION['mis_visited'])) {
        $pdo->exec("UPDATE visitor SET count=count+1 WHERE id=1");
        $_SESSION['mis_visited'] = true;
    }
    $row = $pdo->query("SELECT count FROM visitor WHERE id=1")->fetch();
    echo json_encode(['count' => $row['count'] ?? 0]);
    break;

// ---- LOGIN ----
case 'login':
    $username = trim($input['username'] ?? '');
    $password = trim($input['password'] ?? '');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=? AND status='aktif'");
    $stmt->execute([$username]);
    $u = $stmt->fetch();
    if ($u && password_verify($password, $u['password'])) {
        $_SESSION['mis_user'] = ['id'=>$u['id'],'username'=>$u['username'],'role'=>$u['role']];
        addLog($pdo, 'Login', "User $username login");
        echo json_encode(['ok'=>true,'user'=>['username'=>$u['username'],'role'=>$u['role']]]);
    } else {
        echo json_encode(['ok'=>false,'error'=>'Username/password salah atau akun tidak aktif']);
    }
    break;

// ---- LOGOUT ----
case 'logout':
    if (isAuth()) addLog($pdo, 'Logout', 'User '.currentUser()['username'].' logout');
    session_destroy();
    echo json_encode(['ok'=>true]);
    break;

// ---- CHECK SESSION ----
case 'check_session':
    echo json_encode(['auth'=>isAuth(),'user'=>currentUser()]);
    break;

// ---- SAVE PROFIL ----
case 'save_profil':
    requireAuth();
    $map = [
        'site_title','site_tagline','site_hero_tagline',
        'site_tentang','site_sejarah','site_visi','site_misi','site_tujuan',
        'site_fasilitas','site_tenaga','site_penutup',
        'kontak_alamat','kontak_telp','kontak_email','kontak_maps',
        'wa_number','wa_message'
    ];
    foreach ($map as $key) {
        if (isset($input[$key])) setSetting($pdo, $key, $input[$key]);
    }
    if (!empty($input['logo']))    setSetting($pdo, 'logo', $input['logo']);
    if (isset($input['hero_bg']))  setSetting($pdo, 'hero_bg', $input['hero_bg']);
    addLog($pdo, 'Update Profil', 'Mengubah data profil');
    echo json_encode(['ok'=>true]);
    break;

// ---- SAVE KEPSEK ----
case 'save_kepsek':
    requireAuth();
    if (!empty($input['nama']))  setSetting($pdo, 'kepsek_nama', $input['nama']);
    if (!empty($input['motto'])) setSetting($pdo, 'kepsek_motto', $input['motto']);
    if (!empty($input['foto']))  setSetting($pdo, 'kepsek_foto', $input['foto']);
    addLog($pdo, 'Update Kepsek', 'Mengubah data kepala madrasah');
    echo json_encode(['ok'=>true]);
    break;

// ---- GURU ----
case 'get_guru':
    requireAuth();
    echo json_encode($pdo->query("SELECT id,nama,jabatan,foto FROM guru ORDER BY urutan,id")->fetchAll());
    break;

case 'add_guru':
    requireAuth();
    $nama = trim($input['nama'] ?? '');
    $jabatan = trim($input['jabatan'] ?? 'Guru Kelas');
    $foto = $input['foto'] ?? null;
    if (!$nama) { echo json_encode(['error'=>'Nama wajib diisi']); break; }
    $pdo->prepare("INSERT INTO guru (nama,jabatan,foto) VALUES (?,?,?)")->execute([$nama,$jabatan,$foto]);
    addLog($pdo, 'Tambah Guru', "Menambah guru: $nama");
    echo json_encode(['ok'=>true]);
    break;

case 'delete_guru':
    requireAuth();
    $id = (int)($input['id'] ?? 0);
    $g = $pdo->prepare("SELECT nama FROM guru WHERE id=?"); $g->execute([$id]); $r = $g->fetch();
    $pdo->prepare("DELETE FROM guru WHERE id=?")->execute([$id]);
    addLog($pdo, 'Hapus Guru', 'Hapus guru: '.($r['nama']??''));
    echo json_encode(['ok'=>true]);
    break;

// ---- SLIDER ----
case 'get_slider':
    requireAuth();
    echo json_encode($pdo->query("SELECT id,gambar FROM slider ORDER BY urutan,id")->fetchAll());
    break;

case 'add_slider':
    requireAuth();
    $gambar = $input['gambar'] ?? '';
    if (!$gambar) { echo json_encode(['error'=>'Gambar kosong']); break; }
    $pdo->prepare("INSERT INTO slider (gambar) VALUES (?)")->execute([$gambar]);
    addLog($pdo, 'Upload Slider', 'Menambah slide baru');
    echo json_encode(['ok'=>true]);
    break;

case 'delete_slider':
    requireAuth();
    $id = (int)($input['id'] ?? 0);
    $pdo->prepare("DELETE FROM slider WHERE id=?")->execute([$id]);
    addLog($pdo, 'Hapus Slider', "Hapus slide id $id");
    echo json_encode(['ok'=>true]);
    break;

// ---- GALERI (dengan keterangan) ----
case 'get_galeri':
    requireAuth();
    echo json_encode($pdo->query("SELECT id,gambar,keterangan FROM galeri ORDER BY urutan,id")->fetchAll());
    break;

case 'add_galeri':
    requireAuth();
    $gambar = $input['gambar'] ?? '';
    $keterangan = trim($input['keterangan'] ?? '');
    if (!$gambar) { echo json_encode(['error'=>'Gambar kosong']); break; }
    $pdo->prepare("INSERT INTO galeri (gambar,keterangan) VALUES (?,?)")->execute([$gambar,$keterangan]);
    addLog($pdo, 'Upload Galeri', "Menambah foto: $keterangan");
    echo json_encode(['ok'=>true]);
    break;

case 'delete_galeri':
    requireAuth();
    $id = (int)($input['id'] ?? 0);
    $pdo->prepare("DELETE FROM galeri WHERE id=?")->execute([$id]);
    addLog($pdo, 'Hapus Galeri', "Hapus galeri id $id");
    echo json_encode(['ok'=>true]);
    break;

// ---- BERITA (dengan foto) ----
case 'get_berita':
    requireAuth();
    echo json_encode($pdo->query("SELECT * FROM berita ORDER BY id DESC")->fetchAll());
    break;

case 'add_berita':
    requireAuth();
    $judul    = trim($input['judul'] ?? '');
    $tanggal  = $input['tanggal'] ?? '';
    $kategori = $input['kategori'] ?? 'Berita';
    $isi      = trim($input['isi'] ?? '');
    $foto     = $input['foto'] ?? null;
    if (!$judul || !$isi) { echo json_encode(['error'=>'Judul dan isi harus diisi']); break; }
    $pdo->prepare("INSERT INTO berita (judul,tanggal,kategori,isi,foto) VALUES (?,?,?,?,?)")->execute([$judul,$tanggal,$kategori,$isi,$foto]);
    addLog($pdo, 'Tambah Berita', "Menambah berita: $judul");
    echo json_encode(['ok'=>true,'id'=>$pdo->lastInsertId()]);
    break;

case 'edit_berita':
    requireAuth();
    $id       = (int)($input['id'] ?? 0);
    $judul    = trim($input['judul'] ?? '');
    $tanggal  = $input['tanggal'] ?? '';
    $kategori = $input['kategori'] ?? 'Berita';
    $isi      = trim($input['isi'] ?? '');
    $foto     = $input['foto'] ?? null;
    if (!$judul || !$isi) { echo json_encode(['error'=>'Judul dan isi harus diisi']); break; }
    if ($foto) {
        $pdo->prepare("UPDATE berita SET judul=?,tanggal=?,kategori=?,isi=?,foto=? WHERE id=?")->execute([$judul,$tanggal,$kategori,$isi,$foto,$id]);
    } else {
        $pdo->prepare("UPDATE berita SET judul=?,tanggal=?,kategori=?,isi=? WHERE id=?")->execute([$judul,$tanggal,$kategori,$isi,$id]);
    }
    addLog($pdo, 'Edit Berita', "Edit berita: $judul");
    echo json_encode(['ok'=>true]);
    break;

case 'delete_berita':
    requireAuth();
    $id = (int)($input['id'] ?? 0);
    $b = $pdo->prepare("SELECT judul FROM berita WHERE id=?"); $b->execute([$id]); $r = $b->fetch();
    $pdo->prepare("DELETE FROM berita WHERE id=?")->execute([$id]);
    addLog($pdo, 'Hapus Berita', 'Hapus berita: '.($r['judul']??''));
    echo json_encode(['ok'=>true]);
    break;

// ---- ESKUL ----
case 'get_eskul':
    requireAuth();
    echo json_encode($pdo->query("SELECT id,nama,deskripsi,foto FROM eskul ORDER BY urutan,id")->fetchAll());
    break;

case 'add_eskul':
    requireAuth();
    $nama      = trim($input['nama'] ?? '');
    $deskripsi = trim($input['deskripsi'] ?? '');
    $foto      = $input['foto'] ?? null;
    if (!$nama) { echo json_encode(['error'=>'Nama eskul wajib diisi']); break; }
    $pdo->prepare("INSERT INTO eskul (nama,deskripsi,foto) VALUES (?,?,?)")->execute([$nama,$deskripsi,$foto]);
    addLog($pdo, 'Tambah Eskul', "Menambah eskul: $nama");
    echo json_encode(['ok'=>true]);
    break;

case 'edit_eskul':
    requireAuth();
    $id        = (int)($input['id'] ?? 0);
    $nama      = trim($input['nama'] ?? '');
    $deskripsi = trim($input['deskripsi'] ?? '');
    $foto      = $input['foto'] ?? null;
    if (!$nama) { echo json_encode(['error'=>'Nama eskul wajib diisi']); break; }
    if ($foto) {
        $pdo->prepare("UPDATE eskul SET nama=?,deskripsi=?,foto=? WHERE id=?")->execute([$nama,$deskripsi,$foto,$id]);
    } else {
        $pdo->prepare("UPDATE eskul SET nama=?,deskripsi=? WHERE id=?")->execute([$nama,$deskripsi,$id]);
    }
    addLog($pdo, 'Edit Eskul', "Edit eskul: $nama");
    echo json_encode(['ok'=>true]);
    break;

case 'delete_eskul':
    requireAuth();
    $id = (int)($input['id'] ?? 0);
    $e = $pdo->prepare("SELECT nama FROM eskul WHERE id=?"); $e->execute([$id]); $r = $e->fetch();
    $pdo->prepare("DELETE FROM eskul WHERE id=?")->execute([$id]);
    addLog($pdo, 'Hapus Eskul', 'Hapus eskul: '.($r['nama']??''));
    echo json_encode(['ok'=>true]);
    break;

// ---- JADWAL ----
case 'save_jadwal':
    requireAuth();
    $j12 = $input['jadwal12'] ?? [];
    $j36 = $input['jadwal36'] ?? [];
    $pdo->exec("DELETE FROM jadwal WHERE kelas='12'");
    $pdo->exec("DELETE FROM jadwal WHERE kelas='36'");
    $stmt = $pdo->prepare("INSERT INTO jadwal (kelas,hari,mapel,jam,urutan) VALUES (?,?,?,?,?)");
    foreach ($j12 as $i=>$r) $stmt->execute(['12',$r[0]??'',$r[1]??'',$r[2]??'',$i]);
    foreach ($j36 as $i=>$r) $stmt->execute(['36',$r[0]??'',$r[1]??'',$r[2]??'',$i]);
    addLog($pdo, 'Simpan Jadwal', 'Menyimpan perubahan jadwal');
    echo json_encode(['ok'=>true]);
    break;

// ---- PPDB ----
case 'add_ppdb':
    $d = $input;
    $pdo->prepare("INSERT INTO ppdb (nama,jk,tempat,tgl,alamat,hp,ijazah,akte,tanggal_daftar) VALUES (?,?,?,?,?,?,?,?,?)")
        ->execute([$d['nama']??'',$d['jk']??'',$d['tempat']??'',$d['tgl']??'',$d['alamat']??'',$d['hp']??'',$d['ijazah']??null,$d['akte']??null,$d['tanggal_daftar']??date('d/m/Y')]);
    echo json_encode(['ok'=>true]);
    break;

case 'get_ppdb':
    requireAuth();
    echo json_encode($pdo->query("SELECT * FROM ppdb ORDER BY id DESC")->fetchAll());
    break;

case 'delete_ppdb':
    requireAuth();
    $id = (int)($input['id'] ?? 0);
    $p = $pdo->prepare("SELECT nama FROM ppdb WHERE id=?"); $p->execute([$id]); $r = $p->fetch();
    $pdo->prepare("DELETE FROM ppdb WHERE id=?")->execute([$id]);
    addLog($pdo, 'Hapus PPDB', 'Hapus pendaftar: '.($r['nama']??''));
    echo json_encode(['ok'=>true]);
    break;

case 'clear_ppdb':
    requireAdmin();
    $pdo->exec("DELETE FROM ppdb");
    addLog($pdo, 'Clear PPDB', 'Hapus semua data pendaftar');
    echo json_encode(['ok'=>true]);
    break;

// ---- BIAYA ----
case 'save_biaya':
    requireAuth();
    setSetting($pdo, 'biaya_gambar', $input['gambar'] ?? '');
    addLog($pdo, 'Upload Biaya', 'Upload gambar biaya');
    echo json_encode(['ok'=>true]);
    break;

case 'delete_biaya':
    requireAuth();
    setSetting($pdo, 'biaya_gambar', '');
    addLog($pdo, 'Hapus Biaya', 'Hapus gambar biaya');
    echo json_encode(['ok'=>true]);
    break;

// ---- USERS ----
case 'get_users':
    requireAdmin();
    echo json_encode($pdo->query("SELECT id,username,role,status FROM users ORDER BY id")->fetchAll());
    break;

case 'add_user':
    requireAdmin();
    $username = trim($input['username'] ?? '');
    $password = $input['password'] ?? '';
    $role     = $input['role'] ?? 'staff';
    $status   = $input['status'] ?? 'aktif';
    if (!$username || !$password) { echo json_encode(['error'=>'Username dan password wajib']); break; }
    try {
        $pdo->prepare("INSERT INTO users (username,password,role,status) VALUES (?,?,?,?)")
            ->execute([$username, password_hash($password, PASSWORD_DEFAULT), $role, $status]);
        addLog($pdo, 'Tambah User', "Tambah user: $username ($role)");
        echo json_encode(['ok'=>true]);
    } catch (Exception $e) { echo json_encode(['error'=>'Username sudah ada']); }
    break;

case 'edit_user':
    requireAdmin();
    $id = (int)($input['id'] ?? 0);
    $username = trim($input['username'] ?? '');
    $password = $input['password'] ?? '';
    $role = $input['role'] ?? 'staff';
    $status = $input['status'] ?? 'aktif';
    if (!$username) { echo json_encode(['error'=>'Username wajib']); break; }
    if ($password) {
        $pdo->prepare("UPDATE users SET username=?,password=?,role=?,status=? WHERE id=?")->execute([$username, password_hash($password, PASSWORD_DEFAULT), $role, $status, $id]);
    } else {
        $pdo->prepare("UPDATE users SET username=?,role=?,status=? WHERE id=?")->execute([$username, $role, $status, $id]);
    }
    addLog($pdo, 'Edit User', "Edit user: $username");
    echo json_encode(['ok'=>true]);
    break;

case 'delete_user':
    requireAdmin();
    $id = (int)($input['id'] ?? 0);
    if ($id === 1) { echo json_encode(['error'=>'User admin default tidak bisa dihapus']); break; }
    $u = $pdo->prepare("SELECT username FROM users WHERE id=?"); $u->execute([$id]); $r = $u->fetch();
    $pdo->prepare("DELETE FROM users WHERE id=?")->execute([$id]);
    addLog($pdo, 'Hapus User', 'Hapus user: '.($r['username']??''));
    echo json_encode(['ok'=>true]);
    break;

case 'toggle_user':
    requireAdmin();
    $id = (int)($input['id'] ?? 0);
    $u = $pdo->prepare("SELECT * FROM users WHERE id=?"); $u->execute([$id]); $r = $u->fetch();
    if ($r) {
        $new = $r['status'] === 'aktif' ? 'nonaktif' : 'aktif';
        $pdo->prepare("UPDATE users SET status=? WHERE id=?")->execute([$new,$id]);
        addLog($pdo, 'Toggle User', "User {$r['username']} → $new");
        echo json_encode(['ok'=>true,'status'=>$new]);
    } else { echo json_encode(['error'=>'User tidak ditemukan']); }
    break;

// ---- LOGS ----
case 'get_logs':
    requireAdmin();
    echo json_encode($pdo->query("SELECT * FROM logs ORDER BY id DESC LIMIT 200")->fetchAll());
    break;

case 'clear_logs':
    requireAdmin();
    $pdo->exec("DELETE FROM logs");
    addLog($pdo, 'Clear Logs', 'Hapus semua log');
    echo json_encode(['ok'=>true]);
    break;

default:
    echo json_encode(['error'=>'Action tidak dikenal']);
}
