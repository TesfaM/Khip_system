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

defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions_model extends CI_Model
{
    var $table = 'geopos_transactions';
    var $column_order = array('date', 'acid', 'debit', 'credit', 'payer', 'method');
    var $column_search = array('id', 'account', 'payer');
    var $order = array('id' => 'desc');
    var $opt = '';

    private function _get_datatables_query()
    {
        $this->db->select('geopos_transactions.*,geopos_transactions.id as id');
        $this->db->from($this->table);
        switch ($this->opt) {
            case 'income':
                $this->db->where('type', 'Income');
                break;
            case 'expense':
                $this->db->where('type', 'Expense');
                break;
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        }

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($this->input->post('search')['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $this->input->post('search')['value']);
                } else {
                    $this->db->or_like($item, $this->input->post('search')['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($opt = 'all')
    {
        $this->opt = $opt;
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->db->from('geopos_transactions');
        switch ($this->opt) {
            case 'income':
                $this->db->where('type', 'Income');
                break;
            case 'expense':
                $this->db->where('type', 'Expense');
                break;
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        switch ($this->opt) {
            case 'income':
                $this->db->where('type', 'Income');
                break;
            case 'expense':
                $this->db->where('type', 'Expense');
                break;
        }
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        }

        return $this->db->count_all_results();
    }

    public function categories()
    {
        $this->db->select('*');
        $this->db->from('geopos_trans_cat');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function acc_list()
    {
        $this->db->select('id,acn,holder');
        $this->db->from('geopos_accounts');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function addcat($name)
    {
        $data = array(
            'name' => $name
        );

        return $this->db->insert('geopos_trans_cat', $data);
    }

    public function addtrans($payer_id, $payer_name, $pay_acc, $date, $debit, $credit, $pay_type, $pay_cat, $paymethod, $note, $eid, $loc = 0, $ty = 0)
    {

        if ($pay_acc > 0) {

            $this->db->select('holder');
            $this->db->from('geopos_accounts');
            $this->db->where('id', $pay_acc);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }
            $query = $this->db->get();
            $account = $query->row_array();

            if ($account) {
                $data = array(
                    'payerid' => $payer_id,
                    'payer' => $payer_name,
                    'acid' => $pay_acc,
                    'account' => $account['holder'],
                    'date' => $date,
                    'debit' => $debit,
                    'credit' => $credit,
                    'type' => $pay_type,
                    'cat' => $pay_cat,
                    'method' => $paymethod,
                    'eid' => $eid,
                    'note' => $note,
                    'ext' => $ty,
                    'loc' => $loc
                );
                $amount = $credit - $debit;
                $this->db->set('lastbal', "lastbal+$amount", FALSE);
                $this->db->where('id', $pay_acc);
                $this->db->update('geopos_accounts');

                return $this->db->insert('geopos_transactions', $data);
            }
        }
    }

    public function addtransfer($pay_acc, $pay_acc2, $amount, $eid, $loc = 0)
    {

        if ($pay_acc > 0) {

            $this->db->select('holder');
            $this->db->from('geopos_accounts');
            $this->db->where('id', $pay_acc);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }
            $query = $this->db->get();
            $account = $query->row_array();
            $this->db->select('holder');
            $this->db->from('geopos_accounts');
            $this->db->where('id', $pay_acc2);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }
            $query = $this->db->get();
            $account2 = $query->row_array();

            if ($account2) {
                $data = array(
                    'payerid' => '',
                    'payer' => '',
                    'acid' => $pay_acc2,
                    'account' => $account2['holder'],
                    'date' => date('Y-m-d'),
                    'debit' => 0,
                    'credit' => $amount,
                    'type' => 'Transfer',
                    'cat' => '',
                    'method' => '',
                    'eid' => $eid,
                    'note' => 'Transferred by ' . $account['holder'],
                    'ext' => 9,
                    'loc' => $loc
                );
                $this->db->insert('geopos_transactions', $data);


                $this->db->set('lastbal', "lastbal+$amount", FALSE);
                $this->db->where('id', $pay_acc2);
                $this->db->update('geopos_accounts');
                $datec = date('Y-m-d');

                $data = array(
                    'payerid' => '',
                    'payer' => '',
                    'acid' => $pay_acc,
                    'account' => $account['holder'],
                    'date' => $datec,
                    'debit' => $amount,
                    'credit' => 0,
                    'type' => 'Transfer',
                    'cat' => '',
                    'method' => '',
                    'eid' => $eid,
                    'note' => 'Transferred to ' . $account2['holder'],
                    'ext' => 9,
                    'loc' => $loc
                );

                $this->db->set('lastbal', "lastbal-$amount", FALSE);
                $this->db->where('id', $pay_acc);
                $this->db->update('geopos_accounts');

                return $this->db->insert('geopos_transactions', $data);
            }
        }
    }


    public function delt($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_transactions');
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $this->db->where('id', $id);
        $query = $this->db->get();
        $trans = $query->row_array();

        $amt = $trans['credit'] - $trans['debit'];
        $this->db->set('lastbal', "lastbal-$amt", FALSE);
        $this->db->where('id', $trans['acid']);
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $this->db->update('geopos_accounts');

        if ($trans['tid'] > 0 && $trans['ext'] == 0) {
            $crd = $trans['credit'];
            $this->db->set('pamnt', "pamnt-$crd", FALSE);
            $this->db->set('status', "partial");
            $this->db->where('id', $trans['tid']);
            $this->db->update('geopos_invoices');
        }
                if ($trans['tid'] > 0 && $trans['ext'] == 1) {
            $crd = $trans['debit'];
            $this->db->set('pamnt', "pamnt-$crd", FALSE);
            $this->db->set('status', "partial");
            $this->db->where('id', $trans['tid']);
            $this->db->update('geopos_purchase');
        }
        $this->db->delete('geopos_transactions', array('id' => $id));
        $alert = $this->custom->api_config(66);
        if ($alert['key2'] == 1) {
            $this->load->model('communication_model');
            $subject = $trans['payer'] . ' ' . $this->lang->line('DELETED');
            $body = $subject . '<br> ' . $this->lang->line('Credit') . ' ' . $this->lang->line('Amount') . ' ' . $trans['credit'] . '<br> ' . $this->lang->line('Debit') . ' ' . $this->lang->line('Amount') . ' ' . $trans['debit'] . '<br> ID# ' . $trans['id'];
            $out = $this->communication_model->send_corn_email($alert['url'], $alert['url'], $subject, $body, false, '');
        }
        return array('status' => 'Success', 'message' => $this->lang->line('DELETED'));


    }

    public function view($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_transactions');
        $this->db->where('id', $id);

        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $query = $this->db->get();
        return $query->row_array();
    }

    public function cview($id, $ext = 0)
    {

        if ($ext == 1) {
            $this->db->select('*');
            $this->db->from('geopos_supplier');
            $this->db->where('id', $id);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }
            $query = $this->db->get();
            return $query->row_array();
        } elseif ($ext == 4) {
            $this->db->select('geopos_employees.*,geopos_users.email');
            $this->db->from('geopos_employees');
            $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
            $this->db->where('geopos_employees.id', $id);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }
            $query = $this->db->get();
            return $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('geopos_customers');
            $this->db->where('id', $id);
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }
            $query = $this->db->get();
            return $query->row_array();
        }

    }

    public function cat_details($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_trans_cat');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
       public function cat_details_name($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_trans_cat');
        $this->db->where('name', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function cat_update($id, $cat_name)
    {

        $data = array(
            'name' => $cat_name

        );


        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('geopos_trans_cat')) {
            return true;
        } else {
            return false;
        }
    }

    public function check_balance($id)
    {
        $this->db->select('balance');
        $this->db->from('geopos_customers');
        $this->db->where('id', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->group_start();
            $this->db->where('loc', $this->aauth->get_user()->loc);
            if (BDATA) $this->db->or_where('loc', 0);
            $this->db->group_end();
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $query = $this->db->get();
        return $query->row_array();
    }


}