<?php
include('password.php');
class User extends Password{

    private $_db;

    function __construct($db){
    	parent::__construct();

    	$this->_db = $db;
    }

	private function get_user_hash($username){

		try {
			$stmt = $this->_db->prepare('SELECT id, password, email, personType FROM members WHERE email = :username AND active="Yes" ');
			$stmt->execute(array('username' => $username));

			return $stmt->fetch();

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}

	public function isValidUsername($username){
		if (strlen($username) < 3) return false;
		if (strlen($username) > 37) return false;
		if (!ctype_alnum($username)) return false;
		return true;
	}

	public function login($username,$password){
		//if (!$this->isValidUsername($username)) return false;
		if (strlen($password) < 3) return false;

		$row = $this->get_user_hash($username);

        if($this->password_verify($password,$row['password']) == 1){
            $_SESSION['logged_in'] = true;
            $_SESSION['memberID'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['personType'] = $row['personType'];
            return true;
        }
        else {
            return false;
        }
	}

	public function logout(){
		session_destroy();
	}

	public function is_logged_in(){
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
			return true;
		}
	}

    public function account( array $data ) {
        if( !empty( $data ) ){
            // Trim all the incoming data:
            $trimmed_data = array_map('trim', $data);

            // escape variables for security
            $password = mysqli_real_escape_string( $this->_db, $trimmed_data['password'] );
            $cpassword = $trimmed_data['confirm_password'];
            $user_id = $_SESSION['id'];
            if((!$password) || (!$cpassword) ) {
                throw new Exception( FIELDS_MISSING );
            }
            if ($password !== $cpassword) {
                throw new Exception( PASSWORD_NOT_MATCH );
            }
            $password = md5( $password );
            $query = "UPDATE users SET password = '$password' WHERE id = '$user_id'";
            if(mysqli_query($this->_db, $query)){
                mysqli_close($this->_db);
                return true;
            }
        } else{
            throw new Exception( FIELDS_MISSING );
        }
    }

}
?>
