<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

        <!-- Favicon -->
    <link rel="icon" type="image/png" href="/logo_bps.png">

    <style>
        body {
            background: #4d96c0; /* Biru background */
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
            width: 450px;
            padding: 40px 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.2);
            text-align: center;
        }

        .login-container img {
            width: 140px;
            margin-bottom: 10px;
        }

        .login-container h3 {
            margin-bottom: 40px;
            font-weight: bold;
            font-size: 17px;
        }

        .input-field {
            width: 95%;
            padding: 15px;
            border-radius: 25px;
            border: none;
            outline: none;
            background: #f4a026; /* warna orange */
            color: white;
            margin-bottom: 20px;
            font-size: 14px;
            margin-left: -3px;
        }

        .input-field::placeholder {
            color: white;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            border-radius: 25px;
            border: none;
            background: #76a9d7;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-login:hover {
            opacity: 0.9;
        }
    </style>

</head>
<body>

    <div class="login-container">

        <!-- LOGO -->
        <img src="/logo_bps.png" alt="Logo" width="80" class="me-2">

        <h3>BADAN PUSAT STATISTIK PROV KALSEL</h3>
        

        <!-- FORM TIDAK DIUBAH, HANYA TAMBAH CLASS -->
        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <input type="text" name="username" placeholder="Username" class="input-field">

            <input type="password" name="password" placeholder="Password" class="input-field">

            <button type="submit" class="btn-login">LOGIN</button>
        </form>

    </div>

</body>
</html>
