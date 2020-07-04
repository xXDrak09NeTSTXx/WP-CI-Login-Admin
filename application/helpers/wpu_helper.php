<?php



function is_logged_in()
{
    # membuat instant di CI, jadi sudah tidak memanggil $this dari CI
    $ci = get_instance();
    // global $ci;

    # check apakah ada email yang di input di form login
    # mengabil data dari session userdata(); 
    # yang berada di Control Auth
    if (!$ci->session->userdata('email')) {
        redirect('Auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);



        $querymenu = $ci->db->get_where(
            'user_menu',
            ['menu' => $menu]
        )->row_array();



        $menu_id = $querymenu['id'];

        $useraccess = $ci->db->get_where(
            'user_access_menu',
            [
                'role_id' => $role_id,
                'menu_id' => $menu_id
            ]
        );

        if ($useraccess->num_rows() < 1) {
            redirect('Auth/blocked');
        }
    }
}



function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if($result->num_rows() > 0)
    {
        return "checked = 'checked'";
    }
}