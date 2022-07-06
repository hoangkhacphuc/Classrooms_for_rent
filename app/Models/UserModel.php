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

    // Đăng ký
    public function register($username, $password, $name, $phone, $birthday, $gender, $role)
    {
        $query = $this->db->table('customers')
                            ->where(array('user' => $username))
                            ->get()
                            ->getResultArray();
        if (count($query) > 0) {
            echo json_encode(array('status' => 'error', 'message' => 'Tài khoản đã tồn tại'));
            return;
        }
        $query = $this->db->table('customers')
                            ->where(array('phone_number' => $phone))
                            ->get()
                            ->getResultArray();
        if (count($query) > 0) {
            echo json_encode(array('status' => 'error', 'message' => 'Số điện thoại đã tồn tại'));
            return;
        }
        // check role id
        $query = $this->db->table('roles')
                            ->where(array('id' => $role))
                            ->get()
                            ->getResultArray();
        if (count($query) == 0) {
            echo json_encode(array('status' => 'error', 'message' => 'Vui lòng chọn quyền'));
            return;
        }
        // Thêm tài khoản và trả về id
        
        $query = $this->db->table('customers')
                            ->insert(array(
                                'user' => $username,
                                'pass' => $password,
                                'phone_number' => $phone,
                                'name' => $name,
                                'birth' => $birthday,
                                'gender' => $gender,
                                'role_id' => $role
                            ));
        if ($query) {
            echo json_encode(array('status' => 'success', 'message' => 'Đăng ký thành công', 'data' => array('id' => $this->db->insertID())));
            return;
        }
        echo json_encode(array('status' => 'error', 'message' => 'Đăng ký thất bại'));
    }

    // Đăng ký tài khoản => customer
    public function registerCustomer($username, $password)
    {
        $query = $this->db->table('customers')
                            ->where(array('user' => $username))
                            ->get()
                            ->getResultArray();
        if (count($query) > 0) {
            echo json_encode(array('status' => 'error', 'message' => 'Tài khoản đã tồn tại'));
            return;
        }
        $query = $this->db->table('customers')
                            ->insert(array(
                                'user' => $username,
                                'pass' => $password
                            ));
        if ($query) {
            echo json_encode(array('status' => 'success', 'message' => 'Đăng ký thành công'));
            return;
        }
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
    
    // Lấy danh sách thành viên trừ admin
    public function getListUser()
    {
        $query = $this->db->table('customers')
                            ->select('*')
                            ->where(array('customers.role_id !=' => 1))
                            ->get()
                            ->getResultArray();
        return $query;
    }

    // Xóa tài khoản
    public function deleteUser($id)
    {
        $query = $this->db->table('managements')
                            ->where(array('customer_id' => $id))
                            ->delete();
                            
        $query = $this->db->table('customers')
                            ->where(array('id' => $id))
                            ->delete();
        if ($query) {
            echo json_encode(array('status' => 'success', 'message' => 'Xóa thành công'));
            return;
        }
        echo json_encode(array('status' => 'error', 'message' => 'Xóa thất bại'));
    }
}