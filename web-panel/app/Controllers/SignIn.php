<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class SignIn extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (session()->has('user')) {
            $userId = session()->get('user')['id'];
            
            if (!$this->userModel->find($userId)) {
                session()->remove('user');

                return redirect()->to('/');
            }

            return redirect()->to('dashboard');
        }

        return view('signin');
    }

    public function authorize()
    {
        if ($this->request->is('post')) {
            $rules = [
                'username' => [
                    'rules' => 'required|min_length[4]|max_length[15]|alpha_dash|is_not_unique[users.username]',
                    'errors' => [
                        'required' => 'Please enter a username.',
                        'min_length' => 'Username must be at least 4 characters.',
                        'max_length' => 'Username must not exceed 15 characters.',
                        'alpha_dash' => 'Username must contain alphanumeric characters, underscores or dashes only.',
                        'is_not_unique' => 'Please enter a valid username.',
                    ],
                ],
                'password' => [
                    'rules' => 'required|min_length[6]|max_length[60]|alpha_numeric_punct',
                    'errors' => [
                        'required' => 'Please enter a password.',
                        'min_length' => 'Password must be at least 6 characters.',
                        'max_length' => 'Password must not exceed 60 characters.',
                        'alpha_numeric_punct' => 'Password must contain alphanumeric characters, space, or limited set of punctuation characters only.',
                    ],
                ],
            ];

            if (!$this->validate($rules)) {
                return redirect()->to('signin')->withInput()->with('validation', $this->validator);
            }

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = $this->userModel->where('username', $username)->first();

            if (!$user) {
                $this->validator->setError('username', 'Please enter a valid username.');

                return redirect()->to('signin')->withInput()->with('validation', $this->validator);
            }

            if (!password_verify($password, $user['password'])) {
                $this->validator->setError('password', 'Your password is incorrect.');

                return redirect()->to('signin')->withInput()->with('validation', $this->validator);
            }

            session()->set('user', [
                'id' => $user['id'],
                'role' => $user['role'],
            ]);

            return redirect()->to('dashboard');
        }
    }
}
