<?php
namespace App\Models;

class ShiftModel extends HomeModel
{
    public function __construct()
    {
        parent::__construct();
    }
    
    // Lấy danh sách các ca
    public function getListShift()
    {
        $query = $this->db->table('shifts')
            ->select('*')
            ->get()
            ->getResultArray();
        return $query;
    }

    // Lấy danh sách các ca đã đặt thuê trong ngày yyyy-mm-dd
    public function getListShiftRent($room, $date)
    {
        $query = $this->db->table('managements')
            ->where(array('managements.date_hire' => $date,
                        'managements.room_id' => $room))
            ->get()
            ->getResultArray();
        echo json_encode(array(
            'status' => 'success',
            'message' => 'Lấy thông tin thành công',
            'data' => $query
        ));
    }

    
}