@extends('layouts.app')

@section('content')

<style>
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:24px;
    gap:20px;
    flex-wrap:wrap;
}

.page-title-wrap h1{
    font-size:30px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:6px;
    letter-spacing:-0.5px;
}

.page-title-wrap p{
    font-size:14px;
    color:#64748b;
}

.btn-add{
    background:#16a34a;
    color:white;
    border:none;
    padding:12px 18px;
    border-radius:12px;
    font-size:14px;
    font-weight:700;
    cursor:pointer;
    display:flex;
    align-items:center;
    gap:10px;
    transition:.2s;
}

.btn-add:hover{
    background:#15803d;
}

.btn-primary{
    background:#2563eb;
    color:white;
    border:none;
    padding:12px 16px;
    border-radius:12px;
    font-size:14px;
    font-weight:700;
    cursor:pointer;
}

.btn-secondary{
    background:#64748b;
    color:white;
    border:none;
    padding:12px 16px;
    border-radius:12px;
    font-size:14px;
    font-weight:700;
    cursor:pointer;
}

.table-card{
    background:white;
    border:1px solid #e2e8f0;
    border-radius:20px;
    overflow:hidden;
}

.info-card{
    background:white;
    border:1px solid #e2e8f0;
    border-radius:20px;
    padding:24px;
    margin-bottom:20px;
}

.info-text{
    font-size:15px;
    line-height:1.9;
    color:#475569;
}

.info-text b{
    color:#0f172a;
}

.section-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 24px;
    border-bottom:1px solid #e2e8f0;
}

.section-title{
    font-size:18px;
    font-weight:800;
    color:#0f172a;
}

.table-wrap{
    overflow-x:auto;
}

.data-table{
    width:100%;
    border-collapse:collapse;
}

.data-table thead th{
    background:#eff6ff;
    color:#1e3a8a;
    font-size:13px;
    font-weight:800;
    padding:18px 22px;
    text-align:left;
    border-bottom:1px solid #cbd5e1;
    border-right:1px solid #dbeafe;
    white-space:nowrap;
}

.data-table thead th:last-child{
    border-right:none;
}

.data-table tbody td{
    padding:18px 22px;
    border-bottom:1px solid #e2e8f0;
    border-right:1px solid #f1f5f9;
    vertical-align:middle;
    font-size:14px;
    color:#334155;
}

.data-table tbody td:last-child{
    border-right:none;
}

.data-table tbody tr:hover{
    background:#f8fafc;
}

.action-cell{
    text-align:center;
    width:120px;
}

.empty-state{
    text-align:center;
    padding:60px 20px;
    color:#64748b;
    font-size:14px;
}

/* MODAL */
.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(15,23,42,0.55);
    z-index:9999;
    align-items:center;
    justify-content:center;
    padding:20px;
}

.modal.show{
    display:flex;
}

.modal-box{
    background:white;
    width:100%;
    max-width:650px;
    border-radius:20px;
    padding:24px;
    box-shadow:0 25px 60px rgba(15,23,42,0.18);
}

.modal-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:22px;
}

.modal-title{
    font-size:20px;
    font-weight:800;
    color:#0f172a;
}

.modal-close{
    width:40px;
    height:40px;
    border:none;
    background:#f8fafc;
    border-radius:12px;
    cursor:pointer;
    font-size:16px;
}

.modal-form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}

.modal-form-grid input,
.modal-form-grid select{
    width:100%;
    padding:12px 14px;
    border:1px solid #dbe2ea;
    border-radius:12px;
    font-size:14px;
    background:white;
    outline:none;
}

.modal-footer{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:22px;
}

@media(max-width:768px){
    .modal-form-grid{
        grid-template-columns:1fr;
    }
}
</style>


<div class="page-header">
    <div class="page-title-wrap">
        <h1>Detail Penyuluhan</h1>
        <p>Informasi detail kegiatan penyuluhan SIPARAMA</p>
    </div>

    <button type="button"
            onclick="openModal()"
            class="btn-add">
        <i class="fa-solid fa-plus"></i>
        Tambah Detail
    </button>
</div>


<div class="info-card">
    <div class="info-text">
        Kegiatan penyuluhan yang dilakukan di
        <b>{{ $data->nama_tempat }}</b>
        dengan sasaran
        <b>{{ $data->sasaran }}</b>
        telah dilaksanakan dengan jumlah sebaran sebanyak
        <b>{{ $data->jumlah_sebaran }} orang</b>.
        Kegiatan ini bertujuan untuk memberikan edukasi
        dan meningkatkan pemahaman peserta mengenai
        bahaya penyalahgunaan narkoba serta pentingnya
        menjaga lingkungan yang sehat dan bebas dari narkotika.
    </div>
</div>


<div class="table-card">

    <div class="section-header">
        <div class="section-title">
            Detail Kegiatan Penyuluhan
        </div>
    </div>

    <div class="table-wrap">

        <table class="data-table">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Media</th>
                    <th>Jenis Kegiatan</th>
                    <th>Jumlah Paket</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                        @forelse($data->detail as $item)

