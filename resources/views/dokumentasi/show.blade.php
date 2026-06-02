@extends('layouts.app')

@section('content')

<style>
.wrapper{
    font-family:'Segoe UI', Arial, sans-serif;
    background:#f5f7fb;
    min-height:100vh;
    padding:20px;
}

.page-title{
    font-size:38px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:6px;
}

.page-subtitle{
    font-size:15px;
    color:#64748b;
    margin-bottom:28px;
}

.top-actions{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
    margin-bottom:28px;
    flex-wrap:wrap;
}

.search-box{
    position:relative;
    width:420px;
    max-width:100%;
}

.search-box input{
    width:100%;
    padding:14px 16px 14px 46px;
    border:1px solid #dbe2ea;
    border-radius:14px;
    background:white;
    font-size:14px;
    outline:none;
}

.search-icon{
    position:absolute;
    left:16px;
    top:50%;
    transform:translateY(-50%);
    color:#64748b;
}

.upload-btn{
    background:#2563eb;
    color:white;
    border:none;
    padding:14px 20px;
    border-radius:14px;
    font-weight:700;
    cursor:pointer;
}

.file-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
    gap:24px;
}

.file-card,
.folder-card{
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 6px 24px rgba(15,23,42,0.08);
    transition:.25s;
}

.file-card:hover,
.folder-card:hover{
    transform:translateY(-5px);
}

.folder-card{
    padding:28px;
    text-decoration:none;
    color:#0f172a;
}

.folder-icon{
    font-size:56px;
    margin-bottom:18px;
}

.folder-title{
    font-size:18px;
    font-weight:800;
    margin-bottom:14px;
}

.folder-badge{
    display:inline-block;
    padding:8px 14px;
    border-radius:999px;
    background:#ede9fe;
    color:#6d28d9;
    font-size:12px;
    font-weight:700;
}

.file-image{
    width:100%;
    height:220px;
    object-fit:cover;
    background:#f1f5f9;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:70px;
}

.file-body{
    padding:18px;
}

.file-name{
    font-size:14px;
    font-weight:700;
    color:#0f172a;
    margin-bottom:8px;
    min-height:40px;
}

.file-date{
    font-size:12px;
    color:#64748b;
    margin-bottom:16px;
}

.file-actions{
    display:flex;
    gap:10px;
}

.btn{
    flex:1;
    text-align:center;
    padding:10px;
    border-radius:12px;
    text-decoration:none;
    font-size:13px;
    font-weight:700;
    border:none;
    cursor:pointer;
}

.btn-view{
    background:#2563eb;
    color:white;
}

.btn-delete{
    background:#ef4444;
    color:white;
}

.empty-box{
    background:white;
    padding:40px;
    border-radius:20px;
    text-align:center;
    color:#64748b;
}

.modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(15,23,42,0.55);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:9999;
}

.show-modal{
    display:flex;
}

.modal-box{
    background:white;
    width:100%;
    max-width:540px;
    border-radius:20px;
    overflow:hidden;
}

.modal-header{
    padding:22px;
    border-bottom:1px solid #e5e7eb;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.modal-title{
    font-size:20px;
    font-weight:800;
}

.modal-close{
    font-size:24px;
    cursor:pointer;
}

.modal-body{
    padding:24px;
}

.form-group{
    margin-bottom:18px;
}

.form-label{
    font-size:14px;
    font-weight:700;
    margin-bottom:8px;
    display:block;
}

.form-input{
    width:100%;
    padding:14px 16px;
    border:1px solid #dbe2ea;
    border-radius:14px;
    outline:none;
}

.suggestion-box{
    margin-top:8px;
    background:white;
    border:1px solid #dbe2ea;
    border-radius:14px;
    max-height:220px;
    overflow-y:auto;
    display:none;
}

.suggestion-item{
    padding:14px 16px;
    cursor:pointer;
    border-bottom:1px solid #f1f5f9;
}

.suggestion-item:hover{
    background:#f8fafc;
}

.submit-btn{
    width:100%;
    padding:14px;
    border:none;
    border-radius:14px;
    background:#2563eb;
    color:white;
    font-weight:800;
    cursor:pointer;
}
</style>

