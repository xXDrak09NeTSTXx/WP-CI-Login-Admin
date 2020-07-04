<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();


        # memanggil fungsi llibary di CI, form-vlidation dengan key library()
        $this->load->library('form_validation');
    }







    # Form Login
    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('User');
        }


        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['tittle'] = "Login";
            $this->load->view('auth/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('auth/auth_footer');
        } else {
            // validation success
            $this->P_login();
        }
    }




    # query Login
    private function P_login()
    {
        # (1) mengabil data post dengan cara CI
        # htmlspecialchars untuk mengamankan input dari karakter html
        # True untuk mengamankan input dari karakter html cara dari CI
        # htmlspecialchars($this->input->post('email', true));
        #
        # (2) query data dengan cara CI
        # sesuai filed di kolom Database 
        # ('user' ['email' => $email]);  user = nama table, email = filed table 
        # $email input post dari form login
        # row_array(); untuk mengabil 1 baris kolom yang ada dengan key $email
        #
        # (3) check jika $user ada
        # jika salah krim pesan di else
        #
        # (4) check jika $user['is_active'] == 1 jika 0 salah
        # jika salah krim pesan di else
        # $user['is_active'] di array CI penulisan nya seperti ini
        # is_active adalah field yang ada di tabel user
        # 
        # (5) cek jika $password sama dengan 'password' di data base
        # cara check password yang sudah di encript :
        # $user['password'] = data dari rowarray(), ['password'] = filed table
        #
        # (6) jika password benar
        # membuat $data untuk session nanti :
        # $data = [
        #    'email' => $user['email'],
        #    'role_id' => $user['role_id']
        # ];
        # membuat session
        # untuk membuat session di CI syaratnya harus seperti ini:
        # $this->session->set_userdata($data) 
        # untuk menggunakan :
        # set_userdata(parameter butuh data apa saja untuk membuat session);
        # mengaktifkan session di control lain atau halaman lain Cara dari CI :
        # userdata($data); 
        #
        # (7) Check $user['role_id'] == 1 
        # jika == 1 akan di pindah kan langsung ke halaman Admin
        # jika == 0 atau lainnya akan pindah ke halaman user
        #
        #
        $email = htmlspecialchars($this->input->post('email', true));
        $password = htmlspecialchars($this->input->post('password', true));

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        // var_dump($user);

        if ($user) {


            if ($user['is_active'] == 1) {


                if (password_verify($password, $user['password'])) {


                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];

                    $this->session->set_userdata($data);


                    if ($user['role_id'] == 1) {
                        redirect('Admin');
                    } else {
                        redirect('User');
                    }
                } else {


                    $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">Worng password !</div>');
                    redirect('Auth');
                }
            } else {


                $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">This email has not been activated !</div>');
                redirect('Auth');
            }
        } else {

            $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">Email is not registered !</div>');
            redirect('Auth');
        }
    }




    # Form registration
    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('User');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|trim|valid_email|is_unique[user.email]',
            [
                'is_unique' => 'This email has already been registered'
            ]
        );
        $this->form_validation->set_rules(
            'password1',
            'password',
            'required|trim|min_length[3]|matches[password2]',
            [
                'matches' => 'Password dont match !',
                'min_length' => 'Password too short !'
            ]
        );
        $this->form_validation->set_rules('password2', 'password', 'required|trim|matches[password1]');


        if ($this->form_validation->run() == false) {
            $data['tittle'] = "registration";
            $this->load->view('auth/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('auth/auth_footer');
        } else {
            $email = $this->input->post('email', true);
            $data =
                [
                    'name' => htmlspecialchars($this->input->post('name', true)),
                    'email' => htmlspecialchars($email),
                    'image' => 'default.jpg',
                    'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                    'role_id' => 2,
                    'is_active' => 0,
                    'date_created' => time()
                ];

            # membuat token untuk register ke email
            # ada 2 cara

            # cara pertama
            $token = bin2hex(openssl_random_pseudo_bytes(32));

            # cara kedua
            // $token = base64_encode(random_bytes(32));
            // var_dump($token);
            // die;

            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            $this->_sendemail($token, 'verify');


            $this->session->set_flashdata('massage', '<div class="alert alert-success" role="alert">Congratulations! Your account has been created, please active your account</div>');
            redirect('Auth');
        }
    }




    # auto send email 
    private function _sendemail($token, $type)
    {
        $email = htmlspecialchars($this->input->post('email', true));

        # protocol adalah jalur nya
        # smtp_host adalah jalur host di sini menggunakan gmail dari google sesuai email nya pakai apa
        # smtp_user adalah email yang mau krim otomatis
        # smtp_pass adalah password dari email
        # smtp_port adalah jalur transmisi di sini saya pakai gmail dari google jika pakai email lain cari di internet port nya
        # mailtype adalah ingin menampilkan pesan dengan format fail apa di sini menggunakan HTML
        # charset adalah tulisan nya tipe apa di sini pakai HTML 5 jadi pakai format tulisan adalah utf-8
        # newline adalah untuk enter atau paragaf baru supaya ada jarak dengan pesan


        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'ms99dkntst@gmail.com',
            'smtp_pass' => 'dragon07091997',
            'smtp_port' =>  465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        # memasukan konfigurasi ke email syarat harus sudah auto load library di CI 
        $this->email->initialize($config);


        # memanggil fungsi email di CI
        // $this->load->library('email', $config);

        # konfigurasi email untuk mengirim otomatis
        # from adalah pesan dari email siapa dan alias nya juga bisa
        # to adalah mengirim email nya ke siapa
        # subject adalah judul dari surat
        # massage adalah isi surat nya apa
        # 
        # urldecode() berfungsi mengubah tanda + menjadi yang lain di url
        $this->email->from('ms99dkntst@gmail.com', 'MS.web');
        $this->email->to($email);

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify you account : <a href="' . base_url() . 'Auth/verify?email=' . $email . '&token=' . urldecode($token) . '">Account activate</a>');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password : <a href="' . base_url() . 'Auth/resetpassword?email=' . $email . '&token=' . urldecode($token) . '">Reset password</a>');
        }


        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }




    # verify for token register
    public function verify()
    {
        $email = htmlspecialchars($this->input->get('email'));
        $token = htmlspecialchars($this->input->get('token'));

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {


                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('massage', '<div class="alert alert-success" role="alert">' . $email . ' has been activated ! Please login</div>');
                    redirect('Auth');
                } else {

                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">Account activation failed ! Token expired </div>');
                    redirect('Auth');
                }
            } else {
                $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">Account activation failed ! Wrong token </div>');
                redirect('Auth');
            }
        } else {
            $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">Account activation failed ! Wrong email </div>');
            redirect('Auth');
        }
    }



    # fungsi Logout / destroy sesson
    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('massage', '<div class="alert alert-success" role="alert">You have been logout</div>');
        redirect('Auth');
    }




    # membuat page block
    public function blocked()
    {
        $data['tittle'] = "403 Access Forbiden";
        $this->load->view('errors/block/index', $data);
    }




    public function forgotpassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == false) {

            $data['tittle'] = "Forgot Password";
            $this->load->view('auth/auth_header', $data);
            $this->load->view('auth/forgot_password');
            $this->load->view('auth/auth_footer');
        } else {

            $email = htmlspecialchars($this->input->post('email', true));

            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {


                $token = bin2hex(openssl_random_pseudo_bytes(32));

                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendemail($token, 'forgot');

                $this->session->set_flashdata('massage', '<div class="alert alert-success" role="alert">Please check your email to reset your password !</div>');

                redirect('Auth/forgotpassword');
            } else {


                $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">Email is not register or activated !</div>');

                redirect('Auth/forgotpassword');
            }
        }
    }

    public function resetpassword()
    {
        $email = htmlspecialchars($this->input->get('email', true));
        $token = htmlspecialchars($this->input->get('token', true));

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {


                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {

                    $this->session->set_userdata('reset_email', $email);

                    $this->changepassword();
                } else {

                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">Reset password failed ! Token expired </div>');
                    redirect('Auth');
                }
            } else {
                $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">Reset passwor failed ! wrong token</div>');

                redirect('Auth');
            }
        } else {
            $this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">Reset passwor failed ! wrong email</div>');

            redirect('Auth');
        }
    }

    public function changepassword()
    {
        if (!$this->userdata('reset_email')) {
            redirect('Auth');
        }
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[4]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[4]|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['tittle'] = "Change Password";
            $this->load->view('auth/auth_header', $data);
            $this->load->view('auth/change_password');
            $this->load->view('auth/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);

            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');
            $this->db->delete('user_token', ['email' => $email]);

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('massage', '<div class="alert alert-success" role="alert">Reset passwor success ! please login</div>');

            redirect('Auth');
        }
    }
}
