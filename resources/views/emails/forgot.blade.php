@php
    $placeholders = [
        '{sitename}' => setting('site_name'),
        '{username}' => $data['name'],
        '{usermail}' => $data['email'],
        '{siteshortname}' => setting('site_short_name'),
        '{activationlink}' => '<a href="' . route('password.reset', $data['token']) . '">Forgot Password</a>',
    ];
    // $content = emailcontent('forgot');
    // foreach ($placeholders as $placeholder => $value) {
    //     $content = str_replace($placeholder, $value, $content);
    // }
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Roboto Condensed", sans-serif;
            background-color: white;
            cursor: default;
        }

        .container {
            width: 90%;
            border-radius: 10px;
            margin: auto;
            background: white;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
            padding: 2%;
        }

        .text-orange {
            color: #ff4c00;
        }

        .text-dark {
            color: #666;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center
        }

        .site_name {
            font-size: 20px;
        }

        .mt-5 {
            margin-top: 5%;
        }

        .p-2 {
            padding: 2%;
        }

        .d-flex {
            display: flex;
        }

        .flex-column {
            flex-direction: column
        }

        a {
            text-decoration: none;
            color: black;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }

        .note::before {
            content: "Note:";
            color: red;
        }
    </style>
</head>

<body class="bg-light d-flex align-items-center">
    <div class="container mt-5 text-dark">
        <div class="font-bold text-center site_name p-2">
            <span>Vikas</span>
            <span class="text-orange">Bishnoi</span>
        </div>
        <p>Email:&nbsp;{{$data['name']}}</p>
        <a href="{{ route('password.reset', $data['token']) }}">Forgot Password</a>
        <div class="mt-5 d-flex flex-column footer text-center">
            <div>Contact Information:</div>
            <div class=""> <a href="mailto:{{ setting('site_email') }}">{{ setting('site_email') }}</a></div>
            <div class=""> <a href="tel:{{ setting('site_phone') }}">{{ setting('site_phone') }}</a></div>
        </div>
        <div class="note font-bold p-2 text-center">This email is for intended recipients only. If you have received
            this email in error, please
            disregard it.</div>
    </div>
</body>

</html>
