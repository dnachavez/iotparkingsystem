<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ParkingSpaceHistoryModel;
use App\Models\ParkingSpaceReservationModel;

class ParkingHistory extends BaseController
{
    protected $parkingSpaceHistoryModel;
    protected $parkingSpaceReservationModel;

    public function __construct()
    {
        $this->parkingSpaceHistoryModel = new ParkingSpaceHistoryModel();
        $this->parkingSpaceReservationModel = new ParkingSpaceReservationModel();
    }

    public function index()
    {
        $data = [
            'parkingHistories' => $this->parkingSpaceHistoryModel->orderBy('created_at', 'DESC')->findAll(),
            'parkingSpaceReservationCount' => $this->parkingSpaceReservationModel->where('status', '1')->countAllResults(),
        ];

        return view('parkinghistory', $data);
    }
}
