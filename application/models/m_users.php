<?php

class M_users extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /*
     * Checks if the user exists in the database
     */
    function check($username, $password)
    {
        // Set up and run the query
        $this->db->select('id, username, email, access, activated, firstname, lastname, photo')->from('users')->where('username', $username)->where('password', $password);

        $query = $this->db->get();

        if ($query->num_rows() == 1) // If the user exists return his data
        {
            $result = $query->row_array();

            if ($result['activated'] == 0) // If user's account is inactive
                return 'inactive';
            else if ($result['activated'] == 2)
                return 'awaiting_activation';
            else
                return $result;
        }
        else // Else return false
        {
            return FALSE;
        }
    }

    /*
     * Update user's data
     */
    function update($id, $data)
    {
        $this->db->where('id', $id);
        
        return $this->db->update('users', $data);
    }

    /*
     * Add a new user to the database
     */
    function insert($data)
    {
        return $this->db->insert('users', $data);
    }

    /*
     * Retrieve a row or a specific value of a user
     */
    function get($id, $field = FALSE)
    {
        if ($field) // Retrieve a specific field
        {
            $this->db->select($field)->from('users')->where('id', $id);

            $query = $this->db->get();

            $result = $query->row();

            return $result->$field;
        }
        else // retrieve all
        {
            $query = $this->db->get_where('users', array('id' => $id));

            return $query->row_array();
        }
    }

    /*
     * Retrieve all users
     */
    function getall($num, $offset)
    {
        $this->db->select('id, username, email, access, activated, firstname, lastname');
        $this->db->from('users');
        $this->db->order_by('id', 'desc');
        $this->db->limit($num, $offset);

        $query = $this->db->get();

        return $query;
    }

}

/* End of file m_users.php */