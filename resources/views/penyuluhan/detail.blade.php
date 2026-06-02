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
                </tr>
            </thead>

            <tbody>

                        @forelse($data->detail as $item)

<tr>

    <td>{{ $loop->iteration }}</td>

    <td>{{ $item->jenis_media }}</td>

    <td>{{ $item->jenis_kegiatan }}</td>

    <td>{{ $item->jumlah_paket }}</td>

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


<script>

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