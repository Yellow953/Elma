<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    
    <title>403 Forbidden</title>
    
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">

    <style type="text/css">
        body {
            margin-top: 150px;
            width: 100%;
            height: 100vh;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat
        }

        .error-main {
            background-color: #fff;
            box-shadow: 0px 10px 10px -10px #5D6572;
        }

        .error-main h1 {
            font-weight: bold;
            color: #444444;
            font-size: 100px;
            text-shadow: 2px 4px 5px #6E6E6E;
        }

        .error-main h5 {
            color: #42494F;
        }

        .error-main p {
            color: #9897A0;
            font-size: 14px;
        }
    </style>
</head>

<body style="background-image: url({{ asset('assets/images/shipping.png')}});">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-6 offset-lg-3 col-sm-6 offset-sm-3 col-12 p-3 error-main">
                <div class="row">
                    <div class="col-lg-8 col-12 col-sm-10 offset-lg-2 offset-sm-1">
                        <h1 class="m-0">403</h1>
                        <h3 class="text-danger">Access to this resource on the server is denied!</h3>
                        <h5 class="my-3">Please try a different route or go back to the main page.</h5>
                        <a href="{{ route('dashboard') }}" class="btn btn-warning mt-3 mb-4">Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>