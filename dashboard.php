<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin - MIS Darul Ihya</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script>
<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{--gold:#ffd700;--gold-dim:rgba(255,215,0,0.1);--border:rgba(255,215,0,0.2);--bg:#060f0a;--surface:rgba(12,28,18,0.9);--green:#0a2a1a;--muted:#7a9a85}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg);color:#f0ede6;min-height:100vh}

/* Login */
.login-wrap{display:flex;align-items:center;justify-content:center;min-height:100vh;padding:20px;background:radial-gradient(ellipse at center,#0d2a18 0%,#060f0a 70%)}
.login-box{background:var(--surface);border:1px solid var(--border);border-radius:20px;padding:36px;width:100%;max-width:380px;text-align:center}
.login-logo{font-size:40px;margin-bottom:14px}
.login-title{color:var(--gold);font-size:1.4rem;font-weight:700;margin-bottom:4px}
.login-sub{color:var(--muted);font-size:.8rem;margin-bottom:24px}
.login-box input{width:100%;padding:11px 14px;border-radius:10px;border:1px solid var(--border);background:rgba(0,0,0,.3);color:white;margin-bottom:12px;font-family:inherit;font-size:.9rem;outline:none}
.login-box input:focus{border-color:var(--gold)}
.btn-login{width:100%;background:var(--gold);color:var(--green);border:none;padding:12px;border-radius:10px;font-weight:700;font-size:.95rem;cursor:pointer;transition:.2s}
.btn-login:hover{opacity:.9}

/* Welcome toast */
.welcome-toast{position:fixed;top:20px;right:20px;background:linear-gradient(135deg,#1a4a2a,#0f3d24);border:1px solid var(--gold);border-radius:14px;padding:14px 20px;z-index:999;display:none;animation:slideIn .4s ease}
.welcome-toast.show{display:flex;align-items:center;gap:12px}
@keyframes slideIn{from{opacity:0;transform:translateX(60px)}to{opacity:1;transform:translateX(0)}}
.welcome-toast .wt-icon{font-size:24px}
.welcome-toast .wt-text{font-size:.88rem}
.welcome-toast .wt-name{color:var(--gold);font-weight:700}

/* Dashboard layout */
.dash-header{background:rgba(6,15,10,.97);border-bottom:1px solid var(--border);padding:12px 24px;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:100;backdrop-filter:blur(10px)}
.dash-brand{display:flex;align-items:center;gap:10px}
.dash-brand-icon{width:38px;height:38px;background:var(--gold-dim);border:1px solid var(--gold);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px}
.dash-brand-name{color:var(--gold);font-weight:700;font-size:1rem}
.dash-brand-sub{color:var(--muted);font-size:.68rem}
.dash-user{display:flex;align-items:center;gap:10px}
.user-badge{background:var(--gold-dim);border:1px solid var(--border);padding:5px 12px;border-radius:20px;font-size:.78rem;color:var(--gold)}
.btn-logout{background:rgba(229,57,53,.15);color:#ef9a9a;border:1px solid rgba(229,57,53,.3);padding:6px 14px;border-radius:20px;cursor:pointer;font-size:.78rem;font-weight:600;transition:.2s}
.btn-logout:hover{background:rgba(229,57,53,.3)}

/* Tabs */
.tabs-wrap{background:rgba(8,20,12,.8);border-bottom:1px solid var(--border);padding:0 24px;overflow-x:auto}
.tabs-inner{display:flex;gap:2px;min-width:max-content}
.tab{padding:12px 16px;cursor:pointer;color:var(--muted);font-size:.82rem;font-weight:500;border-bottom:2px solid transparent;transition:.2s;white-space:nowrap;display:flex;align-items:center;gap:6px}
.tab:hover{color:var(--gold)}
.tab.active{color:var(--gold);border-bottom-color:var(--gold)}

/* Content */
.dash-content{max-width:1100px;margin:0 auto;padding:24px 20px}
.tab-pane{display:none}
.tab-pane.active{display:block}

/* Cards */
.d-card{background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:22px;margin-bottom:20px}
.d-card h3{color:var(--gold);font-size:1rem;margin-bottom:18px;display:flex;align-items:center;gap:8px}
.d-card h3::before{content:'';width:3px;height:16px;background:var(--gold);border-radius:3px}

/* Forms */
.f-group{margin-bottom:14px}
.f-group label{display:block;color:var(--gold);font-size:.75rem;font-weight:600;margin-bottom:5px}
.f-group input,.f-group textarea,.f-group select{width:100%;padding:9px 12px;border-radius:8px;border:1px solid var(--border);background:rgba(0,0,0,.3);color:white;font-family:inherit;font-size:.87rem;outline:none}
.f-group input:focus,.f-group textarea:focus{border-color:var(--gold)}
.f-group select option{background:#0a2a1a}
.f-2col{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.preview-img{max-width:180px;max-height:140px;border-radius:10px;border:1px solid var(--gold);margin-top:8px;display:block}

/* Buttons */
.btn{background:var(--gold);color:var(--green);border:none;padding:8px 18px;border-radius:20px;cursor:pointer;font-weight:700;font-size:.82rem;display:inline-flex;align-items:center;gap:6px;transition:.2s}
.btn:hover{opacity:.9}
.btn-danger{background:rgba(229,57,53,.2);color:#ef9a9a;border:1px solid rgba(229,57,53,.3)}
.btn-danger:hover{background:rgba(229,57,53,.4)}
.btn-sec{background:rgba(255,215,0,.12);color:var(--gold);border:1px solid var(--border)}
.btn-sm{padding:5px 12px;font-size:.75rem}

/* Rich editor */
.rich-editor{border:1px solid var(--border);border-radius:10px;overflow:hidden;margin-bottom:14px}
.rich-toolbar{background:rgba(0,0,0,.3);padding:6px 8px;border-bottom:1px solid var(--border);display:flex;gap:4px;flex-wrap:wrap}
.rich-toolbar button{background:var(--gold-dim);border:1px solid var(--border);color:white;padding:3px 9px;border-radius:6px;font-size:.75rem;cursor:pointer}
.rich-toolbar button:hover{background:var(--gold);color:var(--green)}
.rich-body{min-height:100px;padding:12px;background:rgba(0,0,0,.2);color:white;outline:none;font-size:.88rem;line-height:1.7}

/* Item list */
.item-list{max-height:380px;overflow-y:auto;margin-top:14px}
.item-card{background:rgba(0,0,0,.2);border:1px solid var(--border);border-radius:10px;padding:10px 14px;margin-bottom:8px;display:flex;align-items:center;gap:12px}
.item-card .item-img{width:56px;height:56px;object-fit:cover;border-radius:8px;flex-shrink:0;background:#0f3d24}
.item-card .item-info{flex:1;min-width:0}
.item-card .item-name{font-weight:600;font-size:.88rem}
.item-card .item-sub{color:var(--muted);font-size:.72rem;margin-top:2px}
.item-card .item-actions{display:flex;gap:6px;flex-shrink:0}

/* Jadwal */
.jadwal-tbl{width:100%;border-collapse:collapse;margin-bottom:14px}
.jadwal-tbl th,.jadwal-tbl td{border:1px solid var(--border);padding:7px 10px}
.jadwal-tbl th{background:var(--gold-dim);color:var(--gold);font-size:.78rem}
.jadwal-tbl input{width:100%;padding:5px 8px;background:rgba(0,0,0,.3);border:1px solid var(--border);color:white;border-radius:6px;font-size:.82rem;outline:none}
.jadwal-tbl input:focus{border-color:var(--gold)}

/* Log table */
.log-tbl{width:100%;border-collapse:collapse;font-size:.78rem}
.log-tbl th,.log-tbl td{border:1px solid var(--border);padding:7px 10px;text-align:left;vertical-align:top}
.log-tbl th{background:var(--gold-dim);color:var(--gold)}

/* PPDB table */
.ppdb-tbl{width:100%;border-collapse:collapse;font-size:.78rem}
.ppdb-tbl th,.ppdb-tbl td{border:1px solid var(--border);padding:7px 10px;text-align:left}
.ppdb-tbl th{background:var(--gold-dim);color:var(--gold)}

/* Modal */
.modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:500;align-items:center;justify-content:center;padding:20px}
.modal.open{display:flex}
.modal-box{background:#0d2016;border:1px solid var(--border);border-radius:16px;padding:24px;width:100%;max-width:480px;max-height:90vh;overflow-y:auto}
.modal-box h3{color:var(--gold);margin-bottom:18px;font-size:1rem}
.modal-footer{text-align:right;margin-top:16px;display:flex;gap:8px;justify-content:flex-end}

@media(max-width:600px){
.f-2col{grid-template-columns:1fr}
.dash-content{padding:16px 12px}
.tab{padding:10px 12px;font-size:.78rem}
}
</style>
</head>
<body>

<!-- ======== LOGIN ======== -->
<div id="loginWrap" class="login-wrap">
<div class="login-box">
    <div class="login-logo">🕌</div>
    <div class="login-title">MIS Darul Ihya</div>
    <div class="login-sub">Dashboard Admin Panel</div>
    <input type="text" id="loginUser" placeholder="Username" autocomplete="username">
    <input type="password" id="loginPass" placeholder="Password" autocomplete="current-password">
    <button class="btn-login" onclick="doLogin()"><i class="fas fa-sign-in-alt"></i> Masuk</button>
    <div id="loginErr" style="color:#ef9a9a;margin-top:12px;font-size:.82rem;"></div>
</div>
</div>

<!-- ======== WELCOME TOAST ======== -->
<div class="welcome-toast" id="welcomeToast">
    <div class="wt-icon">👋</div>
    <div class="wt-text">Selamat datang, <span class="wt-name" id="welcomeName"></span>!<br><span style="color:var(--muted);font-size:.75rem" id="welcomeRole"></span></div>
</div>

<!-- ======== DASHBOARD ======== -->
<div id="dashWrap" style="display:none">
    <div class="dash-header">
        <div class="dash-brand">
            <div class="dash-brand-icon">🕌</div>
            <div>
                <div class="dash-brand-name">MIS Darul Ihya</div>
                <div class="dash-brand-sub">Admin Dashboard</div>
            </div>
        </div>
        <div class="dash-user">
            <span class="user-badge" id="userBadge"></span>
            <button class="btn-logout" onclick="doLogout()"><i class="fas fa-sign-out-alt"></i> Keluar</button>
        </div>
    </div>

    <div class="tabs-wrap">
        <div class="tabs-inner" id="tabsInner"></div>
    </div>
    <div class="dash-content" id="tabPanes"></div>
</div>

<!-- MODAL GURU -->
<div id="guruModal" class="modal">
<div class="modal-box">
    <h3>➕ Tambah Guru</h3>
    <div class="f-group"><label>Nama Lengkap *</label><input type="text" id="m_guru_nama" placeholder="Nama guru"></div>
    <div class="f-group"><label>Jabatan</label><input type="text" id="m_guru_jabatan" value="Guru Kelas" placeholder="Jabatan"></div>
    <div class="f-group"><label>Foto (opsional)</label><input type="file" id="m_guru_foto" accept="image/*"></div>
    <div class="modal-footer"><button class="btn" onclick="simpanGuru()"><i class="fas fa-save"></i> Simpan</button><button class="btn btn-danger" onclick="document.getElementById('guruModal').classList.remove('open')">Batal</button></div>
</div>
</div>

<!-- MODAL BERITA -->
<div id="beritaModal" class="modal">
<div class="modal-box" style="max-width:600px">
    <h3 id="beritaModalTitle">📰 Tambah Berita</h3>
    <div class="f-group"><label>Judul *</label><input type="text" id="m_b_judul" placeholder="Judul berita"></div>
    <div class="f-2col">
        <div class="f-group"><label>Tanggal</label><input type="date" id="m_b_tanggal"></div>
        <div class="f-group"><label>Kategori</label>
            <select id="m_b_kategori">
                <option value="Berita">📰 Berita</option>
                <option value="Pengumuman">📢 Pengumuman</option>
                <option value="Kegiatan">🎉 Kegiatan</option>
                <option value="Prestasi">🏆 Prestasi</option>
                <option value="Informasi">ℹ️ Informasi</option>
            </select>
        </div>
    </div>
    <div class="f-group"><label>Foto Berita (opsional)</label><input type="file" id="m_b_foto" accept="image/*"><div id="m_b_foto_preview" style="margin-top:6px"></div></div>
    <div class="f-group"><label>Isi Berita *</label><textarea id="m_b_isi" rows="6" placeholder="Tulis isi berita di sini..."></textarea></div>
    <div class="modal-footer"><button class="btn" onclick="simpanBerita()"><i class="fas fa-save"></i> Simpan</button><button class="btn btn-danger" onclick="document.getElementById('beritaModal').classList.remove('open')">Batal</button></div>
</div>
</div>

<!-- MODAL ESKUL -->
<div id="eskulModal" class="modal">
<div class="modal-box">
    <h3 id="eskulModalTitle">🎽 Tambah Eskul</h3>
    <div class="f-group"><label>Nama Eskul *</label><input type="text" id="m_e_nama" placeholder="Nama ekstrakurikuler"></div>
    <div class="f-group"><label>Deskripsi</label><textarea id="m_e_deskripsi" rows="3" placeholder="Deskripsi singkat..."></textarea></div>
    <div class="f-group"><label>Foto (opsional)</label><input type="file" id="m_e_foto" accept="image/*"></div>
    <div class="modal-footer"><button class="btn" onclick="simpanEskul()"><i class="fas fa-save"></i> Simpan</button><button class="btn btn-danger" onclick="document.getElementById('eskulModal').classList.remove('open')">Batal</button></div>
</div>
</div>

<!-- MODAL USER -->
<div id="userModal" class="modal">
<div class="modal-box">
    <h3 id="userModalTitle">👤 Tambah User</h3>
    <div class="f-group"><label>Username *</label><input type="text" id="m_u_username"></div>
    <div class="f-group"><label>Password</label><input type="password" id="m_u_password" placeholder="Kosongkan jika tidak diubah"></div>
    <div class="f-2col">
        <div class="f-group"><label>Role</label><select id="m_u_role"><option value="admin">Admin</option><option value="editor">Editor</option><option value="staff">Staff</option></select></div>
        <div class="f-group"><label>Status</label><select id="m_u_status"><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option></select></div>
    </div>
    <div class="modal-footer"><button class="btn" onclick="simpanUser()"><i class="fas fa-save"></i> Simpan</button><button class="btn btn-danger" onclick="document.getElementById('userModal').classList.remove('open')">Batal</button></div>
</div>
</div>

<script>
let CURRENT_USER = null;
let editBeritaId = null, editEskulId = null, editUserId = null;
let JADWAL12 = [], JADWAL36 = [], PPDB_DATA = [];

// ---- Helpers ----
function esc(s){return String(s||'').replace(/[&<>]/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;'}[m]))}
function compress(file, maxW, cb) {
    const r=new FileReader();
    r.onload=e=>{const img=new Image();img.onload=()=>{let w=img.width,h=img.height;if(w>maxW){h=h*maxW/w;w=maxW;}const c=document.createElement('canvas');c.width=w;c.height=h;c.getContext('2d').drawImage(img,0,0,w,h);cb(c.toDataURL('image/jpeg',0.72));};img.src=e.target.result;};
    r.readAsDataURL(file);
}
async function api(action, data={}) {
    const r = await fetch(`api.php?action=${action}`,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(data)});
    return r.json();
}
async function fetchGet(action) {
    const r = await fetch(`api.php?action=${action}`); return r.json();
}
function toast(msg, ok=true) {
    const t=document.createElement('div');
    t.style.cssText=`position:fixed;bottom:24px;right:24px;background:${ok?'#1a4a2a':'#4a1a1a'};border:1px solid ${ok?'#4caf50':'#e53935'};padding:12px 20px;border-radius:12px;font-size:.85rem;z-index:999;animation:slideIn .3s ease`;
    t.innerText=(ok?'✅ ':'❌ ')+msg;
    document.body.appendChild(t);
    setTimeout(()=>t.remove(),3000);
}

// ---- LOGIN ----
async function doLogin() {
    const username=document.getElementById('loginUser').value.trim();
    const password=document.getElementById('loginPass').value.trim();
    if(!username||!password){document.getElementById('loginErr').innerText='Isi username dan password';return;}
    const j = await api('login',{username,password});
    if(j.ok){
        CURRENT_USER=j.user;
        document.getElementById('loginWrap').style.display='none';
        document.getElementById('dashWrap').style.display='block';
        document.getElementById('userBadge').innerHTML=`<i class="fas fa-user"></i> ${CURRENT_USER.username} · ${CURRENT_USER.role}`;
        // Welcome toast
        const wt=document.getElementById('welcomeToast');
        document.getElementById('welcomeName').innerText=CURRENT_USER.username;
        document.getElementById('welcomeRole').innerText=`Role: ${CURRENT_USER.role}`;
        wt.classList.add('show');
        setTimeout(()=>wt.classList.remove('show'),4000);
        buildTabs();
    } else { document.getElementById('loginErr').innerText=j.error||'Login gagal'; }
}
document.getElementById('loginPass').addEventListener('keypress',e=>{if(e.key==='Enter')doLogin();});

async function doLogout(){await api('logout');location.reload();}

// ---- TABS ----
const TABS = [
    {id:'profil',   icon:'fa-globe',       label:'Profil'},
    {id:'kepsek',   icon:'fa-user-tie',    label:'Kepsek'},
    {id:'guru',     icon:'fa-chalkboard-teacher', label:'Guru'},
    {id:'slider',   icon:'fa-images',      label:'Slider'},
    {id:'heroBg',   icon:'fa-image',       label:'Background'},
    {id:'galeri',   icon:'fa-camera',      label:'Galeri'},
    {id:'berita',   icon:'fa-newspaper',   label:'Berita'},
    {id:'eskul',    icon:'fa-medal',       label:'Eskul'},
    {id:'jadwal',   icon:'fa-calendar-alt',label:'Jadwal'},
    {id:'ppdb',     icon:'fa-clipboard-list',label:'PPDB'},
    {id:'biaya',    icon:'fa-file-invoice',label:'Biaya'},
    {id:'users',    icon:'fa-users-cog',   label:'Users',   admin:true},
    {id:'logs',     icon:'fa-history',     label:'Logs',    admin:true},
];

function buildTabs(){
    const tabs=TABS.filter(t=>!t.admin||(CURRENT_USER.role==='admin'));
    let tabHtml='', paneHtml='';
    tabs.forEach((t,i)=>{
        tabHtml+=`<div class="tab${i===0?' active':''}" data-id="${t.id}"><i class="fas ${t.icon}"></i> ${t.label}</div>`;
        paneHtml+=`<div id="pane-${t.id}" class="tab-pane${i===0?' active':''}">${buildPaneContent(t.id)}</div>`;
    });
    document.getElementById('tabsInner').innerHTML=tabHtml;
    document.getElementById('tabPanes').innerHTML=paneHtml;
    document.querySelectorAll('.tab').forEach(tab=>{
        tab.addEventListener('click',()=>{
            const id=tab.dataset.id;
            document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
            tab.classList.add('active');
            document.querySelectorAll('.tab-pane').forEach(p=>p.classList.remove('active'));
            document.getElementById(`pane-${id}`).classList.add('active');
            const loaders={profil:loadProfil,kepsek:loadKepsek,guru:loadGuruList,slider:loadSliderList,galeri:loadGaleriList,berita:loadBeritaList,eskul:loadEskulList,jadwal:loadJadwal,ppdb:loadPPDB,biaya:loadBiaya,users:loadUserList,logs:loadLogs,heroBg:loadHeroBg};
            if(loaders[id]) loaders[id]();
        });
    });
    loadProfil();
}

function buildPaneContent(id){
    if(id==='profil') return `
    <div class="d-card"><h3><i class="fas fa-globe"></i> Profil Madrasah</h3>
    <div class="f-2col"><div class="f-group"><label>Judul Madrasah</label><input id="p_title" placeholder="MIS Darul Ihya"></div><div class="f-group"><label>Tagline Header</label><input id="p_tagline" placeholder="Akreditasi A"></div></div>
    <div class="f-group"><label>Hero Tagline</label><input id="p_hero_tagline" placeholder="Slogan utama..."></div>
    <div class="f-group"><label>Logo Madrasah</label><input type="file" id="p_logo" accept="image/*"><div id="p_logo_preview"></div></div>
    <div class="f-group"><label>Tentang Kami</label><div class="rich-editor"><div class="rich-toolbar"><button onclick="ec('p_tentang','bold')"><b>B</b></button><button onclick="ec('p_tentang','italic')"><i>I</i></button><button onclick="ec('p_tentang','insertUnorderedList')">• List</button></div><div class="rich-body" id="p_tentang" contenteditable="true"></div></div></div>
    <div class="f-group"><label>Sejarah</label><div class="rich-editor"><div class="rich-toolbar"><button onclick="ec('p_sejarah','bold')"><b>B</b></button><button onclick="ec('p_sejarah','italic')"><i>I</i></button><button onclick="ec('p_sejarah','insertUnorderedList')">• List</button></div><div class="rich-body" id="p_sejarah" contenteditable="true"></div></div></div>
    <div class="f-group"><label>Visi</label><div class="rich-editor"><div class="rich-toolbar"><button onclick="ec('p_visi','bold')"><b>B</b></button><button onclick="ec('p_visi','italic')"><i>I</i></button><button onclick="ec('p_visi','insertUnorderedList')">• List</button></div><div class="rich-body" id="p_visi" contenteditable="true"></div></div></div>
    <div class="f-group"><label>Misi</label><div class="rich-editor"><div class="rich-toolbar"><button onclick="ec('p_misi','bold')"><b>B</b></button><button onclick="ec('p_misi','italic')"><i>I</i></button><button onclick="ec('p_misi','insertUnorderedList')">• List</button></div><div class="rich-body" id="p_misi" contenteditable="true"></div></div></div>
    <div class="f-group"><label>Tujuan</label><div class="rich-editor"><div class="rich-toolbar"><button onclick="ec('p_tujuan','bold')"><b>B</b></button><button onclick="ec('p_tujuan','italic')"><i>I</i></button><button onclick="ec('p_tujuan','insertUnorderedList')">• List</button></div><div class="rich-body" id="p_tujuan" contenteditable="true"></div></div></div>
    <div class="f-group"><label>Fasilitas</label><div class="rich-editor"><div class="rich-toolbar"><button onclick="ec('p_fasilitas','bold')"><b>B</b></button><button onclick="ec('p_fasilitas','italic')"><i>I</i></button><button onclick="ec('p_fasilitas','insertUnorderedList')">• List</button></div><div class="rich-body" id="p_fasilitas" contenteditable="true"></div></div></div>
    <div class="f-group"><label>Tenaga Pendidik</label><div class="rich-editor"><div class="rich-toolbar"><button onclick="ec('p_tenaga','bold')"><b>B</b></button><button onclick="ec('p_tenaga','italic')"><i>I</i></button><button onclick="ec('p_tenaga','insertUnorderedList')">• List</button></div><div class="rich-body" id="p_tenaga" contenteditable="true"></div></div></div>
    <div class="f-group"><label>Penutup</label><div class="rich-editor"><div class="rich-toolbar"><button onclick="ec('p_penutup','bold')"><b>B</b></button><button onclick="ec('p_penutup','italic')"><i>I</i></button><button onclick="ec('p_penutup','insertUnorderedList')">• List</button></div><div class="rich-body" id="p_penutup" contenteditable="true"></div></div></div>
    <div class="f-2col"><div class="f-group"><label>Alamat</label><input id="p_alamat"></div><div class="f-group"><label>Telepon</label><input id="p_telp"></div></div>
    <div class="f-2col"><div class="f-group"><label>Email</label><input id="p_email"></div><div class="f-group"><label>No. WhatsApp</label><input id="p_wa_number" placeholder="628xxx"></div></div>
    <div class="f-group"><label>Pesan WA Default</label><input id="p_wa_message"></div>
    <div class="f-group"><label>Google Maps Embed (iframe)</label><textarea id="p_maps" rows="3" placeholder="&lt;iframe src=...&gt;"></textarea></div>
    <button class="btn" onclick="saveProfil()"><i class="fas fa-save"></i> Simpan Profil</button></div>`;

    if(id==='kepsek') return `<div class="d-card"><h3><i class="fas fa-user-tie"></i> Kepala Madrasah</h3>
    <div class="f-group"><label>Nama Lengkap</label><input id="ks_nama"></div>
    <div class="f-group"><label>Motto</label><input id="ks_motto"></div>
    <div class="f-group"><label>Foto</label><input type="file" id="ks_foto_file" accept="image/*"><div id="ks_preview"></div></div>
    <button class="btn" onclick="saveKepsek()"><i class="fas fa-save"></i> Simpan</button></div>`;

    if(id==='guru') return `<div class="d-card"><h3><i class="fas fa-chalkboard-teacher"></i> Daftar Guru <button class="btn btn-sm" onclick="document.getElementById('guruModal').classList.add('open')" style="margin-left:10px"><i class="fas fa-plus"></i> Tambah Guru</button></h3><div id="guru-list" class="item-list"></div></div>`;

    if(id==='slider') return `<div class="d-card"><h3><i class="fas fa-images"></i> Slider Foto</h3>
    <div class="f-group"><label>Upload Foto Slider (bisa pilih banyak)</label><input type="file" id="slider_file" accept="image/*" multiple></div>
    <button class="btn" onclick="uploadSlider()"><i class="fas fa-upload"></i> Upload</button>
    <div id="slider-list" class="item-list"></div></div>`;

    if(id==='heroBg') return `<div class="d-card"><h3><i class="fas fa-image"></i> Foto Background Hero</h3>
    <p style="color:var(--muted);font-size:.82rem;margin-bottom:14px">Foto sekolah yang bagus akan ditampilkan sebagai latar hero halaman utama. Upload foto dengan angle dan kualitas terbaik.</p>
    <div class="f-group"><label>Upload Foto Background</label><input type="file" id="hero_bg_file" accept="image/*" onchange="uploadHeroBg(this)"></div>
    <div id="hero_bg_preview" style="margin-top:10px"></div>
    <button class="btn btn-danger btn-sm" onclick="hapusHeroBg()" style="margin-top:10px"><i class="fas fa-trash"></i> Hapus Background</button></div>`;

    if(id==='galeri') return `<div class="d-card"><h3><i class="fas fa-camera"></i> Galeri Kegiatan</h3>
    <div class="f-2col">
        <div class="f-group"><label>Upload Foto</label><input type="file" id="galeri_file" accept="image/*" multiple></div>
        <div class="f-group"><label>Keterangan Kegiatan</label><input id="galeri_ket" placeholder="Contoh: Kegiatan Pramuka 2024"></div>
    </div>
    <button class="btn" onclick="uploadGaleri()"><i class="fas fa-upload"></i> Upload</button>
    <div id="galeri-list" class="item-list"></div></div>`;

    if(id==='berita') return `<div class="d-card"><h3><i class="fas fa-newspaper"></i> Berita & Pengumuman <button class="btn btn-sm" onclick="bukaBeritaModal()" style="margin-left:10px"><i class="fas fa-plus"></i> Tambah</button></h3><div id="berita-list" class="item-list"></div></div>`;

    if(id==='eskul') return `<div class="d-card"><h3><i class="fas fa-medal"></i> Ekstrakurikuler <button class="btn btn-sm" onclick="bukaEskulModal()" style="margin-left:10px"><i class="fas fa-plus"></i> Tambah Eskul</button></h3><div id="eskul-list" class="item-list"></div></div>`;

    if(id==='jadwal') return `
    <div class="d-card"><h3><i class="fas fa-calendar-alt"></i> Jadwal Kelas 1 - 2</h3>
    <div style="overflow-x:auto"><table class="jadwal-tbl"><thead><tr><th>Hari</th><th>Mata Pelajaran</th><th>Jam</th><th>Aksi</th></tr></thead><tbody id="jadwal12Body"></tbody></table></div>
    <button class="btn btn-sec btn-sm" onclick="tambahBaris(12)"><i class="fas fa-plus"></i> Tambah Baris</button></div>
    <div class="d-card"><h3><i class="fas fa-calendar-alt"></i> Jadwal Kelas 3 - 6</h3>
    <div style="overflow-x:auto"><table class="jadwal-tbl"><thead><tr><th>Hari</th><th>Mata Pelajaran</th><th>Jam</th><th>Aksi</th></tr></thead><tbody id="jadwal36Body"></tbody></table></div>
    <button class="btn btn-sec btn-sm" onclick="tambahBaris(36)"><i class="fas fa-plus"></i> Tambah Baris</button>
    <div style="margin-top:14px"><button class="btn" onclick="saveJadwal()"><i class="fas fa-save"></i> Simpan Semua Jadwal</button></div></div>`;

    if(id==='ppdb') return `<div class="d-card"><h3><i class="fas fa-clipboard-list"></i> Data Pendaftar PPDB</h3>
    <div style="overflow-x:auto"><table class="ppdb-tbl"><thead><tr><th>No</th><th>Nama</th><th>JK</th><th>Tempat/Tgl</th><th>Alamat</th><th>HP</th><th>Ijazah</th><th>Akte</th><th>Tgl Daftar</th><th>Aksi</th></tr></thead><tbody id="ppdb-body"></tbody></table></div>
    <div style="margin-top:14px;display:flex;gap:8px;flex-wrap:wrap">
        <button class="btn btn-sec" onclick="exportExcel()"><i class="fas fa-file-excel"></i> Export Excel</button>
        <button class="btn btn-sec" onclick="exportPDF()"><i class="fas fa-file-pdf"></i> Export PDF</button>
        <button class="btn btn-danger" onclick="clearPPDB()"><i class="fas fa-trash"></i> Hapus Semua</button>
    </div></div>`;

    if(id==='biaya') return `<div class="d-card"><h3><i class="fas fa-file-invoice"></i> Pamflet Biaya</h3>
    <p style="color:var(--muted);font-size:.82rem;margin-bottom:14px">Upload foto/gambar pamflet biaya dari sekolah. Pastikan teks terbaca jelas.</p>
    <div class="f-group"><label>Upload Gambar Pamflet</label><input type="file" id="biaya_file" accept="image/*" onchange="uploadBiaya(this)"></div>
    <div id="biaya_preview" style="margin-top:10px"></div>
    <button class="btn btn-danger btn-sm" onclick="hapusBiaya()" style="margin-top:10px"><i class="fas fa-trash"></i> Hapus</button></div>`;

    if(id==='users') return `<div class="d-card"><h3><i class="fas fa-users-cog"></i> Manajemen User <button class="btn btn-sm" onclick="bukaUserModal()" style="margin-left:10px"><i class="fas fa-plus"></i> Tambah User</button></h3><div id="user-list" class="item-list"></div></div>`;

    if(id==='logs') return `<div class="d-card"><h3><i class="fas fa-history"></i> Log Aktivitas</h3>
    <div style="overflow-x:auto"><table class="log-tbl"><thead><tr><th>Waktu</th><th>User</th><th>Aksi</th><th>Detail</th></tr></thead><tbody id="log-body"></tbody></table></div>
    <button class="btn btn-danger btn-sm" onclick="clearLogs()" style="margin-top:12px"><i class="fas fa-trash"></i> Hapus Semua Log</button></div>`;

    return '';
}

function ec(id, cmd){ document.getElementById(id).focus(); document.execCommand(cmd,false,null); }

// ---- PROFIL ----
async function loadProfil(){
    const d = await fetchGet('get_public');
    const s=d.site;
    document.getElementById('p_title').value=s.title||'';
    document.getElementById('p_tagline').value=s.tagline||'';
    document.getElementById('p_hero_tagline').value=s.heroTagline||'';
    document.getElementById('p_tentang').innerHTML=s.tentang||'';
    document.getElementById('p_sejarah').innerHTML=s.sejarah||'';
    document.getElementById('p_visi').innerHTML=s.visi||'';
    document.getElementById('p_misi').innerHTML=s.misi||'';
    document.getElementById('p_tujuan').innerHTML=s.tujuan||'';
    document.getElementById('p_fasilitas').innerHTML=s.fasilitas||'';
    document.getElementById('p_tenaga').innerHTML=s.tenagaPendidik||'';
    document.getElementById('p_penutup').innerHTML=s.penutup||'';
    document.getElementById('p_alamat').value=s.kontak.alamat||'';
    document.getElementById('p_telp').value=s.kontak.telp||'';
    document.getElementById('p_email').value=s.kontak.email||'';
    document.getElementById('p_maps').value=s.kontak.maps||'';
    document.getElementById('p_wa_number').value=s.waNumber||'';
    document.getElementById('p_wa_message').value=s.waMessage||'';
    if(d.logo) document.getElementById('p_logo_preview').innerHTML=`<img src="${d.logo}" class="preview-img">`;
}
async function saveProfil(){
    const payload={
        site_title:document.getElementById('p_title').value,
        site_tagline:document.getElementById('p_tagline').value,
        site_hero_tagline:document.getElementById('p_hero_tagline').value,
        site_tentang:document.getElementById('p_tentang').innerHTML,
        site_sejarah:document.getElementById('p_sejarah').innerHTML,
        site_visi:document.getElementById('p_visi').innerHTML,
        site_misi:document.getElementById('p_misi').innerHTML,
        site_tujuan:document.getElementById('p_tujuan').innerHTML,
        site_fasilitas:document.getElementById('p_fasilitas').innerHTML,
        site_tenaga:document.getElementById('p_tenaga').innerHTML,
        site_penutup:document.getElementById('p_penutup').innerHTML,
        kontak_alamat:document.getElementById('p_alamat').value,
        kontak_telp:document.getElementById('p_telp').value,
        kontak_email:document.getElementById('p_email').value,
        kontak_maps:document.getElementById('p_maps').value,
        wa_number:document.getElementById('p_wa_number').value,
        wa_message:document.getElementById('p_wa_message').value,
    };
    const f=document.getElementById('p_logo').files[0];
    if(f){compress(f,200,async data=>{payload.logo=data;await api('save_profil',payload);document.getElementById('p_logo_preview').innerHTML=`<img src="${data}" class="preview-img">`;toast('Profil disimpan!')});}
    else{await api('save_profil',payload);toast('Profil disimpan!');}
}

// ---- KEPSEK ----
async function loadKepsek(){
    const d=await fetchGet('get_public');
    const k=d.site.kepsek;
    document.getElementById('ks_nama').value=k.nama||'';
    document.getElementById('ks_motto').value=k.motto||'';
    if(k.foto) document.getElementById('ks_preview').innerHTML=`<img src="${k.foto}" class="preview-img">`;
}
async function saveKepsek(){
    const nama=document.getElementById('ks_nama').value;
    const motto=document.getElementById('ks_motto').value;
    const f=document.getElementById('ks_foto_file').files[0];
    if(f){compress(f,300,async data=>{await api('save_kepsek',{nama,motto,foto:data});document.getElementById('ks_preview').innerHTML=`<img src="${data}" class="preview-img">`;toast('Kepsek disimpan!')});}
    else{await api('save_kepsek',{nama,motto});toast('Kepsek disimpan!');}
}

// ---- GURU ----
async function loadGuruList(){
    const arr=await fetchGet('get_guru');
    document.getElementById('guru-list').innerHTML=arr.map(g=>`
    <div class="item-card">
        <img class="item-img" src="${g.foto||'https://placehold.co/56x56/0f3d24/ffd700?text=${g.nama[0]}'}" onerror="this.src='https://placehold.co/56'">
        <div class="item-info"><div class="item-name">${esc(g.nama)}</div><div class="item-sub">${esc(g.jabatan)}</div></div>
        <div class="item-actions"><button class="btn btn-danger btn-sm" onclick="hapusGuru(${g.id})"><i class="fas fa-trash"></i></button></div>
    </div>`).join('')||'<p style="color:var(--muted);padding:10px">Belum ada guru</p>';
}
async function hapusGuru(id){if(confirm('Hapus guru ini?')){await api('delete_guru',{id});loadGuruList();toast('Guru dihapus');}}
async function simpanGuru(){
    const nama=document.getElementById('m_guru_nama').value.trim();
    const jabatan=document.getElementById('m_guru_jabatan').value.trim()||'Guru Kelas';
    const f=document.getElementById('m_guru_foto').files[0];
    if(!nama){alert('Nama wajib diisi');return;}
    if(f){compress(f,200,async data=>{await api('add_guru',{nama,jabatan,foto:data});loadGuruList();document.getElementById('guruModal').classList.remove('open');toast('Guru ditambahkan');});}
    else{await api('add_guru',{nama,jabatan,foto:null});loadGuruList();document.getElementById('guruModal').classList.remove('open');toast('Guru ditambahkan');}
    document.getElementById('m_guru_nama').value='';document.getElementById('m_guru_jabatan').value='Guru Kelas';document.getElementById('m_guru_foto').value='';
}

// ---- SLIDER ----
async function loadSliderList(){
    const arr=await fetchGet('get_slider');
    document.getElementById('slider-list').innerHTML=arr.map(s=>`
    <div class="item-card">
        <img class="item-img" src="${s.gambar}">
        <div class="item-info"><div class="item-name">Slide</div></div>
        <div class="item-actions"><button class="btn btn-danger btn-sm" onclick="hapusSlider(${s.id})"><i class="fas fa-trash"></i></button></div>
    </div>`).join('')||'<p style="color:var(--muted);padding:10px">Belum ada slider</p>';
}
async function hapusSlider(id){if(confirm('Hapus slide ini?')){await api('delete_slider',{id});loadSliderList();toast('Slide dihapus');}}
function uploadSlider(){
    const files=document.getElementById('slider_file').files;
    if(!files.length)return;
    let done=0;
    Array.from(files).forEach(f=>{compress(f,800,async data=>{await api('add_slider',{gambar:data});done++;if(done===files.length){loadSliderList();toast('Slider diupload');document.getElementById('slider_file').value='';}}); });
}

// ---- HERO BG ----
async function loadHeroBg(){
    const d=await fetchGet('get_public');
    const p=document.getElementById('hero_bg_preview');
    if(d.heroBg) p.innerHTML=`<img src="${d.heroBg}" style="max-width:100%;max-height:200px;border-radius:10px;border:1px solid var(--gold)">`;
    else p.innerHTML='<p style="color:var(--muted)">Belum ada foto background</p>';
}
function uploadHeroBg(input){
    const f=input.files[0];
    if(!f)return;
    compress(f,1200,async data=>{await api('save_profil',{hero_bg:data});document.getElementById('hero_bg_preview').innerHTML=`<img src="${data}" style="max-width:100%;max-height:200px;border-radius:10px;border:1px solid var(--gold)">`;toast('Background disimpan!');});
}
async function hapusHeroBg(){
    if(!confirm('Hapus foto background?'))return;
    await api('save_profil',{hero_bg:''});
    document.getElementById('hero_bg_preview').innerHTML='<p style="color:var(--muted)">Belum ada foto background</p>';
    toast('Background dihapus');
}

// ---- GALERI ----
async function loadGaleriList(){
    const arr=await fetchGet('get_galeri');
    document.getElementById('galeri-list').innerHTML=arr.map(g=>`
    <div class="item-card">
        <img class="item-img" src="${g.gambar}">
        <div class="item-info"><div class="item-name">${esc(g.keterangan)||'<span style="color:var(--muted)">Tanpa keterangan</span>'}</div></div>
        <div class="item-actions"><button class="btn btn-danger btn-sm" onclick="hapusGaleri(${g.id})"><i class="fas fa-trash"></i></button></div>
    </div>`).join('')||'<p style="color:var(--muted);padding:10px">Belum ada foto</p>';
}
async function hapusGaleri(id){if(confirm('Hapus foto ini?')){await api('delete_galeri',{id});loadGaleriList();toast('Foto dihapus');}}
function uploadGaleri(){
    const files=document.getElementById('galeri_file').files;
    const ket=document.getElementById('galeri_ket').value.trim();
    if(!files.length)return;
    let done=0;
    Array.from(files).forEach(f=>{compress(f,600,async data=>{await api('add_galeri',{gambar:data,keterangan:ket});done++;if(done===files.length){loadGaleriList();toast('Foto galeri diupload');document.getElementById('galeri_file').value='';document.getElementById('galeri_ket').value='';}}); });
}

// ---- BERITA ----
async function loadBeritaList(){
    const arr=await fetchGet('get_berita');
    document.getElementById('berita-list').innerHTML=arr.map(b=>`
    <div class="item-card">
        ${b.foto?`<img class="item-img" src="${b.foto}">`:`<div class="item-img" style="display:flex;align-items:center;justify-content:center;font-size:22px;background:#0f3d24">📰</div>`}
        <div class="item-info"><div class="item-name">${esc(b.judul)}</div><div class="item-sub">${esc(b.tanggal)} · ${esc(b.kategori)}</div></div>
        <div class="item-actions">
            <button class="btn btn-sec btn-sm" onclick="bukaBeritaModal(${b.id})"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger btn-sm" onclick="hapusBerita(${b.id})"><i class="fas fa-trash"></i></button>
        </div>
    </div>`).join('')||'<p style="color:var(--muted);padding:10px">Belum ada berita</p>';
}
async function hapusBerita(id){if(confirm('Hapus berita?')){await api('delete_berita',{id});loadBeritaList();toast('Berita dihapus');}}

function bukaBeritaModal(id=null){
    editBeritaId=id;
    document.getElementById('beritaModalTitle').innerText=id?'✏️ Edit Berita':'📰 Tambah Berita';
    document.getElementById('m_b_judul').value='';
    document.getElementById('m_b_tanggal').value=new Date().toISOString().slice(0,10);
    document.getElementById('m_b_kategori').value='Berita';
    document.getElementById('m_b_isi').value='';
    document.getElementById('m_b_foto').value='';
    document.getElementById('m_b_foto_preview').innerHTML='';
    if(id){
        fetchGet('get_berita').then(arr=>{
            const b=arr.find(x=>x.id==id);
            if(!b)return;
            document.getElementById('m_b_judul').value=b.judul||'';
            document.getElementById('m_b_isi').value=b.isi||'';
            document.getElementById('m_b_kategori').value=b.kategori||'Berita';
            if(b.tanggal&&b.tanggal.includes('/')) document.getElementById('m_b_tanggal').value=b.tanggal.split('/').reverse().join('-');
            if(b.foto) document.getElementById('m_b_foto_preview').innerHTML=`<img src="${b.foto}" class="preview-img">`;
        });
    }
    document.getElementById('beritaModal').classList.add('open');
}
document.getElementById('m_b_foto').addEventListener('change',function(){
    const f=this.files[0];
    if(!f)return;
    compress(f,800,data=>{document.getElementById('m_b_foto_preview').innerHTML=`<img src="${data}" class="preview-img">`;this._b64=data;});
});

async function simpanBerita(){
    const judul=document.getElementById('m_b_judul').value.trim();
    const isi=document.getElementById('m_b_isi').value.trim();
    const tanggalRaw=document.getElementById('m_b_tanggal').value;
    const kategori=document.getElementById('m_b_kategori').value;
    const fotoInput=document.getElementById('m_b_foto');
    if(!judul||!isi){alert('Judul dan isi harus diisi');return;}
    const tanggal=tanggalRaw.split('-').reverse().join('/');
    let foto=fotoInput._b64||null;
    const payload={judul,tanggal,kategori,isi};
    if(foto) payload.foto=foto;
    if(editBeritaId){payload.id=editBeritaId;await api('edit_berita',payload);}
    else{await api('add_berita',payload);}
    loadBeritaList();
    document.getElementById('beritaModal').classList.remove('open');
    fotoInput._b64=null;
    toast('Berita disimpan!');
}

// ---- ESKUL ----
async function loadEskulList(){
    const arr=await fetchGet('get_eskul');
    document.getElementById('eskul-list').innerHTML=arr.map(e=>`
    <div class="item-card">
        ${e.foto?`<img class="item-img" src="${e.foto}">`:`<div class="item-img" style="display:flex;align-items:center;justify-content:center;font-size:24px;background:#0f3d24">🎽</div>`}
        <div class="item-info"><div class="item-name">${esc(e.nama)}</div><div class="item-sub">${esc((e.deskripsi||'').substring(0,60))}</div></div>
        <div class="item-actions">
            <button class="btn btn-sec btn-sm" onclick="bukaEskulModal(${e.id})"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger btn-sm" onclick="hapusEskul(${e.id})"><i class="fas fa-trash"></i></button>
        </div>
    </div>`).join('')||'<p style="color:var(--muted);padding:10px">Belum ada eskul</p>';
}
async function hapusEskul(id){if(confirm('Hapus eskul?')){await api('delete_eskul',{id});loadEskulList();toast('Eskul dihapus');}}

function bukaEskulModal(id=null){
    editEskulId=id;
    document.getElementById('eskulModalTitle').innerText=id?'✏️ Edit Eskul':'🎽 Tambah Eskul';
    document.getElementById('m_e_nama').value='';
    document.getElementById('m_e_deskripsi').value='';
    document.getElementById('m_e_foto').value='';
    if(id){
        fetchGet('get_eskul').then(arr=>{
            const e=arr.find(x=>x.id==id);
            if(e){document.getElementById('m_e_nama').value=e.nama||'';document.getElementById('m_e_deskripsi').value=e.deskripsi||'';}
        });
    }
    document.getElementById('eskulModal').classList.add('open');
}
async function simpanEskul(){
    const nama=document.getElementById('m_e_nama').value.trim();
    const deskripsi=document.getElementById('m_e_deskripsi').value.trim();
    const f=document.getElementById('m_e_foto').files[0];
    if(!nama){alert('Nama eskul wajib diisi');return;}
    const doSave=async(foto=null)=>{
        const p={nama,deskripsi};if(foto)p.foto=foto;if(editEskulId)p.id=editEskulId;
        await api(editEskulId?'edit_eskul':'add_eskul',p);
        loadEskulList();document.getElementById('eskulModal').classList.remove('open');toast('Eskul disimpan!');
    };
    if(f) compress(f,400,data=>doSave(data));
    else doSave();
}

// ---- JADWAL ----
async function loadJadwal(){
    const d=await fetchGet('get_public');
    JADWAL12=d.jadwal12.map(r=>({hari:r[0],mapel:r[1],jam:r[2]}));
    JADWAL36=d.jadwal36.map(r=>({hari:r[0],mapel:r[1],jam:r[2]}));
    renderJadwal();
}
function renderJadwal(){
    const mkRow=(arr,prefix)=>arr.map((_,i)=>`<tr>
        <td><input id="${prefix}_h${i}" value="${esc(arr[i].hari)}" placeholder="Hari"></td>
        <td><input id="${prefix}_m${i}" value="${esc(arr[i].mapel)}" placeholder="Mata Pelajaran"></td>
        <td><input id="${prefix}_j${i}" value="${esc(arr[i].jam)}" placeholder="07:00-08:30"></td>
        <td><button class="btn btn-danger btn-sm" onclick="hapusBaris('${prefix}',${i})"><i class="fas fa-times"></i></button></td>
    </tr>`).join('');
    document.getElementById('jadwal12Body').innerHTML=mkRow(JADWAL12,'j12');
    document.getElementById('jadwal36Body').innerHTML=mkRow(JADWAL36,'j36');
}
function tambahBaris(kelas){if(kelas===12)JADWAL12.push({hari:'',mapel:'',jam:''});else JADWAL36.push({hari:'',mapel:'',jam:''});renderJadwal();}
function hapusBaris(prefix,i){if(prefix==='j12')JADWAL12.splice(i,1);else JADWAL36.splice(i,1);renderJadwal();}
async function saveJadwal(){
    const read=(arr,p)=>arr.map((_,i)=>[document.getElementById(`${p}_h${i}`)?.value||'',document.getElementById(`${p}_m${i}`)?.value||'',document.getElementById(`${p}_j${i}`)?.value||'']).filter(r=>r.some(v=>v));
    const j12=read(JADWAL12,'j12'),j36=read(JADWAL36,'j36');
    await api('save_jadwal',{jadwal12:j12,jadwal36:j36});
    JADWAL12=j12.map(r=>({hari:r[0],mapel:r[1],jam:r[2]}));
    JADWAL36=j36.map(r=>({hari:r[0],mapel:r[1],jam:r[2]}));
    renderJadwal();toast('Jadwal disimpan!');
}

// ---- PPDB ----
async function loadPPDB(){
    PPDB_DATA=await fetchGet('get_ppdb');
    document.getElementById('ppdb-body').innerHTML=PPDB_DATA.map((p,i)=>`<tr>
        <td>${i+1}</td><td>${esc(p.nama)}</td><td>${esc(p.jk)}</td>
        <td>${esc(p.tempat)}<br>${esc(p.tgl)}</td><td>${esc(p.alamat)}</td><td>${esc(p.hp)}</td>
        <td>${p.ijazah?`<a href="${p.ijazah}" target="_blank" style="color:var(--gold)">Lihat</a>`:'-'}</td>
        <td>${p.akte?`<a href="${p.akte}" target="_blank" style="color:var(--gold)">Lihat</a>`:'-'}</td>
        <td>${esc(p.tanggal_daftar)}</td>
        <td><button class="btn btn-danger btn-sm" onclick="hapusPPDB(${p.id})"><i class="fas fa-trash"></i></button></td>
    </tr>`).join('')||`<tr><td colspan="10" style="text-align:center;color:var(--muted);padding:20px">Belum ada pendaftar</td></tr>`;
}
async function hapusPPDB(id){if(confirm('Hapus data pendaftar ini?')){await api('delete_ppdb',{id});loadPPDB();toast('Data dihapus');}}
async function clearPPDB(){if(confirm('Hapus SEMUA data PPDB? Tidak bisa dibatalkan!')){await api('clear_ppdb');loadPPDB();toast('Semua data dihapus');}}
function exportExcel(){
    let data=[['No','Nama','JK','Tempat Lahir','Tanggal Lahir','Alamat','HP','Ijazah','Akte','Tanggal Daftar']];
    PPDB_DATA.forEach((p,i)=>data.push([i+1,p.nama,p.jk,p.tempat,p.tgl,p.alamat,p.hp,p.ijazah?'Ada':'-',p.akte?'Ada':'-',p.tanggal_daftar]));
    const wb=XLSX.utils.book_new(),ws=XLSX.utils.aoa_to_sheet(data);
    XLSX.utils.book_append_sheet(wb,ws,'PPDB');
    XLSX.writeFile(wb,`ppdb_${new Date().toISOString().slice(0,10)}.xlsx`);
}
function exportPDF(){
    const w=window.open('','_blank');
    let html=`<html><head><title>Data PPDB MIS Darul Ihya</title><style>body{font-family:sans-serif}table{width:100%;border-collapse:collapse}th,td{border:1px solid #ccc;padding:6px 10px;font-size:12px}th{background:#0a2a1a;color:#ffd700}</style></head><body><h2>Data PPDB MIS Darul Ihya</h2><p>Dicetak: ${new Date().toLocaleDateString('id-ID')}</p><table><tr><th>No</th><th>Nama</th><th>JK</th><th>Tempat/Tgl</th><th>Alamat</th><th>HP</th></tr>`;
    PPDB_DATA.forEach((p,i)=>{html+=`<tr><td>${i+1}</td><td>${p.nama}</td><td>${p.jk}</td><td>${p.tempat} ${p.tgl}</td><td>${p.alamat}</td><td>${p.hp}</td></tr>`;});
    html+=`</table></body></html>`;
    w.document.write(html);w.print();
}

// ---- BIAYA ----
async function loadBiaya(){
    const d=await fetchGet('get_public');
    const p=document.getElementById('biaya_preview');
    if(d.biayaGambar) p.innerHTML=`<img src="${d.biayaGambar}" style="max-width:100%;max-height:250px;border-radius:10px;border:1px solid var(--gold)">`;
    else p.innerHTML='<p style="color:var(--muted)">Belum ada pamflet biaya</p>';
}
function uploadBiaya(input){
    const f=input.files[0];
    if(!f)return;
    compress(f,800,async data=>{await api('save_biaya',{gambar:data});document.getElementById('biaya_preview').innerHTML=`<img src="${data}" style="max-width:100%;max-height:250px;border-radius:10px;border:1px solid var(--gold)">`;toast('Biaya disimpan!');});
}
async function hapusBiaya(){if(!confirm('Hapus gambar biaya?'))return;await api('delete_biaya');document.getElementById('biaya_preview').innerHTML='<p style="color:var(--muted)">Belum ada pamflet biaya</p>';toast('Biaya dihapus');}

// ---- USERS ----
async function loadUserList(){
    const arr=await fetchGet('get_users');
    document.getElementById('user-list').innerHTML=arr.map(u=>`
    <div class="item-card">
        <div class="item-img" style="display:flex;align-items:center;justify-content:center;font-size:22px;background:#0f3d24;flex-shrink:0">👤</div>
        <div class="item-info">
            <div class="item-name">${esc(u.username)}</div>
            <div class="item-sub">Role: ${u.role} · Status: ${u.status==='aktif'?'✅ Aktif':'⛔ Nonaktif'}</div>
        </div>
        <div class="item-actions">
            <button class="btn btn-sec btn-sm" onclick="bukaUserModal(${u.id})"><i class="fas fa-edit"></i></button>
            ${u.id!=1?`<button class="btn btn-sec btn-sm" onclick="toggleUser(${u.id})"><i class="fas fa-toggle-on"></i></button><button class="btn btn-danger btn-sm" onclick="hapusUser(${u.id})"><i class="fas fa-trash"></i></button>`:''}
        </div>
    </div>`).join('')||'<p style="color:var(--muted);padding:10px">Belum ada user</p>';
}
function bukaUserModal(id=null){
    editUserId=id;
    document.getElementById('userModalTitle').innerText=id?'✏️ Edit User':'👤 Tambah User';
    document.getElementById('m_u_username').value='';document.getElementById('m_u_password').value='';
    document.getElementById('m_u_role').value='staff';document.getElementById('m_u_status').value='aktif';
    if(id){fetchGet('get_users').then(arr=>{const u=arr.find(x=>x.id==id);if(u){document.getElementById('m_u_username').value=u.username;document.getElementById('m_u_role').value=u.role;document.getElementById('m_u_status').value=u.status;}});}
    document.getElementById('userModal').classList.add('open');
}
async function simpanUser(){
    const username=document.getElementById('m_u_username').value.trim();
    const password=document.getElementById('m_u_password').value;
    const role=document.getElementById('m_u_role').value;
    const status=document.getElementById('m_u_status').value;
    if(!username){alert('Username wajib diisi');return;}
    if(!editUserId&&!password){alert('Password wajib untuk user baru');return;}
    const p=editUserId?{id:editUserId,username,password,role,status}:{username,password,role,status};
    const r=await api(editUserId?'edit_user':'add_user',p);
    if(r.error){alert(r.error);return;}
    loadUserList();document.getElementById('userModal').classList.remove('open');toast('User disimpan!');
}
async function hapusUser(id){if(confirm('Hapus user ini?')){const r=await api('delete_user',{id});if(r.error)alert(r.error);else{loadUserList();toast('User dihapus');}}}
async function toggleUser(id){await api('toggle_user',{id});loadUserList();}

// ---- LOGS ----
async function loadLogs(){
    const arr=await fetchGet('get_logs');
    document.getElementById('log-body').innerHTML=arr.map(l=>`<tr><td>${esc(l.waktu)}</td><td>${esc(l.username)}</td><td>${esc(l.action)}</td><td>${esc(l.detail||'')}</td></tr>`).join('')||`<tr><td colspan="4" style="text-align:center;color:var(--muted)">Belum ada log</td></tr>`;
}
async function clearLogs(){if(confirm('Hapus semua log?')){await api('clear_logs');loadLogs();toast('Log dihapus');}}
</script>
</body>
</html>
