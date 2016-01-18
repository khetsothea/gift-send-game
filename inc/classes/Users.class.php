<?php

class Users extends Game
{

    public function check_user($data)
    {
    
	   $result = $this->db->select("SELECT * FROM users WHERE fb_id=".$data['id']." LIMIT 1", 1);
	   
	   $return['session'] = $result[0]['session'];
	   $return['send_status'] = $result[0]['send_status'];
	   
	   if($result) {
				return $return;
				}
		else {
				return false;
		}
				
     }
	 
	   public function get_user($session)
    {
      
	   $result = $this->db->select("SELECT * FROM users WHERE session='".$session."' LIMIT 1", 1);
	   
	  
	   if($result) 
				return $result[0];
		else {
				
				return false;
				
		}
				
     }
	 
    public function create_user($data)
    {
	
	$session = md5(microtime());
	 $array = array(
      'fb_id' => $data['id'],
      'name' => $data['name'],
      'session' => $session,
      );
 
 
      $result = $this->db->insert('users', $array);
	  
	
	   if($result) {
	   $return['session'] = $session;
	   $return['send_status'] = 1;
	   return $return;
	   }
		else {
		return false;
		}	
	   
     }
	 
	 
}