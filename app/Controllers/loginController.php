<?php

namespace App\Controllers;

use App\Models\loginModel;

class loginController extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function login()
    {
        $session = session();
        $loginModel = new loginModel();

        // Get the username and password from POST data
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Fetch user from the database
        $user = $loginModel->getUserByUsername($username);

        if ($user) {
            // Verify the password using password_verify()
            if (password_verify($password, $user['password'])) {
                // Check if the user is 'admin'
                $isAdmin = ($user['jenis'] === 'Pentadbir (Administrator)');

                // Set user data in session
                $session->set([
                    'username' => $user['username'],
                    'logged_in' => true,
                    'is_admin' => $isAdmin
                ]);

                // Redirect to a dashboard or homepage
                return redirect()->to('/dashboard');
            } else {
                // If password is incorrect, set an error message
                $session->setFlashdata('error', 'Katalaluan tidak sah');
                return redirect()->back();
            }
        } else {
            // If user is not found, set an error message
            $session->setFlashdata('error', 'ID tidak wujud');
            return redirect()->back();
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }

    public function register()
    {
        return view('registerUser');
    }

    public function registerUser()
    {
        $loginModel = new loginModel();
        $session = session();

        // Get the user inputs
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $email = $this->request->getPost('email');
        $jenis = $this->request->getPost('jenis');

        // Hash the password before saving it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the data for saving
        $data = [
            'username' => $username,
            'password' => $hashedPassword,
            'email' => $email,
            'jenis' => $jenis
        ];

        // Save the user in the database
        $loginModel->save($data);

        // Set success message and redirect
        $session->setFlashdata('success', 'Pengguna sistem baru sudah didaftar');
        return redirect()->to('/dashboard');
    }
}
