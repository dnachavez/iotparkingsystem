<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class SignOut extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
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

            session()->remove('user');

            return redirect()->to('signin');
        }
    }
}
