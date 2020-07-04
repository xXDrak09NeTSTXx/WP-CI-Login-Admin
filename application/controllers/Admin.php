<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }



    public function index()
    {
        $data['tittle'] = "Dashbord";
        $data['name_tittle'] = "Admin";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templets/my_profile/header/index', $data);
        $this->load->view('templets/my_profile/sidebar/index', $data);
        $this->load->view('templets/my_profile/topbar/index', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templets/my_profile/footer/index');
    }



    public function role()
    {
        $data['tittle'] = "Role";
        $data['name_tittle'] = "Admin";
        $data['user'] = $this->db->get_where(
            'user',
            ['email' => $this->session->userdata('email')]
        )->row_array();
        $data['role']  = $this->db->get('user_role')->result_array();


        $this->load->view('templets/my_profile/header/index', $data);
        $this->load->view('templets/my_profile/sidebar/index', $data);
        $this->load->view('templets/my_profile/topbar/index', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templets/my_profile/footer/index');
    }





    public function roleaccess($role_id)
    {
        $data['tittle'] = "Role";
        $data['name_tittle'] = "Admin";
        $data['user'] = $this->db->get_where(
            'user',
            ['email' => $this->session->userdata('email')]
        )->row_array();

        $data['role']  = $this->db->get_where(
            'user_role',
            ['id' => $role_id]
        )->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();


        $this->load->view('templets/my_profile/header/index', $data);
        $this->load->view('templets/my_profile/sidebar/index', $data);
        $this->load->view('templets/my_profile/topbar/index', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templets/my_profile/footer/index');
    }






    public function changeaccess()
    {
        $menu_id = $this->input->post('menuid');
        $role_id = $this->input->post('roleid');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('massage', '<div class="alert alert-success" role="alert">Accesss changed !</div>');
    }

    public function roledelete($id)
    {
        $this->admin_model->deleterole($id);

        $this->session->set_flashdata('massage', '<div class="alert alert-success" role="alert">Role deleted successfully  !</div>');
        redirect('Admin/role');
    }
}
