<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

    <title>TrenchDevs</title>

    <style nonce="{{ csp_nonce() }}" type="text/css">
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}main{display:block}h1{font-size:2em;margin:.67em 0}hr{box-sizing:content-box;height:0;overflow:visible}pre{font-family:monospace,monospace;font-size:1em}a{background-color:transparent}abbr[title]{border-bottom:none;text-decoration:underline;text-decoration:underline dotted}b,strong{font-weight:bolder}code,kbd,samp{font-family:monospace,monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}img{border-style:none}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;line-height:1.15;margin:0}button,input{overflow:visible}button,select{text-transform:none}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button}[type=button]::-moz-focus-inner,[type=reset]::-moz-focus-inner,[type=submit]::-moz-focus-inner,button::-moz-focus-inner{border-style:none;padding:0}[type=button]:-moz-focusring,[type=reset]:-moz-focusring,[type=submit]:-moz-focusring,button:-moz-focusring{outline:1px dotted ButtonText}fieldset{padding:.35em .75em .625em}legend{box-sizing:border-box;color:inherit;display:table;max-width:100%;padding:0;white-space:normal}progress{vertical-align:baseline}textarea{overflow:auto}[type=checkbox],[type=radio]{box-sizing:border-box;padding:0}[type=number]::-webkit-inner-spin-button,[type=number]::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}details{display:block}summary{display:list-item}template{display:none}[hidden]{display:none}
    </style>
    <style nonce="{{ csp_nonce() }}" type="text/css">

        body {
            font-size: 12px;
        }

        .main-container {
            padding-top: 1.6rem;
            background-color: white;
            /*font-family: "Lucida Console", monospace, sans-serif;*/
            font-family: Georgia, serif;
            font-size: 1rem;
            color: black;
        }

        .footer {
            border-top: 1px solid #dcd5d5;
            padding-top: 10px;
            font-size: 0.8rem;
            font-weight: 100;
            margin-top: 5vh !important;
            background-color: white;
        }

        .message-contents, .footer {
            margin: 20px 5vw;
        }

        .text-center {
            text-align: center;
        }

        .mt-5 {
            margin-top: 2rem !important;
        }

        a {
            text-decoration: underline;
        }


    </style>
</head>
<body>

<div class="main-container">

    <div class="mt-5">
        <div class="col message-contents">

            <h2 style="margin-top: 10px; margin-bottom: 20px;">TrenchDevs</h2>

            <p style="margin-bottom: 10px;">
                @yield('email_header')
            </p>

            <p>
                @yield('email_body')
            </p>
        </div>
    </div>

    <div class="footer">
        <div style="margin: 10px auto;">
            You are receiving this email because you are a member of TrenchDevs. <br>
            Please do not reply to this email. <br>
            For further assistance please contact support at support@trenchdevs.org <br>

            @if(site_route_has('notifications.emails.showUnsubscribeForm'))
                <a href="{{site_route('notifications.emails.showUnsubscribeForm')}}">Click here to Unsubscribe</a> from
                all
                emails<br>
            @endif
            <a target="_blank" href="https://trenchdevs.org">© TrenchDevs {{date('Y')}}</a>
        </div>
    </div>


</div>


</body>
</html>
