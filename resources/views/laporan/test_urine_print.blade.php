<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Test Urine</title>

    <style>
        @page{
            size:A4 landscape;
            margin:10mm;
        }

        body{
            margin:0;
        }
    </style>

</head>

<body onload="window.print()">

@include('laporan.test_urine_template')

</body>
</html>