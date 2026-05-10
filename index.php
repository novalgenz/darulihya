<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIS Darul Ihya - Madrasah Ibtidaiyah Swasta</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #0a2a1a; color: #f5f0e8; }
        :root { --gold: #ffd700; --gold-dim: rgba(255,215,0,0.15); --border: rgba(255,215,0,0.2); --surface: rgba(20,40,28,0.75); }
        .container { max-width: 1200px; margin: auto; padding: 20px; }
        header { background: rgba(10,26,18,0.95); border-bottom: 1px solid var(--border); padding: 10px 20px; position: sticky; top:0; z-index:99; backdrop-filter: blur(8px); }
        .header-inner { display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: auto; flex-wrap: wrap; gap: 15px; }
        .logo { display: flex; align-items: center; gap: 12px; cursor: pointer; }
        .logo-icon { width: 45px; height: 45px; background: var(--gold-dim); border: 1px solid var(--gold); border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .logo-icon img { width: 100%; height: 100%; object-fit: cover; }
        .logo-text .name { color: var(--gold); font-weight: 700; font-size: 1.2rem; font-family: 'Amiri', serif; }
        .logo-text .sub { font-size: 0.7rem; color: #b0a890; }
        nav { display: flex; gap: 8px; flex-wrap: wrap; justify-content: center; }
        nav a { color: #b0a890; text-decoration: none; padding: 8px 16px; border-radius: 40px; font-size: 0.9rem; font-weight: 500; transition: 0.2s; }
        nav a.active, nav a:hover { background: var(--gold); color: #0a2a1a; }
        .search-box { position: relative; }
        .search-box input { padding: 8px 16px; border-radius: 40px; border: 1px solid var(--border); background: rgba(0,0,0,0.4); color: white; width: 200px; outline: none; }
        .search-box input:focus { border-color: var(--gold); }
        .search-box i { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--gold); }
        .menu-toggle { display: none; background: none; border: 1px solid var(--border); color: white; padding: 8px 12px; border-radius: 8px; cursor: pointer; }
        .page { display: none; animation: fadeIn 0.3s; }
        .page.active { display: block; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(10px);} to { opacity:1; transform:translateY(0);} }
        .card { background: var(--surface); backdrop-filter: blur(12px); border: 1px solid var(--border); border-radius: 20px; padding: 24px; margin-bottom: 24px; }
        .card h3 { color: var(--gold); font-size: 1.2rem; margin-bottom: 16px; border-left: 4px solid var(--gold); padding-left: 12px; }
        .hero-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
        .btn { background: var(--gold); color: #0a2a1a; padding: 10px 24px; border: none; border-radius: 40px; font-weight: 600; cursor: pointer; display: inline-block; }
        .slider-wrap { position: relative; border-radius: 20px; overflow: hidden; aspect-ratio: 16/9; }
        .slider-track { display: flex; transition: transform 0.5s; height: 100%; }
        .slide { min-width: 100%; height: 100%; }
        .slide img { width: 100%; height: 100%; object-fit: cover; }
        .slider-btn { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); border: none; width: 36px; height: 36px; border-radius: 50%; color: white; cursor: pointer; }
        .slider-prev { left: 12px; }
        .slider-next { right: 12px; }
        .slider-dots { position: absolute; bottom: 12px; left: 0; right: 0; display: flex; justify-content: center; gap: 8px; }
        .dot { width: 8px; height: 8px; background: rgba(255,255,255,0.5); border-radius: 50%; cursor: pointer; }
        .dot.active { background: var(--gold); width: 20px; border-radius: 4px; }
        .stats-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin: 20px 0; }
        .stat-item { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 16px; text-align: center; }
        .stat-num { font-size: 1.8rem; font-weight: 700; color: var(--gold); }
        .guru-grid, .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px,1fr)); gap: 20px; }
        .berita-sidebar { display: grid; grid-template-columns: 1fr 300px; gap: 30px; }
        .berita-list { display: flex; flex-direction: column; gap: 20px; }
        .berita-card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 20px; transition: 0.2s; }
        .berita-card h4 { color: var(--gold); margin-bottom: 8px; font-size: 1.1rem; }
        .berita-card small { color: #b0a890; font-size: 0.75rem; display: block; margin-bottom: 12px; }
        .berita-card p { font-size: 0.9rem; line-height: 1.5; }
        .berita-card .btn-sm { background: var(--gold-dim); color: var(--gold); padding: 6px 12px; border-radius: 30px; font-size: 0.7rem; display: inline-block; margin-top: 12px; cursor: pointer; }
        .kategori-list { background: var(--surface); border-radius: 16px; padding: 20px; position: sticky; top: 100px; }
        .kategori-list h4 { color: var(--gold); margin-bottom: 15px; }
        .kategori-list ul { list-style: none; }
        .kategori-list li { margin-bottom: 10px; }
        .kategori-list a { color: #b0a890; text-decoration: none; display: block; padding: 6px 12px; border-radius: 30px; transition: 0.2s; }
        .kategori-list a.active, .kategori-list a:hover { background: var(--gold); color: #0a2a1a; }
        .guru-card, .gallery-item { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 16px; text-align: center; transition: 0.2s; }
        .guru-img { width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 12px; overflow: hidden; }
        .guru-img img { width: 100%; height: 100%; object-fit: cover; }
        .gallery-item { padding: 0; cursor: pointer; overflow: hidden; aspect-ratio: 1/1; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: 0.2s; }
        .gallery-item:hover img { transform: scale(1.05); }
        .jadwal-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .jadwal-table th, .jadwal-table td { border: 1px solid var(--border); padding: 10px; text-align: center; }
        .jadwal-table th { background: rgba(255,215,0,0.15); color: var(--gold); }
        .kontak-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .kontak-item { display: flex; align-items: center; gap: 16px; background: var(--surface); border-radius: 16px; padding: 16px; }
        .ppdb-form { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group label { color: var(--gold); font-size: 0.8rem; }
        .form-group input, .form-group select, .form-group textarea { padding: 10px; border-radius: 10px; border: 1px solid var(--border); background: rgba(0,0,0,0.3); color: white; }
        .wa-float { position: fixed; bottom: 20px; right: 20px; background: #25D366; width: 52px; height: 52px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; color: white; cursor: pointer; z-index: 99; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
        footer { text-align: center; padding: 20px; color: #8a9e90; font-size: 12px; border-top: 1px solid var(--border); margin-top: 20px; }
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.9); z-index: 1000; align-items: center; justify-content: center; }
        .modal.open { display: flex; }
        .modal-img { max-width: 90%; max-height: 90%; border-radius: 12px; }
        .rich-text ul, .rich-text ol { padding-left: 20px; margin: 8px 0; }
        .rich-text li { margin: 4px 0; }
        .pagination { display: flex; justify-content: center; gap: 10px; margin-top: 20px; }
        .pagination button { background: var(--gold-dim); border: none; padding: 8px 16px; border-radius: 30px; color: white; cursor: pointer; }
        @media (max-width: 768px) {
            .header-inner { flex-direction: column; align-items: stretch; }
            .menu-toggle { display: block; align-self: flex-end; }
            nav { display: none; flex-direction: column; background: #0a2a1a; padding: 10px; border-radius: 12px; margin-top: 10px; }
            nav.open { display: flex; }
            .search-box { align-self: center; width: 100%; }
            .search-box input { width: 100%; }
            .hero-grid { grid-template-columns: 1fr; }
            .stats-row { grid-template-columns: repeat(2,1fr); }
            .berita-sidebar { grid-template-columns: 1fr; }
            .ppdb-form { grid-template-columns: 1fr; }
            .kontak-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<header>
    <div class="header-inner">
        <div class="logo" id="logoArea">
            <div class="logo-icon" id="logoIcon">🕌</div>
            <div class="logo-text">
                <div class="name" id="siteTitle">MIS DARUL IHYA</div>
                <div class="sub" id="siteTagline">Akreditasi A</div>
            </div>
        </div>
        <button class="menu-toggle" id="menuToggle">☰</button>
        <nav id="navMenu">
            <a data-page="beranda" class="active">Beranda</a>
            <a data-page="profil">Profil</a>
            <a data-page="guru">Guru</a>
            <a data-page="galeri">Galeri</a>
            <a data-page="berita">Berita</a>
            <a data-page="jadwal">Jadwal</a>
            <a data-page="kontak">Kontak</a>
            <a data-page="ppdb">PPDB</a>
        </nav>
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Cari berita...">
            <i class="fas fa-search"></i>
        </div>
    </div>
</header>

<main class="container">
    <!-- Beranda -->
    <div id="beranda" class="page active">
        <div class="hero"><div class="hero-grid">
            <div><h1 id="heroTitle">MIS DARUL IHYA</h1><p id="heroTagline"></p><button class="btn" data-page="ppdb">Daftar Sekarang</button></div>
            <div class="slider-wrap"><div class="slider-track" id="sliderTrack"></div><button class="slider-btn slider-prev" id="prevBtn">❮</button><button class="slider-btn slider-next" id="nextBtn">❯</button><div class="slider-dots" id="sliderDots"></div></div>
        </div></div>
        <div class="stats-row"><div class="stat-item"><div class="stat-num" id="statGuru">0</div><div>Tenaga Pendidik</div></div><div class="stat-item"><div class="stat-num">A</div><div>Akreditasi</div></div><div class="stat-item"><div class="stat-num">6</div><div>Ruang Kelas</div></div><div class="stat-item"><div class="stat-num" id="visitorCount">0</div><div>Pengunjung</div></div></div>
        <div class="card"><h3>Tentang Kami</h3><div id="tentangText" class="rich-text"></div></div>
        <div class="card"><h3>Informasi Biaya</h3><div id="biayaContainer" style="text-align:center;"></div></div>
        <div class="card"><h3>Berita Terbaru</h3><div class="berita-list" id="beritaRingkasan"></div><div style="text-align:center; margin-top:10px;"><button class="btn btn-sm" data-page="berita">Lihat Semua Berita</button></div></div>
        <div class="counter">Total pengunjung: <span id="visitorCountFooter">0</span></div>
    </div>

    <!-- Profil -->
    <div id="profil" class="page">
        <div class="card"><h3>Sejarah</h3><div id="sejarahText" class="rich-text"></div></div>
        <div class="card"><h3>Visi</h3><div id="visiText" class="rich-text"></div></div>
        <div class="card"><h3>Misi</h3><div id="misiList" class="rich-text"></div></div>
        <div class="card"><h3>Tujuan</h3><div id="tujuanList" class="rich-text"></div></div>
        <div class="card"><h3>Fasilitas</h3><div id="fasilitasText" class="rich-text"></div></div>
        <div class="card"><h3>Tenaga Pendidik</h3><div id="tenagaPendidikText" class="rich-text"></div></div>
        <div class="card"><h3>Penutup</h3><div id="penutupText" class="rich-text"></div></div>
    </div>

    <!-- Guru -->
    <div id="guru" class="page">
        <div class="card"><h3>Kepala Madrasah</h3><div id="kepsekBox"></div></div>
        <div class="card"><h3>Tenaga Pendidik</h3><div class="guru-grid" id="guruGrid"></div></div>
    </div>

    <!-- Galeri -->
    <div id="galeri" class="page">
        <div class="card"><h3>Galeri Kegiatan</h3><div class="gallery-grid" id="galleryGrid"></div></div>
    </div>

    <!-- Halaman Berita -->
    <div id="berita" class="page">
        <div class="berita-sidebar">
            <div class="berita-list" id="beritaListFull"></div>
            <div class="kategori-list">
                <h4>Kategori</h4>
                <ul>
                    <li><a href="#" data-kategori="semua" class="kategori-link active">Semua</a></li>
                    <li><a href="#" data-kategori="Berita" class="kategori-link">📰 Berita</a></li>
                    <li><a href="#" data-kategori="Pengumuman" class="kategori-link">📢 Pengumuman</a></li>
                    <li><a href="#" data-kategori="Kegiatan" class="kategori-link">🎉 Kegiatan</a></li>
                    <li><a href="#" data-kategori="Prestasi" class="kategori-link">🏆 Prestasi</a></li>
                    <li><a href="#" data-kategori="Informasi" class="kategori-link">ℹ️ Informasi</a></li>
                </ul>
            </div>
        </div>
        <div class="pagination" id="paginationBerita"></div>
    </div>

    <!-- Jadwal -->
    <div id="jadwal" class="page">
        <div class="card"><h3>Jadwal Kelas 1-2</h3>
            <table class="jadwal-table"><thead><tr><th>Hari</th><th>Mata Pelajaran</th><th>Jam</th></tr></thead><tbody id="jadwal12Body"></tbody></table>
        </div>
        <div class="card"><h3>Jadwal Kelas 3-6</h3>
            <table class="jadwal-table"><thead><tr><th>Hari</th><th>Mata Pelajaran</th><th>Jam</th></tr></thead><tbody id="jadwal36Body"></tbody></table>
        </div>
    </div>

    <!-- Kontak -->
    <div id="kontak" class="page">
        <div class="kontak-grid">
            <div class="kontak-item"><i class="fas fa-map-marker-alt"></i><div><div class="kontak-label">Alamat</div><div id="kontakAlamat"></div></div></div>
            <div class="kontak-item"><i class="fas fa-phone"></i><div><div class="kontak-label">Telepon</div><div id="kontakTelp"></div></div></div>
            <div class="kontak-item"><i class="fas fa-envelope"></i><div><div class="kontak-label">Email</div><div id="kontakEmail"></div></div></div>
        </div>
        <div id="mapsContainer" style="margin-top:20px; border-radius:16px; overflow:hidden;"></div>
    </div>

    <!-- PPDB -->
    <div id="ppdb" class="page">
        <div class="card"><h3>Formulir Pendaftaran PPDB</h3>
            <form id="ppdbForm">
                <div class="ppdb-form">
                    <div class="form-group"><label>Nama Lengkap *</label><input type="text" id="f_nama" required></div>
                    <div class="form-group"><label>Jenis Kelamin</label><select id="f_jk"><option>Laki-laki</option><option>Perempuan</option></select></div>
                    <div class="form-group"><label>Tempat Lahir</label><input id="f_tempat"></div>
                    <div class="form-group"><label>Tanggal Lahir</label><input type="date" id="f_tgl"></div>
                    <div class="form-group"><label>Alamat</label><textarea id="f_alamat" rows="2"></textarea></div>
                    <div class="form-group"><label>Upload Ijazah / Rapor (max 2MB)</label><input type="file" id="f_ijazah" accept=".jpg,.png,.pdf"></div>
                    <div class="form-group"><label>Upload Akte / KK (max 2MB)</label><input type="file" id="f_akte" accept=".jpg,.png,.pdf"></div>
                    <div class="form-group"><label>No. HP Orang Tua</label><input type="tel" id="f_hp"></div>
                    <div class="form-group"><label>Jalur Pendaftaran</label><select id="f_jalur"><option>Reguler</option><option>Prestasi</option><option>Afirmasi</option></select></div>
                </div>
                <button type="submit" class="btn">Kirim Pendaftaran</button>
            </form>
            <div id="ppdbMsg" style="margin-top:15px;"></div>
        </div>
    </div>
</main>

<div id="imageModal" class="modal" onclick="closeModal()"><img id="modalImage" class="modal-img"><span style="position:absolute;top:20px;right:30px;font-size:30px;cursor:pointer;">&times;</span></div>
<div class="wa-float" id="waBtn"><i class="fab fa-whatsapp"></i></div>
<footer>© 2026 MIS Darul Ihya | NPSN: 60706770</footer>

<script>
/**
 * APP STATE & CONFIG
 */
let DATA = null;
let currentKategori = 'semua';
let currentPage = 1;
const itemsPerPage = 6;

/**
 * CORE DATA LOADING
 */
async function loadData() {
    try {
        const res = await fetch('api.php?action=get_public');
        DATA = await res.json();
        renderAll();
    } catch (e) {
        console.error('Gagal load data:', e);
    }
}

async function loadVisitor() {
    try {
        const res = await fetch('api.php?action=visitor');
        const json = await res.json();
        const count = json.count || 0;
        document.getElementById('visitorCount').innerText = count;
        document.getElementById('visitorCountFooter').innerText = count;
    } catch (e) {
        console.error('Visitor counter error');
    }
}

/**
 * UTILITIES
 */
function escapeHtml(str) {
    return String(str || '').replace(/[&<>]/g, m => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;'
    }[m]));
}

/**
 * RENDERING FUNCTIONS
 */
function renderAll() {
    if (!DATA) return;
    const s = DATA.site;

    // 1. Header & Identity
    document.getElementById('siteTitle').innerText = s.title;
    document.getElementById('siteTagline').innerText = s.tagline;
    document.getElementById('heroTitle').innerHTML = s.title.replace(' ', '<br>');
    document.getElementById('heroTagline').innerText = s.heroTagline;

    if (DATA.logo) {
        document.getElementById('logoIcon').innerHTML = `<img src="${DATA.logo}" style="width:100%;height:100%;object-fit:cover;">`;
    } else {
        document.getElementById('logoIcon').innerHTML = '🕌';
    }

    // 2. Profil Content
    const profileSections = {
        'tentangText': s.tentang,
        'sejarahText': s.sejarah,
        'visiText': s.visi,
        'misiList': s.misi,
        'tujuanList': s.tujuan,
        'fasilitasText': s.fasilitas,
        'tenagaPendidikText': s.tenagaPendidik,
        'penutupText': s.penutup
    };
    
    for (const [id, content] of Object.entries(profileSections)) {
        const el = document.getElementById(id);
        if (el) el.innerHTML = content || '';
    }

    // 3. Kontak
    document.getElementById('kontakAlamat').innerText = s.kontak.alamat;
    document.getElementById('kontakTelp').innerText = s.kontak.telp;
    document.getElementById('kontakEmail').innerText = s.kontak.email;
    document.getElementById('mapsContainer').innerHTML = s.kontak.maps || '';
    document.getElementById('statGuru').innerText = DATA.guru.length;

    // 4. Kepsek & Guru
    renderKepsek(s.kepsek);
    renderGuru(DATA.guru);

    // 5. Slider & Gallery
    renderSlider(DATA.slider);
    renderGallery(DATA.galeri);

    // 6. Jadwal & Biaya
    renderJadwal(DATA.jadwal12, DATA.jadwal36);
    renderBiaya(DATA.biayaGambar);

    // 7. Berita
    renderBeritaRingkasan();
    if (document.getElementById('berita').classList.contains('active')) {
        renderBeritaFull();
    }

    // 8. WhatsApp Button
    document.getElementById('waBtn').onclick = () => {
        const url = `https://wa.me/${s.waNumber}?text=${encodeURIComponent(s.waMessage)}`;
        window.open(url, '_blank');
    };
}

function renderKepsek(kepsek) {
    const foto = kepsek.foto || 'https://placehold.co/100';
    document.getElementById('kepsekBox').innerHTML = `
        <div class="guru-card">
            <div class="guru-img"><img src="${foto}" onerror="this.src='https://placehold.co/100'"></div>
            <div class="guru-name">${escapeHtml(kepsek.nama)}</div>
            <div class="guru-role">Kepala Madrasah</div>
            <div class="guru-motto">"${escapeHtml(kepsek.motto)}"</div>
        </div>`;
}

function renderGuru(guru) {
    const html = guru.map(g => `
        <div class="guru-card">
            <div class="guru-img"><img src="${g.foto || 'https://placehold.co/80'}" onerror="this.src='https://placehold.co/80'"></div>
            <div class="guru-name">${escapeHtml(g.nama)}</div>
            <div class="guru-role">${escapeHtml(g.jabatan || 'Guru')}</div>
        </div>
    `).join('');
    document.getElementById('guruGrid').innerHTML = html || '<p>Belum ada data guru</p>';
}

function renderSlider(slides) {
    const track = document.getElementById('sliderTrack');
    if (!slides || slides.length === 0) {
        track.innerHTML = `<div class="slide"><img src="https://placehold.co/800x500/1a472a/ffd700?text=MIS+Darul+Ihya"></div>`;
        initSliderControls(1);
    } else {
        track.innerHTML = slides.map(s => `<div class="slide"><img src="${s}"></div>`).join('');
        initSliderControls(slides.length);
    }
}

function renderGallery(images) {
    const html = images.map(img => `
        <div class="gallery-item" onclick="openModal('${img}')">
            <img src="${img}" loading="lazy">
        </div>
    `).join('');
    document.getElementById('galleryGrid').innerHTML = html || '<p>Belum ada foto galeri</p>';
}

function renderJadwal(j12, j36) {
    document.getElementById('jadwal12Body').innerHTML = j12.map(row => 
        `<tr>${row.map(c => `<td>${escapeHtml(c)}</td>`).join('')}</tr>`
    ).join('');
    
    document.getElementById('jadwal36Body').innerHTML = j36.map(row => 
        `<tr>${row.map(c => `<td>${escapeHtml(c)}</td>`).join('')}</tr>`
    ).join('');
}

function renderBiaya(gambar) {
    const container = document.getElementById('biayaContainer');
    if (gambar) {
        container.innerHTML = `
            <img src="${gambar}" style="max-width:100%;max-height:300px;border-radius:16px;border:2px solid var(--gold);cursor:pointer;" onclick="openModal('${gambar}')">
            <p style="font-size:12px;color:gray;margin-top:8px;">Klik untuk memperbesar</p>`;
    } else {
        container.innerHTML = `
            <div style="padding:30px;background:var(--gold-dim);border-radius:16px;">
                <i class="fas fa-image" style="font-size:48px;opacity:0.5;"></i>
                <p>Informasi biaya akan segera diupdate</p>
            </div>`;
    }
}

function renderBeritaRingkasan() {
    const arr = DATA.berita || [];
    const terbaru = [...arr].slice(0, 3);
    const html = terbaru.map(b => `
        <div class="berita-card">
            <h4>${escapeHtml(b.judul)}</h4>
            <small>${escapeHtml(b.tanggal)} · ${escapeHtml(b.kategori)}</small>
            <p>${escapeHtml((b.isi || '').substring(0, 100))}...</p>
            <div class="btn-sm" onclick="document.querySelector('[data-page=berita]').click()">Baca Selengkapnya</div>
        </div>
    `).join('');
    document.getElementById('beritaRingkasan').innerHTML = html || '<p>Belum ada berita.</p>';
}

function renderBeritaFull() {
    const arr = DATA.berita || [];
    const filtered = currentKategori === 'semua' ? arr : arr.filter(b => b.kategori === currentKategori);
    const totalPages = Math.ceil(filtered.length / itemsPerPage);
    const start = (currentPage - 1) * itemsPerPage;
    const paginated = filtered.slice(start, start + itemsPerPage);

    const html = paginated.map(b => `
        <div class="berita-card">
            <h4>${escapeHtml(b.judul)}</h4>
            <small>${escapeHtml(b.tanggal)} · ${escapeHtml(b.kategori)}</small>
            <p>${escapeHtml((b.isi || '').substring(0, 200))}...</p>
            <div class="btn-sm" onclick="alert('${escapeHtml(b.judul)}')">Baca Selengkapnya</div>
        </div>
    `).join('');
    
    document.getElementById('beritaListFull').innerHTML = html || '<p>Tidak ada berita dalam kategori ini.</p>';
    renderPagination(totalPages);
}

function renderPagination(totalPages) {
    let pagHtml = '';
    for (let i = 1; i <= totalPages; i++) {
        pagHtml += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="goToNewsPage(${i})">${i}</button>`;
    }
    document.getElementById('paginationBerita').innerHTML = pagHtml;
}

function goToNewsPage(n) {
    currentPage = n;
    renderBeritaFull();
    window.scrollTo({ top: document.getElementById('berita').offsetTop - 100, behavior: 'smooth' });
}

/**
 * SLIDER CONTROLS
 */
let sliderIndex = 0, sliderInterval;

function initSliderControls(total) {
    if (sliderInterval) clearInterval(sliderInterval);
    sliderIndex = 0;
    
    const dots = document.getElementById('sliderDots');
    if (dots && total > 0) {
        dots.innerHTML = Array.from({ length: total }, (_, i) => 
            `<div class="dot ${i === 0 ? 'active' : ''}" onclick="goSlide(${i})"></div>`
        ).join('');
    }

    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    if (total <= 1) {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
        return;
    }

    prevBtn.style.display = 'flex';
    nextBtn.style.display = 'flex';

    const restartInterval = () => {
        clearInterval(sliderInterval);
        sliderInterval = setInterval(() => goSlide((sliderIndex + 1) % total), 5000);
    };

    restartInterval();
    prevBtn.onclick = () => { goSlide((sliderIndex - 1 + total) % total); restartInterval(); };
    nextBtn.onclick = () => { goSlide((sliderIndex + 1) % total); restartInterval(); };
}

function goSlide(n) {
    sliderIndex = n;
    const track = document.getElementById('sliderTrack');
    if (track) track.style.transform = `translateX(-${n * 100}%)`;
    document.querySelectorAll('.dot').forEach((d, i) => d.classList.toggle('active', i === n));
}

/**
 * MODAL & UI HELPERS
 */
function openModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.add('open');
}

function closeModal() {
    document.getElementById('imageModal').classList.remove('open');
}

/**
 * NAVIGATION & EVENTS
 */
document.querySelectorAll('[data-page]').forEach(el => {
    el.addEventListener('click', e => {
        e.preventDefault();
        const page = el.dataset.page;
        
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        document.getElementById(page).classList.add('active');
        
        document.querySelectorAll('nav a').forEach(a => a.classList.remove('active'));
        if (el.tagName === 'A') el.classList.add('active');
        
        document.getElementById('navMenu').classList.remove('open');
        window.scrollTo(0, 0);
        
        if (page === 'berita') {
            currentPage = 1;
            if (DATA) renderBeritaFull();
        }
    });
});

document.getElementById('menuToggle').onclick = () => {
    document.getElementById('navMenu').classList.toggle('open');
};

document.addEventListener('click', e => {
    if (e.target.classList.contains('kategori-link')) {
        e.preventDefault();
        currentKategori = e.target.dataset.kategori;
        currentPage = 1;
        document.querySelectorAll('.kategori-link').forEach(l => l.classList.remove('active'));
        e.target.classList.add('active');
        renderBeritaFull();
    }
});

document.getElementById('searchInput').addEventListener('keypress', e => {
    if (e.key === 'Enter') {
        document.querySelector('[data-page="berita"]').click();
        e.target.value = '';
    }
});

/**
 * FORM HANDLING
 */
document.getElementById('ppdbForm').addEventListener('submit', async e => {
    e.preventDefault();
    
    const nama = document.getElementById('f_nama').value.trim();
    if (!nama) return alert('Nama wajib diisi');

    const fileIjazah = document.getElementById('f_ijazah').files[0];
    const fileAkte = document.getElementById('f_akte').files[0];

    if (!fileIjazah || !fileAkte) return alert('Harap upload Ijazah dan Akte/KK');
    if (fileIjazah.size > 2 * 1024 * 1024 || fileAkte.size > 2 * 1024 * 1024) {
        return alert('Ukuran file maksimal 2MB');
    }

    const toBase64 = file => new Promise(res => {
        const r = new FileReader();
        r.onload = () => res(r.result);
        r.readAsDataURL(file);
    });

    const payload = {
        nama,
        jk: document.getElementById('f_jk').value,
        tempat: document.getElementById('f_tempat').value,
        tgl: document.getElementById('f_tgl').value,
        alamat: document.getElementById('f_alamat').value,
        hp: document.getElementById('f_hp').value,
        jalur: document.getElementById('f_jalur').value,
        ijazah: await toBase64(fileIjazah),
        akte: await toBase64(fileAkte),
        tanggal_daftar: new Date().toLocaleDateString('id-ID')
    };

    try {
        const res = await fetch('api.php?action=add_ppdb', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        const json = await res.json();
        
        if (json.ok) {
            const msgEl = document.getElementById('ppdbMsg');
            msgEl.innerHTML = '<p style="color:var(--gold); font-weight:bold;">✅ Pendaftaran berhasil! Data Anda telah tersimpan.</p>';
            document.getElementById('ppdbForm').reset();
            setTimeout(() => msgEl.innerHTML = '', 5000);
        } else {
            alert('Gagal: ' + (json.error || 'Terjadi kesalahan sistem'));
        }
    } catch (err) {
        alert('Gagal mengirim data. Periksa koneksi internet Anda.');
    }
});

/**
 * INITIALIZATION
 */
document.addEventListener('DOMContentLoaded', () => {
    loadData();
    loadVisitor();
});
</script>

</body>
</html>
