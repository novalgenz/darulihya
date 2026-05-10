<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - MIS Darul Ihya</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #070f0a; color: #f0ede6; padding: 20px; }
        .container { max-width: 1200px; margin: auto; }
        .card { background: rgba(15,30,20,0.8); border: 1px solid rgba(255,215,0,0.2); border-radius: 16px; padding: 20px; margin-bottom: 20px; }
        h2 { color: #ffd700; margin-bottom: 15px; border-bottom: 1px solid rgba(255,215,0,0.2); padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #ffd700; font-size: 14px; }
        input, textarea, select { width: 100%; padding: 10px; border-radius: 8px; border: 1px solid rgba(255,215,0,0.3); background: rgba(0,0,0,0.3); color: white; }
        button { background: #ffd700; color: #0a2a1a; border: none; padding: 8px 16px; border-radius: 20px; cursor: pointer; font-weight: bold; margin-right: 8px; margin-top: 5px; }
        button.danger { background: #e53935; color: white; }
        button.secondary { background: #2c3e50; color: white; }
        .preview-img { max-width: 200px; border-radius: 12px; border: 2px solid #ffd700; margin-top: 10px; }
        .tabs { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
        .tab { background: rgba(255,215,0,0.1); padding: 8px 16px; border-radius: 30px; cursor: pointer; }
        .tab.active { background: #ffd700; color: #0a2a1a; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .login-box { max-width: 400px; margin: 100px auto; background: rgba(15,30,20,0.9); padding: 30px; border-radius: 20px; text-align: center; }
        .item-list { max-height: 400px; overflow-y: auto; }
        .item-card { background: rgba(0,0,0,0.2); border: 1px solid rgba(255,215,0,0.2); border-radius: 10px; padding: 10px; margin-bottom: 8px; display: flex; align-items: center; gap: 12px; justify-content: space-between; }
        .item-card img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
        .jadwal-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .jadwal-table th, .jadwal-table td { border: 1px solid rgba(255,215,0,0.3); padding: 8px; }
        .jadwal-table input { width: 100%; padding: 6px; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,215,0,0.3); color: white; border-radius: 6px; }
        .rich-editor { border: 1px solid rgba(255,215,0,0.3); border-radius: 8px; margin-bottom: 15px; }
        .editor-toolbar { background: rgba(0,0,0,0.3); padding: 6px; border-bottom: 1px solid rgba(255,215,0,0.3); }
        .editor-toolbar button { background: rgba(255,215,0,0.2); margin: 2px; padding: 4px 8px; font-size: 12px; }
        .editor-body { min-height: 120px; padding: 10px; background: rgba(0,0,0,0.2); }
        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); align-items: center; justify-content: center; z-index: 1000; }
        .modal.open { display: flex; }
        .modal-content { background: #152b1c; border-radius: 16px; padding: 20px; width: 500px; max-width: 90%; }
        .modal-content h3 { color: #ffd700; margin-bottom: 15px; }
        .log-table { width: 100%; border-collapse: collapse; font-size: 12px; }
        .log-table th, .log-table td { border: 1px solid rgba(255,215,0,0.2); padding: 6px; text-align: left; }
        @media (max-width: 768px) { .container { padding: 10px; } }
    </style>
</head>
<body>

<!-- Login Page -->
<div id="loginPage" class="login-box">
    <h2>🔐 Admin Login</h2>
    <input type="text" id="loginUser" placeholder="Username"><br><br>
    <input type="password" id="loginPass" placeholder="Password"><br><br>
    <button onclick="doLogin()">Login</button>
    <div id="loginErr" style="color:red; margin-top:10px;"></div>
</div>

<!-- Dashboard -->
<div id="dashboard" style="display:none;">
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h1>📋 Dashboard MIS Darul Ihya</h1>
            <div>
                <span id="currentUserBadge" style="background:rgba(255,215,0,0.2); padding:6px 12px; border-radius:20px; margin-right:10px;"></span>
                <button onclick="doLogout()" class="danger">Logout</button>
            </div>
        </div>
        <div class="tabs" id="tabs"></div>
        <div id="tabContents"></div>
    </div>
</div>

<!-- Modal User -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <h3 id="userModalTitle">Tambah User</h3>
        <div class="form-group"><label>Username</label><input type="text" id="user_username"></div>
        <div class="form-group"><label>Password</label><input type="password" id="user_password" placeholder="Kosongkan jika tidak diubah"></div>
        <div class="form-group"><label>Role</label>
            <select id="user_role"><option value="admin">Admin</option><option value="editor">Editor</option><option value="staff">Staff</option></select>
        </div>
        <div class="form-group"><label>Status</label>
            <select id="user_status"><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option></select>
        </div>
        <div style="text-align:right; margin-top:15px;">
            <button onclick="simpanUser()">Simpan</button>
            <button class="danger" onclick="tutupModalUser()">Batal</button>
        </div>
    </div>
</div>

<script>
// ---- State ----
let CURRENT_USER = null;
let editingUserId = null;
let editingBeritaId = null;
let JADWAL12 = [], JADWAL36 = [];
let PPDB_DATA = [];

// ---- Helpers ----
function escapeHtml(str) {
    return String(str||'').replace(/[&<>]/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;'}[m]));
}
function compressImage(file, maxW, cb) {
    let reader = new FileReader();
    reader.onload = e => {
        let img = new Image();
        img.onload = () => {
            let w=img.width, h=img.height;
            if(w>maxW){h=h*maxW/w;w=maxW;}
            let canvas=document.createElement('canvas');
            canvas.width=w; canvas.height=h;
            canvas.getContext('2d').drawImage(img,0,0,w,h);
            cb(canvas.toDataURL('image/jpeg',0.7));
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}
async function api(action, data={}) {
    const res = await fetch(`api.php?action=${action}`, {
        method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify(data)
    });
    return res.json();
}

// ---- LOGIN / LOGOUT ----
async function doLogin() {
    const username = document.getElementById('loginUser').value.trim();
    const password = document.getElementById('loginPass').value.trim();
    if (!username || !password) { document.getElementById('loginErr').innerText='Isi username dan password'; return; }
    const json = await api('login', {username, password});
    if (json.ok) {
        CURRENT_USER = json.user;
        document.getElementById('loginPage').style.display = 'none';
        document.getElementById('dashboard').style.display = 'block';
        document.getElementById('currentUserBadge').innerHTML = `<i class="fas fa-user"></i> ${CURRENT_USER.username} (${CURRENT_USER.role})`;
        buildTabs();
    } else {
        document.getElementById('loginErr').innerText = json.error || 'Login gagal';
    }
}
document.getElementById('loginPass').addEventListener('keypress', e=>{ if(e.key==='Enter') doLogin(); });

async function doLogout() {
    await api('logout');
    location.reload();
}

// ---- TABS ----
const tabList = [
    {id:'profil',  label:'📋 Profil',  adminOnly:false},
    {id:'kepsek',  label:'👤 Kepsek',  adminOnly:false},
    {id:'guru',    label:'👩‍🏫 Guru',    adminOnly:false},
    {id:'slider',  label:'🖼️ Slider',  adminOnly:false},
    {id:'galeri',  label:'📸 Galeri',  adminOnly:false},
    {id:'berita',  label:'📰 Berita',  adminOnly:false},
    {id:'jadwal',  label:'📅 Jadwal',  adminOnly:false},
    {id:'ppdb',    label:'📋 PPDB',    adminOnly:false},
    {id:'biaya',   label:'💰 Biaya',   adminOnly:false},
    {id:'users',   label:'👥 Users',   adminOnly:true},
    {id:'logs',    label:'📜 Logs',    adminOnly:true},
];

function buildTabs() {
    let tabsHtml='', contentsHtml='';
    let first = true;
    tabList.forEach(t => {
        if (t.adminOnly && CURRENT_USER.role !== 'admin') return;
        tabsHtml += `<div class="tab ${first?'active':''}" data-tab="${t.id}">${t.label}</div>`;
        contentsHtml += `<div id="tab-${t.id}" class="tab-content ${first?'active':''}">${getTabContent(t.id)}</div>`;
        first = false;
    });
    document.getElementById('tabs').innerHTML = tabsHtml;
    document.getElementById('tabContents').innerHTML = contentsHtml;
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', ()=>{
            const id = tab.dataset.tab;
            document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
            tab.classList.add('active');
            document.querySelectorAll('.tab-content').forEach(c=>c.classList.remove('active'));
            document.getElementById(`tab-${id}`).classList.add('active');
            if(id==='profil')  loadProfil();
            if(id==='kepsek')  loadKepsek();
            if(id==='guru')    renderGuruList();
            if(id==='slider')  renderSliderList();
            if(id==='galeri')  renderGaleriList();
            if(id==='berita')  renderBeritaAdmin();
            if(id==='jadwal')  loadJadwal();
            if(id==='ppdb')    loadPPDB();
            if(id==='biaya')   loadBiaya();
            if(id==='users')   renderUserList();
            if(id==='logs')    renderLogs();
        });
    });
    // Load tab pertama (profil)
    loadProfil();
}

function getTabContent(id) {
    if (id==='profil') return `
        <div class="card">
            <h2>Profil Madrasah</h2>
            <div class="form-group"><label>Judul</label><input id="siteTitle"></div>
            <div class="form-group"><label>Tagline</label><input id="siteTagline"></div>
            <div class="form-group"><label>Hero Tagline</label><input id="heroTagline"></div>
            <div class="form-group"><label>Logo Madrasah</label><input type="file" id="logoUpload" accept="image/*"><div id="logoPreview"><p>Belum ada logo</p></div></div>
            <div class="form-group"><label>Tentang</label><div class="rich-editor"><div class="editor-toolbar"><button onclick="execCmd('tentangEditor','bold')"><b>B</b></button><button onclick="execCmd('tentangEditor','italic')"><i>I</i></button><button onclick="execCmd('tentangEditor','insertUnorderedList')">List</button></div><div class="editor-body" id="tentangEditor" contenteditable="true"></div></div></div>
            <div class="form-group"><label>Sejarah</label><div class="rich-editor"><div class="editor-toolbar"><button onclick="execCmd('sejarahEditor','bold')"><b>B</b></button><button onclick="execCmd('sejarahEditor','italic')"><i>I</i></button><button onclick="execCmd('sejarahEditor','insertUnorderedList')">List</button></div><div class="editor-body" id="sejarahEditor" contenteditable="true"></div></div></div>
            <div class="form-group"><label>Visi</label><div class="rich-editor"><div class="editor-toolbar"><button onclick="execCmd('visiEditor','bold')"><b>B</b></button><button onclick="execCmd('visiEditor','italic')"><i>I</i></button><button onclick="execCmd('visiEditor','insertUnorderedList')">List</button></div><div class="editor-body" id="visiEditor" contenteditable="true"></div></div></div>
            <div class="form-group"><label>Misi</label><div class="rich-editor"><div class="editor-toolbar"><button onclick="execCmd('misiEditor','bold')"><b>B</b></button><button onclick="execCmd('misiEditor','italic')"><i>I</i></button><button onclick="execCmd('misiEditor','insertUnorderedList')">List</button></div><div class="editor-body" id="misiEditor" contenteditable="true"></div></div></div>
            <div class="form-group"><label>Tujuan</label><div class="rich-editor"><div class="editor-toolbar"><button onclick="execCmd('tujuanEditor','bold')"><b>B</b></button><button onclick="execCmd('tujuanEditor','italic')"><i>I</i></button><button onclick="execCmd('tujuanEditor','insertUnorderedList')">List</button></div><div class="editor-body" id="tujuanEditor" contenteditable="true"></div></div></div>
            <div class="form-group"><label>Fasilitas</label><div class="rich-editor"><div class="editor-toolbar"><button onclick="execCmd('fasilitasEditor','bold')"><b>B</b></button><button onclick="execCmd('fasilitasEditor','italic')"><i>I</i></button><button onclick="execCmd('fasilitasEditor','insertUnorderedList')">List</button></div><div class="editor-body" id="fasilitasEditor" contenteditable="true"></div></div></div>
            <div class="form-group"><label>Tenaga Pendidik</label><div class="rich-editor"><div class="editor-toolbar"><button onclick="execCmd('tenagaEditor','bold')"><b>B</b></button><button onclick="execCmd('tenagaEditor','italic')"><i>I</i></button><button onclick="execCmd('tenagaEditor','insertUnorderedList')">List</button></div><div class="editor-body" id="tenagaEditor" contenteditable="true"></div></div></div>
            <div class="form-group"><label>Penutup</label><div class="rich-editor"><div class="editor-toolbar"><button onclick="execCmd('penutupEditor','bold')"><b>B</b></button><button onclick="execCmd('penutupEditor','italic')"><i>I</i></button><button onclick="execCmd('penutupEditor','insertUnorderedList')">List</button></div><div class="editor-body" id="penutupEditor" contenteditable="true"></div></div></div>
            <div class="form-group"><label>Alamat</label><input id="alamat"></div>
            <div class="form-group"><label>Telepon</label><input id="telp"></div>
            <div class="form-group"><label>Email</label><input id="email"></div>
            <div class="form-group"><label>Google Maps (iframe)</label><textarea id="maps" rows="4"></textarea></div>
            <div class="form-group"><label>WhatsApp Number</label><input id="waNumber"></div>
            <div class="form-group"><label>Pesan WA</label><input id="waMessage"></div>
            <button onclick="saveProfil()">💾 Simpan Profil</button>
        </div>`;
    if (id==='kepsek') return `
        <div class="card">
            <h2>Kepala Madrasah</h2>
            <div class="form-group"><label>Nama</label><input id="kepsekNama"></div>
            <div class="form-group"><label>Motto</label><input id="kepsekMotto"></div>
            <div class="form-group"><label>Foto</label><input type="file" id="kepsekFotoFile" accept="image/*"></div>
            <div id="kepsekPreview"><p>Belum ada foto</p></div>
            <button onclick="saveKepsek()">💾 Simpan Kepsek</button>
        </div>`;
    if (id==='guru') return `<div class="card"><h2>Daftar Guru <button onclick="bukaModalGuru()">+ Tambah Guru</button></h2><div id="guruList" class="item-list"></div></div>`;
    if (id==='slider') return `<div class="card"><h2>Slider Foto</h2><div id="sliderList" class="item-list"></div><input type="file" id="sliderFile" accept="image/*" multiple><button onclick="uploadSlider()">Upload Slider</button></div>`;
    if (id==='galeri') return `<div class="card"><h2>Galeri Foto</h2><div id="galeriList" class="item-list"></div><input type="file" id="galeriFile" accept="image/*" multiple><button onclick="uploadGaleri()">Upload Galeri</button></div>`;
    if (id==='berita') return `<div class="card"><h2>📰 Kelola Berita & Pengumuman</h2><button onclick="bukaModalBerita()">+ Tambah Berita</button><div id="beritaListAdmin" class="item-list" style="margin-top:15px;"></div></div>`;
    if (id==='jadwal') return `
        <div class="card"><h2>Jadwal Kelas 1-2</h2><table class="jadwal-table"><thead><tr><th>Hari</th><th>Mata Pelajaran</th><th>Jam</th><th>Aksi</th></tr></thead><tbody id="jadwal12Body"></tbody></table><button onclick="tambahBaris12()">+ Tambah Baris</button></div>
        <div class="card"><h2>Jadwal Kelas 3-6</h2><table class="jadwal-table"><thead><tr><th>Hari</th><th>Mata Pelajaran</th><th>Jam</th><th>Aksi</th></tr></thead><tbody id="jadwal36Body"></tbody></table><button onclick="tambahBaris36()">+ Tambah Baris</button><button onclick="saveJadwal()">💾 Simpan Semua Jadwal</button></div>`;
    if (id==='ppdb') return `
        <div class="card"><h2>Data Pendaftar PPDB</h2><div style="overflow-x:auto;"><table border="1" style="width:100%;border-collapse:collapse;font-size:13px;"><thead><tr><th>No</th><th>Nama</th><th>JK</th><th>Tempat/Tgl</th><th>Alamat</th><th>HP</th><th>Jalur</th><th>Ijazah</th><th>Akte</th><th>Aksi</th></tr></thead><tbody id="ppdbBody"></tbody></table></div>
        <div style="margin-top:15px;">
        <button onclick="exportExcel()">📥 Export Excel</button>
        <button onclick="exportPDF()">📄 Export PDF</button>
        <button onclick="clearPPDB()" class="danger">🗑️ Hapus Semua</button>
        </div></div>`;
    if (id==='biaya') return `<div class="card"><h2>Gambar Pamplet Biaya</h2><input type="file" id="biayaFile" accept="image/*" onchange="uploadBiaya(this)"><div id="biayaPreview" style="margin-top:10px;"></div><button onclick="hapusBiaya()" class="danger" style="margin-top:10px;">🗑️ Hapus Gambar</button></div>`;
    if (id==='users') return `<div class="card"><h2>👥 Manajemen User</h2><button onclick="bukaModalUser()">+ Tambah User</button><div id="userList" class="item-list" style="margin-top:15px;"></div></div>`;
    if (id==='logs') return `<div class="card"><h2>📜 Log Aktivitas</h2><div style="overflow-x:auto;"><table class="log-table"><thead><tr><th>Waktu</th><th>User</th><th>Aksi</th><th>Detail</th></tr></thead><tbody id="logBody"></tbody></table></div><button onclick="clearLogs()" class="danger" style="margin-top:10px;">Hapus Semua Log</button></div>`;
    return '';
}

function execCmd(editorId, cmd) { document.getElementById(editorId).focus(); document.execCommand(cmd,false,null); }

// ---- PROFIL ----
async function loadProfil() {
    const res = await fetch('api.php?action=get_public');
    const d = await res.json();
    const s = d.site;
    document.getElementById('siteTitle').value    = s.title || '';
    document.getElementById('siteTagline').value  = s.tagline || '';
    document.getElementById('heroTagline').value  = s.heroTagline || '';
    document.getElementById('tentangEditor').innerHTML = s.tentang || '';
    document.getElementById('sejarahEditor').innerHTML = s.sejarah || '';
    document.getElementById('visiEditor').innerHTML    = s.visi || '';
    document.getElementById('misiEditor').innerHTML    = s.misi || '';
    document.getElementById('tujuanEditor').innerHTML  = s.tujuan || '';
    document.getElementById('fasilitasEditor').innerHTML = s.fasilitas || '';
    document.getElementById('tenagaEditor').innerHTML  = s.tenagaPendidik || '';
    document.getElementById('penutupEditor').innerHTML = s.penutup || '';
    document.getElementById('alamat').value    = s.kontak.alamat || '';
    document.getElementById('telp').value      = s.kontak.telp || '';
    document.getElementById('email').value     = s.kontak.email || '';
    document.getElementById('maps').value      = s.kontak.maps || '';
    document.getElementById('waNumber').value  = s.waNumber || '';
    document.getElementById('waMessage').value = s.waMessage || '';
    if (d.logo) document.getElementById('logoPreview').innerHTML = `<img src="${d.logo}" class="preview-img">`;
}

async function saveProfil() {
    const payload = {
        site_title:       document.getElementById('siteTitle').value,
        site_tagline:     document.getElementById('siteTagline').value,
        site_hero_tagline:document.getElementById('heroTagline').value,
        site_tentang:     document.getElementById('tentangEditor').innerHTML,
        site_sejarah:     document.getElementById('sejarahEditor').innerHTML,
        site_visi:        document.getElementById('visiEditor').innerHTML,
        site_misi:        document.getElementById('misiEditor').innerHTML,
        site_tujuan:      document.getElementById('tujuanEditor').innerHTML,
        site_fasilitas:   document.getElementById('fasilitasEditor').innerHTML,
        site_tenaga:      document.getElementById('tenagaEditor').innerHTML,
        site_penutup:     document.getElementById('penutupEditor').innerHTML,
        kontak_alamat:    document.getElementById('alamat').value,
        kontak_telp:      document.getElementById('telp').value,
        kontak_email:     document.getElementById('email').value,
        kontak_maps:      document.getElementById('maps').value,
        wa_number:        document.getElementById('waNumber').value,
        wa_message:       document.getElementById('waMessage').value,
    };
    const logoFile = document.getElementById('logoUpload').files[0];
    if (logoFile) {
        compressImage(logoFile, 200, async data => {
            payload.logo = data;
            await api('save_profil', payload);
            document.getElementById('logoPreview').innerHTML = `<img src="${data}" class="preview-img">`;
            alert('✅ Profil disimpan!');
        });
    } else {
        await api('save_profil', payload);
        alert('✅ Profil disimpan!');
    }
}

// ---- KEPSEK ----
async function loadKepsek() {
    const res = await fetch('api.php?action=get_public');
    const d = await res.json();
    const k = d.site.kepsek;
    document.getElementById('kepsekNama').value  = k.nama || '';
    document.getElementById('kepsekMotto').value = k.motto || '';
    if (k.foto) document.getElementById('kepsekPreview').innerHTML = `<img src="${k.foto}" class="preview-img">`;
}
async function saveKepsek() {
    const nama  = document.getElementById('kepsekNama').value;
    const motto = document.getElementById('kepsekMotto').value;
    const file  = document.getElementById('kepsekFotoFile').files[0];
    if (file) {
        compressImage(file, 300, async data => {
            await api('save_kepsek', {nama, motto, foto:data});
            document.getElementById('kepsekPreview').innerHTML = `<img src="${data}" class="preview-img">`;
            alert('✅ Kepsek disimpan!');
        });
    } else {
        await api('save_kepsek', {nama, motto});
        alert('✅ Kepsek disimpan!');
    }
}

// ---- GURU ----
async function renderGuruList() {
    const guru = await api('get_guru');
    // api get_guru is GET, use fetch directly
    const res = await fetch('api.php?action=get_guru');
    const arr = await res.json();
    let html = arr.map(g=>`
        <div class="item-card">
            <img src="${g.foto||'https://placehold.co/60'}" onerror="this.src='https://placehold.co/60'">
            <div><b>${escapeHtml(g.nama)}</b><br>${escapeHtml(g.jabatan)}</div>
            <button class="danger" onclick="hapusGuru(${g.id})">Hapus</button>
        </div>`).join('');
    document.getElementById('guruList').innerHTML = html || '<p>Belum ada guru</p>';
}
async function hapusGuru(id) {
    if (confirm('Hapus guru ini?')) { await api('delete_guru',{id}); renderGuruList(); }
}
function bukaModalGuru() { document.getElementById('guruModal').classList.add('open'); }
function tutupModalGuru() {
    document.getElementById('guruModal').classList.remove('open');
    document.getElementById('modal_guru_nama').value='';
    document.getElementById('modal_guru_jabatan').value='Guru Kelas';
    document.getElementById('modal_guru_foto').value='';
}
async function simpanGuru() {
    const nama    = document.getElementById('modal_guru_nama').value.trim();
    const jabatan = document.getElementById('modal_guru_jabatan').value.trim()||'Guru Kelas';
    const file    = document.getElementById('modal_guru_foto').files[0];
    if (!nama) { alert('Nama guru wajib diisi'); return; }
    if (file) {
        compressImage(file,200, async data=>{
            await api('add_guru',{nama,jabatan,foto:data});
            renderGuruList(); tutupModalGuru();
        });
    } else {
        await api('add_guru',{nama,jabatan,foto:null});
        renderGuruList(); tutupModalGuru();
    }
}
document.body.insertAdjacentHTML('beforeend',`
<div id="guruModal" class="modal">
    <div class="modal-content">
        <h3>Tambah Guru Baru</h3>
        <div class="form-group"><label>Nama Lengkap</label><input type="text" id="modal_guru_nama" placeholder="Nama Guru"></div>
        <div class="form-group"><label>Jabatan</label><input type="text" id="modal_guru_jabatan" value="Guru Kelas"></div>
        <div class="form-group"><label>Foto (opsional)</label><input type="file" id="modal_guru_foto" accept="image/*"></div>
        <div style="text-align:right; margin-top:15px;">
            <button onclick="simpanGuru()">Simpan</button>
            <button class="danger" onclick="tutupModalGuru()">Batal</button>
        </div>
    </div>
</div>`);

// ---- SLIDER ----
async function renderSliderList() {
    const res = await fetch('api.php?action=get_slider');
    const arr = await res.json();
    let html = arr.map(s=>`
        <div class="item-card">
            <img src="${s.gambar}">
            <div>Slider</div>
            <button class="danger" onclick="hapusSlider(${s.id})">Hapus</button>
        </div>`).join('');
    document.getElementById('sliderList').innerHTML = html || '<p>Belum ada slider</p>';
}
async function hapusSlider(id) {
    if (confirm('Hapus slider ini?')) { await api('delete_slider',{id}); renderSliderList(); }
}
function uploadSlider() {
    const files = document.getElementById('sliderFile').files;
    if (!files.length) return;
    let done = 0;
    Array.from(files).forEach(f=>{
        compressImage(f,800, async data=>{
            await api('add_slider',{gambar:data});
            done++;
            if (done===files.length) { renderSliderList(); alert('Upload slider berhasil'); }
        });
    });
    document.getElementById('sliderFile').value='';
}

// ---- GALERI ----
async function renderGaleriList() {
    const res = await fetch('api.php?action=get_galeri');
    const arr = await res.json();
    let html = arr.map(g=>`
        <div class="item-card">
            <img src="${g.gambar}">
            <div>Foto</div>
            <button class="danger" onclick="hapusGaleri(${g.id})">Hapus</button>
        </div>`).join('');
    document.getElementById('galeriList').innerHTML = html || '<p>Belum ada galeri</p>';
}
async function hapusGaleri(id) {
    if (confirm('Hapus foto ini?')) { await api('delete_galeri',{id}); renderGaleriList(); }
}
function uploadGaleri() {
    const files = document.getElementById('galeriFile').files;
    if (!files.length) return;
    let done = 0;
    Array.from(files).forEach(f=>{
        compressImage(f,600, async data=>{
            await api('add_galeri',{gambar:data});
            done++;
            if (done===files.length) { renderGaleriList(); alert('Upload galeri berhasil'); }
        });
    });
    document.getElementById('galeriFile').value='';
}

// ---- BERITA ----
async function renderBeritaAdmin() {
    const res = await fetch('api.php?action=get_berita');
    const arr = await res.json();
    let html = arr.map(b=>`
        <div class="item-card">
            <div><b>${escapeHtml(b.judul)}</b><br><small>${escapeHtml(b.tanggal)} - ${escapeHtml(b.kategori)}</small></div>
            <div>
                <button onclick="bukaModalBerita(${b.id},'${escapeHtml(b.judul)}','${b.tanggal}','${b.kategori}')">Edit</button>
                <button class="danger" onclick="hapusBerita(${b.id})">Hapus</button>
            </div>
        </div>`).join('');
    document.getElementById('beritaListAdmin').innerHTML = html || '<p>Belum ada berita</p>';
}
async function hapusBerita(id) {
    if (confirm('Hapus berita ini?')) { await api('delete_berita',{id}); renderBeritaAdmin(); }
}
function bukaModalBerita(id=null, judul='', tanggal='', kategori='Berita') {
    editingBeritaId = id;
    document.getElementById('beritaModalTitle').innerText = id ? 'Edit Berita' : 'Tambah Berita';
    document.getElementById('berita_judul').value    = judul;
    document.getElementById('berita_tanggal').value  = tanggal || new Date().toISOString().slice(0,10);
    document.getElementById('berita_kategori').value = kategori;
    document.getElementById('berita_isi').value      = '';
    if (id) {
        fetch('api.php?action=get_berita').then(r=>r.json()).then(arr=>{
            const b = arr.find(x=>x.id==id);
            if(b) {
                document.getElementById('berita_isi').value = b.isi;
                // fix tanggal format dd/mm/yyyy -> yyyy-mm-dd
                if(b.tanggal && b.tanggal.includes('/')) {
                    document.getElementById('berita_tanggal').value = b.tanggal.split('/').reverse().join('-');
                }
            }
        });
    }
    document.getElementById('beritaModal').classList.add('open');
}
function tutupModalBerita() { document.getElementById('beritaModal').classList.remove('open'); }
async function simpanBerita() {
    const judul    = document.getElementById('berita_judul').value.trim();
    const tanggal  = document.getElementById('berita_tanggal').value;
    const kategori = document.getElementById('berita_kategori').value;
    const isi      = document.getElementById('berita_isi').value.trim();
    if (!judul||!isi) { alert('Judul dan isi harus diisi'); return; }
    const tglFormatted = tanggal.split('-').reverse().join('/');
    if (editingBeritaId) {
        await api('edit_berita',{id:editingBeritaId, judul, tanggal:tglFormatted, kategori, isi});
    } else {
        await api('add_berita',{judul, tanggal:tglFormatted, kategori, isi});
    }
    renderBeritaAdmin(); tutupModalBerita();
}
document.body.insertAdjacentHTML('beforeend',`
<div id="beritaModal" class="modal">
    <div class="modal-content">
        <h3 id="beritaModalTitle">Tambah Berita</h3>
        <div class="form-group"><label>Judul</label><input type="text" id="berita_judul"></div>
        <div class="form-group"><label>Tanggal</label><input type="date" id="berita_tanggal"></div>
        <div class="form-group"><label>Kategori</label>
            <select id="berita_kategori">
                <option value="Berita">📰 Berita</option>
                <option value="Pengumuman">📢 Pengumuman</option>
                <option value="Kegiatan">🎉 Kegiatan</option>
                <option value="Prestasi">🏆 Prestasi</option>
                <option value="Informasi">ℹ️ Informasi</option>
            </select>
        </div>
        <div class="form-group"><label>Isi</label><textarea id="berita_isi" rows="5"></textarea></div>
        <div style="text-align:right;"><button onclick="simpanBerita()">Simpan</button><button class="danger" onclick="tutupModalBerita()">Batal</button></div>
    </div>
</div>`);

// ---- JADWAL ----
async function loadJadwal() {
    const res = await fetch('api.php?action=get_public');
    const d = await res.json();
    JADWAL12 = d.jadwal12.map(r=>({hari:r[0],mapel:r[1],jam:r[2]}));
    JADWAL36 = d.jadwal36.map(r=>({hari:r[0],mapel:r[1],jam:r[2]}));
    renderJadwalTables();
}
function renderJadwalTables() {
    let h12='', h36='';
    JADWAL12.forEach((r,i)=>{
        h12+=`<tr><td><input type="text" id="j12_h${i}" value="${escapeHtml(r.hari)}" placeholder="Hari"></td><td><input type="text" id="j12_m${i}" value="${escapeHtml(r.mapel)}" placeholder="Mata Pelajaran"></td><td><input type="text" id="j12_j${i}" value="${escapeHtml(r.jam)}" placeholder="Jam"></td><td><button class="danger" onclick="hapusBaris12(${i})">Hapus</button></td></tr>`;
    });
    JADWAL36.forEach((r,i)=>{
        h36+=`<tr><td><input type="text" id="j36_h${i}" value="${escapeHtml(r.hari)}" placeholder="Hari"></td><td><input type="text" id="j36_m${i}" value="${escapeHtml(r.mapel)}" placeholder="Mata Pelajaran"></td><td><input type="text" id="j36_j${i}" value="${escapeHtml(r.jam)}" placeholder="Jam"></td><td><button class="danger" onclick="hapusBaris36(${i})">Hapus</button></td></tr>`;
    });
    document.getElementById('jadwal12Body').innerHTML = h12;
    document.getElementById('jadwal36Body').innerHTML = h36;
}
function tambahBaris12() { JADWAL12.push({hari:'',mapel:'',jam:''}); renderJadwalTables(); }
function hapusBaris12(i) { JADWAL12.splice(i,1); renderJadwalTables(); }
function tambahBaris36() { JADWAL36.push({hari:'',mapel:'',jam:''}); renderJadwalTables(); }
function hapusBaris36(i) { JADWAL36.splice(i,1); renderJadwalTables(); }
async function saveJadwal() {
    let new12=[], new36=[];
    JADWAL12.forEach((_,i)=>{ let h=document.getElementById(`j12_h${i}`)?.value||'', m=document.getElementById(`j12_m${i}`)?.value||'', j=document.getElementById(`j12_j${i}`)?.value||''; if(h||m||j) new12.push([h,m,j]); });
    JADWAL36.forEach((_,i)=>{ let h=document.getElementById(`j36_h${i}`)?.value||'', m=document.getElementById(`j36_m${i}`)?.value||'', j=document.getElementById(`j36_j${i}`)?.value||''; if(h||m||j) new36.push([h,m,j]); });
    await api('save_jadwal',{jadwal12:new12, jadwal36:new36});
    JADWAL12 = new12.map(r=>({hari:r[0],mapel:r[1],jam:r[2]}));
    JADWAL36 = new36.map(r=>({hari:r[0],mapel:r[1],jam:r[2]}));
    renderJadwalTables();
    alert('✅ Jadwal disimpan!');
}

// ---- PPDB ----
async function loadPPDB() {
    const res = await fetch('api.php?action=get_ppdb');
    PPDB_DATA = await res.json();
    let html = '';
    PPDB_DATA.forEach((p,idx)=>{
        html+=`<tr>
            <td>${idx+1}</td><td>${escapeHtml(p.nama)}</td><td>${escapeHtml(p.jk)}</td>
            <td>${escapeHtml(p.tempat)} ${escapeHtml(p.tgl)}</td><td>${escapeHtml(p.alamat)}</td>
            <td>${escapeHtml(p.hp)}</td><td>${escapeHtml(p.jalur)}</td>
            <td>${p.ijazah?`<a href="${p.ijazah}" target="_blank">Lihat</a>`:'-'}</td>
            <td>${p.akte?`<a href="${p.akte}" target="_blank">Lihat</a>`:'-'}</td>
            <td><button class="danger" onclick="hapusPPDB(${p.id})">Hapus</button></td>
        </tr>`;
    });
    document.getElementById('ppdbBody').innerHTML = html || '<tr><td colspan="10">Belum ada pendaftar</td></tr>';
}
async function hapusPPDB(id) {
    if (confirm('Hapus data pendaftar ini?')) { await api('delete_ppdb',{id}); loadPPDB(); }
}
async function clearPPDB() {
    if (confirm('Hapus SEMUA data PPDB?')) { await api('clear_ppdb'); loadPPDB(); }
}
function exportExcel() {
    let data=[['No','Nama','JK','Tempat Lahir','Tanggal Lahir','Alamat','HP','Jalur','Ijazah','Akte','Tanggal Daftar']];
    PPDB_DATA.forEach((p,i)=>data.push([i+1,p.nama,p.jk,p.tempat,p.tgl,p.alamat,p.hp,p.jalur,p.ijazah?'Ada':'-',p.akte?'Ada':'-',p.tanggal_daftar]));
    let wb=XLSX.utils.book_new(), ws=XLSX.utils.aoa_to_sheet(data);
    XLSX.utils.book_append_sheet(wb,ws,'PPDB');
    XLSX.writeFile(wb,`ppdb_${new Date().toISOString().slice(0,10)}.xlsx`);
}
function exportPDF() {
    let win=window.open('','_blank');
    let html=`<html><head><title>Data PPDB</title></head><body><h2>Data PPDB</h2><table border="1"><tr><th>No</th><th>Nama</th><th>JK</th><th>Tempat/Tgl</th><th>Alamat</th><th>HP</th><th>Jalur</th></tr>`;
    PPDB_DATA.forEach((p,i)=>{html+=`<tr><td>${i+1}</td><td>${p.nama}</td><td>${p.jk}</td><td>${p.tempat} ${p.tgl}</td><td>${p.alamat}</td><td>${p.hp}</td><td>${p.jalur}</td></tr>`;});
    html+=`</table></body></html>`;
    win.document.write(html); win.print();
}

// ---- BIAYA ----
async function loadBiaya() {
    const res = await fetch('api.php?action=get_public');
    const d = await res.json();
    const el = document.getElementById('biayaPreview');
    if (el && d.biayaGambar) el.innerHTML = `<img src="${d.biayaGambar}" class="preview-img"><br><small>Gambar tersimpan</small>`;
    else if(el) el.innerHTML = '<p>Belum ada gambar biaya</p>';
}
function uploadBiaya(input) {
    const f = input.files[0];
    if (!f) return;
    compressImage(f,800, async data=>{
        await api('save_biaya',{gambar:data});
        document.getElementById('biayaPreview').innerHTML = `<img src="${data}" class="preview-img"><br><small>Gambar tersimpan</small>`;
        alert('✅ Gambar biaya tersimpan!');
    });
}
async function hapusBiaya() {
    if (confirm('Hapus gambar biaya?')) {
        await api('delete_biaya');
        document.getElementById('biayaPreview').innerHTML='<p>Belum ada gambar biaya</p>';
        alert('Gambar dihapus');
    }
}

// ---- USERS ----
async function renderUserList() {
    const res = await fetch('api.php?action=get_users');
    const arr = await res.json();
    let html = arr.map(u=>`
        <div class="item-card">
            <div><b>${escapeHtml(u.username)}</b> (${u.role})<br>Status: ${u.status==='aktif'?'✅ Aktif':'⛔ Nonaktif'}</div>
            <div>
                <button onclick="bukaModalUser(${u.id})">Edit</button>
                ${u.id!=1?`<button class="secondary" onclick="toggleUser(${u.id})">Toggle Status</button>`:''}
                ${u.id!=1?`<button class="danger" onclick="hapusUser(${u.id})">Hapus</button>`:''}
            </div>
        </div>`).join('');
    document.getElementById('userList').innerHTML = html || '<p>Belum ada user</p>';
}
function bukaModalUser(editId=null) {
    editingUserId = editId;
    if (editId) {
        fetch('api.php?action=get_users').then(r=>r.json()).then(arr=>{
            const u=arr.find(x=>x.id==editId);
            if(u){
                document.getElementById('userModalTitle').innerText='Edit User';
                document.getElementById('user_username').value=u.username;
                document.getElementById('user_password').value='';
                document.getElementById('user_role').value=u.role;
                document.getElementById('user_status').value=u.status;
            }
        });
    } else {
        document.getElementById('userModalTitle').innerText='Tambah User';
        document.getElementById('user_username').value='';
        document.getElementById('user_password').value='';
        document.getElementById('user_role').value='staff';
        document.getElementById('user_status').value='aktif';
    }
    document.getElementById('userModal').classList.add('open');
}
function tutupModalUser() { document.getElementById('userModal').classList.remove('open'); }
async function simpanUser() {
    const username = document.getElementById('user_username').value.trim();
    const password = document.getElementById('user_password').value;
    const role     = document.getElementById('user_role').value;
    const status   = document.getElementById('user_status').value;
    if (!username) { alert('Username harus diisi'); return; }
    let res;
    if (editingUserId) {
        res = await api('edit_user',{id:editingUserId,username,password,role,status});
    } else {
        if (!password) { alert('Password harus diisi untuk user baru'); return; }
        res = await api('add_user',{username,password,role,status});
    }
    if (res.error) { alert(res.error); return; }
    renderUserList(); tutupModalUser(); alert('User tersimpan');
}
async function hapusUser(id) {
    if (confirm('Hapus user ini?')) { const r=await api('delete_user',{id}); if(r.error){alert(r.error);}else{renderUserList();} }
}
async function toggleUser(id) {
    await api('toggle_user',{id}); renderUserList();
}

// ---- LOGS ----
async function renderLogs() {
    const res = await fetch('api.php?action=get_logs');
    const arr = await res.json();
    let html = arr.map(l=>`<tr><td>${escapeHtml(l.waktu)}</td><td>${escapeHtml(l.username)}</td><td>${escapeHtml(l.action)}</td><td>${escapeHtml(l.detail||'')}</td></tr>`).join('');
    document.getElementById('logBody').innerHTML = html || '<tr><td colspan="4">Belum ada log</td></tr>';
}
async function clearLogs() {
    if (confirm('Hapus semua log?')) { await api('clear_logs'); renderLogs(); }
}
</script>
</body>
</html>
