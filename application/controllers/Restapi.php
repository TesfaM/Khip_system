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

class Restapi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('restapi_model', 'restapi');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->li_a = 'advance';
    }

    public function index()
    {
        $data['message'] = false;
        $data['keys'] = $this->restapi->keylist();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Keys';
        $this->load->view('fixed/header', $head);
        $this->load->view('restapi/list', $data);
        $this->load->view('fixed/footer');
    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->db->delete('geopos_restkeys', array('id' => $id));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('API Key deleted')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function add()
    {


        if ($this->restapi->addnew()) {

            $data['message'] = true;


            $data['keys'] = $this->restapi->keylist();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add New Key';
            $this->load->view('fixed/header', $head);
            $this->load->view('restapi/list', $data);
            $this->load->view('fixed/footer');
        }


    }
}