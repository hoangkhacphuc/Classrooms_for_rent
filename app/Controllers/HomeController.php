<?php

namespace App\Controllers;

use org\bovigo\vfs\vfsStream;

class HomeController extends BaseController
{

    public $homeModel;
    public $userModel;
    public $shiftModel;
    public $roomModel;

    public function __construct()
    {
        $this->homeModel = new \App\Models\HomeModel();
        $this->userModel = new \App\Models\UserModel();
        $this->shiftModel = new \App\Models\ShiftModel();
        $this->roomModel = new \App\Models\RoomModel();
    }

    public function index()
    {
        $isLogin = $this->checkLogin();
        if (!$isLogin) {
            return redirect()->to(site_url('./login'));
        }
        $isAdmin = $this->userModel->isAdmin();
        $header = view('Layouts/_header', array(
            'isLogin' => $isLogin,
            'isAdmin' => $isAdmin,
            'Page_Title' => 'Trang Chủ',
            'Page_Resource' => array(
                '<link rel="stylesheet" href="./Assets/CSS/index.css">',
                '<script src="./Assets/Js/index.js"></script>'
            )
        ));
        $footer = view('Layouts/_footer');
        $data = array(
            'header' => $header,
            'footer' => $footer,
            'profile' => $this->userModel->getProfile()
        );
        return view('Client/index', $data);
    }

    public function Login_Page()
    {
        $isLogin = $this->checkLogin();
        if ($isLogin) {
            return redirect()->to(site_url('/'));
        }
        $header = view('Layouts/_header', array(
            'isLogin' => $isLogin,
            'Page_Title' => 'Đăng nhập',
            'Page_Resource' => array(
                '<link rel="stylesheet" href="./Assets/CSS/login.css">',
                '<script src="./Assets/Js/login.js"></script>'
            )
        ));
        $footer = view('Layouts/_footer');
        $data = array(
            'header' => $header,
            'footer' => $footer
        );
        return view('Client/login', $data);
    }

    public function Pay_Page()
    {
        $isLogin = $this->checkLogin();
        $header = view('Layouts/_header', array(
            'isLogin' => $isLogin,
            'Page_Title' => 'Thanh toán',
            'Page_Resource' => array(
                '<link rel="stylesheet" href="./Assets/CSS/pay.css">',
            )
        ));
        $footer = view('Layouts/_footer');
        $data = array(
            'header' => $header,
            'footer' => $footer
        );
        return view('Client/pay', $data);
    }



// --------------------- FUNCTION CHECK ---------------------

    // Kiểm tra đã đăng nhập
    public function checkLogin()
    {
        if ($this->homeModel->session->has('User_ID')) {
            return true;
        } else {
            return false;
        }
    }

    // Kiểm tra định dạng Email
    public function checkEmail($email)
    {
        $email = trim($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return true;
        }
    }

    // Kiểm tra định dạng Số điện thoại
    public function checkPhone($phone)
    {
        $phone = trim($phone);
        if (!preg_match('/^[0-9]{10,13}$/', $phone)) {
            return false;
        } else {
            return true;
        }
    }

    // Kiểm tra ngày hợp lệ
    public function checkDate($date)
    {
        $date = trim($date);
        if (!checkdate(substr($date, 5, 2), substr($date, 8, 2), substr($date, 0, 4))) {
            return false;
        } else {
            return true;
        }
    }

    // Kiểm tra có phải số nguyên
    public function checkNumber($number)
    {
        $number = trim($number);
        if (!preg_match('/^-?[0-9]+$/', $number)) {
            return false;
        } else {
            return true;
        }
    }

    // Kiểm tra chuỗi có phải Injection SQL 
    public function checkInjection($string)
    {
        $string = trim($string);
        if (!preg_match('/[\'|"|\s|\t|\n|\r]/', $string)) {
            return false;
        } else {
            return true;
        }
    }

    // Kiểm tra có giới tính (0|1)
    public function checkGender($number)
    {
        $number = trim($number);
        if ($number != 0 && $number != 1) {
            return false;
        } else {
            return true;
        }
    }

    // Chuyển date sang format dd/mm/yyyy
    public function convertDate($date)
    {
        $date = trim($date);
        $date = substr($date, 8, 2) . '/' . substr($date, 5, 2) . '/' . substr($date, 0, 4);
        return $date;
    }

    // Convert datetime to format dd/mm/yyyy hh:mm
    public function convertDateTime($datetime)
    {
        $datetime = trim($datetime);
        $datetime = substr($datetime, 8, 2) . '/' . substr($datetime, 5, 2) . '/' . substr($datetime, 0, 4) . ' ' . substr($datetime, 11, 2) . ':' . substr($datetime, 14, 2);
        return $datetime;
    }

    // Convert datetime to format HH:ii:ss dd/mm/yyyy
    public function convertDateTime2($datetime)
    {
        $datetime = trim($datetime);
        $datetime = substr($datetime, 11, 2) . ':' . substr($datetime, 14, 2) . ':' . substr($datetime, 17, 2) . ' - ' . substr($datetime, 8, 2) . '/' . substr($datetime, 5, 2) . '/' . substr($datetime, 0, 4);
        return $datetime;
    }

    // Convert datetime to format hh:mm 
    public function convertTime($datetime)
    {
        $datetime = trim($datetime);
        $datetime = substr($datetime, 11, 2) . ':' . substr($datetime, 14, 2);
        return $datetime;
    }

    // Convert time in item of list room rent
    public function convertTimeRoomRent($listRoomRent)
    {
        for ($i = 0; $i < count($listRoomRent); $i++) {
            $listRoomRent[$i]['date_hire'] = $this->convertDate($listRoomRent[$i]['date_hire']);
            $listRoomRent[$i]['created'] = $this->convertDateTime($listRoomRent[$i]['created']);
            $listRoomRent[$i]['start'] = $this->convertTime($listRoomRent[$i]['start']);
            $listRoomRent[$i]['end'] = $this->convertTime($listRoomRent[$i]['end']);
        }
        return $listRoomRent;
    }

    // Convert time in item of list shifts
    public function convertTimeShift($listShift)
    {
        for ($i = 0; $i < count($listShift); $i++) {
            $listShift[$i]['start'] = $this->convertTime($listShift[$i]['start']);
            $listShift[$i]['end'] = $this->convertTime($listShift[$i]['end']);
        }
        return $listShift;
    }

    // check date past
    function checkDatePast($date)
    {
        $date = trim($date);
        $date = substr($date, 8, 2) . '/' . substr($date, 5, 2) . '/' . substr($date, 0, 4);
        $date = strtotime($date);
        $now = strtotime(date('d/m/Y'));
        if ($date < $now) {
            return true;
        } else {
            return false;
        }
    }

}
