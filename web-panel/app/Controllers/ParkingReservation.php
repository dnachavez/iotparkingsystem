<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ParkingSpaceReservationModel;

class ParkingReservation extends BaseController
{
    protected $parkingSpaceReservationModel;

    public function __construct()
    {
        $this->parkingSpaceReservationModel = new ParkingSpaceReservationModel();
    }

    public function index()
    {
        $parkingSpace = $this->request->getGet('parking-space');
        $reservationDate = $this->request->getGet('reservation-date');

        $data = [
            'parkingSpaceReservationCount' => $this->parkingSpaceReservationModel->where('status', '1')->countAllResults(),
            'parkingSpaceReservations' => $this->reservationFilter($parkingSpace, $reservationDate),
        ];

        return view('parkingreservation', $data);
    }

    private function reservationFilter($parkingSpace, $reservationDate)
    {
        if ($parkingSpace && $reservationDate) {
            return $this->parkingSpaceReservationModel->where('parking_space_id', $parkingSpace)->where('reservation_date', $reservationDate)->orderBy('created_at', 'DESC')->findAll();
        } elseif ($parkingSpace) {
            return $this->parkingSpaceReservationModel->where('parking_space_id', $parkingSpace)->orderBy('created_at', 'DESC')->findAll();
        } elseif ($reservationDate) {
            return $this->parkingSpaceReservationModel->where('reservation_date', $reservationDate)->orderBy('created_at', 'DESC')->findAll();
        } else {
            return $this->parkingSpaceReservationModel->orderBy('created_at', 'DESC')->findAll();
        }
    }
}
