<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - SIPARAMA</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Inter',sans-serif;
        }

        /* FULL SCREEN */
        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:30px;
            overflow:hidden;
            background:linear-gradient(
                135deg,
                #5888e6 0%,
                #8daae9 50%,
                #a8c4ef 100%
            );
        }

        /* BOX UTAMA */
        .login-wrapper{
            width:100%;
            max-width:800px;
            height:450px;
            border-radius:30px;
            overflow:hidden;
            background:rgba(255,255,255,0.08);
            border:1px solid rgba(255,255,255,0.18);
            backdrop-filter:blur(14px);
            -webkit-backdrop-filter:blur(14px);
            box-shadow:0 25px 70px rgba(0,0,0,0.28);
            display:grid;
            grid-template-columns:1fr 1.15fr;
        }

        /* PANEL KIRI */
        .left-panel{
            position:relative;
            background:rgba(255,255,255,0.96);
            padding:38px 42px;
        }

        /* LOGO + TITLE */
        .brand-header{
            display:flex;
            align-items:center;
            position:absolute;
            top:0;
            left:0;
            gap:12px;
        }

        .brand-logo{
            width:120px;
            height:120px;
            object-fit:contain;
            flex-shrink:0;
        }

        .brand-title{
            font-size:30px;
            font-weight:900;
            color:#000;
            letter-spacing:-1px;
        }

        /* SUBTITLE */
        .brand-subtitle{
            position:absolute;
            left:55px;
            top:170px;
        }

        .welcome-text{
            font-size:25px;
            font-weight:800;
            color:#3565cd;
            letter-spacing:1px;
            margin-bottom:4px;
        }

        .system-text{
            font-size:18px;
            font-weight:700;
            color:#1b3774;
            line-height:1.45;
            max-width:320px;
            margin-left:18px;
        }

        /* PANEL KANAN */
        .right-panel{
            position:relative;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:30px;
            overflow:hidden;
            background:rgba(6,43,115,0.35);
            border-left:1px solid rgba(255,255,255,0.18);
        }

        .right-panel::before{
            content:'';
            position:absolute;
            inset:0;
            background:url('{{ asset("images/kantor-bnn.png") }}');
            background-size:cover;
            background-repeat:no-repeat;
            background-position:right center;
            opacity:0.16;
            z-index:1;
        }

        .forgot-card{
            position:relative;
            z-index:2;
            width:100%;
            max-width:340px;
            color:white;
            text-align:center;
        }

        .lock-icon{
            width:72px;
            height:72px;
            border-radius:50%;
            background:white;
            color:#062b73;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:28px;
            margin:0 auto 16px;
            box-shadow:0 15px 35px rgba(0,0,0,0.18);
        }

        .forgot-title{
            font-size:25px;
            font-weight:900;
            margin-bottom:8px;
        }

        .forgot-subtitle{
            font-size:16px;
            font-weight:600;
            opacity:.9;
            margin-bottom:16px;
        }

        .info-box{
            background:rgba(235, 225, 225, 1);
            border:1px solid rgba(255,255,255,0.25);
            border-radius:16px;
            padding:16px;
            margin-bottom:18px;
            text-align:left;
            display:flex;
            gap:10px;
            align-items:flex-start;
            backdrop-filter:blur(10px);
        }

        .info-box i{
            font-size:16px;
            margin-top:2px;
            color: #040404;
            flex-shrink:0;
        }

        .info-text{
            font-size:13px;
            font-weight:600;
            line-height:1.6;
            color: #040404;
        }

        .back-btn{
            width:100%;
            height:50px;
            border:none;
            border-radius:14px;
            background:#16a34a;
            color:white;
            font-size:15px;
            font-weight:800;
            cursor:pointer;
            transition:.2s;
            text-decoration:none;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .back-btn:hover{
            background:#15803d;
        }

        @media(max-width:992px){
            .login-wrapper{
                grid-template-columns:1fr;
                height:auto;
            }

            .brand-header,
            .brand-subtitle{
                position:static;
            }

            .left-panel{
                padding:40px 30px;
                text-align:center;
            }

            .brand-header{
                justify-content:center;
                margin-bottom:30px;
            }

            .brand-subtitle{
                margin-top:20px;
            }

            .system-text{
                margin-left:0;
                max-width:none;
            }

            .right-panel{
                padding:40px 25px;
                border-left:none;
                border-top:1px solid rgba(255,255,255,0.18);
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <!-- LEFT SAME AS LOGIN -->
    <div class="left-panel">

        <div class="brand-header">
            <img src="{{ asset('images/bnn-logo.png') }}"
                 alt="BNN Logo"
                 class="brand-logo">

            <div class="brand-title">
                SIPARAMA
            </div>
        </div>

        <div class="brand-subtitle">
            <div class="welcome-text">
                WELCOME BACK!
            </div>

            <div class="system-text">
                Sistem Informasi Kegiatan Pencegahan dan Pemberdayaan Masyarakat
            </div>
        </div>

    </div>

    <!-- RIGHT SAME DESIGN AS LOGIN -->
    <div class="right-panel">

        <div class="forgot-card">

            <div class="lock-icon">
                <i class="fa-solid fa-lock"></i>
            </div>

            <div class="forgot-title">
                Lupa Password
            </div>

            <div class="forgot-subtitle">
                Bantuan akses akun SIPARAMA
            </div>

            <div class="info-box">
                <i class="fa-solid fa-circle-info"></i>

                <div class="info-text">
                    Jika Anda lupa password akun SIPARAMA, silakan hubungi administrator sistem untuk melakukan reset password akun Anda.
                </div>
            </div>

            <a href="/login" class="back-btn">
                Kembali ke Login
            </a>

        </div>

    </div>

</div>

</body>
</html>