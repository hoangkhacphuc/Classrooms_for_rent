<?php

namespace App\Controllers;

class ShiftController extends HomeController
{
    public function __construct()
    {
        parent::__construct();
    }

    // Controller API get list shift rent in day
    public function getListShiftRent()
    {
        $isLogin = $this->checkLogin();
        if (!$isLogin) {
            return $this->response->setJSON(array(
                'status' => 'error',
                'message' => 'Đăng nhập vào hệ thống để tiếp tục'
            ));
        }
        $room = $this->request->getPost('room');
        $date = $this->request->getPost('date');
        // check date empty
        if (empty($date)) {
            return $this->response->setJSON(array(
                'status' => 'error',
                'message' => 'Không có ngày nào được chọn'
            ));
        }
        // check shift empty
        if (empty($room)) {
            return $this->response->setJSON(array(
                'status' => 'error',
                'message' => 'Không có phòng nào được chọn'
            ));
        }
        // check shift 
        if (!$this->checkNumber($room)) {
            return $this->response->setJSON(array(
                'status' => 'error',
                'message' => 'Định dạng mã phòng không đúng'
            ));
        }
        // check date format
        if (!$this->checkDate($date)) {
            return $this->response->setJSON(array(
                'status' => 'error',
                'message' => 'Ngày chọn không hợp lệ'
            ));
        }
        $this->shiftModel->getListShiftRent($room, $date);
    }
}