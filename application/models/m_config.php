<?php

class M_config extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    /*
     * Updates the value of a field
     */
    function update($name, $value)
    {
        // Set up the data
        $data = array(
            'value' => $value
        );

        return $this->db->update('config', $data, "name = '$name'");
    }

    /*
     * Gets the value of a field
     */
    function get($name)
    {
        // Set up and run the query
        $this->db->select('value')->from('config')->where('name', $name);

        $query = $this->db->get();

        $result = $query->row();

        return $result->value;
    }
    
    /*
     * Get all the table
     */
    function get_all() {
        
        return $this->db->get('config')->result_array();
    }

}

/* End of file m_config.php */