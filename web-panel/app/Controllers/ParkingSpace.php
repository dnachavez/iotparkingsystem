<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ParkingSpaceHistoryModel;
use App\Models\UserModel;
use App\Models\ParkingSpaceModel;
use App\Models\ParkingSpaceReservationModel;

class ParkingSpace extends BaseController
{
    protected $userModel;
    protected $parkingSpaceModel;
    protected $parkingSpaceReservationModel;
    protected $parkingSpaceHistoryModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->parkingSpaceModel = new ParkingSpaceModel();
        $this->parkingSpaceReservationModel = new ParkingSpaceReservationModel();
        $this->parkingSpaceHistoryModel = new ParkingSpaceHistoryModel();
    }

    public function index($id)
    {
        if (!session()->has('user')) {
            return redirect()->to('signin');
        } else {
            $userId = session()->get('user')['id'];
            
            if (!$this->userModel->find($userId)) {
                session()->remove('user');

                return redirect()->to('signin');
            }
        }
        
        if (!$id || !$this->parkingSpaceModel->find($id)) {
            return redirect()->to('dashboard');
        }
        
        $parkingSpace = $this->parkingSpaceModel->find($id);

        $now = new \DateTime('now');
        $currentDate = $now->format('Y-m-d');
        $currentTime = $now->format('H:i:s');

        $parkingSpaceReservations = $this->parkingSpaceReservationModel->where('parking_space_id', $id)->where('reservation_date', $currentDate)->where('status', '1')->findAll();
        
        $data = [
            'parkingSpace' => [
                'id' => $parkingSpace['id'],
                'name' => $parkingSpace['name'],
                'status' => $parkingSpace['status'],
            ],
            'parkingSpaceReservation' => [
                'isReserved' => false,
            ],
        ];

        foreach ($parkingSpaceReservations as $parkingSpaceReservation) {
            if ($currentTime >= $parkingSpaceReservation['reservation_time']) {
                $reservationTime = \DateTime::createFromFormat('H:i:s', $parkingSpaceReservation['reservation_time']);
                $formattedReservationTime = $reservationTime->format('h:i A');
                $data['parkingSpaceReservation'] = [
                    'isReserved' => true,
                    'name' => $parkingSpaceReservation['first_name'] . ' ' . $parkingSpaceReservation['middle_name'] . ' ' . $parkingSpaceReservation['last_name'],
                    'licensePlate' => $parkingSpaceReservation['license_plate'],
                    'reservationDate' => $parkingSpaceReservation['reservation_date'],
                    'reservationTime' => $formattedReservationTime,
                ];
            }
        }

        return view('parkingspace', $data);
    }

    public function reserve($id)
    {
        if (!session()->has('user')) {
            return redirect()->to('signin');
        } else {
            $userId = session()->get('user')['id'];
            
            if (!$this->userModel->find($userId)) {
                session()->remove('user');

                return redirect()->to('signin');
            }
        }
        
        if (!$id || !$this->parkingSpaceModel->find($id)) {
            return redirect()->to('dashboard');
        }
        
        $rules = [
            'first-name' => [
                'rules' => 'required|min_length[2]|max_length[50]',
                'errors' => [
                    'required' => 'Please enter a first name.',
                    'min_length' => 'First name must be at least 2 characters.',
                    'max_length' => 'First name must not exceed 50 characters.',
                ],
            ],
            'middle-name' => [
                'rules' => 'max_length[50]',
                'errors' => [
                    'max_length' => 'Middle name must not exceed 50 characters.',
                ],
            ],
            'last-name' => [
                'rules' => 'required|min_length[2]|max_length[50]',
                'errors' => [
                    'required' => 'Please enter a last name.',
                    'min_length' => 'Last name must be at least 2 characters.',
                    'max_length' => 'Last name must not exceed 50 characters.',
                ],
            ],
            'license-plate' => [
                'rules' => 'required|min_length[3]|max_length[10]',
                'errors' => [
                    'required' => 'Please enter a license plate.',
                    'min_length' => 'License plate must be at least 3 characters.',
                    'max_length' => 'License plate must not exceed 10 characters.',
                ],
            ],
            'reservation-date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please enter a reservation date.',
                ],
            ],
            'reservation-time' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please enter a reservation time.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('parking/space/' . $id)->withInput()->with('validation', $this->validator);
        }

        $firstName = $this->request->getPost('first-name');
        $middleName = $this->request->getPost('middle-name');
        $lastName = $this->request->getPost('last-name');
        $licensePlate = $this->request->getPost('license-plate');
        $reservationDate = $this->request->getPost('reservation-date');
        $reservationTime = $this->request->getPost('reservation-time');

        $formatReservationDate = \DateTime::createFromFormat('Y-m-d', $reservationDate);

        if (!$formatReservationDate) {
            $this->validator->setError('reservation-date', 'Please enter a valid date.');

            return redirect()->to('parking/space/' . $id)->withInput()->with('validation', $this->validator);
        }

        $formattedReservationDate = $formatReservationDate->format('Y-m-d');

        $formatReservationTime = \DateTime::createFromFormat('H:i', $reservationTime);

        if (!$formatReservationTime) {
            $this->validator->setError('reservation-time', 'Please enter a valid time.');

            return redirect()->to('parking/space/' . $id)->withInput()->with('validation', $this->validator);
        }

        $formattedReservationTime = $formatReservationTime->format('H:i:s');

        $parkingSpaceReservations = $this->parkingSpaceReservationModel->where('parking_space_id', $id)->where('reservation_date', $formattedReservationDate)->where('status', '1')->findAll();

        foreach ($parkingSpaceReservations as $parkingSpaceReservation) {
            if ($formattedReservationTime >= $parkingSpaceReservation['reservation_time']) {
                $this->validator->setError('reservation-date', 'The date has already been reserved.');
                
                $this->validator->setError('reservation-time', 'The time has already been reserved.');

                return redirect()->to('parking/space/' . $id)->withInput()->with('validation', $this->validator);
            }
        }
        
        $this->parkingSpaceReservationModel->insert([
            'parking_space_id' => $id,
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'license_plate' => $licensePlate,
            'reservation_date' => $formattedReservationDate,
            'reservation_time' => $formattedReservationTime,
            'status' => '1',
        ]);

        return redirect()->to('dashboard');
    }

    public function cancelReservation($id)
    {
        if (!session()->has('user')) {
            return redirect()->to('signin');
        } else {
            $userId = session()->get('user')['id'];
            
            if (!$this->userModel->find($userId)) {
                session()->remove('user');

                return redirect()->to('signin');
            }
        }
        
        if (!$id || !$this->parkingSpaceModel->find($id)) {
            return redirect()->to('dashboard');
        }

        $now = new \DateTime('now');
        $currentDate = $now->format('Y-m-d');
        $currentTime = $now->format('H:i:s');

        $parkingSpaceReservations = $this->parkingSpaceReservationModel->where('parking_space_id', $id)->where('reservation_date', $currentDate)->where('status', '1')->findAll();

        foreach ($parkingSpaceReservations as $parkingSpaceReservation) {
            if ($currentTime >= $parkingSpaceReservation['reservation_time']) {
                $this->parkingSpaceReservationModel->update($parkingSpaceReservation['id'], ['status' => '2']);

                $this->parkingSpaceModel->update($parkingSpaceReservation['parking_space_id'], ['status' => '1']);
            }
        }

        return redirect()->to('dashboard');
    }

    public function markUnavailable($id)
    {
        if (!session()->has('user')) {
            return redirect()->to('signin');
        } else {
            $userId = session()->get('user')['id'];
            
            if (!$this->userModel->find($userId)) {
                session()->remove('user');

                return redirect()->to('signin');
            }
        }
        
        if (!$id || !$this->parkingSpaceModel->find($id)) {
            return redirect()->to('dashboard');
        }

        $parkingSpace = $this->parkingSpaceModel->find($id);

        if ($parkingSpace['status'] == '1') {
            $this->parkingSpaceModel->update($id, ['status' => '0']);

            $this->parkingSpaceHistoryModel->insert([
                'parking_space_id' => $id,
                'status' => '0',
            ]);
        }

        if ($parkingSpace['status'] == '2') {
            $now = new \DateTime('now');
            $currentDate = $now->format('Y-m-d');
            $currentTime = $now->format('H:i:s');

            $parkingSpaceReservations = $this->parkingSpaceReservationModel->where('parking_space_id', $id)->where('reservation_date', $currentDate)->where('status', '1')->findAll();

            foreach ($parkingSpaceReservations as $parkingSpaceReservation) {
                if ($currentTime >= $parkingSpaceReservation['reservation_time']) {
                    $this->parkingSpaceReservationModel->update($parkingSpaceReservation['id'], ['status' => '0']);

                    $this->parkingSpaceModel->update($parkingSpaceReservation['parking_space_id'], ['status' => '0']);

                    $this->parkingSpaceHistoryModel->insert([
                        'parking_space_id' => $id,
                        'status' => '0',
                    ]);
                }
            }
        }

        return redirect()->to('dashboard');
    }

    public function markAvailable($id)
    {
        if (!session()->has('user')) {
            return redirect()->to('signin');
        } else {
            $userId = session()->get('user')['id'];
            
            if (!$this->userModel->find($userId)) {
                session()->remove('user');

                return redirect()->to('signin');
            }
        }
        
        if (!$id || !$this->parkingSpaceModel->find($id)) {
            return redirect()->to('dashboard');
        }

        $parkingSpace = $this->parkingSpaceModel->find($id);

        if ($parkingSpace['status'] == '0') {
            $this->parkingSpaceModel->update($id, ['status' => '1']);

            $this->parkingSpaceHistoryModel->insert([
                'parking_space_id' => $id,
                'status' => '1',
            ]);
        }

        return redirect()->to('dashboard');
    }
}
