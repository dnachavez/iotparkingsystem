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
        <link rel="stylesheet" href="<?= base_url('vendor/slick/slick.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('vendor/slick/slick-theme.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('css/custom.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('vendor/sidebar/demo.css'); ?>">
    </head>
    <body>
        <div class="osahan-signup">
            <div class="osahan-header-nav shadow-sm p-3 d-flex align-items-center bg-danger">
                <h5 class="font-weight-normal mb-0 text-white"><a href="<?= base_url(); ?>" class="text-danger mr-3"><i class="icofont-rounded-left"></i></a> Sign in to your account</h5>
            </div>
            <div class="px-3 pt-3 pb-5">
                <form action="<?= base_url('signin/authorize'); ?>" method="post">
                    <div class="form-group">
                        <label for="username" class="text-muted f-10 mb-1">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter a username" value="<?= old('username'); ?>">
                        <?= (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('username')) ? '<div class="mb-3"><span class="text-danger small">' . session()->getFlashdata('validation')->getError('username') . '</span></div>' : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="password" class="text-muted f-10 mb-1">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter a username">
                        <?= (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('password')) ? '<div class="mb-3"><span class="text-danger small">' . session()->getFlashdata('validation')->getError('password') . '</span></div>' : ''; ?>
                    </div>
                    <?= csrf_field(); ?>
                    <button type="submit" class="btn btn-danger btn-block osahanbus-btn mb-4 rounded-1">Sign In</button>
                </form>
            </div>
        </div>
        <script src="<?= base_url('vendor/jquery/jquery.min.js'); ?>"></script>
        <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
        <script src="<?= base_url('vendor/slick/slick.min.js'); ?>"></script>
        <script src="<?= base_url('vendor/sidebar/hc-offcanvas-nav.js'); ?>"></script>
        <script src="<?= base_url('js/custom.js'); ?>"></script>
    </body>
</html>
