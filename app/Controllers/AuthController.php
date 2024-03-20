<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthController extends BaseController
{

    public function login()
    {
        return view('login_view');
    }

    public function processLogin()
    {
        $session = session();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (!$username || !$password) {
            // Redirect back to login page with error message
            return redirect()->to('/login')->with('error', 'Username and password are required');
        }

        $authModel = new \App\Models\AuthModel();
        $user = $authModel->getUser($username);

        // Ensure the user exists and the password matches
        if ($user && $password === $user['password']) {

            $departmentName = isset($user['department_name']) ? $user['department_name'] : null;

            // Convert user data to a session-friendly format
            $userData = [
                'user_id' => $user['user_id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'department_name' => $departmentName, // Add this line
            ];

            // Generate a unique session identifier
            $sessionIdentifier = md5($username . $password);

            // Set user session data with the session identifier
            $session->set('user_data', $userData);
            $session->set('session_identifier', $sessionIdentifier);

            // Redirect to dashboard or appropriate page
            return redirect()->to('/show_audits');
            
        } else {
            // Redirect back to login page with error message
            return redirect()->to('/login')->with('error', 'Invalid username or password');
        }
    }


    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}

