<?php
namespace App\Models;

class RoomModel extends HomeModel
{
    public function __construct()
    {
        parent::__construct();
    }
    

    // Lấy danh sách phòng
    public function getListRoom()
    {
        $query = $this->db->table('rooms')
            ->select('*')
            ->get()
            ->getResultArray();
        return $query;
    }

    // Lấy danh sách phòng đã đặt thuê
    public function getListRoomRent()
    {
        $query = $this->db->table('managements')
            ->select('*, managements.id as id_management')
            ->where('managements.customer_id', $this->session->get('User_ID'))
            ->join('rooms', 'rooms.id = managements.room_id')
            ->join('shifts', 'shifts.id = managements.shift_id')
            ->get()
            ->getResultArray();
        return $query;
    }

    // Xóa phòng đã đặt thuê qua id
    public function deleteRoomRent($id)
    {
        $query = $this->db->table('managements')
            ->where(array(
                'id' => $id,
                'customer_id' => $this->session->get('User_ID')
            ))
            ->delete();
        if ($query) {
            echo json_encode(array(
                'status' => 'success',
                'message' => 'Xóa thành công'
            ));
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Xóa thất bại'
            ));
        }
    }
}