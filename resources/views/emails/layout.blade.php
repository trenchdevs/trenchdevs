<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

    <title>TrenchDevs</title>
    <style type="text/css">

        .logo {
            max-width: 150px;
        }

        .main-container {
            padding-top: 2.3rem;
            height: 100vh;
            background-color: #40a798;
            width: 80%;
            margin: 0 auto;
            color: white;
            font-family: "Lucida Console", monospace, sans-serif;
        }

        .footer {
            font-size: 12px;
            font-weight: 100;
            margin-top: 30vh !important;
            background-color: #40a798;
        }

        .message-contents, .footer {
            margin: 0 10%;
        }

        .text-center {
            text-align: center;
        }

        .mt-5 {
            margin-top: 2rem !important;
        }

        a {
            text-decoration: underline;
            color: white;
        }


    </style>
</head>
<body class="bg-white-25 mt-5">


<div class="main-container">

    <div class="mb-3">
        <div class="col text-center">
            <img class="logo text-center img-fluid" src="https://trenchdevs-assets.s3.amazonaws.com/logo/v1/logo.png"
                 alt="">
        </div>
    </div>

    <div class="mt-5">
        <div class="col text-center message-contents">
            <p>
                @yield('email_header')
            </p>

            <p>
                @yield('email_body')
            </p>
        </div>
    </div>

    <div class="footer text-center">
        You are receiving this email because you are a member of TrenchDevs <br>
        Please do not reply to this email. <br>
        For further assistance please contact support at support@trenchdevs.org <br>
        <a href="/emails/unsubscribe">Click here to unsubscribe</a> from these emails<br>
        © TrenchDevs {{date('Y')}}
    </div>


</div>


</body>
</html>
