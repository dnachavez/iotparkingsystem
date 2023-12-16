<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConstantModel;

class Tollgate extends BaseController
{
    protected $constantModel;

    public function __construct()
    {
        $this->constantModel = new ConstantModel();
    }

    public function index()
    {
        $tollgateConstant = $this->constantModel->where('name', 'tollgate')->first();

        if ($tollgateConstant['value'] == 'close') {
            $this->constantModel->where('name', 'tollgate')->set('value', 'open')->update();
        } else {
            $this->constantModel->where('name', 'tollgate')->set('value', 'close')->update();
        }

        return redirect()->to('dashboard');
    }
}
