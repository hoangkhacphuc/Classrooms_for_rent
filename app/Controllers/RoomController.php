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

}