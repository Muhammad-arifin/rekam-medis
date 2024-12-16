<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Login extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function process()
    {
        $model = new UserModel();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            return redirect()->to('/dashboard');
        } else {
            // Failed login
            return redirect()->back()->with('error', 'Invalid username or password');
        }
    }
}
