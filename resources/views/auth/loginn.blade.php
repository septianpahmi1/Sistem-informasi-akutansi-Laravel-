<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login | KOPERASI CIPTA USAHA
        SENTOSA</title>
    <link href="/dist/img/logo.png" rel="icon">
    <link href="/dist/img/logo.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>


    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2" style="background-image: url('dist/img/banner-login.jpg');"></div>
        <div class="contents order-2 order-md-1">

            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7">
                        <img src="dist/img/logo.png" height="80" alt="Logo Koperasi Cipata Usaha Sentosa"
                            class="mb-3">
                        <h3>Login to <strong>SIAkuntansi</strong></h3>
                        <p class="mb-4">Sistem Informasi Akuntansi Koperasi Cipata Usaha Sentosa.
                        </p>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group first">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" name="email"
                                    placeholder="your-email@gmail.com" id="email" :value="old('email')" required
                                    autofocus autocomplete="username">
                                @error('email')
                                    <span class="text-danger mt-3 mb-3">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group last mb-3 position-relative">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" required autocomplete="current-password"
                                        class="form-control" placeholder="Your Password" minlength="8" id="password">
                                    <button type="button" class=" btn-sm btn-primary" id="togglePassword">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="text-danger mt-3 mb-3">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex mb-5 align-items-center">
                                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                                    <input type="checkbox" checked="checked" />
                                    <div class="control__indicator"></div>
                                </label>
                            </div>

                            <button type="submit" value="Log In" class="btn btn-block btn-primary">Masuk</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const passwordField = document.querySelector("#password");
        const toggleIcon = document.querySelector("#toggleIcon");

        togglePassword.addEventListener("click", function() {
            const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
            passwordField.setAttribute("type", type);
            toggleIcon.classList.toggle("fa-eye");
            toggleIcon.classList.toggle("fa-eye-slash");
        });
    </script>
</body>

</html>
