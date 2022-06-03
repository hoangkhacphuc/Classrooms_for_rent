<?php
namespace App\Models;

class UserModel extends HomeModel
{
    public function __construct()
    {
        parent::__construct();
    }
    
    // Đăng nhập
    public function login($username, $password)
    {
        $query = $this->db->table('customers')
                            ->where(array('user' => $username, 'pass' => $password))
                            ->get()
                            ->getResultArray();
        if (count($query) > 0) {
            $this->session->set('User_ID', $query[0]['id']);
            echo json_encode(array('status' => 'success', 'message' => 'Đăng nhập thành công'));
            return;
        }
        echo json_encode(array('status' => 'error', 'message' => 'Tài khoản hoặc mật khẩu không đúng'));
    }

    // Đăng xuất
    public function logout()
    {
        $this->session->destroy();
    }

    // Lấy thông tin cá nhân
    public function getProfile()
    {
        $query = $this->db->table('customers')
                            ->select('*, customers.name as full_name, roles.name as role_name')
                            ->where(array('customers.id' => $this->session->get('User_ID')))
                            ->join('roles', 'roles.id = customers.role_id')
                            ->get()
                            ->getResultArray();
        return $query[0];
    }
        
    // Cập nhật thông tin cá nhân
    public function updateProfile($data)
    {
        $query = $this->db->table('customers')
                            ->where(array('id' => $this->session->get('User_ID')))
                            ->update($data);
        if ($query) {
            echo json_encode(array('status' => 'success', 'message' => 'Cập nhật thành công'));
            return;
        }
        echo json_encode(array('status' => 'error', 'message' => 'Cập nhật thất bại'));
    }

    // kiểm tra quyền Admin
    public function isAdmin()
    {
        $query = $this->db->table('customers')
                            ->where(array('id' => $this->session->get('User_ID')))
                            ->get()
                            ->getResultArray();
        if ($query[0]['role_id'] == 1) {
            return true;
        }
        return false;
    }

    // Số thành viên tham gia tuần này
    public function getAmountUserJoinThisWeek()
    {
        // begin of the week
        $start_week = date('Y-m-d', strtotime('monday this week'));
        // end of the week
        $end_week = date('Y-m-d', strtotime('sunday this week'));
        $query = $this->db->table('customers')
                            ->select('COUNT(*) as count')
                            ->where(array('customers.created >=' => $start_week,
                                         'customers.created <=' => $end_week))
                            ->get()
                            ->getResultArray();
        return $query[0]['count'];
    }

    // Lấy tổng số thành viên
    public function getTotalUser()
    {
        $query = $this->db->table('customers')
                            ->select('COUNT(*) as count')
                            ->get()
                            ->getResultArray();
        return $query[0]['count'];
    }
    
}