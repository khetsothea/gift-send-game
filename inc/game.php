<?php

/*
*   Autoload classes
*/

function __autoload($class_name) {

    require_once __DIR__ . '\\classes\\' . $class_name . '.class.php';	

	}

/**
 *  Factory class of the gift send game
 */
Class Game
{
    public $uri;
    
    protected $config;
    protected $db;
    protected $vars;
    protected $helpers;
    
    
    public function __construct()
    {
        
        $this->config = include __DIR__ . '/config.php';
        
        $this->helpers = new Helpers;
        $this->uri     = $this->helpers->uri();
        
        $this->db = new Database($this->config);
        
    }
    
    /**
     *  Routes for application
     */
    public function start()
    {
        
        switch ($this->uri) {
            case '':
                $this->view('');
                break;
            case 'login':
                $this->login();
                break;
            case 'getgifts':
                $this->getgifts();
                break;
            case 'sendgift':
                $this->sendgift();
                break;
            
            case 'cron':
                $this->cron();
                break;
            
            default:
                header('HTTP/1.0 404 Not Found', true, 404);
                die();
                break;
        }
        
    }
    /**
     *  Cron tasks for application
     *  @return boelan 
     */
    public function cron()
    {
        $send_status = array(
            'send_status' => 1
        );
        $update      = $this->db->update('users', $send_status, 'fb_id!="0"');
        if ($update)
            return true;
        else
            return false;
    }
    /**
     *  Show view
     *  @return html 
     */
    protected function view($data)
    {
        $data = array(
            'APPID' => $this->config['facebook']['appid']
        );
        include __DIR__ . '/view/layout.php';
        
    }
    
    /**
     *  login user
     *  @return object 
     */
    public function login()
    {
        
        $request = $this->helpers->clear();
		
        $user = new Users;
		
       $result = $user->check_user($request);
       //return $result;

	   if(!$result) {
	  $result = $user->create_user($request);	


	  
	  echo  json_encode($result);
	  }
	  else echo  json_encode($result);
        
    }
    /**
     *  get gifts for user
     *  @return json array 
     */
    public function getgifts()
    {
        
        $request = $this->helpers->clear();
        
        $user = new Users;
        
        $current_user = $user->get_user($request['session']);
        
        $result = $this->db->select("SELECT *, DATEDIFF(NOW(), expire) AS expire_day  FROM gifts WHERE receiver='" . $current_user['fb_id'] . "' 
        and `expire` BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()
      ", 0);
        
		if(!$result) $result = 0;
        
        echo json_encode($result);
    }
    
    /**
     *  Send gift function
     *  @return boelan 
     */
    public function sendgift()
    {
        
        $request = $this->helpers->clear();
        
        $user         = new Users;
        $current_user = $user->get_user($request['session']);
        
        if ($current_user['send_status']) {
            
            $array = array(
                'gift_type' => $request['gift'],
                'sender' => $current_user['fb_id'],
                'sender_name' => $request['sender_name'],
                'receiver' => $request['id'],
                'expire' => date('Y-m-d')
            );
            
            
            $result = $this->db->insert('gifts', $array);
            
            
            $send_status = array(
                'send_status' => 0
            );
            $update = $this->db->update('users', $send_status, ' fb_id=' . $current_user['fb_id']);
            
            
            echo json_encode(1);
        }
        
        else
            echo json_encode(0);
        
        
        
    }
    
    
    
    
    
    
}