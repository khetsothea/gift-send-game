<?php

class Helpers 
{

	   /**
       *  Set uri segment for application
       *  @return string
       */
    public function uri()
    {
		$path = ltrim($_SERVER['REQUEST_URI'], '/');    
		$elements = explode('/', $path);  
			return $elements[1];
     }
	 
	   /**
       *  Clear http requests
       *  @return array
       */
	  public function clear()
    {
	
	foreach($_POST as $key => $val)
    	{
		
    		$data[$key] = htmlspecialchars($val);
    	}
	
		return $data;
    }
  
}