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

    // Controller API đăng ký
    public function register()
    {
        if (!$this->checkLogin())
        {
            echo json_encode(array('status' => 'error', 'message' => 'Vui lòng đăng nhập'));
            return;
        }
        if (!$this->userModel->isAdmin())
        {
            echo json_encode(array('status' => 'error', 'message' => 'Bạn không có quyền thực hiện chức năng này'));
            return;
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $repassword = $this->request->getPost('repassword');
        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');
        $birthday = $this->request->getPost('birthday');
        $gender = $this->request->getPost('gender');
        $role = $this->request->getPost('role');

        // check input is empty
        if (empty($username) || empty($password) || empty($repassword) || empty($name) || empty($phone) || empty($birthday) || empty($gender) || empty($role))
        {
            echo json_encode(array('status' => 'error', 'message' => 'Thiếu thông tin'));
            return; 
        }

        if ($this->checkInjection($username) || $this->checkInjection($password)) {
            echo json_encode(array('status' => 'error', 'message' => 'Tài khoản hoặc mật khẩu không hợp lệ'));
            return;
        }

        // check password
        if ($password != $repassword)
        {
            echo json_encode(array('status' => 'error', 'message' => 'Mật khẩu không khớp'));
            return;
        }

        // check phone
        if (!$this->checkPhone($phone)) {
            echo json_encode(array('status' => 'error', 'message' => 'Số điện thoại không hợp lệ'));
            return;
        }

        // check birthday
        if (!$this->checkDate($birthday)) {
            echo json_encode(array('status' => 'error', 'message' => 'Ngày sinh không hợp lệ'));
            return;
        }
        // check gender
        if (!is_numeric($gender) || $gender < 0 || $gender > 1)
        {
            echo json_encode(array('status' => 'error', 'message' => 'Giới tính không hợp lệ'));
            return;
        }
        $this->userModel->register($username, md5($password), $name, $phone, $birthday, $gender, $role);
    }

    public function Statistical_Page()
    {
        $isLogin = $this->checkLogin();
        if (!$isLogin) {
            return redirect()->to(site_url('./login'));
        }
        $isAdmin = $this->userModel->isAdmin();
        if (!$isAdmin) {
            return redirect()->to(site_url('/'));
        }
        $header = view('Layouts/_header', array(
            'isLogin' => $isLogin,
            'isAdmin' => $isAdmin,
            'Page_Title' => 'Thống kê',
            'revenueToday' => $this->roomModel->getRevenueToday(),
            'revenueMonth' => $this->roomModel->getRevenueMonth(),
            'listRoom' => $this->roomModel->getListRoom(),
            'getAmountUserJoinThisWeek' => $this->userModel->getAmountUserJoinThisWeek(),
            'getTotalUser' => $this->userModel->getTotalUser(),
            'getStatisticRoom' => $this->roomModel->getStatisticRoom(),
            'Page_Resource' => array(
                '<link rel="stylesheet" href="./Assets/CSS/statistical.css">',
            )
        ));
        $footer = view('Layouts/_footer');
        $data = array(
            'header' => $header,
            'footer' => $footer,
            'profile' => $this->userModel->getProfile()
        );
        return view('Admin/statistical', $data);
    }

    // Controller Quản lý tài khoản
    public function Accounts_Manager_Page()
    {
        $isLogin = $this->checkLogin();
        if (!$isLogin) {
            return redirect()->to(site_url('./login'));
        }
        $isAdmin = $this->userModel->isAdmin();
        if (!$isAdmin) {
            return redirect()->to(site_url('/'));
        }
        $header = view('Layouts/_header', array(
            'isLogin' => $isLogin,
            'isAdmin' => $isAdmin,
            'Page_Title' => 'Quản lý tài khoản',
            'listUser' => $this->changeDateFormatInListUser($this->userModel->getListUser()),
            'Page_Resource' => array(
                '<link rel="stylesheet" href="./Assets/CSS/accounts.css">',
                '<script src="./Assets/Js/accounts.js"></script>'
            )
        ));
        $footer = view('Layouts/_footer');
        $data = array(
            'header' => $header,
            'footer' => $footer,
            'profile' => $this->userModel->getProfile()
        );
        return view('Admin/accounts', $data);
    }

    // Controller API xóa tài khoản
    public function deleteUser()
    {
        if (!$this->checkLogin()) {
            echo json_encode(array('status' => 'error', 'message' => 'Vui lòng đăng nhập'));
            return;
        }
        $isAdmin = $this->userModel->isAdmin();
        if (!$isAdmin) {
            echo json_encode(array('status' => 'error', 'message' => 'Bạn không có quyền thực hiện thao tác này'));
            return;
        }

        $id = $this->request->getPost('id');
        if (!isset($id)) {
            echo json_encode(array('status' => 'error', 'message' => 'Vui lòng nhập đầy đủ thông tin'));
            return;
        }
        // check id is number
        if (!is_numeric($id)) {
            echo json_encode(array('status' => 'error', 'message' => 'ID không hợp lệ'));
            return;
        }
        $this->userModel->deleteUser($id);
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

    // Đổi định dạng ngày trong danh sách user
    public function changeDateFormatInListUser($users)
    {
        for ($i = 0; $i < count($users); $i++) {
            $users[$i]['birth'] = $this->convertDate($users[$i]['birth']);
            $users[$i]['created'] = $this->convertDateTime2($users[$i]['created']);
        }
        return $users;
    }

    
}