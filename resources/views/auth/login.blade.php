<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIPARAMA</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        /* BOX LOGIN */
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
        }

        .brand-logo{
            width:120px;
            height:120px;
            object-fit:contain;
        }

        .brand-title{
            font-size:30px;
            font-weight:900;
            color:#000;
            letter-spacing:-1px;
        }

        /* BLOK WELCOME */
        .brand-subtitle{
            position:absolute;
            left:55px;
            top:170px;
        }

        .welcome-text{
            font-size:25px;
            font-weight:800;
            color: #3565cd;
            letter-spacing:1px;
            margin-bottom:4px;
        }

        .system-text{
            font-size:18px;
            font-weight:700;
            color: #1b3774;
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
            padding:50px;
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

        .login-card{
            position:relative;
            z-index:1;
            width:100%;
            max-width:430px;
            color:white;
        }

        .login-title{
            font-size:25px;
            font-weight:900;
            margin-bottom:10px;
            text-align:center;
        }

        .login-subtitle{
            text-align:center;
            font-weight:600;
            font-size:16px;
            opacity:.9;
            margin-bottom:18px;
        }

        .form-group{
            margin-bottom:20px;
        }

        .input-wrap{
            position:relative;
        }

        .input-wrap i.left-icon{
            position:absolute;
            left:18px;
            top:50%;
            transform:translateY(-50%);
            color:#64748b;
            font-size:16px;
        }

        .toggle-password{
            position:absolute;
            right:18px;
            top:50%;
            transform:translateY(-50%);
            color:#64748b;
            cursor:pointer;
            font-size:16px;
        }

        input{
            width:100%;
            height:58px;
            border:none;
            border-radius:14px;
            padding:0 48px;
            font-size:15px;
            outline:none;
            background:white;
            color:#0f172a;
        }

        input::placeholder{
            color:#94a3b8;
        }

        .login-btn{
            width:100%;
            height:58px;
            border:none;
            border-radius:14px;
            background:#16a34a;
            color:white;
            font-size:16px;
            font-weight:800;
            cursor:pointer;
            transition:.2s;
            margin-top:4px;
        }

        .login-btn:hover{
            background:#15803d;
        }

        .forgot-password{
            margin-top:28px;
            text-align:center;
        }

        .forgot-password a{
            color:white;
            font-size:16px;
            font-weight:900;
            text-decoration:none;
        }

        .forgot-password a:hover{
            text-decoration:underline;
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

    <div class="right-panel">

        <div class="login-card">

            <div class="login-title">SIGN IN</div>

            <div class="login-subtitle">
                To access the system
            </div>

            <form method="POST" action="/login">
                @csrf

                <div class="form-group">
                    <div class="input-wrap">
                        <i class="fa-regular fa-user left-icon"></i>
                        <input type="text" name="username"
                               placeholder="Masukkan username" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock left-icon"></i>
                        <input type="password" name="password"
                               id="password"
                               placeholder="Masukkan password" required>

                        <i class="fa-regular fa-eye toggle-password"
                           onclick="togglePassword()"></i>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    Login
                </button>
            </form>

            <div class="forgot-password">
                <a href="{{ route('forgot.password') }}">
                    Lupa Password?
                </a>
            </div>

        </div>
    </div>
</div>

<script>
function togglePassword(){
    const password = document.getElementById('password');
    const icon = document.querySelector('.toggle-password');

    if(password.type === 'password'){
        password.type = 'text';
        icon.classList.replace('fa-eye','fa-eye-slash');
    }else{
        password.type = 'password';
        icon.classList.replace('fa-eye-slash','fa-eye');
    }
}
</script>

</body>
</html>