<div class="wrapper">

    <div class="page-title">
        {{ ucwords(str_replace('-', ' ', $modul)) }}
    </div>

    <div class="page-subtitle">
        Dokumentasi kegiatan {{ str_replace('-', ' ', $modul) }}
    </div>

    <div class="top-actions">

        <div class="search-box">
            <div class="search-icon">🔍</div>
            <input type="text" id="searchInput" placeholder="Cari dokumentasi...">
        </div>

        <button type="button" class="upload-btn" id="openUploadModal">
            + Upload Dokumentasi
        </button>

    </div>

    <div class="file-grid">

        @if($modul == 'desa-bersinar' && !isset($desa))

            @forelse($data as $item)

                <a href="/files/{{ $modul }}/{{ urlencode($item->nama_desa) }}"
                   class="folder-card item-card">

                    <div class="folder-icon">🏠</div>

                    <div class="folder-title">
                        {{ $item->nama_desa }}
                    </div>

                    <span class="folder-badge">
                        {{ \App\Models\Dokumentasi::where('modul','desa-bersinar')->where('nama_desa',$item->nama_desa)->count() }} File
                    </span>

                </a>

            @empty

                <div class="empty-box">
                    Belum ada dokumentasi.
                </div>

            @endforelse

        @else

            @forelse($data as $item)

                @php
                    $ext = strtolower(pathinfo($item->file, PATHINFO_EXTENSION));
                @endphp

                <div class="file-card item-card">
                @if(in_array($ext, ['jpg','jpeg','png','webp','gif']))
                        <img src="/uploads/{{ $item->file }}" class="file-image">
                    @elseif($ext == 'pdf')
                        <div class="file-image">📄</div>
                    @elseif(in_array($ext, ['doc','docx']))
                        <div class="file-image">📝</div>
                    @else
                        <div class="file-image">📁</div>
                    @endif

                    <div class="file-body">

                        <div class="file-name">
                            @if($modul == 'test-urine')
                                {{ $item->testUrine->nama_instansi ?? 'Kegiatan Test Urine' }}

                            @elseif($modul == 'penyuluhan')
                                {{ $item->penyuluhan->nama_tempat ?? 'Kegiatan Penyuluhan' }}

                            @elseif($modul == 'desa-bersinar')
                                {{ $item->detailDesa->kegiatan ?? 'Kegiatan Desa Bersinar' }}

                            @endif
                        </div>

                        <div class="file-date">
                            Upload: {{ $item->created_at->format('d M Y') }}
                        </div>

                        <div class="file-actions">

                            <a href="/uploads/{{ $item->file }}"
                               target="_blank"
                               class="btn btn-view">
                                Lihat
                            </a>

                            <form action="/files/{{ $item->id }}"
                                  method="POST"
                                  style="flex:1;">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-delete">
                                    Hapus
                                </button>
                            </form>

                        </div>

                    </div>

                </div>

            @empty

                <div class="empty-box">
                    Belum ada dokumentasi.
                </div>

            @endforelse

        @endif

    </div>

</div>

<!-- MODAL -->
<div class="modal-overlay" id="uploadModal">

    <div class="modal-box">

        <div class="modal-header">
            <div class="modal-title">
                Upload Dokumentasi
            </div>

            <div class="modal-close" id="closeUploadModal">
                ×
            </div>
        </div>

        <div class="modal-body">

            <form action="/files" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="modul" value="{{ $modul }}">
                <input type="hidden" name="kegiatan_id" id="kegiatanId">

                @if($modul == 'desa-bersinar')
                    <input type="hidden"
                           name="nama_desa"
                           value="{{ $desa ?? '' }}">
                @endif

                @if($modul != 'desa-bersinar')

                    <div class="form-group">
                        <label class="form-label">
                            Cari Kegiatan
                        </label>

                        <input type="text"
                               id="searchKegiatan"
                               class="form-input"
                               placeholder="Ketik nama kegiatan...">

                        <div class="suggestion-box" id="suggestionBox"></div>
                    </div>

                @endif

                <div class="form-group">
                    <label class="form-label">
                        Upload File
                    </label>

                    <input type="file"
                           name="file"
                           class="form-input"
                           required>
                </div>

                <button type="submit" class="submit-btn">
                    Simpan Dokumentasi
                </button>

            </form>

        </div>

    </div>

</div>

<script>
const searchInput = document.getElementById('searchInput');

if(searchInput){
    searchInput.addEventListener('keyup', function(){
        const keyword = this.value.toLowerCase();
        const items = document.querySelectorAll('.item-card');

        items.forEach(item => {
            const text = item.innerText.toLowerCase();
            item.style.display = text.includes(keyword) ? '' : 'none';
        });
    });
}

/* MODAL */
const uploadModal = document.getElementById('uploadModal');
const openUploadModal = document.getElementById('openUploadModal');
const closeUploadModal = document.getElementById('closeUploadModal');

if(openUploadModal){
    openUploadModal.addEventListener('click', function(){
        uploadModal.classList.add('show-modal');
    });
}

if(closeUploadModal){
    closeUploadModal.addEventListener('click', function(){
        uploadModal.classList.remove('show-modal');
    });
}

if(uploadModal){
    uploadModal.addEventListener('click', function(e){
        if(e.target === uploadModal){
            uploadModal.classList.remove('show-modal');
        }
    });
}

/* AUTOCOMPLETE */
const searchKegiatan = document.getElementById('searchKegiatan');
const suggestionBox = document.getElementById('suggestionBox');
const kegiatanId = document.getElementById('kegiatanId');

if(searchKegiatan){

    searchKegiatan.addEventListener('keyup', function(){

        const keyword = this.value;

        if(keyword.length < 2){
            suggestionBox.style.display = 'none';
            suggestionBox.innerHTML = '';
            return;
        }

        fetch(`/files/search-kegiatan?modul={{ $modul }}&keyword=${keyword}`)
            .then(res => res.json())
            .then(data => {

                suggestionBox.innerHTML = '';

                if(data.length === 0){
                    suggestionBox.style.display = 'none';
                    return;
                }

                suggestionBox.style.display = 'block';

                data.forEach(item => {

                    const div = document.createElement('div');
                    div.className = 'suggestion-item';

                    div.innerText = item.label;

                    div.addEventListener('click', function(){

                        searchKegiatan.value = item.label;
                        kegiatanId.value = item.id;
                        suggestionBox.style.display = 'none';

                    });

                    suggestionBox.appendChild(div);

                });

            });

    });

}
</script>

@endsection