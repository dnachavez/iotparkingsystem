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
        <link rel="stylesheet" href="<?= base_url('vendor/select-tool/dist/css/select2.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('css/custom.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('vendor/sidebar/demo.css'); ?>">
    </head>
    <body class="bg-light">
        <div class="osahan-verification">
            <div class="p-3 shadow bg-danger danger-nav osahan-home-header">
                <div class="font-weight-normal mb-0 d-flex align-items-center">
                    <img src="<?= base_url('img/logo.png'); ?>" alt="" class="img-fluid osahan-nav-logo">
                    <div class="ml-auto d-flex align-items-center">
                        <a href="#" class="toggle osahan-toggle h4 m-0 text-white ml-auto"><i class="icofont-navigation-menu"></i></a>
                    </div>
                </div>
            </div>
            <div class="bg-danger px-3 pb-3">
                <div class="bg-white rounded-1 p-3">
                    <form action="<?= base_url('parking/reservation'); ?>" method="get">
                        <div class="form-group border-bottom pb-2">
                            <label for="parking-space" class="mb-2"><span class="icofont-search-map text-danger"></span> Parking Space</label><br>
                            <select name="parking-space" id="parking-space" class="js-example-basic-single form-control">
                                <option value="">Select a parking space</option>
                                <?php foreach ($parkingSpaces as $parkingSpace): ?>
                                    <option value="<?= $parkingSpace['id']; ?>"><?= $parkingSpace['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group border-bottom pb-1">
                            <label for="reservation-date" class="mb-2"><span class="icofont-ui-calendar text-danger"></span> Reservation Date</label><br>
                            <input type="date" name="reservation-date" id="reservation-date" class="form-control border-0 p-0">
                        </div>
                        <?= csrf_field(); ?>
                        <button type="submit" class="btn btn-danger btn-block osahanbus-btn rounded-1">Search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="seat-select padding-bt">
            <div class="ticket p-3">
                <div class="bg-white rounded-1 shadow-sm p-3 mb-3 w-100">
                    <div class="row text-center mx-0 mb-3">
                        <div class="col-6 p-0">
                            <small class="text-muted mb-1 f-10 pr-1">Users</small>
                            <p class="small mb-0 l-hght-14" id="user-count"><?= $userCount; ?></p>
                        </div>
                        <div class="col-6 p-0">
                            <small class="text-muted mb-1 f-10 pr-1">Parking Spaces</small>
                            <p class="small mb-0 l-hght-14" id="parking-space-count"><?= $parkingSpaceCount; ?></p>
                        </div>
                    </div>
                    <div class="row text-center mx-0 mb-3">
                        <div class="col-6 p-0">
                            <small class="text-muted mb-1 f-10 pr-1">Reservations</small>
                            <p class="small mb-0 l-hght-14" id="parking-space-reservation-count"><?= $parkingSpaceReservationCount; ?></p>
                        </div>
                        <div class="col-6 p-0">
                            <small class="text-muted mb-1 f-10 pr-1">History</small>
                            <p class="small mb-0 l-hght-14" id="parking-space-history-count"><?= $parkingSpaceHistoryCount; ?></p>
                        </div>
                    </div>
                </div>
                <div class="select-seat row bg-white mx-0 px-3 pt-3 pb-1 mb-3 rounded-1 shadow-sm">
                    <div class="col-8 pl-0">
                        <div class="d-flex">
                            <div class="sold text-center">
                                <img src="<?= base_url('img/sold-seat.png'); ?>" alt="" class="img-fluid mb-1">
                                <p class="small f-10">Unavailable</p>
                            </div>
                            <div class="sold text-center mx-3">
                                <img src="<?= base_url('img/available-seat.png'); ?>" alt="" class="img-fluid mb-1">
                                <p class="small f-10">Reserved</p>
                            </div>
                            <div class="sold text-center">
                                <img src="<?= base_url('img/selected-seat.png'); ?>" alt="" class="img-fluid mb-1">
                                <p class="small f-10">Available</p>
                            </div>
                        </div>
                        <div class="select-seat">
                            <div class="checkboxes-seat mt-4">
                                <?php if ($parkingSpaces && count($parkingSpaces) > 0): ?>
                                    <?php foreach ($parkingSpaces as $parkingSpaceIndex => $parkingSpace): ?>
                                        <?php if ($parkingSpaceIndex % 2 == 0): ?>
                                            <div class="btn-group btn-group-toggle d-block mb-1" data-toggle="buttons">
                                        <?php endif; ?>
                                        <?php switch ($parkingSpace['status']) {
                                            case '0':
                                                $parkingSpaceClass = 'btn check-seat btn-danger small btn-sm rounded mr-2 mb-2';
                                                $parkingSpaceStyle = 'background-color: #bd2130;';
                                                break;
                                            case '2':
                                                $parkingSpaceClass = 'btn check-seat btn-dark small btn-sm rounded mr-2 mb-2';
                                                $parkingSpaceStyle = 'background-color: #1d2124;';
                                                break;
                                            
                                            default:
                                                $parkingSpaceClass = 'btn check-seat btn-success small btn-sm rounded mr-2 mb-2';
                                                $parkingSpaceStyle = 'background-color: #1e7e34;';
                                                break;
                                        } ?>
                                        <label for="parking-space-<?= $parkingSpace['id']; ?>" class="<?= $parkingSpaceClass; ?>" id="parking-space-<?= $parkingSpace['id']; ?>" style="<?= $parkingSpaceStyle; ?> color: #fff;" onclick="window.location.href = '<?= base_url('parking/space/' . $parkingSpace['id']); ?>'">
                                            <input type="checkbox" name="parking-space-<?= $parkingSpace['id']; ?>" autocomplete="off">
                                            <?= $parkingSpace['name']; ?>
                                        </label>
                                        <?php if ($parkingSpaceIndex % 2 != 0 || $parkingSpaceIndex == count($parkingSpaces) - 1): ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted small">No data to display</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 text-right pr-0">
                        <img src="<?= base_url('img/driver.png'); ?>" alt="" class="img-fluid mb-4">
                        <div class="checkboxes-seat mt-4">
                            <div class="btn-group btn-group-toggle d-block mb-1" data-toggle="buttons">
                                <?php switch ($tollgateConstant['value']) {
                                    case 'close':
                                        $tollgateClass = 'btn check-seat btn-danger small btn-sm rounded mr-2 mb-2';
                                        $tollgateStyle = 'background-color: #bd2130;';
                                        break;
                                    
                                    default:
                                        $tollgateClass = 'btn check-seat btn-success small btn-sm rounded mr-2 mb-2';
                                        $tollgateStyle = 'background-color: #1e7e34;';
                                        break;
                                } ?>
                                <label for="tollgate" class="<?= $tollgateClass; ?>" style="<?= $tollgateStyle; ?> color: #fff;" onclick="window.location.href = '<?= base_url('parking/tollgate'); ?>'">
                                    <input type="checkbox" name="tollgate" id="tollgate" autocomplete="off">
                                    TG
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fixed-bottom p-3">
            <div class="footer-menu row m-0 bg-danger shadow rounded-2">
                <div class="col-4 p-0 text-center">
                    <a href="<?= base_url('dashboard'); ?>" class="home text-white active">
                        <span class="icofont-pie-chart h5"></span>
                        <p class="mb-0 small">Dashboard</p>
                    </a>
                </div>
                <div class="col-4 p-0 text-center">
                    <a href="<?= base_url('parking/reservation'); ?>" class="home text-white">
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
        <script src="<?= base_url('vendor/select-tool/dist/js/select2.min.js'); ?>"></script>
        <script src="<?= base_url('vendor/sidebar/hc-offcanvas-nav.js'); ?>"></script>
        <script src="<?= base_url('js/custom.js'); ?>"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setInterval(checkParkingStatus, 1000);

                function checkParkingStatus() {
                    fetch('<?= base_url('api/parking/space/status'); ?>')
                        .then(response => response.json())
                        .then(data => {
                            Object.values(data).forEach(item => {
                                if(item && item.id) {
                                    var parkingSpaceElement = document.getElementById('parking-space-' + item.id);
                                    if (parkingSpaceElement) {
                                        var newParkingSpaceClass = item.status == '0' ? 'btn-danger' : (item.status == '1' ? 'btn-success' : 'btn-dark');
                                        var newParkingSpaceStyle = item.status == '0' ? 'background-color: #bd2130; color: #ffffff;' : (item.status == '1' ? 'background-color: #1e7e34; color: #ffffff;' : 'background-color: #1d2124; color: #ffffff;');

                                        parkingSpaceElement.className = 'btn check-seat ' + newParkingSpaceClass + ' small btn-sm rounded mr-2 mb-2';
                                        parkingSpaceElement.style = newParkingSpaceStyle;
                                    }
                                }
                            });

                            if(data.counts) {
                                document.getElementById('user-count').innerHTML = data.counts.users;
                                document.getElementById('parking-space-count').innerHTML = data.counts.parkingSpaces;
                                document.getElementById('parking-space-reservation-count').innerHTML = data.counts.reservations;
                                document.getElementById('parking-space-history-count').innerHTML = data.counts.history;
                            }
                        });
                }
            });
        </script>
    </body>
</html>
