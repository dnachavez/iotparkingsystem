<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConstantModel;
use App\Models\ParkingSpaceHistoryModel;
use App\Models\ParkingSpaceModel;
use App\Models\ParkingSpaceReservationModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $userModel;
    protected $parkingSpaceModel;
    protected $parkingSpaceReservationModel;
    protected $parkingSpaceHistoryModel;
    protected $constantModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->parkingSpaceModel = new ParkingSpaceModel();
        $this->parkingSpaceReservationModel = new ParkingSpaceReservationModel();
        $this->parkingSpaceHistoryModel = new ParkingSpaceHistoryModel();
        $this->constantModel = new ConstantModel();
    }

    public function index()
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

        $data = [
            'parkingSpaces' => $this->parkingSpaceModel->findAll(),
            'userCount' => $this->userModel->countAllResults(),
            'parkingSpaceCount' => $this->parkingSpaceModel->countAllResults(),
            'parkingSpaceReservationCount' => $this->parkingSpaceReservationModel->where('status', '1')->countAllResults(),
            'parkingSpaceHistoryCount' => $this->parkingSpaceHistoryModel->countAllResults(),
            'tollgateConstant' => $this->constantModel->where('name', 'tollgate')->first(),
        ];

        return view('dashboard', $data);
    }
}
