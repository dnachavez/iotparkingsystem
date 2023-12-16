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
        <div class="payment padding-bt">
            <div class="osahan-header-nav shadow-sm p-3 d-flex align-items-center bg-danger">
                <h5 class="font-weight-normal mb-0 text-white">
                    <a href="<?= base_url('dashboard'); ?>" class="text-danger mr-3"><i class="icofont-rounded-left"></i></a>
                    Parking Space
                </h5>
                <div class="ml-auto d-flex align-items-center">
                    <a href="#" class="toggle osahan-toggle h4 m-0 text-white ml-auto"><i class="icofont-navigation-menu"></i></a>
                </div>
            </div>
            <?php if ($parkingSpaceReservation['isReserved']): ?>
                <div class="your-ticket p-3">
                    <div class="list_item d-flex rounded-1 col-12 m-0 bg-white shadow-sm mb-3">
                        <div class="pl-3 py-3 d-flex w-100">
                            <div class="bus_details w-100">
                                <p class="mb-2 l-hght-18 font-weight-bold">Reservation Details</p>
                                <div class="l-hght-10 d-flex align-items-center my-2">
                                    <small class="text-muted mb-0 pr-1">Name</small>
                                    <p class="small mb-0 l-hght-14 ml-auto"><?= $parkingSpaceReservation['name']; ?></p>
                                </div>
                                <div class="l-hght-10 d-flex align-items-center my-2">
                                    <small class="text-muted mb-0 pr-1">License Plate</small>
                                    <p class="small mb-0 l-hght-14 ml-auto"><?= $parkingSpaceReservation['licensePlate']; ?></p>
                                </div>
                                <div class="l-hght-10 d-flex align-items-center my-2">
                                    <small class="text-muted mb-0 pr-1">Reservation Date</small>
                                    <p class="small mb-0 l-hght-14 ml-auto"><?= $parkingSpaceReservation['reservationDate']; ?></p>
                                </div>
                                <div class="l-hght-10 d-flex align-items-center mt-2">
                                    <small class="text-muted mb-0 pr-1">Reserved Time</small>
                                    <p class="small mb-0 l-hght-14 ml-auto"><?= $parkingSpaceReservation['reservationTime']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="fixed-bottom payment-borrad shadow bg-white m-3 rounded-1 p-3">
            <div class="d-flex small">
                <p>Set Parking Space</p>
                <?php if ($parkingSpace['status'] == '0'): ?>
                    <p class="ml-auto font-weight-bold text-danger">Unavailable</p>
                <?php elseif ($parkingSpace['status'] == '2'): ?>
                    <p class="ml-auto font-weight-bold text-dark">Reserved</p>
                <?php else: ?>
                    <p class="ml-auto font-weight-bold text-success">Available</p>
                <?php endif; ?>
            </div>
            <div class="d-flex small">
                <form action="<?= base_url('parking/space/' . $parkingSpace['id'] . '/reserve'); ?>" method="post" class="w-100">
                    <?php if ($parkingSpace['status'] == '1'): ?>
                        <div class="form-group row mb-2">
                            <div class="col-4">
                                <label for="first-name" class="mb-1 small text-muted">First Name</label>
                                <input type="text" name="first-name" id="first-name" class="form-control text-center form-control-sm" placeholder="Enter a first name" value="<?= old('first-name'); ?>">
                                <?= (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('first-name')) ? '<div class="mb-3"><span class="text-danger small">' . session()->getFlashdata('validation')->getError('first-name') . '</span></div>' : ''; ?>
                            </div>
                            <div class="col-4">
                                <label for="middle-name" class="mb-1 small text-muted">Middle Name</label>
                                <input type="text" name="middle-name" id="middle-name" class="form-control text-center form-control-sm" placeholder="Enter a middle name" value="<?= old('middle-name'); ?>">
                                <?= (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('middle-name')) ? '<div class="mb-3"><span class="text-danger small">' . session()->getFlashdata('validation')->getError('middle-name') . '</span></div>' : ''; ?>
                            </div>
                            <div class="col-4">
                                <label for="last-name" class="mb-1 small text-muted">Last Name</label>
                                <input type="text" name="last-name" id="last-name" class="form-control text-center form-control-sm" placeholder="Enter a last name" value="<?= old('last-name'); ?>">
                                <?= (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('last-name')) ? '<div class="mb-3"><span class="text-danger small">' . session()->getFlashdata('validation')->getError('last-name') . '</span></div>' : ''; ?>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="license-plate" class="mb-1 small text-muted">License Plate</label>
                            <input type="text" name="license-plate" id="license-plate" class="form-control form-control-sm" placeholder="Enter a license plate" value="<?= old('license-plate'); ?>">
                            <?= (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('license-plate')) ? '<div class="mb-3"><span class="text-danger small">' . session()->getFlashdata('validation')->getError('license-plate') . '</span></div>' : ''; ?>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-6">
                                <label for="reservation-date" class="mb-1 small text-muted">Reservation Date</label>
                                <input type="date" name="reservation-date" id="reservation-date" class="form-control text-center form-control-sm" placeholder="Enter a reservation date">
                                <?= (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('reservation-date')) ? '<div class="mb-3"><span class="text-danger small">' . session()->getFlashdata('validation')->getError('reservation-date') . '</span></div>' : ''; ?>
                            </div>
                            <div class="col-6">
                                <label for="reservation-time" class="mb-1 small text-muted">Reservation Time</label>
                                <input type="time" name="reservation-time" id="reservation-time" class="form-control text-center form-control-sm" placeholder="Enter a reservation time">
                                <?= (session()->getFlashdata('validation') && session()->getFlashdata('validation')->hasError('reservation-time')) ? '<div class="mb-3"><span class="text-danger small">' . session()->getFlashdata('validation')->getError('reservation-time') . '</span></div>' : ''; ?>
                            </div>
                        </div>
                        <?= csrf_field(); ?>
                        <button type="submit" class="btn btn-danger btn-block">Set Reservation</button>
                    <?php endif; ?>
                    <?php if ($parkingSpace['status'] == '2'): ?>
                        <a href="<?= base_url('parking/space/' . $parkingSpace['id'] . '/reserve/cancel'); ?>" class="btn btn-danger btn-block">Cancel Reservation</a>
                    <?php endif; ?>
                    <?php if ($parkingSpace['status'] == '1' || $parkingSpace['status'] == '2'): ?>
                        <a href="<?= base_url('parking/space/' . $parkingSpace['id'] . '/mark/unavailable'); ?>" class="btn btn-danger btn-block">Mark Unavailable</a>
                    <?php else: ?>
                        <a href="<?= base_url('parking/space/' . $parkingSpace['id'] . '/mark/available'); ?>" class="btn btn-danger btn-block">Mark Available</a>
                    <?php endif; ?>
                </form>
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