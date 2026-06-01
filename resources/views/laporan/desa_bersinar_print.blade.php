<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Print Laporan Desa Bersinar</title>

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

@include('laporan.desa_bersinar_template')

</body>
</html>