<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConstantModel;
use App\Models\ParkingSpaceHistoryModel;
use App\Models\ParkingSpaceModel;
use App\Models\ParkingSpaceReservationModel;
use App\Models\UserModel;

class ParkingSpaceApi extends BaseController
{
    protected $parkingSpaceReservationModel;
    protected $userModel;
    protected $parkingSpaceModel;
    protected $constantModel;
    protected $parkingSpaceHistoryModel;

    public function __construct()
    {
        $this->parkingSpaceReservationModel = new ParkingSpaceReservationModel();
        $this->userModel = new UserModel();
        $this->parkingSpaceModel = new ParkingSpaceModel();
        $this->constantModel = new ConstantModel();
        $this->parkingSpaceHistoryModel = new ParkingSpaceHistoryModel();
    }
    
    public function index()
    {
        //
    }

    public function parkingSpaceStatus()
    {
        $now = new \DateTime('now');
        $currentDate = $now->format('Y-m-d');
        $currentTime = $now->format('H:i:s');

        $parkingSpaceReservations = $this->parkingSpaceReservationModel->where('status', '1')->findAll();

        foreach ($parkingSpaceReservations as $parkingSpaceReservation) {
            if ($currentDate == $parkingSpaceReservation['reservation_date'] && $currentTime >= $parkingSpaceReservation['reservation_time']) {
                $this->parkingSpaceModel->update($parkingSpaceReservation['parking_space_id'], ['status' => '2']);
            } elseif ($currentDate > $parkingSpaceReservation['reservation_date']) {
                $this->parkingSpaceReservationModel->update($parkingSpaceReservation['id'], ['status' => '2']);
                $this->parkingSpaceModel->update($parkingSpaceReservation['parking_space_id'], ['status' => '1']);
            }
        }

        $parkingSpaces = $this->parkingSpaceModel->findAll();

        $userCount = $this->userModel->countAllResults();
        $parkingSpaceCount = $this->parkingSpaceModel->countAllResults();
        $parkingSpaceReservationCount = $this->parkingSpaceReservationModel->where('status', '1')->countAllResults();
        $parkingSpaceHistoryCount = $this->parkingSpaceHistoryModel->countAllResults();

        $data = [];

        foreach ($parkingSpaces as $parkingSpace) {
            $data[] = [
                'id' => $parkingSpace['id'],
                'status' => $parkingSpace['status'],
            ];
        }

        $data['counts'] = [
            'users' => $userCount,
            'parkingSpaces' => $parkingSpaceCount,
            'reservations' => $parkingSpaceReservationCount,
            'history' => $parkingSpaceHistoryCount,
        ];

        return $this->response->setJSON($data);
    }

    public function parkingStatus()
    {
        $parkingSpaces = $this->parkingSpaceModel->findAll();

        $parkingSpaceData = [];

        foreach ($parkingSpaces as $parkingSpace) {
            $parkingSpaceData[] = [
                'parkingSpaceId' => $parkingSpace['id'],
                'parkingSpaceStatus' => $parkingSpace['status'] == '0' ? 'unavailable' : ($parkingSpace['status'] == '2' ? 'reserved' : 'available'),
            ];
        }

        $tollgateConstant = $this->constantModel->where('name', 'tollgate')->first();

        $data = [
            'tollgateStatus' => $tollgateConstant['value'],
            'parkingSpaces' => $parkingSpaceData,
        ];

        return $this->response->setJSON($data);
    }

    public function updateParkingStatus()
    {
        if ($this->request->is('post')) {
            $postData = $this->request->getJSON();
    
            $tollgateStatus = $postData->tollgateStatus ?? null;
            $parkingSpaceId = $postData->parkingSpaceId ?? null;
            $parkingSpaceStatus = $postData->parkingSpaceStatus ?? null;
    
            if ($tollgateStatus !== null) {
                if ($this->constantModel->where('name', 'tollgate')->set('value', $tollgateStatus)->update()) {
                    return $this->response->setJSON(['status' => 'success', 'message' => 'Tollgate status has been updated.']);
                } else {
                    return $this->response->setJSON(['status' => 'fail', 'message' => 'Error updating tollgate status.']);
                }
            }
    
            if ($parkingSpaceId !== null && $parkingSpaceStatus !== null) {
                $parkingSpace = $this->parkingSpaceModel->find($parkingSpaceId);
                
                if ($parkingSpace['status'] == $parkingSpaceStatus) {
                    return $this->response->setJSON(['status' => 'fail', 'message' => 'No change in parking space status.']);
                }
                
                if ($this->parkingSpaceModel->update($parkingSpaceId, ['status' => $parkingSpaceStatus])) {
                    $this->parkingSpaceHistoryModel->insert([
                        'parking_space_id' => $parkingSpaceId,
                        'status' => $parkingSpaceStatus,
                    ]);
    
                    return $this->response->setJSON(['status' => 'success', 'message' => 'Parking space status has been updated.']);
                } else {
                    return $this->response->setJSON(['status' => 'fail', 'message' => 'Error updating parking space status.']);
                }
            }
    
            return $this->response->setJSON(['status' => 'fail', 'message' => 'Invalid request.']);
        }
    }
}
