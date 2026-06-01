@extends('layouts.app')

@section('content')

<style>
    .page-title{
        font-size:32px;
        font-weight:800;
        color: #5277cd;
        margin-bottom:24px;
    }

    /* CARD UTAMA */
        .about-wrapper{
        position:relative;
        background:
            linear-gradient(
                rgba(255,255,255,0.83),
                rgba(255,255,255,0.90)
            ),
            url('{{ asset("images/BNN.png") }}');

        background-size:100%;
        background-position:center top;
        background-repeat:no-repeat;

        border:1px solid #6580a4;
        border-radius:24px;
        padding:40px;
        box-shadow:0 10px 30px rgba(15,23,42,0.04);
        margin-bottom:30px;
        min-height:420px;
    }

   .about-title{
    position:relative;
    z-index:2;
    font-size:36px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:24px;
}

   .about-text{
    position:relative;
    z-index:2;
    font-size:15px;
    line-height:1.9;
    color:#1e293b;
    text-align:justify;
    width:85%;
}

    /* CARD PROGRAM */
    .program-grid{
        display:grid;
        grid-template-columns:repeat(4,1fr);
        gap:20px;
    }

    .program-card{
        background:#ffffff;
        border:1px solid #e2e8f0;
        border-radius:20px;
        padding:28px 22px;
        text-align:center;
        box-shadow:0 10px 25px rgba(15,23,42,0.04);
        transition:.2s;
    }

    .program-card:hover{
        transform:translateY(-5px);
    }

    .program-icon{
        width:80px;
        height:80px;
        border-radius:50%;
        margin:0 auto 20px;
        display:flex;
        justify-content:center;
        align-items:center;
        font-size:30px;
    }

    .blue{
        background:#eff6ff;
        color:#2563eb;
    }

    .green{
        background:#ecfdf5;
        color:#16a34a;
    }

    .purple{
        background:#faf5ff;
        color:#9333ea;
    }

    .orange{
        background:#fff7ed;
        color:#ea580c;
    }

    .program-title{
        font-size:22px;
        font-weight:800;
        color:#0f172a;
        margin-bottom:14px;
    }

    .program-text{
        font-size:14px;
        line-height:1.8;
        color:#64748b;
        min-height:110px;
    }

    .program-btn{
        display:inline-block;
        margin-top:20px;
        padding:12px 20px;
        border-radius:12px;
        font-size:14px;
        font-weight:700;
        text-decoration:none;
        transition:.2s;
    }

    .btn-blue{
        background:#eff6ff;
        color:#2563eb;
    }

    .btn-green{
        background:#ecfdf5;
        color:#16a34a;
    }

    .btn-purple{
        background:#faf5ff;
        color:#9333ea;
    }

    .btn-orange{
        background:#fff7ed;
        color:#ea580c;
    }

    .program-btn:hover{
        opacity:.85;
    }

    @media(max-width:1200px){
        .program-grid{
            grid-template-columns:repeat(2,1fr);
        }
    }

    @media(max-width:992px){
        .about-wrapper{
            grid-template-columns:1fr;
        }

        .about-image{
            min-height:320px;
        }
    }

    @media(max-width:700px){
        .program-grid{
            grid-template-columns:1fr;
        }
    }
</style>

<div class="page-title">
    Tentang Pencegahan dan  Pemeberdayaan Masyarakat (P2M)
</div>

<div class="about-wrapper">

    <div>
    
        <div class="about-text">
            Bidang Pencegahan dan Pemberdayaan Masyarakat (P2M) merupakan salah satu bidang dalam struktur organisasi 
            Badan Narkotika Nasional (BNN) yang memiliki peran strategis dalam upaya pencegahan penyalahgunaan narkotika
             melalui pendekatan preventif dan pemberdayaan masyarakat. Bidang ini berfokus pada peningkatan kesadaran, 
             pengetahuan, serta partisipasi aktif masyarakat dalam mendukung upaya Pencegahan dan Pemberantasan 
             Penyalahgunaan dan Peredaran Gelap Narkotika (P4GN).
            <br><br>

            Badan Narkotika Nasional (BNN) merupakan Lembaga Pemerintah Non Kementerian (LPNK) yang memiliki tugas
             melaksanakan pemerintahan di bidang pencegahan, pemberantasan penyalahgunaan, serta peredaran gelap 
             narkotika, psikotropika, prekursor, dan bahan adiktif lainnya.
            <br><br>

            Khusus di lingkungan BNN Provinsi Kalimantan Selatan, Bidang P2M berkomitmen menjalin kolaborasi dengan
             pemerintah daerah, institusi pendidikan, dunia usaha, serta masyarakat guna menciptakan lingkungan yang 
             sehat, aman, dan bebas dari penyalahgunaan narkoba.
        </div>
    </div>

</div>

<div class="program-grid">

    <div class="program-card">
        <div class="program-icon blue">
            <i class="fa-solid fa-vial"></i>
        </div>

        <div class="program-title">
            Test Urine
        </div>

        <div class="program-text">
            Pemeriksaan urin sebagai deteksi dini penggunaan narkoba di lingkungan masyarakat.
        </div>

        <a href="/test-urine" class="program-btn btn-blue">
            Lihat Selengkapnya
        </a>
    </div>

    <div class="program-card">
        <div class="program-icon green">
            <i class="fa-solid fa-bullhorn"></i>
        </div>

        <div class="program-title">
            Penyuluhan
        </div>

        <div class="program-text">
            Edukasi dan penyebaran informasi untuk meningkatkan pemahaman masyarakat tentang bahaya narkoba.
        </div>

        <a href="/penyuluhan" class="program-btn btn-green">
            Lihat Selengkapnya
        </a>
    </div>

    <div class="program-card">
        <div class="program-icon purple">
            <i class="fa-solid fa-users"></i>
        </div>

        <div class="program-title">
            Penggiat
        </div>

        <div class="program-text">
            Wadah partisipasi aktif masyarakat dalam mendukung program pencegahan penyalahgunaan narkoba.
        </div>

        <a href="/penggiat" class="program-btn btn-purple">
            Lihat Selengkapnya
        </a>
    </div>

    <div class="program-card">
        <div class="program-icon orange">
            <i class="fa-solid fa-house-user"></i>
        </div>

        <div class="program-title">
            Desa Bersinar
        </div>

        <div class="program-text">
            Program pemberdayaan masyarakat untuk mewujudkan lingkungan yang bersih dari narkoba.
        </div>

        <a href="/desa-bersinar" class="program-btn btn-orange">
            Lihat Selengkapnya
        </a>
    </div>

</div>

@endsection