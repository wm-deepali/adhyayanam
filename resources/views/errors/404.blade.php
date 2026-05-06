{{-- resources/views/errors/404.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>404 - Page Not Found</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family: Arial, sans-serif;
            background:#f8fafc;
            height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
        }

        .error-container{
            max-width:600px;
            width:100%;
            background:#fff;
            border-radius:20px;
            padding:50px 30px;
            text-align:center;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
        }

        .error-icon{
            font-size:80px;
            color:#ff4d4f;
            margin-bottom:20px;
        }

        .error-code{
            font-size:90px;
            font-weight:700;
            color:#111827;
            line-height:1;
        }

        .error-title{
            font-size:28px;
            margin-top:15px;
            margin-bottom:10px;
            color:#1f2937;
        }

        .error-text{
            color:#6b7280;
            font-size:16px;
            line-height:1.7;
            margin-bottom:30px;
        }

        .btn-home{
            display:inline-block;
            background:#111827;
            color:#fff;
            text-decoration:none;
            padding:14px 28px;
            border-radius:10px;
            transition:0.3s;
            font-weight:600;
        }

        .btn-home:hover{
            background:#000;
        }

        @media(max-width:576px){

            .error-code{
                font-size:70px;
            }

            .error-title{
                font-size:22px;
            }

        }

    </style>

</head>

<body>

    <div class="error-container">

        <div class="error-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>

        <div class="error-code">
            404
        </div>

        <h1 class="error-title">
            Oops! Page Not Found
        </h1>

        <p class="error-text">
            The page you are looking for might have been removed,
            had its name changed, or is temporarily unavailable.
        </p>

        <a href="{{ url('/') }}" class="btn-home">
            <i class="fa fa-home"></i> Back To Home
        </a>

    </div>

</body>

</html>