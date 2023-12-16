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
    <body class="bg-light">
        <div class="my-ticket padding-bt">
            <div class="osahan-header-nav shadow-sm p-3 d-flex align-items-center bg-danger">
                <h5 class="font-weight-normal mb-0 text-white">
                    <a href="<?= base_url('dashboard'); ?>" class="text-danger mr-3"><i class="icofont-rounded-left"></i></a>
                    Reservations
                </h5>
                <div class="ml-auto d-flex align-items-center">
                    <a href="#" class="toggle osahan-toggle h4 m-0 text-white ml-auto"><i class="icofont-navigation-menu"></i></a>
                </div>
            </div>
            <div class="your-ticket border-top row m-0 p-3">
                <?php if ($parkingSpaceReservations && count($parkingSpaceReservations) > 0): ?>
                    <?php foreach ($parkingSpaceReservations as $parkingSpaceReservation): ?>
                        <div class="bg-white rounded-1 shadow-sm p-3 mb-3 w-100">
                            <a href="#">
                                <div class="d-flex align-items-center mb-2">
                                    <small class="text-muted">Parking No. <?= $parkingSpaceReservation['parking_space_id']; ?></small>
                                    <?php switch ($parkingSpaceReservation['status']) {
                                        case '0':
                                            echo '<small class="text-danger ml-auto f-10">Inactive</small>';
                                            break;
                                        case '2':
                                            echo '<small class="text-dark ml-auto f-10">Cancelled</small>';
                                            break;
                                        
                                        default:
                                            echo '<small class="text-success ml-auto f-10">Active</small>';
                                            break;
                                    } ?>
                                </div>
                                <h6 class="mb-3 l-hght-18 font-weight-bold text-dark"><?= $parkingSpaceReservation['license_plate']; ?></h6>
                            </a>
                            <div class="row mx-0 mb-3">
                                <div class="col-6 p-0">
                                    <small class="text-muted mb-1 f-10 pr-1">Name</small>
                                    <p class="small mb-0 l-hght-14"><?= $parkingSpaceReservation['first_name']; ?> <?= $parkingSpaceReservation['middle_name']; ?> <?= $parkingSpaceReservation['last_name']; ?></p>
                                </div>
                                <div class="col-6 p-0">
                                    <small class="text-muted mb-1 f-10 pr-1">Reserved On</small>
                                    <?php
                                        $reservedOn = new DateTime($parkingSpaceReservation['created_at']);

                                        $formattedDate = $reservedOn->format('Y-m-d');
                                        $formattedTime = $reservedOn->format('g:i A');
                                        
                                        echo '<p class="small mb-0 l-hght-14">'. $formattedDate. ' ' . $formattedTime . '</p>';
                                    ?>
                                </div>
                            </div>
                            <div class="row mx-0">
                                <div class="col-6 p-0">
                                    <small class="text-muted mb-1 f-10 pr-1">Reservation Date</small>
                                    <p class="small mb-0 l-hght-14"><?= $parkingSpaceReservation['reservation_date']; ?></p>
                                </div>
                                <div class="col-6 p-0">
                                    <small class="text-muted mb-1 f-10 pr-1">Reservation Time</small>
                                    <?php
                                        $reservationTime = \DateTime::createFromFormat('H:i:s', $parkingSpaceReservation['reservation_time']);
                                        $formattedReservationTime = $reservationTime->format('h:i A');

                                        echo '<p class="small mb-0 l-hght-14">' . $formattedReservationTime . '</p>';
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-white rounded-1 shadow-sm p-3 mb-3 w-100">
                        <p class="text-muted small mb-0">No data to display</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="fixed-bottom p-3">
            <div class="footer-menu row m-0 bg-danger shadow rounded-2">
                <div class="col-4 p-0 text-center">
                    <a href="<?= base_url('dashboard'); ?>" class="home text-white">
                        <span class="icofont-pie-chart h5"></span>
                        <p class="mb-0 small">Dashboard</p>
                    </a>
                </div>
                <div class="col-4 p-0 text-center">
                    <a href="<?= base_url('parking/reservation'); ?>" class="home text-white active">
                        <span class="icofont-ticket h5"></span>
                        <small class="osahan-n"><?= $parkingSpaceReservationCount; ?></small>
                        <p class="mb-0 small">Reservations</p>
                    </a>
                </div>
                <div class="col-4 p-0 text-center">
                    <a href="<?= base_url('parking/history'); ?>" class="home text-white">
                        <span class="icofont-notification h5"></span>
                        <p class="mb-0 small">History</p>
                    </a>
                </div>
            </div>
        </div>
        <nav id="main-nav">
            <ul class="second-nav">
                <li>
                    <a href="#" class="bg-danger sidebar-user d-flex align-items-center py-4 px-3 border-0 mb-0">
                        <img src="<?= base_url('img/logo.png'); ?>" alt="" class="img-fluid rounded-pill mr-3" style="width: 24%;">
                        <div class="text-white">
                            <h6 class="mb-0">IoT Parking System</h6>
                            <span class="f-10 text-white-50">Version 1.0</span>
                        </div>
                    </a>
                </li>
                <li><a href="<?= base_url(); ?>"><i class="icofont-home mr-2"></i> Home</a></li>
                <li><a href="<?= base_url('dashboard'); ?>"><i class="icofont-pie-chart mr-2"></i> Dashboard</a></li>
                <li><a href="<?= base_url('parking/reservation'); ?>"><i class="icofont-ticket mr-2"></i> Reservations</a></li>
                <li><a href="<?= base_url('parking/history'); ?>"><i class="icofont-notification mr-2"></i> History</a></li>
                <li>
                    <a href="#"><i class="icofont-user mr-2"></i> Account</a>
                    <ul>
                        <li><a href="<?= base_url('signout'); ?>">Sign Out</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="bottom-nav">
                <li class="email">
                    <a href="mailto:dna.chavez@outlook.com" class="nav-item text-center" tabindex="0" role="menuitem">
                        <p class="h5 m-0"><i class="icofont-envelope"></i></p>
                        Email
                    </a>
                </li>
                <li class="github">
                    <a href="https://github.com/dnachavez" target="_blank" rel="noopener noreferrer" class="nav-item text-center" tabindex="0" role="menuitem">
                        <p class="h5 m-0"><i class="icofont-github"></i></p>
                        GitHub
                    </a>
                </li>
                <li class="ko-fi">
                    <a href="https://dnachavez.ph" target="_blank" rel="noopener noreferrer" class="nav-item text-center" tabindex="0" role="menuitem">
                        <p class="h5 m-0"><i class="icofont-info-circle"></i></p>
                        Portfolio
                    </a>
                </li>
            </ul>
        </nav>
        <script src="<?= base_url('vendor/jquery/jquery.min.js'); ?>"></script>
        <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
        <script src="<?= base_url('vendor/slick/slick.min.js'); ?>"></script>
        <script src="<?= base_url('vendor/sidebar/hc-offcanvas-nav.js'); ?>"></script>
        <script src="<?= base_url('js/custom.js'); ?>"></script>
    </body>
</html>