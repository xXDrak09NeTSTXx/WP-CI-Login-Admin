<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {

        $data['tittle'] = "My profile";
        $data['name_tittle'] = "User";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();



        $this->load->view('templets/my_profile/header/index', $data);
        $this->load->view('templets/my_profile/sidebar/index', $data);
        $this->load->view('templets/my_profile/topbar/index', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templets/my_profile/footer/index');
    }



    public function edit()
    {

        $data['tittle'] = "Edit profile";
        $data['name_tittle'] = "User";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();




        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('templets/my_profile/header/index', $data);
            $this->load->view('templets/my_profile/sidebar/index', $data);
            $this->load->view('templets/my_profile/topbar/index', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templets/my_profile/footer/index');
        } else {
            # DATA dari post view edit
            $name = htmlspecialchars($this->input->post('name', true));
            $email = htmlspecialchars($this->input->post('email', true));

            # BAGIAN update gambar
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['upload_path'] = './asset/img/profile/';
                $config['allowed_types'] = 'gif|jpg|png';
                # menggunakan satuan KB
                $config['max_size']     = '3048';
                $this->load->library('upload', $config);


                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'asset/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }


            # Bagian update name
            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');
            $this->session->set_flashdata('massage', '<div class="alert alert-success" role="alert">Your profile has been update !</div>');
            redirect('User');
        }
    }




    public function changepassword()
    {

        $data['tittle'] = "Change Password";
        $data['name_tittle'] = "User";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confrim Password', 'required|trim|min_length[3]|matches[new_password1]');
        if ($this->form_validation->run() == false) {
            $this->load->view('templets/my_profile/header/index', $data);
            $this->load->view('templets/my_profile/sidebar/index', $data);
            $this->load->view('templets/my_profile/topbar/index', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templets/my_profile/footer/index');
        } else {
            $current_password = htmlspecialchars($this->input->post('current_password', true));
            $new_password = htmlspecialchars($this->input->post('new_password1', true));

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">Wrong Current Password !</div>');
                redirect('User/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">New Password can not be the same as current password  !</div>');
                    redirect('User/changepassword');
                } else {
                    # password sudah OK dari syarat di atas
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');
                    $this->session->set_flashdata('massage', '<div class="alert alert-success" role="alert">Password Change !</div>');
                    redirect('User/changepassword');
                }
            }
        }
    }
}
