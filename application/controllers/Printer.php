<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Printer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('printer_model', 'printer');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }

    public function index()
    {
        $data['printers'] = $this->printer->printers_list();
        $head['title'] = "Printers";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('printers/index', $data);
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        $this->load->model('locations_model');
        if ($this->input->post()) {
            $p_name = $this->input->post('p_name', true);
            $p_type = $this->input->post('p_type', true);
            $p_connect = $this->input->post('p_connect');
            $p_mode = $this->input->post('pmode');
            $lid = $this->input->post('lid');

            $this->printer->create($p_name, $p_type, $p_connect, $lid, $p_mode);
        } else {

            $data['printers'] = $this->printer->printers_list();
            $data['locations'] = $this->locations_model->locations_list();
            $head['title'] = "Printers";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('printers/add', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function view()
    {
        $id = $this->input->get('id');
        $data['printer'] = $this->printer->printer_details($id);
        $head['title'] = "View Printer";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('printers/view', $data);
        $this->load->view('fixed/footer');
    }

    public function edit()
    {
        $id = $this->input->get('id');
        $data['printer'] = $this->printer->printer_details($id);
        $this->load->model('locations_model');
        if ($this->input->post()) {
            $p_name = $this->input->post('p_name', true);
            $p_type = $this->input->post('p_type');
            $p_connect = $this->input->post('p_connect');
            $lid = $this->input->post('lid');
            $id = $this->input->post('p_id');
            $p_mode = $this->input->post('pmode');

            $this->printer->edit($id, $p_name, $p_type, $p_connect, $lid, $p_mode);
        } else {

            $data['printers'] = $this->printer->printers_list();
            $data['locations'] = $this->locations_model->locations_list();
            $head['title'] = "Printers";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('printers/edit', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->db->delete('geopos_config', array('id' => $id, 'type' => 1));
            echo json_encode(array('status' => 'Success', 'message' => 'Printer Removed'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


}