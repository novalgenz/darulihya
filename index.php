<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MIS Darul Ihya</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{--gold:#ffd700;--gold2:#ffed80;--gold-dim:rgba(255,215,0,0.12);--border:rgba(255,215,0,0.18);--surface:rgba(12,30,18,0.82);--green:#0a2a1a;--green2:#0f3d24;--text:#f0ede6;--muted:#8fa99a}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--green);color:var(--text);overflow-x:hidden}

/* ---- HEADER ---- */
header{background:rgba(8,20,12,0.96);border-bottom:1px solid var(--border);padding:10px 20px;position:sticky;top:0;z-index:200;backdrop-filter:blur(10px)}
.header-inner{display:flex;justify-content:space-between;align-items:center;max-width:1200px;margin:auto;gap:12px}
.logo{display:flex;align-items:center;gap:10px;cursor:pointer;flex-shrink:0}
.logo-icon{width:44px;height:44px;background:var(--gold-dim);border:1px solid var(--gold);border-radius:12px;display:flex;align-items:center;justify-content:center;overflow:hidden;font-size:22px}
.logo-icon img{width:100%;height:100%;object-fit:cover}
.logo-name{color:var(--gold);font-weight:700;font-size:1.1rem;font-family:'Amiri',serif;letter-spacing:.5px}
.logo-sub{font-size:.65rem;color:var(--muted)}
nav{display:flex;gap:4px;flex-wrap:wrap;justify-content:center}
nav a{color:var(--muted);text-decoration:none;padding:7px 13px;border-radius:30px;font-size:.82rem;font-weight:500;transition:.2s;white-space:nowrap}
nav a.active,nav a:hover{background:var(--gold);color:var(--green)}
.menu-btn{display:none;background:none;border:1px solid var(--border);color:white;padding:7px 11px;border-radius:8px;cursor:pointer;font-size:16px}
.search-wrap{position:relative}
.search-wrap input{padding:7px 36px 7px 14px;border-radius:30px;border:1px solid var(--border);background:rgba(0,0,0,0.35);color:white;width:180px;outline:none;font-size:.82rem}
.search-wrap input:focus{border-color:var(--gold)}
.search-wrap i{position:absolute;right:11px;top:50%;transform:translateY(-50%);color:var(--gold);font-size:.8rem}

/* ---- PAGES ---- */
.page{display:none;animation:fadeUp .35s ease}
.page.active{display:block}
@keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
.container{max-width:1200px;margin:auto;padding:28px 20px}

/* ---- HERO ---- */
.hero{min-height:100vh;position:relative;display:flex;flex-direction:column;justify-content:center;overflow:hidden}
.hero-bg{position:absolute;inset:0;background:linear-gradient(135deg,#030e07 0%,#071a0d 40%,#0a2a1a 100%);z-index:0}
.hero-bg-img{position:absolute;inset:0;background-size:cover;background-position:center;opacity:.25;z-index:1}
.hero-pattern{position:absolute;inset:0;z-index:2;opacity:.04;background-image:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffd700' fill-rule='evenodd'%3E%3Cpath d='M30 0l8 15H22zm0 60l8-15H22zM0 30l15-8v16zm60 0l-15-8v16z'/%3E%3C/g%3E%3C/svg%3E")}
.hero-content{position:relative;z-index:3;max-width:1200px;margin:auto;padding:0 20px;display:grid;grid-template-columns:1fr 1fr;gap:50px;align-items:center;width:100%}
.hero-badge{display:inline-flex;align-items:center;gap:8px;background:var(--gold-dim);border:1px solid var(--border);padding:6px 14px;border-radius:30px;font-size:.75rem;color:var(--gold);margin-bottom:18px}
.hero-title{font-family:'Amiri',serif;font-size:clamp(2rem,5vw,3.4rem);font-weight:700;line-height:1.15;margin-bottom:14px}
.hero-title span{color:var(--gold)}
.hero-tagline{color:var(--muted);font-size:1rem;line-height:1.6;margin-bottom:28px;max-width:420px}
.hero-btns{display:flex;gap:12px;flex-wrap:wrap}
.btn-primary{background:var(--gold);color:var(--green);padding:12px 26px;border:none;border-radius:30px;font-weight:700;cursor:pointer;font-size:.9rem;transition:.2s;display:inline-flex;align-items:center;gap:8px}
.btn-primary:hover{background:var(--gold2);transform:translateY(-2px)}
.btn-outline{background:transparent;color:var(--gold);padding:12px 26px;border:1px solid var(--gold);border-radius:30px;font-weight:600;cursor:pointer;font-size:.9rem;transition:.2s}
.btn-outline:hover{background:var(--gold-dim)}
.hero-slider{border-radius:20px;overflow:hidden;aspect-ratio:16/9;box-shadow:0 20px 60px rgba(0,0,0,.5);position:relative}
.slider-track{display:flex;transition:transform .5s ease;height:100%}
.slide{min-width:100%;height:100%;background:#0f3d24}
.slide img{width:100%;height:100%;object-fit:cover}
.sl-btn{position:absolute;top:50%;transform:translateY(-50%);background:rgba(0,0,0,.5);border:none;width:34px;height:34px;border-radius:50%;color:white;cursor:pointer;z-index:2;transition:.2s}
.sl-btn:hover{background:rgba(255,215,0,.7);color:#0a2a1a}
.sl-prev{left:10px}.sl-next{right:10px}
.sl-dots{position:absolute;bottom:10px;left:0;right:0;display:flex;justify-content:center;gap:6px}
.dot{width:7px;height:7px;background:rgba(255,255,255,.4);border-radius:50%;cursor:pointer;transition:.3s}
.dot.active{background:var(--gold);width:18px;border-radius:4px}
.hero-stats{position:relative;z-index:3;background:rgba(0,0,0,.35);backdrop-filter:blur(12px);border-top:1px solid var(--border);margin-top:0;padding:18px 20px}
.hero-stats-inner{max-width:1200px;margin:auto;display:grid;grid-template-columns:repeat(4,1fr);gap:10px}
.stat-item{text-align:center;padding:10px}
.stat-num{font-size:1.6rem;font-weight:800;color:var(--gold);font-family:'Amiri',serif}
.stat-label{font-size:.72rem;color:var(--muted)}

/* ---- CARD ---- */
.card{background:var(--surface);backdrop-filter:blur(12px);border:1px solid var(--border);border-radius:18px;padding:24px;margin-bottom:22px}
.card-title{color:var(--gold);font-size:1.1rem;font-weight:700;margin-bottom:16px;display:flex;align-items:center;gap:10px}
.card-title::before{content:'';width:4px;height:18px;background:var(--gold);border-radius:4px;flex-shrink:0}
.section-heading{text-align:center;margin-bottom:30px}
.section-heading h2{font-family:'Amiri',serif;font-size:2rem;color:var(--gold)}
.section-heading p{color:var(--muted);font-size:.9rem;margin-top:6px}

/* ---- BERITA ---- */
.berita-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:22px}
.berita-card{background:var(--surface);border:1px solid var(--border);border-radius:16px;overflow:hidden;cursor:pointer;transition:.2s}
.berita-card:hover{transform:translateY(-4px);border-color:rgba(255,215,0,.4)}
.berita-thumb{width:100%;height:180px;object-fit:cover;background:#0f3d24;display:flex;align-items:center;justify-content:center;color:var(--muted)}
.berita-thumb img{width:100%;height:100%;object-fit:cover}
.berita-body{padding:16px}
.berita-badge{display:inline-block;background:var(--gold-dim);color:var(--gold);padding:3px 10px;border-radius:20px;font-size:.68rem;font-weight:600;margin-bottom:8px}
.berita-card h4{font-size:1rem;font-weight:700;line-height:1.4;margin-bottom:8px}
.berita-card small{color:var(--muted);font-size:.72rem}
.berita-card p{font-size:.82rem;color:var(--muted);margin-top:8px;line-height:1.5}
.berita-sidebar{display:grid;grid-template-columns:1fr 260px;gap:24px}
.kategori-box{background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:18px;position:sticky;top:90px}
.kategori-box h4{color:var(--gold);margin-bottom:14px;font-size:.9rem}
.kat-link{display:block;padding:7px 12px;border-radius:30px;color:var(--muted);text-decoration:none;font-size:.82rem;transition:.2s;cursor:pointer;margin-bottom:4px}
.kat-link.active,.kat-link:hover{background:var(--gold);color:var(--green)}

/* ---- GALERI ---- */
.gallery-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:14px}
.gallery-item{border-radius:12px;overflow:hidden;cursor:pointer;position:relative;aspect-ratio:1;background:#0f3d24}
.gallery-item img{width:100%;height:100%;object-fit:cover;transition:.3s}
.gallery-item:hover img{transform:scale(1.06)}
.gallery-caption{position:absolute;bottom:0;left:0;right:0;background:linear-gradient(transparent,rgba(0,0,0,.8));padding:10px 10px 10px;color:white;font-size:.75rem;transform:translateY(100%);transition:.3s}
.gallery-item:hover .gallery-caption{transform:translateY(0)}

/* ---- GURU ---- */
.guru-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:18px}
.guru-card{background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:20px;text-align:center;transition:.2s}
.guru-card:hover{border-color:rgba(255,215,0,.4);transform:translateY(-3px)}
.guru-avatar{width:90px;height:90px;border-radius:50%;margin:0 auto 12px;overflow:hidden;border:2px solid var(--gold);background:#0f3d24;display:flex;align-items:center;justify-content:center;font-size:28px}
.guru-avatar img{width:100%;height:100%;object-fit:cover}
.guru-name{font-weight:700;font-size:.9rem;margin-bottom:4px}
.guru-role{color:var(--gold);font-size:.72rem}
.kepsek-card{display:flex;align-items:center;gap:20px;background:rgba(255,215,0,.06);border:1px solid var(--gold);border-radius:16px;padding:20px;margin-bottom:24px}
.kepsek-avatar{width:80px;height:80px;border-radius:50%;overflow:hidden;border:2px solid var(--gold);flex-shrink:0}
.kepsek-avatar img{width:100%;height:100%;object-fit:cover}
.kepsek-motto{font-style:italic;color:var(--muted);font-size:.82rem;margin-top:4px}

/* ---- ESKUL ---- */
.eskul-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:18px}
.eskul-card{background:var(--surface);border:1px solid var(--border);border-radius:16px;overflow:hidden;transition:.2s}
.eskul-card:hover{border-color:rgba(255,215,0,.4);transform:translateY(-3px)}
.eskul-img{height:130px;background:linear-gradient(135deg,#0f3d24,#1a5c38);display:flex;align-items:center;justify-content:center;font-size:40px;overflow:hidden}
.eskul-img img{width:100%;height:100%;object-fit:cover}
.eskul-body{padding:14px}
.eskul-name{font-weight:700;font-size:.95rem;color:var(--gold);margin-bottom:6px}
.eskul-desc{font-size:.78rem;color:var(--muted);line-height:1.5}

/* ---- JADWAL ---- */
.jadwal-table{width:100%;border-collapse:collapse}
.jadwal-table th,.jadwal-table td{border:1px solid var(--border);padding:10px 14px;text-align:left}
.jadwal-table th{background:var(--gold-dim);color:var(--gold);font-size:.82rem}
.jadwal-table td{font-size:.85rem}

/* ---- KONTAK ---- */
.kontak-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;margin-bottom:22px}
.kontak-item{background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:18px;display:flex;align-items:flex-start;gap:14px}
.kontak-icon{width:38px;height:38px;background:var(--gold-dim);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--gold);flex-shrink:0}
.kontak-label{font-size:.7rem;color:var(--muted);margin-bottom:3px}
.kontak-val{font-size:.9rem}

/* ---- PPDB ---- */
.ppdb-form{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.form-group{display:flex;flex-direction:column;gap:5px}
.form-group label{color:var(--gold);font-size:.75rem;font-weight:600}
.form-group input,.form-group select,.form-group textarea{padding:10px 13px;border-radius:10px;border:1px solid var(--border);background:rgba(0,0,0,.3);color:white;font-size:.88rem;outline:none;font-family:inherit}
.form-group input:focus,.form-group select,.form-group textarea:focus{border-color:var(--gold)}
.form-group select option{background:#0a2a1a}

/* ---- BIAYA PLACEHOLDER ---- */
.biaya-placeholder{text-align:center;padding:40px;background:var(--gold-dim);border:2px dashed var(--border);border-radius:16px}
.biaya-placeholder i{font-size:48px;color:var(--muted);margin-bottom:12px}

/* ---- WA FLOAT ---- */
.wa-float{position:fixed;bottom:22px;right:22px;background:#25D366;width:54px;height:54px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:28px;color:white;cursor:pointer;z-index:99;box-shadow:0 4px 15px rgba(37,211,102,.4);transition:.2s}
.wa-float:hover{transform:scale(1.1)}

/* ---- MODAL BERITA ---- */
.modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.88);z-index:300;align-items:center;justify-content:center;padding:20px}
.modal.open{display:flex}
.modal-berita{background:#0d2016;border:1px solid var(--border);border-radius:20px;max-width:720px;width:100%;max-height:90vh;overflow-y:auto}
.modal-berita-header{padding:20px 24px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:flex-start;gap:12px}
.modal-berita-header h2{font-size:1.2rem;line-height:1.4;flex:1}
.modal-close{background:none;border:none;color:var(--muted);font-size:22px;cursor:pointer;padding:0;line-height:1;flex-shrink:0}
.modal-close:hover{color:white}
.modal-berita-foto{width:100%;max-height:320px;object-fit:cover}
.modal-berita-meta{padding:14px 24px;display:flex;gap:10px;align-items:center;border-bottom:1px solid var(--border)}
.modal-berita-body{padding:20px 24px;font-size:.9rem;line-height:1.8;white-space:pre-wrap}

/* ---- MODAL GALERI ---- */
.modal-img-wrap{max-width:90vw;max-height:90vh;position:relative}
.modal-img-wrap img{max-width:100%;max-height:85vh;border-radius:12px;display:block}
.modal-img-caption{text-align:center;color:var(--muted);margin-top:10px;font-size:.85rem}

/* ---- RICH TEXT ---- */
.rich-text ul,.rich-text ol{padding-left:22px;margin:8px 0}
.rich-text li{margin:5px 0;line-height:1.6}
.rich-text p{margin-bottom:10px;line-height:1.7}

/* ---- FOOTER ---- */
footer{text-align:center;padding:24px 20px;color:var(--muted);font-size:.78rem;border-top:1px solid var(--border);margin-top:20px}

/* ---- PAGINATION ---- */
.pagination{display:flex;justify-content:center;gap:8px;margin-top:20px}
.pg-btn{background:var(--gold-dim);border:1px solid var(--border);padding:7px 14px;border-radius:30px;color:var(--text);cursor:pointer;font-size:.8rem;transition:.2s}
.pg-btn.active,.pg-btn:hover{background:var(--gold);color:var(--green);border-color:var(--gold)}

/* ---- RESPONSIVE ---- */
@media(max-width:900px){
.hero-content{grid-template-columns:1fr;text-align:center}
.hero-slider{display:none}
.hero-stats-inner{grid-template-columns:repeat(2,1fr)}
.berita-sidebar{grid-template-columns:1fr}
.kategori-box{position:static}
}
@media(max-width:768px){
.header-inner{flex-wrap:wrap}
.menu-btn{display:block}
nav{display:none;width:100%;flex-direction:column;background:#0a2a1a;border-radius:12px;padding:10px}
nav.open{display:flex}
.search-wrap{width:100%}
.search-wrap input{width:100%}
.ppdb-form{grid-template-columns:1fr}
.hero-btns{justify-content:center}
}
</style>
</head>
<body>

<header>
<div class="header-inner">
    <div class="logo" id="logoArea">
        <div class="logo-icon" id="logoIcon">🕌</div>
        <div>
            <div class="logo-name" id="siteTitle">MIS DARUL IHYA</div>
            <div class="logo-sub" id="siteTagline">Akreditasi A</div>
        </div>
    </div>
    <button class="menu-btn" id="menuBtn">☰</button>
    <nav id="navMenu">
        <a data-page="beranda" class="active">Beranda</a>
        <a data-page="profil">Profil</a>
        <a data-page="guru">Guru</a>
        <a data-page="galeri">Galeri</a>
        <a data-page="berita">Berita</a>
        <a data-page="eskul">Eskul</a>
        <a data-page="jadwal">Jadwal</a>
        <a data-page="kontak">Kontak</a>
        <a data-page="ppdb">PPDB</a>
    </nav>
    <div class="search-wrap">
        <input type="text" id="searchInput" placeholder="Cari berita...">
        <i class="fas fa-search"></i>
    </div>
</div>
</header>

<!-- ======== BERANDA ======== -->
<div id="beranda" class="page active">
<div class="hero">
    <div class="hero-bg"></div>
    <div class="hero-bg-img" id="heroBgImg"></div>
    <div class="hero-pattern"></div>
    <div class="hero-content">
        <div>
            <div class="hero-badge"><i class="fas fa-star"></i> <span id="heroBadge">Madrasah Ibtidaiyah Swasta</span></div>
            <h1 class="hero-title" id="heroTitle">MIS<br><span>DARUL IHYA</span></h1>
            <p class="hero-tagline" id="heroTagline">Mencetak generasi unggul, cerdas, beriman, dan berakhlak mulia</p>
            <div class="hero-btns">
                <button class="btn-primary" data-page="ppdb"><i class="fas fa-pen-to-square"></i> Daftar Sekarang</button>
                <button class="btn-outline" data-page="profil">Tentang Kami</button>
            </div>
        </div>
        <div class="hero-slider">
            <div class="slider-track" id="sliderTrack"></div>
            <button class="sl-btn sl-prev" id="slPrev">❮</button>
            <button class="sl-btn sl-next" id="slNext">❯</button>
            <div class="sl-dots" id="slDots"></div>
        </div>
    </div>
    <div class="hero-stats">
        <div class="hero-stats-inner">
            <div class="stat-item"><div class="stat-num" id="statGuru">0</div><div class="stat-label">Tenaga Pendidik</div></div>
            <div class="stat-item"><div class="stat-num">A</div><div class="stat-label">Akreditasi</div></div>
            <div class="stat-item"><div class="stat-num">6</div><div class="stat-label">Ruang Kelas</div></div>
            <div class="stat-item"><div class="stat-num" id="visitorNum">0</div><div class="stat-label">Pengunjung</div></div>
        </div>
    </div>
</div>

<div class="container">
    <div class="card">
        <div class="card-title">Tentang Kami</div>
        <div id="tentangText" class="rich-text"></div>
    </div>

    <div style="margin:10px 0 24px;">
        <div class="section-heading"><h2>📰 Berita Terbaru</h2><p>Informasi dan pengumuman terkini dari madrasah</p></div>
        <div class="berita-grid" id="beritaHome"></div>
        <div style="text-align:center;margin-top:18px;"><button class="btn-primary" data-page="berita"><i class="fas fa-newspaper"></i> Lihat Semua Berita</button></div>
    </div>

    <div style="margin:10px 0 24px;">
        <div class="section-heading"><h2>🎽 Ekstrakurikuler</h2><p>Kegiatan pengembangan diri siswa</p></div>
        <div class="eskul-grid" id="eskulHome"></div>
        <div style="text-align:center;margin-top:18px;"><button class="btn-primary" data-page="eskul"><i class="fas fa-medal"></i> Lihat Semua Eskul</button></div>
    </div>

    <div class="card">
        <div class="card-title">Informasi Biaya</div>
        <div id="biayaBox"></div>
    </div>
</div>
</div>

<!-- ======== PROFIL ======== -->
<div id="profil" class="page">
<div class="container">
    <div class="card"><div class="card-title">Sejarah Madrasah</div><div id="sejarahText" class="rich-text"></div></div>
    <div class="card"><div class="card-title">Visi</div><div id="visiText" class="rich-text"></div></div>
    <div class="card"><div class="card-title">Misi</div><div id="misiText" class="rich-text"></div></div>
    <div class="card"><div class="card-title">Tujuan</div><div id="tujuanText" class="rich-text"></div></div>
    <div class="card"><div class="card-title">Fasilitas</div><div id="fasilitasText" class="rich-text"></div></div>
    <div class="card"><div class="card-title">Tenaga Pendidik</div><div id="tenagaText" class="rich-text"></div></div>
    <div class="card"><div class="card-title">Penutup</div><div id="penutupText" class="rich-text"></div></div>
</div>
</div>

<!-- ======== GURU ======== -->
<div id="guru" class="page">
<div class="container">
    <div class="card">
        <div class="card-title">Kepala Madrasah</div>
        <div id="kepsekBox"></div>
    </div>
    <div class="card">
        <div class="card-title">Tenaga Pendidik</div>
        <div class="guru-grid" id="guruGrid"></div>
    </div>
</div>
</div>

<!-- ======== GALERI ======== -->
<div id="galeri" class="page">
<div class="container">
    <div class="card">
        <div class="card-title">Galeri Kegiatan</div>
        <div class="gallery-grid" id="galleryGrid"></div>
    </div>
</div>
</div>

<!-- ======== BERITA ======== -->
<div id="berita" class="page">
<div class="container">
    <div class="berita-sidebar">
        <div>
            <div class="berita-grid" id="beritaFull"></div>
            <div class="pagination" id="beritaPagination"></div>
        </div>
        <div class="kategori-box">
            <h4>📂 Kategori</h4>
            <div class="kat-link active" data-kat="semua">📋 Semua</div>
            <div class="kat-link" data-kat="Berita">📰 Berita</div>
            <div class="kat-link" data-kat="Pengumuman">📢 Pengumuman</div>
            <div class="kat-link" data-kat="Kegiatan">🎉 Kegiatan</div>
            <div class="kat-link" data-kat="Prestasi">🏆 Prestasi</div>
            <div class="kat-link" data-kat="Informasi">ℹ️ Informasi</div>
        </div>
    </div>
</div>
</div>

<!-- ======== ESKUL ======== -->
<div id="eskul" class="page">
<div class="container">
    <div class="section-heading" style="margin-bottom:24px;"><h2>🎽 Ekstrakurikuler</h2><p>Program pengembangan bakat dan minat siswa MIS Darul Ihya</p></div>
    <div class="eskul-grid" id="eskulFull"></div>
</div>
</div>

<!-- ======== JADWAL ======== -->
<div id="jadwal" class="page">
<div class="container">
    <div class="card">
        <div class="card-title">Jadwal Kelas 1 - 2</div>
        <div style="overflow-x:auto"><table class="jadwal-table"><thead><tr><th>Hari</th><th>Mata Pelajaran</th><th>Jam</th></tr></thead><tbody id="jadwal12Body"></tbody></table></div>
    </div>
    <div class="card">
        <div class="card-title">Jadwal Kelas 3 - 6</div>
        <div style="overflow-x:auto"><table class="jadwal-table"><thead><tr><th>Hari</th><th>Mata Pelajaran</th><th>Jam</th></tr></thead><tbody id="jadwal36Body"></tbody></table></div>
    </div>
</div>
</div>

<!-- ======== KONTAK ======== -->
<div id="kontak" class="page">
<div class="container">
    <div class="kontak-grid">
        <div class="kontak-item"><div class="kontak-icon"><i class="fas fa-map-marker-alt"></i></div><div><div class="kontak-label">Alamat</div><div class="kontak-val" id="kontakAlamat"></div></div></div>
        <div class="kontak-item"><div class="kontak-icon"><i class="fas fa-phone"></i></div><div><div class="kontak-label">Telepon</div><div class="kontak-val" id="kontakTelp"></div></div></div>
        <div class="kontak-item"><div class="kontak-icon"><i class="fas fa-envelope"></i></div><div><div class="kontak-label">Email</div><div class="kontak-val" id="kontakEmail"></div></div></div>
    </div>
    <div class="card"><div class="card-title">Lokasi</div><div id="mapsBox"></div></div>
</div>
</div>

<!-- ======== PPDB ======== -->
<div id="ppdb" class="page">
<div class="container">
    <div class="card">
        <div class="card-title">Formulir Pendaftaran PPDB</div>
        <form id="ppdbForm">
            <div class="ppdb-form">
                <div class="form-group"><label>Nama Lengkap *</label><input type="text" id="f_nama" required placeholder="Nama lengkap calon siswa"></div>
                <div class="form-group"><label>Jenis Kelamin</label><select id="f_jk"><option>Laki-laki</option><option>Perempuan</option></select></div>
                <div class="form-group"><label>Tempat Lahir</label><input id="f_tempat" placeholder="Kota/kabupaten"></div>
                <div class="form-group"><label>Tanggal Lahir</label><input type="date" id="f_tgl"></div>
                <div class="form-group" style="grid-column:1/-1"><label>Alamat Lengkap</label><textarea id="f_alamat" rows="2" placeholder="Alamat tempat tinggal"></textarea></div>
                <div class="form-group"><label>No. HP Orang Tua</label><input type="tel" id="f_hp" placeholder="08xxxxxxxxxx"></div>
                <div class="form-group"><label>Upload Ijazah / Rapor TK (max 2MB)</label><input type="file" id="f_ijazah" accept=".jpg,.jpeg,.png,.pdf"></div>
                <div class="form-group"><label>Upload Akte / Kartu Keluarga (max 2MB)</label><input type="file" id="f_akte" accept=".jpg,.jpeg,.png,.pdf"></div>
            </div>
            <div style="margin-top:20px;"><button type="submit" class="btn-primary"><i class="fas fa-paper-plane"></i> Kirim Pendaftaran</button></div>
        </form>
        <div id="ppdbMsg" style="margin-top:15px;"></div>
    </div>
</div>
</div>

<!-- ======== MODAL BACA BERITA ======== -->
<div id="beritaModal" class="modal" onclick="if(event.target===this)tutupBeritaModal()">
<div class="modal-berita">
    <div class="modal-berita-header">
        <h2 id="mbTitle"></h2>
        <button class="modal-close" onclick="tutupBeritaModal()">✕</button>
    </div>
    <img id="mbFoto" class="modal-berita-foto" style="display:none">
    <div class="modal-berita-meta">
        <span class="berita-badge" id="mbKategori"></span>
        <small id="mbTanggal" style="color:var(--muted)"></small>
    </div>
    <div class="modal-berita-body" id="mbIsi"></div>
</div>
</div>

<!-- ======== MODAL GALERI ======== -->
<div id="galeriModal" class="modal" onclick="if(event.target===this)tutupGaleriModal()">
<div class="modal-img-wrap">
    <img id="galeriModalImg" onclick="event.stopPropagation()">
    <div class="modal-img-caption" id="galeriModalCaption"></div>
    <button style="position:absolute;top:-12px;right:-12px;background:#e53935;border:none;width:28px;height:28px;border-radius:50%;color:white;cursor:pointer;font-size:14px" onclick="tutupGaleriModal()">✕</button>
</div>
</div>

<div class="wa-float" id="waBtn"><i class="fab fa-whatsapp"></i></div>
<footer>© 2026 MIS Darul Ihya | NPSN: 60706770 | Ciomas, Bogor</footer>

<script>
let DATA = null;
let ALL_BERITA = [];
let currentKat = 'semua';
let currentPage = 1;
const PER_PAGE = 6;

// ---- Fetch data ----
async function loadData() {
    try {
        const res = await fetch('api.php?action=get_public');
        DATA = await res.json();
        render();
    } catch(e) { console.error('Gagal load data', e); }
}
async function loadVisitor() {
    try {
        const r = await fetch('api.php?action=visitor');
        const j = await r.json();
        document.getElementById('visitorNum').innerText = j.count;
    } catch(e) {}
}

function esc(s) { return String(s||'').replace(/[&<>]/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;'}[m])); }

// ---- Render berita cards ----
function beritaCardHtml(b) {
    const thumb = b.foto
        ? `<div class="berita-thumb"><img src="${b.foto}" loading="lazy"></div>`
        : `<div class="berita-thumb" style="display:flex;align-items:center;justify-content:center;font-size:36px;">📰</div>`;
    return `<div class="berita-card" onclick="bukaBaca(${b.id})">
        ${thumb}
        <div class="berita-body">
            <span class="berita-badge">${esc(b.kategori)}</span>
            <h4>${esc(b.judul)}</h4>
            <small><i class="fas fa-calendar" style="color:var(--gold)"></i> ${esc(b.tanggal)}</small>
            <p>${esc((b.isi||'').substring(0,120))}${(b.isi||'').length>120?'…':''}</p>
            <div style="margin-top:10px;color:var(--gold);font-size:.78rem;font-weight:600;">Baca Selengkapnya →</div>
        </div>
    </div>`;
}

// ---- Render eskul cards ----
function eskulCardHtml(e) {
    const img = e.foto
        ? `<div class="eskul-img"><img src="${e.foto}" loading="lazy"></div>`
        : `<div class="eskul-img">${getEskulEmoji(e.nama)}</div>`;
    return `<div class="eskul-card">${img}<div class="eskul-body"><div class="eskul-name">${esc(e.nama)}</div><div class="eskul-desc">${esc(e.deskripsi)}</div></div></div>`;
}
function getEskulEmoji(nama) {
    const n = (nama||'').toLowerCase();
    if(n.includes('pramuka')) return '⚜️';
    if(n.includes('tahfidz')||n.includes('quran')) return '📖';
    if(n.includes('olahraga')||n.includes('sepak')) return '⚽';
    if(n.includes('seni')||n.includes('nasyid')||n.includes('hadroh')) return '🎵';
    if(n.includes('komputer')||n.includes('it')) return '💻';
    if(n.includes('arab')) return '📜';
    if(n.includes('english')||n.includes('inggris')) return '🌍';
    return '🎽';
}

// ---- Render all ----
function render() {
    if (!DATA) return;
    const s = DATA.site;
    ALL_BERITA = DATA.berita || [];

    // Header & hero
    document.getElementById('siteTitle').innerText = s.title;
    document.getElementById('siteTagline').innerText = s.tagline;
    document.getElementById('heroTitle').innerHTML = s.title.replace(' ','<br><span style="color:var(--gold)">') + '</span>';
    document.getElementById('heroTagline').innerText = s.heroTagline;
    document.getElementById('statGuru').innerText = DATA.guru.length;

    // Logo
    if (DATA.logo) document.getElementById('logoIcon').innerHTML = `<img src="${DATA.logo}">`;

    // Hero background
    if (DATA.heroBg) document.getElementById('heroBgImg').style.backgroundImage = `url('${DATA.heroBg}')`;

    // Profil
    document.getElementById('tentangText').innerHTML  = s.tentang;
    document.getElementById('sejarahText').innerHTML  = s.sejarah;
    document.getElementById('visiText').innerHTML     = s.visi;
    document.getElementById('misiText').innerHTML     = s.misi;
    document.getElementById('tujuanText').innerHTML   = s.tujuan;
    document.getElementById('fasilitasText').innerHTML = s.fasilitas;
    document.getElementById('tenagaText').innerHTML   = s.tenagaPendidik;
    document.getElementById('penutupText').innerHTML  = s.penutup;

    // Kontak
    document.getElementById('kontakAlamat').innerText = s.kontak.alamat;
    document.getElementById('kontakTelp').innerText   = s.kontak.telp;
    document.getElementById('kontakEmail').innerText  = s.kontak.email;
    if (s.kontak.maps) document.getElementById('mapsBox').innerHTML = s.kontak.maps;

    // Kepsek
    document.getElementById('kepsekBox').innerHTML = `
        <div class="kepsek-card">
            <div class="kepsek-avatar"><img src="${s.kepsek.foto||'https://placehold.co/80x80/0f3d24/ffd700?text=K'}" onerror="this.src='https://placehold.co/80x80'"></div>
            <div><div style="font-weight:700;font-size:1.05rem">${esc(s.kepsek.nama)}</div>
            <div style="color:var(--gold);font-size:.78rem;margin:3px 0">Kepala Madrasah</div>
            <div class="kepsek-motto">"${esc(s.kepsek.motto)}"</div></div>
        </div>`;

    // Guru
    document.getElementById('guruGrid').innerHTML = DATA.guru.length
        ? DATA.guru.map(g=>`<div class="guru-card"><div class="guru-avatar">${g.foto?`<img src="${g.foto}">`:g.nama[0]}</div><div class="guru-name">${esc(g.nama)}</div><div class="guru-role">${esc(g.jabatan||'Guru')}</div></div>`).join('')
        : '<p style="color:var(--muted)">Belum ada data guru</p>';

    // Slider
    const slides = DATA.slider;
    document.getElementById('sliderTrack').innerHTML = slides.length
        ? slides.map(s=>`<div class="slide"><img src="${s}" loading="lazy"></div>`).join('')
        : `<div class="slide" style="display:flex;align-items:center;justify-content:center;font-family:'Amiri',serif;font-size:28px;color:var(--gold)">MIS Darul Ihya</div>`;
    initSlider(slides.length||1);

    // Galeri
    document.getElementById('galleryGrid').innerHTML = DATA.galeri.length
        ? DATA.galeri.map(g=>`<div class="gallery-item" onclick="bukaGaleri('${g.gambar}','${esc(g.keterangan||'')}')"><img src="${g.gambar}" loading="lazy">${g.keterangan?`<div class="gallery-caption">${esc(g.keterangan)}</div>`:''}</div>`).join('')
        : '<p style="color:var(--muted)">Belum ada foto</p>';

    // Berita home (3 terbaru)
    document.getElementById('beritaHome').innerHTML = ALL_BERITA.slice(0,3).map(beritaCardHtml).join('') || '<p style="color:var(--muted)">Belum ada berita</p>';

    // Eskul home (4)
    document.getElementById('eskulHome').innerHTML = (DATA.eskul||[]).slice(0,4).map(eskulCardHtml).join('');

    // Eskul full
    document.getElementById('eskulFull').innerHTML = (DATA.eskul||[]).length
        ? DATA.eskul.map(eskulCardHtml).join('')
        : '<p style="color:var(--muted)">Belum ada data eskul</p>';

    // Jadwal
    document.getElementById('jadwal12Body').innerHTML = DATA.jadwal12.map(r=>`<tr>${r.map(c=>`<td>${esc(c)}</td>`).join('')}</tr>`).join('');
    document.getElementById('jadwal36Body').innerHTML = DATA.jadwal36.map(r=>`<tr>${r.map(c=>`<td>${esc(c)}</td>`).join('')}</tr>`).join('');

    // Biaya
    const biayaBox = document.getElementById('biayaBox');
    if (DATA.biayaGambar) {
        biayaBox.innerHTML = `<img src="${DATA.biayaGambar}" style="max-width:100%;max-height:350px;border-radius:14px;cursor:pointer;border:1px solid var(--border)" onclick="bukaGaleri('${DATA.biayaGambar}','Informasi Biaya PPDB')"><p style="font-size:.75rem;color:var(--muted);margin-top:8px;">Klik gambar untuk memperbesar</p>`;
    } else {
        biayaBox.innerHTML = `<div class="biaya-placeholder"><i class="fas fa-file-invoice-dollar"></i><p style="color:var(--muted);margin-top:10px">Pamflet biaya akan ditampilkan di sini setelah diterima dari pihak sekolah.</p></div>`;
    }

    // WA
    document.getElementById('waBtn').onclick = ()=>window.open(`https://wa.me/${s.waNumber}?text=${encodeURIComponent(s.waMessage)}`, '_blank');

    // Berita full (render jika aktif)
    if (document.getElementById('berita').classList.contains('active')) renderBeritaFull();
}

// ---- Berita full + pagination ----
function renderBeritaFull() {
    let arr = currentKat === 'semua' ? ALL_BERITA : ALL_BERITA.filter(b=>b.kategori===currentKat);
    const total = Math.ceil(arr.length/PER_PAGE);
    const slice = arr.slice((currentPage-1)*PER_PAGE, currentPage*PER_PAGE);
    document.getElementById('beritaFull').innerHTML = slice.map(beritaCardHtml).join('') || '<p style="color:var(--muted)">Tidak ada berita</p>';
    let pg='';
    for(let i=1;i<=total;i++) pg+=`<button class="pg-btn ${i===currentPage?'active':''}" onclick="goPage(${i})">${i}</button>`;
    document.getElementById('beritaPagination').innerHTML = pg;
}
function goPage(n){ currentPage=n; renderBeritaFull(); window.scrollTo(0,0); }

// ---- Modal baca berita ----
function bukaBaca(id) {
    const b = ALL_BERITA.find(x=>x.id==id);
    if (!b) return;
    document.getElementById('mbTitle').innerText    = b.judul;
    document.getElementById('mbKategori').innerText = b.kategori;
    document.getElementById('mbTanggal').innerText  = '📅 ' + b.tanggal;
    document.getElementById('mbIsi').innerText      = b.isi;
    const foto = document.getElementById('mbFoto');
    if (b.foto) { foto.src=b.foto; foto.style.display='block'; } else { foto.style.display='none'; }
    document.getElementById('beritaModal').classList.add('open');
    document.body.style.overflow='hidden';
}
function tutupBeritaModal() {
    document.getElementById('beritaModal').classList.remove('open');
    document.body.style.overflow='';
}

// ---- Modal galeri ----
function bukaGaleri(src, caption='') {
    document.getElementById('galeriModalImg').src = src;
    document.getElementById('galeriModalCaption').innerText = caption;
    document.getElementById('galeriModal').classList.add('open');
    document.body.style.overflow='hidden';
}
function tutupGaleriModal() {
    document.getElementById('galeriModal').classList.remove('open');
    document.body.style.overflow='';
}

// ---- Slider ----
let slIdx=0, slTimer;
function initSlider(total) {
    clearInterval(slTimer); slIdx=0;
    const dots = document.getElementById('slDots');
    if (total<=1) { document.getElementById('slPrev').style.display='none'; document.getElementById('slNext').style.display='none'; if(dots) dots.innerHTML=''; return; }
    document.getElementById('slPrev').style.display='flex'; document.getElementById('slNext').style.display='flex';
    dots.innerHTML = Array.from({length:total},(_,i)=>`<div class="dot ${i===0?'active':''}" onclick="goSlide(${i})"></div>`).join('');
    slTimer = setInterval(()=>goSlide((slIdx+1)%total), 5000);
    document.getElementById('slPrev').onclick=()=>{ clearInterval(slTimer); goSlide((slIdx-1+total)%total); slTimer=setInterval(()=>goSlide((slIdx+1)%total),5000); };
    document.getElementById('slNext').onclick=()=>{ clearInterval(slTimer); goSlide((slIdx+1)%total); slTimer=setInterval(()=>goSlide((slIdx+1)%total),5000); };
}
function goSlide(n) {
    slIdx=n;
    document.getElementById('sliderTrack').style.transform=`translateX(-${n*100}%)`;
    document.querySelectorAll('.dot').forEach((d,i)=>d.classList.toggle('active',i===n));
}

// ---- Navigasi ----
document.querySelectorAll('[data-page]').forEach(el=>{
    el.addEventListener('click', e=>{
        e.preventDefault();
        const page = el.dataset.page;
        document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
        document.getElementById(page).classList.add('active');
        document.querySelectorAll('nav a').forEach(a=>a.classList.remove('active'));
        if (el.tagName==='A') el.classList.add('active');
        document.getElementById('navMenu').classList.remove('open');
        window.scrollTo(0,0);
        if (page==='berita' && DATA) { currentPage=1; renderBeritaFull(); }
    });
});
document.getElementById('menuBtn').onclick=()=>document.getElementById('navMenu').classList.toggle('open');

// ---- Kategori ----
document.querySelectorAll('.kat-link').forEach(el=>{
    el.addEventListener('click',()=>{
        currentKat=el.dataset.kat; currentPage=1;
        document.querySelectorAll('.kat-link').forEach(k=>k.classList.remove('active'));
        el.classList.add('active');
        renderBeritaFull();
    });
});

// ---- Search ----
document.getElementById('searchInput').addEventListener('keypress', e=>{
    if(e.key==='Enter'){ document.querySelector('[data-page="berita"]').click(); e.target.value=''; }
});

// ---- PPDB Submit ----
document.getElementById('ppdbForm').addEventListener('submit', async e=>{
    e.preventDefault();
    const nama = document.getElementById('f_nama').value.trim();
    const hp   = document.getElementById('f_hp').value.trim();
    const fi   = document.getElementById('f_ijazah').files[0];
    const fa   = document.getElementById('f_akte').files[0];
    if (!nama) { alert('Nama wajib diisi'); return; }
    if (!fi||!fa) { alert('Upload Ijazah dan Akte/KK wajib'); return; }
    if (fi.size>2*1024*1024||fa.size>2*1024*1024) { alert('Ukuran file maksimal 2MB'); return; }
    const toB64 = f=>new Promise(res=>{ const r=new FileReader(); r.onload=()=>res(r.result); r.readAsDataURL(f); });
    const payload = {
        nama, jk: document.getElementById('f_jk').value,
        tempat: document.getElementById('f_tempat').value,
        tgl: document.getElementById('f_tgl').value,
        alamat: document.getElementById('f_alamat').value,
        hp, ijazah: await toB64(fi), akte: await toB64(fa),
        tanggal_daftar: new Date().toLocaleDateString('id-ID')
    };
    const btn = e.submitter; btn.disabled=true; btn.innerText='Mengirim...';
    try {
        const res = await fetch('api.php?action=add_ppdb',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(payload)});
        const json = await res.json();
        if (json.ok) {
            document.getElementById('ppdbMsg').innerHTML='<div style="background:rgba(76,175,80,.15);border:1px solid #4caf50;border-radius:12px;padding:14px;color:#81c784;">✅ Pendaftaran berhasil! Data kamu sudah tersimpan. Kami akan menghubungi kamu melalui WhatsApp.</div>';
            document.getElementById('ppdbForm').reset();
        } else { alert('Gagal: '+(json.error||'Error')); }
    } catch(err) { alert('Gagal mengirim. Cek koneksi internet.'); }
    finally { btn.disabled=false; btn.innerHTML='<i class="fas fa-paper-plane"></i> Kirim Pendaftaran'; setTimeout(()=>document.getElementById('ppdbMsg').innerHTML='',5000); }
});

// ---- Init ----
loadData();
loadVisitor();
</script>
</body>
</html>
