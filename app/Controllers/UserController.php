<?php

namespace App\Controllers;

class UserController extends HomeController
{
    public function __construct()
    {
        parent::__construct();
    }

    // Controller API đăng nhập
    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $password = md5($password);
        if (!isset($username) || !isset($password)) {
            echo json_encode(array('status' => 'error', 'message' => 'Vui lòng nhập đầy đủ thông tin'));
            return;
        }
        if ($this->checkInjection($username) || $this->checkInjection($password)) {
            echo json_encode(array('status' => 'error', 'message' => 'Tài khoản hoặc mật khẩu không hợp lệ'));
            return;
        }
        $this->userModel->login($username, $password);
    }

    // Controller đăng xuất
    public function logout()
    {
        $this->userModel->logout();
        return redirect()->to(site_url('/'));
    }

    // Controller API cập nhật thông tin cá nhân
    public function updateProfile()
    {
        $data = $this->request->getPost();
        if (!isset($data['name']) || !isset($data['phone']) || !isset($data['gender']) || !isset($data['birth'])) {
            echo json_encode(array('status' => 'error', 'message' => 'Vui lòng nhập đầy đủ thông tin'));
            return;
        }
        if (!$this->checkPhone($data['phone']) || !$this->checkDate($data['birth']) || !$this->checkGender($data['gender'])) {
            echo json_encode(array('status' => 'error', 'message' => 'Tên, ngày sinh, số điện thoại, giới tính không hợp lệ'));
            return;
        }
        $data = array(
            'name' => $data['name'],
            'gender' => $data['gender'],
            'phone_number' => $data['phone'],
            'birth' => $data['birth']
        );
        $this->userModel->updateProfile($data);
    }

    
}