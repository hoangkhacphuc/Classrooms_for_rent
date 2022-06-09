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
        
        $isLogin = $this->checkLogin();
        if (!$isLogin) {
            return redirect()->to(site_url('./login'));
        }
        $isAdmin = $this->userModel->isAdmin();
        if ($isAdmin) {
            return redirect()->to(site_url('/'));
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

    // Controller Rooms Manager
    public function Rooms_Manager_Page()
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
            'Page_Title' => 'Quản lý phòng',
            'listRoom' => $this->roomModel->getListRoom(),
            'Page_Resource' => array(
                '<link rel="stylesheet" href="./Assets/CSS/rooms.css">',
                '<script src="./Assets/Js/rooms.js"></script>'
            )
        ));
        $footer = view('Layouts/_footer');
        $data = array(
            'header' => $header,
            'footer' => $footer,
            'profile' => $this->userModel->getProfile()
        );
        return view('Admin/rooms', $data);
    }

    // Controller API xóa phòng
    public function deleteRoom()
    {
        $isLogin = $this->checkLogin();
        if (!$isLogin) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Bạn chưa đăng nhập'
            ));
            return;
        }
        $isAdmin = $this->userModel->isAdmin();
        if (!$isAdmin) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Không có quyền truy cập'
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
        $this->roomModel->deleteRoom($id);
    }

    // Controller API cập nhật phòng
    public function updateRoom()
    {
        $isLogin = $this->checkLogin();
        if (!$isLogin) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Bạn chưa đăng nhập'
            ));
            return;
        }
        $isAdmin = $this->userModel->isAdmin();
        if (!$isAdmin) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Không có quyền truy cập'
            ));
            return;
        }
        // Check input 
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $size = $this->request->getPost('size');
        $rentCost = $this->request->getPost('rentCost');

        // check input empty
        if (empty($id) || empty($name) || empty($size) || empty($rentCost)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Thông tin không được để trống'
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
        // check size is integer
        if (!is_numeric($size)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Số ghế phải là số'
            ));
            return;
        }
        // check rentCost is integer
        if (!is_numeric($rentCost)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Giá thuê phải là số'
            ));
            return;
        }
        // Check size > 0
        if ($size <= 0) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Số ghế phải lớn hơn 0'
            ));
            return;
        }
        // Check rentCost > 0
        if ($rentCost <= 0) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Giá thuê phải lớn hơn 0'
            ));
            return;
        }
        $this->roomModel->updateRoom($id, $name, $size, $rentCost);
    }

    // Controller API thêm phòng
    public function addRoom()
    {
        $isLogin = $this->checkLogin();
        if (!$isLogin) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Bạn chưa đăng nhập'
            ));
            return;
        }
        $isAdmin = $this->userModel->isAdmin();
        if (!$isAdmin) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Không có quyền truy cập'
            ));
            return;
        }
        // Check input 
        $name = $this->request->getPost('name');
        $size = $this->request->getPost('size');
        $rentCost = $this->request->getPost('rentCost');

        // check input empty
        if (empty($name) || empty($size) || empty($rentCost)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Thông tin không được để trống'
            ));
            return;
        }
        // check size is integer
        if (!is_numeric($size)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Số ghế phải là số'
            ));
            return;
        }
        // check rentCost is integer
        if (!is_numeric($rentCost)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Giá thuê phải là số'
            ));
            return;
        }
        // Check size > 0
        if ($size <= 0) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Số ghế phải lớn hơn 0'
            ));
            return;
        }
        // Check rentCost > 0
        if ($rentCost <= 0) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Giá thuê phải lớn hơn 0'
            ));
            return;
        }
        $this->roomModel->addRoom($name, $size, $rentCost);
    }
}