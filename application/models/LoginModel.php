<?php
class LoginModel extends CI_Model
{
    public function checkLogin($email){
        $this->db->select("user_id,user_password,user_role");
        $this->db->from('users');   
        $this->db->where('user_email',$email);
        $query = $this->db->get();        
        if ($query->num_rows() > 0) {
            return $query->result_array();                     
        }else{
            return array();
        }
    }    
    
}
?>