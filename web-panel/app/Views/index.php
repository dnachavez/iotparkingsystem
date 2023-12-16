<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="A web panel for an IoT parking system project built using CodeIgniter 4 and Arduino Uno R4 WiFi">
        <meta name="author" content="dnachavez.ph">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('img/apple-touch-icon.png'); ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('img/favicon-32x32.png'); ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('img/favicon-16x16.png'); ?>">
        <link rel="manifest" href="<?= base_url('img/site.webmanifest'); ?>">
        <link rel="mask-icon" href="<?= base_url('img/safari-pinned-tab.svg'); ?>" color="#dc3545">
        <link rel="shortcut icon" href="<?= base_url('img/favicon.ico'); ?>">
        <meta name="apple-mobile-web-app-title" content="IoT Parking System">
        <meta name="application-name" content="IoT Parking System">
        <meta name="msapplication-TileColor" content="#dc3545">
        <meta name="msapplication-config" content="<?= base_url('img/browserconfig.xml'); ?>">
        <meta name="theme-color" content="#ffffff">
        <title>IoT Parking System</title>
        <link rel="stylesheet" href="<?= base_url('vendor/bootstrap/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('vendor/icons/icofont.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('css/custom.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('vendor/sidebar/demo.css'); ?>">
    </head>
    <body>
        <div class="osahan-index bg-c d-flex align-items-center justify-content-center vh-100 index-page">
            <div class="text-center">
                <a href="<?= base_url(); ?>"><i class="icofont-bus text-white display-1 bg-danger p-4 rounded-circle"></i></a><br>
                <div class="spinner"></div>
            </div>
        </div>
        <div class="osahan-fotter fixed-bottom m-3">
            <a href="<?= base_url('signin'); ?>" class="btn btn-block px-4 py-3 d-flex align-items-center osahanbus-btlan btn-danger text-white shadow">Get Started <i class="icofont-arrow-right ml-auto"></i></a>
        </div>
        <script src="<?= base_url('vendor/jquery/jquery.min.js'); ?>"></script>
        <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
        <script src="<?= base_url('vendor/owl-carousel/owl.carousel.html'); ?>"></script>
        <script src="<?= base_url('vendor/sidebar/hc-offcanvas-nav.js'); ?>"></script>
        <script src="<?= base_url('js/custom.js'); ?>"></script>
    </body>
</html>
