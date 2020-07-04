<?php 

defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {
        # data yang di krim ke halaman
        $data['tittle'] = "Menu management";
        $data['name_tittle'] = "User";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            # tampilan menu
            $this->load->view('templets/my_profile/header/index', $data);
            $this->load->view('templets/my_profile/sidebar/index', $data);
            $this->load->view('templets/my_profile/topbar/index', $data);
            $this->load->view('menu/menu_management', $data);
            $this->load->view('templets/my_profile/footer/index');
        } else {

            $this->db->insert('user_menu', ['menu' => htmlspecialchars($this->input->post('menu'))]);

            $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">New menu add !</div>');
            redirect('Auth');
        }
    }

    public function submenu()
    {
        # data yang di krim ke halaman
        $data['tittle'] = "Submenu managemant";
        $data['name_tittle'] = "User";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('menu_model', 'menu');
        $data['submenu'] = $this->menu->getsubmenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();


        $this->form_validation->set_rules('title', 'Tittle', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');


        if ($this->form_validation->run() == false) {
            # tampilan menu
            $this->load->view('templets/my_profile/header/index', $data);
            $this->load->view('templets/my_profile/sidebar/index', $data);
            $this->load->view('templets/my_profile/topbar/index', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templets/my_profile/footer/index');
        } else {
            $data = [
                'title'     => htmlspecialchars($this->input->post('title', true)),
                'menu_id'   => htmlspecialchars($this->input->post('menu_id', true)),
                'url'       => htmlspecialchars($this->input->post('url', true)),
                'icon'      => htmlspecialchars($this->input->post('icon', true)),
                'is_active' => htmlspecialchars($this->input->post('is_active', true)),
            ];
            $this->db->insert('user_sub_menu', $data);

            $this->session->set_flashdata('massage', '<div class="alert alert-success" role="alert">New submenu add !</div>');
            redirect('Menu/submenu');
        }

    }

    public function menumanagementdelete($id)
    {
        $this->menu_model->deletemenumanagement($id);

        $this->session->set_flashdata('massage', '<div class="alert alert-success" role="alert">Menu deleted successfully  !</div>');
        redirect('Menu');
    }

    public function submenudelete($id)
    {
        $this->menu_model->deletesubmenu($id);

        $this->session->set_flashdata('massage', '<div class="alert alert-success" role="alert">Submenu deleted successfully  !</div>');
        redirect('Menu/submenu');
    }
}