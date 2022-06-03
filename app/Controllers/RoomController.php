<?php

namespace App\Controllers;

class RoomController extends HomeController
{
    public function __construct()
    {
        parent::__construct();
    }

    // Controller for room
    public function index()
    {
        $isAdmin = $this->userModel->isAdmin();
        if ($isAdmin) {
            return redirect()->to(site_url('/'));
        }
        $isLogin = $this->checkLogin();
        if (!$isLogin) {
            return redirect()->to(site_url('./login'));
        }
        $header = view('Layouts/_header', array(
            'isLogin' => $isLogin,
            'Page_Title' => 'Thuê Phòng',
            'Page_Resource' => array(
                '<link rel="stylesheet" href="./Assets/CSS/rent.css">',
                '<script src="./Assets/Js/rent.js"></script>'
            )
        ));
        $footer = view('Layouts/_footer');
        $data = array(
            'header' => $header,
            'footer' => $footer,
            'rooms_rent' => $this->convertTimeRoomRent($this->roomModel->getListRoomRent()),
            'rooms' => $this->roomModel->getListRoom(),
            'shifts' => $this->convertTimeShift($this->shiftModel->getListShift()),
        );
        return view('Client/rent', $data);
    }

    // Controller xóa phòng đã đặt thuê
    public function deleteRoomRent()
    {
        $isLogin = $this->checkLogin();
        if (!$isLogin) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Bạn chưa đăng nhập'
            ));
            return;
        }
        $id = $this->request->getPost('id');
        // check id empty
        if (empty($id)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'ID không được để trống'
            ));
            return;
        }
        // check id is integer
        if (!is_numeric($id)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'ID phải là số'
            ));
            return;
        }
        $this->roomModel->deleteRoomRent($id);
    }

    // Controller thuê phòng
    public function rentRoom()
    {
        if (!$this->checkLogin()) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Bạn chưa đăng nhập'
            ));
            return;
        }
        $room_id = $this->request->getPost('room_id');
        $date_hire = $this->request->getPost('date_hire');
        $rent_shift = $this->request->getPost('rent_shift');
        // check room_id empty
        if (empty($room_id)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'ID phòng không được để trống'
            ));
            return;
        }
        // check room_id is integer
        if (!is_numeric($room_id)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'ID phòng phải là số'
            ));
            return;
        }
        // check date_hire empty
        if (empty($date_hire)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Ngày thuê không được để trống'
            ));
            return;
        }
        // check date_hire is date
        if (!$this->checkDate($date_hire)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Ngày thuê không đúng định dạng'
            ));
            return;
        }
        // check date_hire is past
        if ($this->checkDatePast($date_hire)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Ngày thuê không được nhỏ hơn ngày hiện tại'
            ));
            return;
        }
        // check rent_shift empty
        if (empty($rent_shift)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Ca thuê không được để trống'
            ));
            return;
        }
        // check rent_shift is array integer
        if (!is_array($rent_shift)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Ca thuê phải là mảng số'
            ));
            return;
        }
        foreach ($rent_shift as $shift) {
            if (!is_numeric($shift)) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Ca thuê phải là mảng số'
                ));
                return;
            }
        }
        $this->roomModel->rentRoom($room_id, $date_hire, $rent_shift);
    }

}