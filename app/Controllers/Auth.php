<?php namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
{
    $data['username'] = session()->get('username'); // Atur nama pengguna dari session
    return view('login', $data);
}

    public function authenticate()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $model = new UserModel();
        $user = $model->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set('logged_in', true);
            return redirect()->to('/dashboard');
        } else {
            session()->setFlashdata('error', 'Invalid username or password');
            return redirect()->to('/login');
        }
    }

    public function logout()
{
    session()->destroy(); // Hapus session
    return redirect()->to('/login'); // Arahkan kembali ke halaman login
}



}
