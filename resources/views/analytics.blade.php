@extends('layouts.app')

@section('content')

<style>
.wrapper{
    background:transparent;
    min-height:auto;
    padding:0;
}

/* HEADER */
.page-title-main{
    font-size:28px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:6px;
    letter-spacing:-0.3px;
}

.page-subtitle{
    font-size:14px;
    color:#64748b;
    margin-bottom:22px;
    line-height:1.6;
}

/* SUMMARY */
.summary-wrap{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:16px;
    margin-bottom:22px;
}

.summary-box{
    background:#ffffff;
    border:1px solid #e2e8f0;
    border-radius:18px;
    padding:20px;
    box-shadow:0 4px 18px rgba(15,23,42,0.04);
    display:flex;
    align-items:center;
    gap:14px;
    position:relative;
    overflow:hidden;
}

.summary-box::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:4px;
}

.card-green::before{ background:#16a34a; }
.card-blue::before{ background:#2563eb; }
.card-orange::before{ background:#f59e0b; }
.card-purple::before{ background:#7c3aed; }

.summary-icon{
    width:50px;
    height:50px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
    color:#fff;
    flex-shrink:0;
}

.icon-green{ background:linear-gradient(135deg,#22c55e,#16a34a); }
.icon-blue{ background:linear-gradient(135deg,#3b82f6,#2563eb); }
.icon-orange{ background:linear-gradient(135deg,#fbbf24,#f59e0b); }
.icon-purple{ background:linear-gradient(135deg,#8b5cf6,#7c3aed); }

.summary-title{
    font-size:13px;
    color:#64748b;
    font-weight:600;
    margin-bottom:6px;
}

.summary-value{
    font-size:28px;
    font-weight:800;
    color:#0f172a;
    line-height:1;
}

/* GRID */
.dashboard-chart-row{
    margin-bottom:20px;
}

.dashboard-chart-grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:18px;
}

/* CARD */
.chart-card,
.sentiment-card{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:18px;
    box-shadow:0 4px 18px rgba(15,23,42,0.04);
    overflow:hidden;
}

.chart-header{
    padding:18px 20px;
    border-bottom:1px solid #edf2f7;
}

.chart-header-flex{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:14px;
    flex-wrap:wrap;
}

.chart-header span{
    font-size:16px;
    font-weight:800;
    color:#0f172a;
}

.chart-subtitle{
    font-size:13px;
    color:#64748b;
    margin-top:5px;
    font-weight:500;
    line-height:1.5;
    max-width:640px;
}

/* TAB */
.chart-tabs{
    display:flex;
    gap:6px;
    background:#f8fafc;
    padding:4px;
    border-radius:10px;
}

.tab-btn{
    border:none;
    background:transparent;
    padding:8px 14px;
    font-size:12px;
    font-weight:700;
    color:#64748b;
    border-radius:8px;
    cursor:pointer;
    transition:.2s;
}

.tab-btn.active{
    background:#2563eb;
    color:#fff;
    box-shadow:none;
}

/* CHART */
.chart-body{
    padding:16px;
    height:420px;
}

#grafikTestUrine,
#grafikPenyuluhan,
#grafikMedia,
#grafikPenggiat,
#grafikDesa{
    width:100%;
    height:100%;
}

/* SENTIMENT */
.sentiment-content{
    padding:24px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.sentiment-subtitle{
    font-size:13px;
    color:#64748b;
    line-height:1.6;
    margin-bottom:22px;
}

.sentiment-stats{
    display:flex;
    justify-content:space-between;
    gap:18px;
    margin-bottom:18px;
}

.sentiment-col{
    flex:1;
    text-align:center;
}

.sentiment-divider{
    width:1px;
    background:#e2e8f0;
}

.negative-label,
.positive-label{
    font-size:13px;
    font-weight:800;
}

.negative-label{ color:#16a34a; }
.positive-label{ color:#dc2626; }

.negative-percent,
.positive-percent{
    font-size:40px;
    font-weight:300;
    margin-top:10px;
}

.negative-percent{ color:#16a34a; }
.positive-percent{ color:#dc2626; }

.status-count{
    font-size:13px;
    color:#64748b;
    margin-top:8px;
}

.progress-wrapper{
    width:100%;
    height:14px;
    display:flex;
    overflow:hidden;
    border-radius:999px;
    background:#e5e7eb;
}

.progress-negative{
    background:linear-gradient(90deg,#22c55e,#16a34a);
}

.progress-positive{
    background:linear-gradient(90deg,#ef4444,#dc2626);
}

/* TOOLTIP */
.apexcharts-tooltip{
    border-radius:14px !important;
    box-shadow:0 10px 24px rgba(15,23,42,.12) !important;
}

/* RESPONSIVE */
@media(max-width:1200px){
    .dashboard-chart-grid{
        grid-template-columns:1fr;
    }

    .summary-wrap{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:768px){
    .summary-wrap{
        grid-template-columns:1fr;
    }

    .sentiment-stats{
        flex-direction:column;
    }

    .sentiment-divider{
        display:none;
    }

    .page-title-main{
        font-size:24px;
    }

    .chart-body{
        height:360px;
    }
}
</style>

        <div class="wrapper">

        <div style="margin-bottom:22px;">
            <div class="page-title-main">Analytics</div>

            <div class="page-subtitle">
                Sistem Informasi Kegiatan Pencegahan dan Pemberdayaan Masyarakat
            </div>
        </div>


<!-- TEST URINE -->
<div class="dashboard-chart-row">
    <div class="dashboard-chart-grid">

        <div class="chart-card">
            <div class="chart-header chart-header-flex">

                <div>
                    <span>Test Urine</span>
                    <div class="chart-subtitle">
                        Ringkasan kegiatan test urine berdasarkan total kegiatan dan jenis instansi
                    </div>
                </div>

                <div class="chart-tabs">
                    <button class="tab-btn active" id="btnBulanan">Timeline</button>
                    <button class="tab-btn" id="btnInstansi">Instansi</button>
                </div>

            </div>

            <div class="chart-body">
                <div id="grafikTestUrine"></div>
            </div>
        </div>

        <div class="sentiment-card" style="height:auto;">
            <div class="chart-header">
                <span>Hasil Test Urine</span>
            </div>

            <div class="sentiment-content">

                <div class="sentiment-subtitle">
                    Persentase hasil pemeriksaan test urine berdasarkan hasil reaktif dan non reaktif.
                </div>

                <div class="sentiment-stats">

                    <div class="sentiment-col">
                        <div class="negative-label">NON REAKTIF</div>
                        <div class="negative-percent">{{ $persen_negatif }}%</div>
                        <div class="status-count">{{ $total_negatif }} Orang</div>
                    </div>

                    <div class="sentiment-divider"></div>

                    <div class="sentiment-col">
                        <div class="positive-label">REAKTIF</div>
                        <div class="positive-percent">{{ $persen_positif }}%</div>
                        <div class="status-count">{{ $total_positif }} Orang</div>
                    </div>

                </div>

                <div class="progress-wrapper">
                    <div class="progress-negative" style="width: {{ $persen_negatif }}%"></div>
                    <div class="progress-positive" style="width: {{ $persen_positif }}%"></div>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- PENYULUHAN -->
<div class="dashboard-chart-row">
    <div class="dashboard-chart-grid">

        <!-- CHART PENYULUHAN -->
        <div class="chart-card">

            <div class="chart-header chart-header-flex">

                <div>
                    <span>Penyuluhan</span>

                    <div class="chart-subtitle">
                        Perbandingan total kegiatan penyuluhan dan jumlah sebaran berdasarkan tampilan data yang dipilih.
                    </div>
                </div>

                <div class="chart-tabs">
                    <button class="tab-btn active" id="btnPenyuluhanBulanan">Timeline</button>
                    <button class="tab-btn" id="btnPenyuluhanInstansi">Instansi</button>
                </div>

            </div>

            <div class="chart-body">
                <div id="grafikPenyuluhan"></div>
            </div>

        </div>

        <!-- MEDIA -->
        <div class="chart-card">

            <div class="chart-header">
                <span>Jenis Media</span>

                <div class="chart-subtitle">
                    Distribusi media sebagai sarana penyebaran informasi dalam kegiatan penyuluhan.
                </div>
            </div>

            <div class="chart-body" style="
                display:flex;
                flex-direction:column;
                align-items:center;
                justify-content:center;
                gap:20px;
            ">

                <div style="width:100%;max-width:220px;height:220px;">
                    <div id="grafikMedia"></div>
                </div>

                <div id="mediaLegendCustom"
                    style="
                        width:100%;
                        display:flex;
                        flex-direction:column;
                        gap:12px;
                        padding:0 10px;
                    ">
                </div>

            </div>

        </div>

    </div>
</div>
<!-- PEMBERDAYAAN -->
<div class="dashboard-chart-row">
    <div class="dashboard-chart-grid">

        <!-- PENGGIAT -->
            <div class="chart-card">
        <div class="chart-header">
        <span>Penggiat P4GN</span>
        <div class="chart-subtitle">
            Distribusi Penggiat berdasarkan kategori instansi.
        </div>
    </div>

            <div class="chart-body">
                <div id="grafikPenggiat"></div>
            </div>
        </div>

        <!-- DESA -->
           <div class="chart-card">
    <div class="chart-header">
        <span>Desa Bersinar</span>
        <div class="chart-subtitle">
           Program Desa Bersinar Berdasarkan wilayah Desa dan Kelurahan
        </div>
    </div>

                <div class="chart-body" style="
                    display:flex;
                    flex-direction:column;
                    align-items:center;
                    justify-content:center;
                    gap:24px;
                ">

                   <div style="width:100%;max-width:220px;height:220px;">
                        <div id="grafikDesa"></div>
                    </div>

                    <div style="
                        width:100%;
                        display:flex;
                        flex-direction:column;
                        gap:16px;
                        padding:0 20px;
                    ">

                        <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                            padding-bottom:14px;
                            border-bottom:1px solid #e5e7eb;
                        ">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <span style="
                                    width:14px;
                                    height:14px;
                                    border-radius:50%;
                                    background:#f59e0b;
                                "></span>
                               <span style="font-size:13px;font-weight:600;color:#475569;">Desa</span>
                            </div>
                            <strong style="font-size:14px;">{{ $total_desa }}</strong>
                        </div>

                        <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                            padding-bottom:14px;
                            border-bottom:1px solid #e5e7eb;
                        ">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <span style="
                                    width:14px;
                                    height:14px;
                                    border-radius:50%;
                                    background:#2563eb;
                                "></span>
                                <span style="font-size:13px;font-weight:600;color:#475569;">Kelurahan</span>
                            </div>
                            <strong style="font-size:14px;">{{ $total_kelurahan }}</strong>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function(){

    const labelsBulanan = {!! json_encode($labels_test_urine) !!};
    const totalPeserta = {!! json_encode($data_total_peserta) !!}.map(Number);
    const totalKegiatan = {!! json_encode($data_total_kegiatan) !!}.map(Number);

    const labelsInstansi = {!! json_encode($labels_instansi) !!};
    const dataInstansi = {!! json_encode($data_instansi) !!}.map(Number);
    const dataKegiatanInstansi = {!! json_encode($data_kegiatan_instansi) !!}.map(Number);

    const labelsPenyuluhan = {!! json_encode($labels_penyuluhan) !!};
    const dataKegiatanPenyuluhan = {!! json_encode($data_kegiatan_penyuluhan) !!}.map(Number);
    const dataSebaranPenyuluhan = {!! json_encode($data_sebaran_penyuluhan) !!}.map(Number);

    const labelsInstansiPenyuluhan = {!! json_encode($labels_instansi_penyuluhan) !!};
    const dataKegiatanInstansiPenyuluhan = {!! json_encode($data_kegiatan_instansi_penyuluhan) !!}.map(Number);
    const dataSebaranInstansiPenyuluhan = {!! json_encode($data_sebaran_instansi_penyuluhan) !!}.map(Number);

    const labelsMedia = {!! json_encode($labels_media) !!};
    const dataMedia = {!! json_encode($data_media) !!}.map(Number);

    const labelsPenggiat = [
        'Relawan',
        'Pemerintah',
        'Sekolah',
        'Perguruan Tinggi',
        'Swasta'
    ];

    const dataPenggiat = [
        {{ $total_relawan }},
        {{ $total_pemerintah_penggiat }},
        {{ $total_sekolah_penggiat }},
        {{ $total_pt_penggiat }},
        {{ $total_swasta_penggiat }}
    ];

    let chartTestUrine;
    let chartPenyuluhan;
    let chartMedia;
    let chartPenggiat;
    let chartDesa;

    function niceMax(value){
        if(!value || value <= 10) return 10;
        if(value <= 20) return 20;
        if(value <= 50) return 50;
        if(value <= 100) return 100;
        if(value <= 200) return 200;
        if(value <= 500) return 500;
        if(value <= 1000) return 1000;
        return Math.ceil(value / 100) * 100;
    }

    function buildTestUrine(labels, kegiatan, peserta, mode='bulanan'){
        if(chartTestUrine){
            chartTestUrine.destroy();
        }

        chartTestUrine = new ApexCharts(
            document.querySelector("#grafikTestUrine"),
            {
                chart:{
                    type:'line',
                    height:430,
                    toolbar:{show:false}
                },

                series:[
                    {
                        name:'Total Kegiatan',
                        type:'column',
                        data:kegiatan
                    },
                    {
                        name:'Total Peserta',
                        type:'line',
                        data:peserta
                    }
                ],

                colors:['#2563eb','#16a34a'],

                stroke:{
                    width:[0,4],
                    curve:'smooth'
                },

                markers:{
                    size:[0,5]
                },

                plotOptions:{
                    bar:{
                        borderRadius:4,
                        columnWidth: mode === 'instansi' ? '25%' : '45%'
                    }
                },

                xaxis:{
                    categories:labels
                },

                yaxis:[
                    {
                        max:niceMax(Math.max(...kegiatan))
                    },
                    {
                        opposite:true,
                        max:niceMax(Math.max(...peserta))
                    }
                ],

                grid:{
                    borderColor:'#eef2f7'
                },

                legend:{
                    position:'bottom'
                }
            }
        );

        chartTestUrine.render();
    }

    function buildPenyuluhan(labels, kegiatan, sebaran, mode='bulanan'){
        if(chartPenyuluhan){
            chartPenyuluhan.destroy();
        }

        chartPenyuluhan = new ApexCharts(
            document.querySelector("#grafikPenyuluhan"),
            {
                chart:{
                    type:'line',
                    height:430,
                    toolbar:{show:false}
                },

                series:[
                    {
                        name:'Total Kegiatan',
                        type: mode === 'instansi' ? 'column' : 'line',
                        data:kegiatan
                    },
                    {
                        name:'Jumlah Sebaran',
                        type:'area',
                        data:sebaran
                    }
                ],

                colors:['#2563eb','#16a34a'],

                stroke:{
                    width: mode === 'instansi' ? [0,3] : [4,3],
                    curve:'smooth'
                },

                fill:{
                    type:['solid','gradient'],
                    gradient:{
                        opacityFrom:0.35,
                        opacityTo:0.05
                    }
                },

                markers:{
                    size: mode === 'instansi' ? [0,4] : [5,4]
                },

                plotOptions:{
                    bar:{
                        borderRadius:4,
                        columnWidth:'25%'
                    }
                },

                xaxis:{
                    categories:labels
                },

                yaxis:[
                    {
                        max:niceMax(Math.max(...kegiatan))
                    },
                    {
                        opposite:true,
                        max:niceMax(Math.max(...sebaran))
                    }
                ],

                grid:{
                    borderColor:'#eef2f7'
                },

                legend:{
                    position:'bottom'
                }
            }
        );

        chartPenyuluhan.render();
    }

    function buildMedia(){
        if(chartMedia){
            chartMedia.destroy();
        }

        const colors = ['#2563eb','#16a34a','#f59e0b','#7c3aed'];

        chartMedia = new ApexCharts(
            document.querySelector("#grafikMedia"),
            {
                chart:{
                    type:'donut',
                    height:260
                },

                series:dataMedia,
                labels:labelsMedia,
                colors:colors,

                dataLabels:{
                    enabled:false
                },

                legend:{
                    show:false
                },

                plotOptions:{
                    pie:{
                        donut:{
                            size:'72%',
                            labels:{
                                show:true,
                                total:{
                                    show:true,
                                    label:'Media',
                                    formatter:function(){
                                        return dataMedia.reduce((a,b)=>a+b,0);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        );

        chartMedia.render();

        const legend = document.getElementById('mediaLegendCustom');
        legend.innerHTML = '';

        const total = dataMedia.reduce((a,b)=>a+b,0);

        labelsMedia.forEach((label,index)=>{
            const persen = total > 0 ? ((dataMedia[index]/total)*100).toFixed(1) : 0;

            legend.innerHTML += `
                        <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                            padding-bottom:14px;
                            border-bottom:1px solid #e5e7eb;
                        ">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span style="width:12px;height:12px;border-radius:50%;background:${colors[index]};display:inline-block;"></span>
                        <span style="font-weight:600;color:#475569;">${label}</span>
                    </div>
                    <strong style="color:#0f172a;">${persen}%</strong>
                </div>
            `;
        });
    }

    function buildPenggiat(){
        if(chartPenggiat){
            chartPenggiat.destroy();
        }

        chartPenggiat = new ApexCharts(
            document.querySelector("#grafikPenggiat"),
            {
                chart:{
                    type:'bar',
                    height:320,
                    toolbar:{show:false}
                },

                series:[
                    {
                        name:'Total Penggiat',
                        data:dataPenggiat
                    }
                ],

                colors:['#7c3aed'],

                plotOptions:{
                    bar:{
                        horizontal:true,
                        borderRadius:4,
                        barHeight:'72%'
                    }
                },

                dataLabels:{
                    enabled:true,
                    formatter:function(val){
                        return parseInt(val);
                    }
                },

                xaxis:{
                    categories:labelsPenggiat,
                    min: 0,
                    max: niceMax(Math.max(...dataPenggiat)),
                    tickAmount: 5,
                    labels:{
                        formatter:function(val){
                            return parseInt(val);
                        }
                    }
                },

                grid:{
                    borderColor:'#eef2f7'
                },

                legend:{
                    show:false
                }
            }
        );

        chartPenggiat.render();
    }

    function buildDesa(){
        if(chartDesa){
            chartDesa.destroy();
        }

        chartDesa = new ApexCharts(
            document.querySelector("#grafikDesa"),
            {
                chart:{
                    type:'donut',
                    height:260
                },

               series:[
                        {{ $total_desa }},
                        {{ $total_kelurahan }}
                    ],

                labels:[
                        'Desa',
                        'Kelurahan'
                    ],

               colors:[
                        '#f59e0b',
                        '#2563eb'
                    ],

                dataLabels:{
                    enabled:false
                },

                tooltip:{
                    enabled:false
                },

                legend:{
                    show:false
                },

                stroke:{
                    width:0
                },

                plotOptions:{
                    pie:{
                        donut:{
                            size:'72%',
                            labels:{
                                show:true,
                                total:{
                                    show:true,
                                    label:'Desa Bersinar',
                                    formatter:function(){
                                        return {{ $total_desa_bersinar }};
                                    }
                                }
                            }
                        }
                    }
                }
            }
        );

        chartDesa.render();
    }

    // DEFAULT LOAD
    buildTestUrine(labelsBulanan,totalKegiatan,totalPeserta);
    buildPenyuluhan(labelsPenyuluhan,dataKegiatanPenyuluhan,dataSebaranPenyuluhan);
    buildMedia();
    buildPenggiat();
    buildDesa();

    // TEST URINE TAB
    document.getElementById('btnBulanan').addEventListener('click',function(){
        this.classList.add('active');
        document.getElementById('btnInstansi').classList.remove('active');
        buildTestUrine(labelsBulanan,totalKegiatan,totalPeserta);
    });

    document.getElementById('btnInstansi').addEventListener('click',function(){
        this.classList.add('active');
        document.getElementById('btnBulanan').classList.remove('active');
        buildTestUrine(labelsInstansi,dataKegiatanInstansi,dataInstansi,'instansi');
    });

    // PENYULUHAN TAB
    document.getElementById('btnPenyuluhanBulanan').addEventListener('click',function(){
        this.classList.add('active');
        document.getElementById('btnPenyuluhanInstansi').classList.remove('active');
        buildPenyuluhan(labelsPenyuluhan,dataKegiatanPenyuluhan,dataSebaranPenyuluhan);
    });

    document.getElementById('btnPenyuluhanInstansi').addEventListener('click',function(){
        this.classList.add('active');
        document.getElementById('btnPenyuluhanBulanan').classList.remove('active');
        buildPenyuluhan(
            labelsInstansiPenyuluhan,
            dataKegiatanInstansiPenyuluhan,
            dataSebaranInstansiPenyuluhan,
            'instansi'
        );
    });

});
</script>

</div>

@endsection