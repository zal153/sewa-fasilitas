<!doctype html>
<html lang="en">

<!-- Mirrored from dashui.codescandy.com/tailwindcss-pro/404-error.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 17 Dec 2024 08:16:50 GMT -->

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('') }}asset/images/favicon/favicon.ico" />

    <!-- Libs CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" />
    <link rel="stylesheet" href="{{ asset('') }}asset/libs/simplebar/dist/simplebar.min.css" />
    <link rel="stylesheet" href="{{ asset('') }}asset/libs/bootstrap-icons/font/bootstrap-icons.min.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('') }}asset/css/theme.min.css" />
    <!-- Analytics Code -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-M8S4MT3EYG"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());

        gtag("config", "G-M8S4MT3EYG");
    </script>

    <title>404 Error</title>
</head>

<body>
    <!-- start error page -->
    <div class="h-screen flex justify-center items-center mx-auto">
        <!-- row -->
        <div class="flex flex-col">
            <!-- col -->
            <!-- content -->
            <div class="text-center">
                <div class="mb-3">
                    <!-- img -->
                    <img src="{{ asset('') }}asset/images/error/404-error-img.png" alt="" class="mw-100" />
                </div>
                <!-- text -->
                <h1 class="text-5xl font-bold">Oops! the page not found.</h1>
                <p class="mb-8 text-xl">Or simply leverage the expertise of our consultation team.</p>
                <!-- button -->
                <a href="{{ route('mahasiswa.dashboard') }}"
                    class="btn bg-indigo-600 text-white border-indigo-600 hover:bg-indigo-800 hover:border-indigo-800 active:bg-indigo-800 active:border-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300">
                    Go Home
                </a>
            </div>
        </div>
    </div>
    <!-- end of navbar -->

    <!-- Libs JS -->
    <script src="{{ asset('') }}asset/libs/feather-icons/dist/feather.min.js"></script>
    <script src="{{ asset('') }}asset/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('') }}asset/libs/simplebar/dist/simplebar.min.js"></script>

    <!-- Theme JS -->
    <script src="{{ asset('') }}asset/js/theme.min.js"></script>
</body>

<!-- Mirrored from dashui.codescandy.com/tailwindcss-pro/404-error.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 17 Dec 2024 08:16:51 GMT -->

</html>
