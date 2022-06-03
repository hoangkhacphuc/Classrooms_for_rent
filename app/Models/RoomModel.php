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
            ->orderBy('managements.date_hire', 'DESC')
            ->limit(50)
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

    // Kiểm tra room id có tồn tại trong bảng room hay không
    public function checkRoomID($id)
    {
        $query = $this->db->table('rooms')
            ->where('id', $id)
            ->get()
            ->getResultArray();
        if (count($query) > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Thuê phòng nhiều ca
    public function rentRoom($room_id, $date_hire, $rent_shift)
    {
        if (!$this->checkRoomID($room_id)) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Phòng không tồn tại'
            ));
            return;
        }
        foreach ($rent_shift as $shift) {
            $query = $this->db->table('managements')
                ->where(array(
                    'room_id' => $room_id,
                    'date_hire' => $date_hire,
                    'shift_id' => $shift
                ))
                ->get()
                ->getResultArray();
            if (count($query) > 0) {
                echo json_encode(array(
                    'status' => 'error',
                    'message' => 'Phòng đã có người thuê'
                ));
                return;
            }
        }
        foreach ($rent_shift as $shift) {
            $query = $this->db->table('managements')
                ->insert(array(
                    'room_id' => $room_id,
                    'date_hire' => $date_hire,
                    'shift_id' => $shift,
                    'customer_id' => $this->session->get('User_ID')
                ));
        }
        echo json_encode(array(
            'status' => 'success',
            'message' => 'Thuê phòng thành công'
        ));
    }

    // Doanh thu hôm nay
    public function getRevenueToday()
    {
        $query = $this->db->table('managements')
            ->select('*, managements.id as id_management')
            ->where('managements.date_hire', date('Y-m-d'))
            ->join('rooms', 'rooms.id = managements.room_id')
            ->join('shifts', 'shifts.id = managements.shift_id')
            ->get()
            ->getResultArray();
        return $query;
    }

    // Doanh thu tháng này
    public function getRevenueMonth()
    {
        $query = $this->db->table('managements')
            ->select('*, managements.id as id_management')
            ->where(array(
                'YEAR(managements.date_hire)' => date('Y'),
                'MONTH(managements.date_hire)' => date('m')
            ))
            ->join('rooms', 'rooms.id = managements.room_id')
            ->join('shifts', 'shifts.id = managements.shift_id')
            ->get()
            ->getResultArray();
        return $query;
    }

    // Doanh thu của phòng
    public function getRevenueRoom($room_id)
    {
        $query = $this->db->table('managements')
            ->select('*, managements.id as id_management')
            ->where(array(
                'room_id' => $room_id,
            ))
            ->join('rooms', 'rooms.id = managements.room_id')
            ->join('shifts', 'shifts.id = managements.shift_id')
            ->get()
            ->getResultArray();
        return $query;
    }

    // Thống kê phòng
    public function getStatisticRoom()
    {
        $query = $this->db->table('rooms')
            ->select('*')
            ->get()
            ->getResultArray();
        $new = array();
        for ($i=0; $i < count($query); $i++) { 
            $revenue = $this->getRevenueRoom($query[$i]['id']);
            array_push($new, array(
                'name' => $query[$i]['name'],
                'amount_shift' => count($revenue),
                'revenue' => array_sum(array_column($revenue, 'rentCost'))
            ));
        }
        return $new;
    }

    // Xóa phòng
    public function deleteRoom($id)
    {
        // Check room id
        $query = $this->db->table('rooms')
            ->where('id', $id)
            ->get()
            ->getResultArray();
        if (count($query) == 0) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Phòng không tồn tại'
            ));
            return;
        }

        $query = $this->db->table('managements')
            ->where('room_id', $id)
            ->delete();

        $query = $this->db->table('rooms')
            ->where('id', $id)
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

    // Cập nhật thông tin phòng
    public function updateRoom($id, $name, $size, $rentCost)
    {
        // Check room id
        $query = $this->db->table('rooms')
            ->where('id', $id)
            ->get()
            ->getResultArray();
        if (count($query) == 0) {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Phòng không tồn tại'
            ));
            return;
        }

        $query = $this->db->table('rooms')
            ->where('id', $id)
            ->update(array(
                'name' => $name,
                'size' => $size,
                'rentCost' => $rentCost,
            ));

        if ($query) {
            echo json_encode(array(
                'status' => 'success',
                'message' => 'Cập nhật thành công'
            ));
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Cập nhật thất bại'
            ));
        }
    }

    // Thêm phòng và trả về id mới thêm
    public function addRoom($name, $size, $rentCost)
    {
        $query = $this->db->table('rooms')
            ->insert(array(
                'name' => $name,
                'size' => $size,
                'rentCost' => $rentCost,
            ));
        if ($query) {
            echo json_encode(array(
                'status' => 'success',
                'message' => 'Thêm thành công',
                'id' => $this->db->insertID()
            ));
        } else {
            echo json_encode(array(
                'status' => 'error',
                'message' => 'Thêm thất bại'
            ));
        }
    }
}