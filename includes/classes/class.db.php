<?php

#####################################
# Document: class.db.php        	#
# Author: Richard Hoogstraaten		#
# Version: 3.2						#
# Copyright: �2008 hoogstraaten.eu	#
#####################################

class db_driver{

    private $db_connection = NULL;
    private $sql_result = Array();
    public $development_mode;
    public $table_prefix;
    public $query_counter = 0;

    // Constructor
    public function __construct($mysql_host, $mysql_user, $mysql_password, $mysql_database){
        $this->db_connection = mysql_connect($mysql_host, $mysql_user, $mysql_password) or die($this->db_error("Could not connect to the database!"));
        mysql_select_db($mysql_database, $this->db_connection) or die($this->db_error("Could not select database!"));
    }
    
    // Make a value safe for queries
    // Param:	$value	Mixed
    public function make_value_safe($value){
        if(get_magic_quotes_gpc()){
            $value = stripslashes($value);
        }
        $value = mysql_real_escape_string($value, $this->db_connection);
        return $value;
    }

	// Compile a query
	// Param:	$array	Array
	// Param:	$is_insert	Boolean
    public function compile_query($array, $is_insert){
        if($is_insert){ // We are compiling the fieldnames and fieldvalues for an insert query
            foreach($array as $k => $v){
                $v = $this->make_value_safe($v);
                $field_names .= "`".$k."`,";
                $field_values .= "'".$v."',";
            }
            // Removes the last ',' from both strings
            $field_names  = preg_replace("/,$/", "", $field_names);
            $field_values = preg_replace("/,$/", "", $field_values);

            return array('FIELD_NAMES'  => $field_names, 'FIELD_VALUES' => $field_values);
        } else { // We are compiling the fieldnames and fieldvalues for an update query
            foreach($array as $k => $v){
                $v = $this->make_value_safe($v);
                $update_string .= "`".$k."`='".$v."',";
            }
            // Removes the last ',' from the string
            $update_string = preg_replace("/,$/" , "", $update_string);

            return $update_string;
        }
    }
    
	// Execute a query
	// Param:	$the_query	String
	// Param:	$query_id	Integer
    public function query($the_query, $query_id){
        $the_query = preg_replace("[prefix]", $this->table_prefix, $the_query);
        $this->sql_result[$query_id] = mysql_query($the_query, $this->db_connection) or die($this->db_error("An error occurred while executing the following query:\n".$the_query));
        $this->query_counter++;
    }
    
	// Calls error page if something goes wrong
	// Param:	$message	String
    private function db_error($message){
        //if($this->development_mode == TRUE){
            $_SESSION['mysql_error'] = "<textarea readonly=\"readonly\" rows=\"6\" cols=\"60\">".$message."\n\nMySQL error: ".mysql_error()."\nMySQL error code: ".mysql_errno()."\nDate: ".date("l dS")." of ".date("F Y h:i:s A")."</textarea>";
        //}
        if (strpos($_SESSION['mysql_error'], "Unknown MySQL server host") !== false) { 
		unlink("setup\setup.lock");
		echo("<meta http-equiv=\"refresh\" content=\"0;url=setup\index.php\">");
			
		}elseif (strpos($_SESSION['mysql_error'], "using password: YES") !== false) { 
		unlink("setup\setup.lock");
		echo("<meta http-equiv=\"refresh\" content=\"0;url=setup\index.php\">");
		}elseif (strpos($_SESSION['mysql_error'], "using password: NO") !== false) { 
		unlink("setup\setup.lock");
		echo("<meta http-equiv=\"refresh\" content=\"0;url=setup\index.php\">");
		}elseif (strpos($_SESSION['mysql_error'], "/var/lib/mysql/mysql.sock") !== false) { 
		unlink("setup\setup.lock");
		echo("<meta http-equiv=\"refresh\" content=\"0;url=setup\index.php\">");
		}else{
			echo("<meta http-equiv=\"refresh\" content=\"0;url=error.php\">");
		}
        
        die();
    }
	
	// Get al the field data of a result set
	// Param:	$query_id	Integer
    public function get_field_data($query_id){
        return mysql_fetch_assoc($this->sql_result[$query_id]);
    }
	
	public function getmetadata($query_id,$id){
        return mysql_fetch_field($this->sql_result[$query_id],$id);
    }
	
	public function get_num_metadata($query_id){
        return mysql_num_fields($this->sql_result[$query_id]);
    }
	// Get the number of rows from a result set
	// Param:	$query_id	Integer
    public function get_num_records($query_id){
        return mysql_num_rows($this->sql_result[$query_id]);
    }
	
	// Destructor
    public function __destruct(){
        mysql_close($this->db_connection);
    }
}
?>
