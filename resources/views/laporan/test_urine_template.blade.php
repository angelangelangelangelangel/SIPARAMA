<style>

    @page{
        size:A4 landscape;
        margin:18px;
    }

    *{
        box-sizing:border-box;
    }

    body{
        font-family:DejaVu Sans, sans-serif;
        font-size:11px;
        color:#111827;
        margin:0;
    }

    .container{
        width:100%;
    }

    .kop{
    width:100%;
    text-align:center;
    margin-bottom:15px;
}

.logo{
    text-align:center;
    margin-bottom:10px;
}

.logo img{
    width:95px;
}

.instansi{
    font-size:20px;
    font-weight:bold;
    text-transform:uppercase;
}

.tahun-laporan{
    font-size:15px;
    font-weight:bold;
    margin-top:4px;
}

.tahun-laporan{
    margin-top:5px;
    font-size:15px;
    font-weight:bold;
}

.tahun{
    margin-top:4px;
    font-size:13px;
    font-weight:bold;
}

.garis-kop{
    border:0;
    border-top:3px solid #000;
    margin-top:10px;
    margin-bottom:20px;
}

    .header{
        text-align:center;
        margin-bottom:20px;
        border-bottom:2px solid #111827;
        padding-bottom:10px;
    }

    .header-table{
        width:100%;
        border-bottom:4px solid #000;
        padding-bottom:25px;
        margin-bottom:20px;
    }

.instansi{
    font-size:24px;
    font-weight:bold;
    letter-spacing:1px;
}

.instansi-sub{
    font-size:18px;
    font-weight:bold;
    margin-top:3px;
}

.judul-laporan{
    margin-top:12px;
    font-size:20px;
    font-weight:bold;
}

.tahun{
    margin-top:4px;
    font-size:14px;
    font-weight:bold;
}

.tahun-laporan{
    font-size:16px;
    margin-top:6px;
}

    .title{
        font-size:20px;
        font-weight:bold;
        text-transform:uppercase;
        margin-bottom:4px;
    }

    .subtitle{
        font-size:12px;
        color:#4b5563;
    }


    table{
        width:100%;
        border-collapse:collapse;
    }

   table th{
    background:#dbeafe !important;
    border:1.5px solid #000 !important;
    padding:8px;
    font-size:11px;
    text-align:center;
    font-weight:bold;
}

table td{
    border:1.5px solid #000 !important;
    padding:8px;
    font-size:11px;
    vertical-align:middle;
}

@media print{

    body{
        -webkit-print-color-adjust:exact;
        print-color-adjust:exact;
    }

   table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
}

    th,
    td{
        word-wrap:break-word;
    }

}
    .text-center{
        text-align:center;
    }

    .footer{
        margin-top:5px;
        width:100%;
    }

    .footer-right{
        width:320px;
        margin-left:auto;
        float:right;
        text-align:center;
        font-size:11px;
    }

    @media print{

    .footer{
        page-break-inside:avoid;
    }

    table{
        page-break-inside:auto;
    }

    tr{
        page-break-inside:avoid;
    }

}

    .ttd-space{
        height:70px;
    }
    

    </style>

    <div class="container">

    <div class="header-table">

    <div style="position:relative; height:110px;">

       <img src="{{ isset($isPdf) && $isPdf
            ? public_path('images/bnn-logo.png')
            : asset('images/bnn-logo.png') }}"
            style="
                position:absolute;
                left:10px;
                top:0;
                width:90px;
            ">

        <div style="
            text-align:center;
            padding-left:90px;
        ">

            <div style="
                font-size:22px;
                font-weight:bold;
            ">
                BADAN NARKOTIKA NASIONAL PROVINSI KALIMANTAN SELATAN
            </div>

            <div style="
                font-size:18px;
                font-weight:bold;
                margin-top:5px;
            ">
                BIDANG PENCEGAHAN DAN PEMBERDAYAAN MASYARAKAT
            </div>

            <div style="
                font-size:20px;
                font-weight:bold;
                margin-top:8px;
            ">
                LAPORAN KEGIATAN TEST URINE
            </div>

            <div style="
                font-size:14px;
                font-weight:bold;
                margin-top:5px;
            ">
                PERIODE :
                01 JANUARI {{ request('tahun') ?: date('Y') }}
                s.d
                31 DESEMBER {{ request('tahun') ?: date('Y') }}
            </div>

        </div>

    </div>

</div>

    @php
$sections = [
    'A. LINGKUNGAN PEMERINTAH' => $pemerintah,
    'B. LINGKUNGAN SWASTA' => $swasta,
    'C. LINGKUNGAN PENDIDIKAN' => $pendidikan,
    'D. LINGKUNGAN MASYARAKAT' => $masyarakat,
];
@endphp

@foreach($sections as $title => $items)

<div style="
    margin-top:18px;
    background:#dbeafe;
    border:1px solid #374151;
    padding:6px 10px;
    font-weight:bold;
    font-size:11px;
">
    {{ $title }}
</div>

<table>

    <thead>
        <tr>
            <th width="4%">No</th>
            <th width="12%">Tanggal</th>
            <th width="26%">Instansi</th>
            <th width="18%">Sasaran</th>
            <th width="18%">Tujuan Tes</th>
            <th width="8%">Peserta</th>
            <th width="7%">Reaktif</th>
            <th width="7%">Non</th>
        </tr>
    </thead>

    <tbody>

    @forelse($items->values() as $item)

        <tr>

            <td class="text-center">
                {{ $loop->iteration }}
            </td>

            <td class="text-center">
                {{ date('d-m-Y', strtotime($item->tanggal_kegiatan)) }}
            </td>

            <td>
                {{ $item->nama_instansi }}
            </td>

            <td>
                {{ $item->sasaran }}
            </td>

            <td>
                {{ $item->tujuan_test }}
            </td>

            <td class="text-center">
                {{ $item->peserta->count() }}
            </td>

            <td class="text-center">
                {{ $item->peserta->where('hasil','reaktif')->count() }}
            </td>

            <td class="text-center">
                {{ $item->peserta->where('hasil','non_reaktif')->count() }}
            </td>

        </tr>

    @empty

        <tr>
            <td colspan="8" class="text-center">
                Tidak ada data
            </td>
        </tr>

    @endforelse

    <tr style="background:#fef08a; font-weight:bold;">

        <td colspan="5" class="text-center">
            TOTAL
        </td>

        <td class="text-center">
            {{ $items->sum(function($x){
                return $x->peserta->count();
            }) }}
        </td>

        <td class="text-center">
            {{ $items->sum(function($x){
                return $x->peserta->where('hasil','reaktif')->count();
            }) }}
        </td>

        <td class="text-center">
            {{ $items->sum(function($x){
                return $x->peserta->where('hasil','non_reaktif')->count();
            }) }}
        </td>

    </tr>

    </tbody>

</table>

@endforeach

<div style="
    margin-top:10px;
    width:350px;
    float:left;
    background:#e2e8f0;
    border:1px solid #374151;
    padding:8px 12px;
    font-weight:bold;
    font-size:12px;
">
    TOTAL KESELURUHAN :
    {{ $totalKeseluruhan }}
        </div>

            <div class="footer">

                <div class="footer-right">

            <div>
                Banjarmasin, {{ date('d M Y') }}
            </div>

            <br>

            <div style="font-weight:bold;">
                Kepala Bidang P2M
            </div>

            <div style="font-weight:bold;">
                BNN Provinsi Kalimantan Selatan
            </div>

            <div style="height:15px;"></div>

            <div style="font-weight:bold;">
                Rakhmadiansyah, S.Kep
            </div>

        </div>

    </div>

</div>