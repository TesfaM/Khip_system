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

class Templates extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();

        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->model('templates_model', 'templates');

    }


    public function email()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['emails'] = $this->templates->get_template(6, 16);
        $head['title'] = 'Email Templates';
        $this->load->view('fixed/header');
        $this->load->view('templates/email', $data);
        $this->load->view('fixed/footer');
    }

    public function email_update()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $subject = $this->input->post('subject', true);
            $body = $this->input->post('body');

            $this->templates->edit($id, $subject, $body);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $id = $this->input->get('id');
            $head['title'] = 'Edit Email Template';
            $data['email'] = $this->templates->template_info($id);
            $this->load->view('fixed/header');
            $this->load->view('templates/email-edit', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function sms()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['emails'] = $this->templates->get_template(30, 36);
        $head['title'] = 'Email Templates';
        $this->load->view('fixed/header');
        $this->load->view('templates/sms', $data);
        $this->load->view('fixed/footer');
    }

    public function sms_update()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $subject = 'SMS';
            $body = $this->input->post('body');

            $this->templates->edit($id, $subject, $body);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $id = $this->input->get('id');
            $head['title'] = 'Edit SMS Template';
            $data['sms'] = $this->templates->template_info($id);
            $this->load->view('fixed/header');
            $this->load->view('templates/sms-edit', $data);
            $this->load->view('fixed/footer');
        }
    }


}