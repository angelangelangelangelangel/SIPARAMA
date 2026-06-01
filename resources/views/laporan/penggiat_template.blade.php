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

th{
    background:#dbeafe !important;
    border:1.5px solid #000 !important;
    padding:8px;
    font-size:11px;
    text-align:center;
    font-weight:bold;
}

td{
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

    body{
        -webkit-print-color-adjust:exact;
        print-color-adjust:exact;
    }

    table{
        page-break-inside:auto;
    }

    tr{
        page-break-inside:avoid;
    }

    .footer{
        page-break-inside:avoid;
    }

}

</style>

<div class="container">

    <div class="header-table">

        <div style="position:relative;height:110px;">

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
                    LAPORAN DATA PENGGIAT
                </div>

                <div style="
                    font-size:14px;
                    font-weight:bold;
                    margin-top:5px;
                ">
                    PERIODE TAHUN {{ date('Y') }}
                </div>

            </div>

        </div>

    </div>

    <table>

        <thead>

            <tr>
                <th width="5%">No</th>
                <th width="18%">Nama Penggiat</th>
                <th width="18%">Instansi</th>
                <th width="14%">Jabatan</th>
                <th width="18%">Jenis Instansi</th>
                <th width="10%">Kategori</th>
                <th width="15%">Keterangan</th>
            </tr>

        </thead>

        <tbody>

        @forelse($data as $item)

            <tr>

                <td class="text-center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $item->nama_penggiat }}
                </td>

                <td>
                    {{ $item->instansi }}
                </td>

                <td>
                    {{ $item->jabatan ?? '-' }}
                </td>

                <td>
                    {{ $item->jenis_instansi }}
                </td>

                <td class="text-center">
                    {{ $item->kategori_pendidikan ?? '-' }}
                </td>

                <td>
                    {{ $item->keterangan ?? '-' }}
                </td>

            </tr>

        @empty

            <tr>

                <td colspan="7" class="text-center">
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

            <div style="height:70px;"></div>

            <div style="font-weight:bold;">
                Rakhmadiansyah, S.Kep
            </div>

        </div>

    </div>

</div>