<tr>

    <td>{{ $loop->iteration }}</td>

    <td>{{ $item->jenis_media }}</td>

    <td>{{ $item->jenis_kegiatan }}</td>

    <td>{{ $item->jumlah_paket }}</td>

    <td class="action-cell">

        <div style="display:flex; justify-content:center; gap:8px;">

            <button type="button"
                    onclick='editDetail(
                        "{{ $item->id }}",
                        @json($item->jenis_media),
                        @json($item->jenis_kegiatan),
                        @json($item->jumlah_paket)
                    )'
                    style="
                        width:38px;
                        height:38px;
                        border:none;
                        border-radius:10px;
                        background:#dbeafe;
                        color:#2563eb;
                        cursor:pointer;
                    ">
                <i class="fa-solid fa-pen"></i>
            </button>

            <form action="/detail-penyuluhan/{{ $item->id }}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit"
                        onclick="return confirm('Yakin hapus detail?')"
                        style="
                            width:38px;
                            height:38px;
                            border:none;
                            border-radius:10px;
                            background:#fee2e2;
                            color:#dc2626;
                            cursor:pointer;
                        ">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>

        </div>

    </td>

</tr>

@empty

<tr>
    <td colspan="5" class="empty-state">
        Belum ada detail kegiatan
    </td>
</tr>

@endforelse

            </tbody>

        </table>

    </div>

</div>


<!-- MODAL TAMBAH -->
<div class="modal" id="modalForm">

    <div class="modal-box">

        <div class="modal-header">
            <div class="modal-title">
                Tambah Detail Kegiatan
            </div>

            <button type="button"
                    class="modal-close"
                    onclick="closeModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="/penyuluhan/{{ $data->id }}/detail" method="POST">
            @csrf

            <div class="modal-form-grid">

                <select name="jenis_media" required>
                    <option value="">Pilih Jenis Media</option>
                    <option value="Konvensional">Konvensional</option>
                    <option value="Cetak">Cetak</option>
                    <option value="Penyiaran">Penyiaran</option>
                    <option value="Online">Online</option>
                </select>

                <input type="text"
                       name="jenis_kegiatan"
                       placeholder="Jenis Kegiatan"
                       required>

                <input type="number"
                       name="jumlah_paket"
                       placeholder="Jumlah Paket"
                       required>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn-secondary"
                        onclick="closeModal()">
                    Batal
                </button>

                <button type="submit"
                        class="btn-primary">
                    Simpan Detail
                </button>

            </div>

        </form>

    </div>

</div>


<!-- MODAL EDIT -->
<div class="modal" id="editModal">

    <div class="modal-box">

        <div class="modal-header">
            <div class="modal-title">
                Edit Detail Kegiatan
            </div>

            <button type="button"
                    class="modal-close"
                    onclick="closeEditModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-form-grid">

                <select name="jenis_media"
                        id="edit_jenis_media"
                        required>

                    <option value="Konvensional">Konvensional</option>
                    <option value="Cetak">Cetak</option>
                    <option value="Penyiaran">Penyiaran</option>
                    <option value="Online">Online</option>

                </select>

                <input type="text"
                       name="jenis_kegiatan"
                       id="edit_jenis_kegiatan"
                       required>

                <input type="number"
                       name="jumlah_paket"
                       id="edit_jumlah_paket"
                       required>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn-secondary"
                        onclick="closeEditModal()">
                    Batal
                </button>

                <button type="submit"
                        class="btn-primary">
                    Update Detail
                </button>

            </div>

        </form>

    </div>

</div>

<script>
function openModal(){
    document.getElementById('modalForm').classList.add('show');
}

function closeModal(){
    document.getElementById('modalForm').classList.remove('show');
}

function editDetail(id, media, kegiatan, jumlah){

    document.getElementById('editModal').classList.add('show');

    document.getElementById('editForm').action =
        '/detail-penyuluhan/' + id;

    document.getElementById('edit_jenis_media').value = media;
    document.getElementById('edit_jenis_kegiatan').value = kegiatan;
    document.getElementById('edit_jumlah_paket').value = jumlah;
}

function closeEditModal(){
    document.getElementById('editModal').classList.remove('show');
}

document.addEventListener('click', function(e){

    if(e.target.id === 'modalForm'){
        closeModal();
    }

    if(e.target.id === 'editModal'){
        closeEditModal();
    }

});

/* SUCCESS ALERT */
@if(session('success'))
Swal.fire({
    icon:'success',
    title:'Berhasil',
    text:'{{ session('success') }}',
    confirmButtonColor:'#2563eb',
    background:'#ffffff'
});
@endif

/* ERROR ALERT */
@if(session('error'))
Swal.fire({
    icon:'error',
    title:'Gagal',
    text:'{{ session('error') }}',
    confirmButtonColor:'#dc2626',
    background:'#ffffff'
});
@endif

/* VALIDATION ALERT */
@if($errors->any())
Swal.fire({
    icon:'error',
    title:'Validasi Gagal',
    text:'{{ $errors->first() }}',
    confirmButtonColor:'#dc2626',
    background:'#ffffff'
});
@endif
</script>

@endsection