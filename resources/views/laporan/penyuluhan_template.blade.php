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

.header-table{
    width:100%;
    border-bottom:4px solid #000;
    padding-bottom:25px;
    margin-bottom:20px;
}

table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
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

th,
td{
    word-wrap:break-word;
    overflow-wrap:break-word;
}

.text-center{
    text-align:center;
}

.footer{
    margin-top:15px;
    width:100%;
}

.footer-right{
    width:320px;
    margin-left:auto;
    text-align:center;
    font-size:11px;
}

@media print{

    body{
        -webkit-print-color-adjust:exact;
        print-color-adjust:exact;
    }

    .footer{
        page-break-inside:avoid;
    }

    tr{
        page-break-inside:avoid;
    }

}

</style><div class="container"><div class="header-table">

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
                LAPORAN KEGIATAN PENYULUHAN
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
    $nomor = 1;
@endphp

<table>

    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="10%">Tanggal</th>
            <th width="17%">Tempat</th>
            <th width="15%">Sasaran</th>
            <th width="15%">Jenis Media</th>
            <th width="18%">Jenis Kegiatan</th>
            <th width="10%">Jumlah Paket</th>
            <th width="8%">Jumlah Sebaran</th>
        </tr>
    </thead>

    <tbody>

    @forelse($data as $item)

        @if($item->detail->count())

            @foreach($item->detail as $detail)

            <tr>

                <td class="text-center">
                    {{ $nomor++ }}
                </td>

                <td class="text-center">
                    {{ date('d-m-Y', strtotime($item->tanggal_kegiatan)) }}
                </td>

                <td>
                    {{ $item->nama_tempat }}
                </td>

                <td>
                    {{ $item->sasaran }}
                </td>

                <td>
                    {{ $detail->jenis_media }}
                </td>

                <td>
                    {{ $detail->jenis_kegiatan }}
                </td>

                <td class="text-center">
                    {{ $detail->jumlah_paket }}
                </td>

                <td class="text-center">
                    {{ $item->jumlah_sebaran }}
                </td>

            </tr>

            @endforeach

        @else

            <tr>

                <td class="text-center">
                    {{ $nomor++ }}
                </td>

                <td class="text-center">
                    {{ date('d-m-Y', strtotime($item->tanggal_kegiatan)) }}
                </td>

                <td>
                    {{ $item->nama_tempat }}
                </td>

                <td>
                    {{ $item->sasaran }}
                </td>

                <td>-</td>

                <td>-</td>

                <td class="text-center">
                    0
                </td>

                <td class="text-center">
                    {{ $item->jumlah_sebaran }}
                </td>

            </tr>

        @endif

    @empty

        <tr>
            <td colspan="8" class="text-center">
                Tidak ada data
            </td>
        </tr>

    @endforelse

    </tbody>

</table>

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

        <div style="height:90px;"></div>

        <div style="font-weight:bold;">
            Rakhmadiansyah, S.Kep
        </div>

    </div>

</div>

</div>