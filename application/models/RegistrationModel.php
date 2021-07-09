<?php
class RegistrationModel extends CI_Model
{
    public function getCountries(){
        $this->db->select("country_code,country_name");
        $this->db->from('countries');   
        $this->db->order_by("country_name", "asc");
        $query = $this->db->get();        
        if ($query->num_rows() > 0) {
            return $query->result_array();                     
        }else{
            return array();
        }
    }
    public function getSubscriptions(){
        $this->db->select("tag_id,tag_name");
        $this->db->from('tags');   
        $this->db->order_by("tag_name", "asc");
        $query = $this->db->get();        
        if ($query->num_rows() > 0) {
            return $query->result_array();                     
        }else{
            return array();
        }
    }
    public function checkEmailIdExistsOrNot($email){
        $this->db->select("user_email");
        $this->db->from('users');
        $this->db->where('user_email',$email);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {           
            return true;
        }else{
            return false;
        }
    }
    public function createUser($data){
        if($this->db->insert('users',$data)){
            return true;
        }
        return false;
    }
    public function updateUser($data,$id){
        $this->db->where('user_id',$id);
        if($this->db->update('users',$data)){
            return true;
        }
        return false;
    }
    public function deleteUser($id){        
        $this->db->where('user_id', $id);
        if($this->db->delete('users')){
            return true;
        }
        return false;
    }
    
    
    public function getUserDetails($id){
        $this->db->select("a.user_id,a.user_first_name,a.user_last_name,a.user_phone_number,a.user_dob,a.user_email,a.user_country,a.user_subscription,a.user_role,b.tag_name,c.country_name");
        $this->db->from('users a');   
        $this->db->join("tags b", "b.tag_id = a.user_subscription", "left");   
        $this->db->join("countries c", "c.country_code = a.user_country", "left");   
        if($id!=null){
            $this->db->where('a.user_id',$id);
        }else{
            $this->db->where('a.user_role',2);
        }        
        $query = $this->db->get();        
        if ($query->num_rows() > 0) {
            return $query->result_array();                     
        }else{
            return array();
        }		
    }
}
?>