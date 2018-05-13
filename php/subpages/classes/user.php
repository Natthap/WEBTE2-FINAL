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

    public function getCategory() {
        $query = "SELECT * FROM `categories`";
        $results = mysqli_query($this->_db, $query)  or die(mysqli_error());
        $categories = array();
        while ( $result = mysqli_fetch_assoc($results) ) {
            $categories[$result['id']] = $result['category_name'];
        }
        mysqli_close($this->_db);
        return $categories;
    }

    public function getQuestions(array $data) {
        if( !empty( $data ) ){

            // escape variables for security
            $category_id = mysqli_real_escape_string( $this->_db, trim( $data['category'] ) );
            if((!$category_id) ) {
                throw new Exception( FIELDS_MISSING );
            }
            $user_id = $_SESSION['id'];
            $query = "INSERT INTO scores ( user_id,right_answer,category_id, created)VALUES ( '$user_id',0,'$category_id', now())";
            mysqli_query( $this->_db, $query);
            $_SESSION['score_id'] = mysqli_insert_id($this->_db);
            $results = array();
            $number_question = $_POST['num_questions'];
            $row = mysqli_query( $this->_db, "select * from questions where category_id=$category_id ORDER BY RAND() LIMIT 45");
            $rowcount = mysqli_num_rows( $row );
            $remainder = $rowcount/$number_question;
            $results['number_question'] = $number_question;
            $results['remainder'] = $remainder;
            $results['rowcount'] = $rowcount;
            while ( $result = mysqli_fetch_assoc($row) ) {
                $results['questions'][] = $result;
            }
            mysqli_close($this->_db);
            return $results;
        } else{
            throw new Exception( FIELDS_MISSING );
        }
    }

    public function getResults($id = '') {
        if( !empty( $id ) ){
            $right_answer=0;
            $wrong_answer=0;
            $unanswered=0;
            $query1 = "select answers from scores where uuid = '$id'";
            $query1_result = mysqli_query( $this->_con, $query1)   or die(mysqli_error());
            $query1_result = mysqli_fetch_assoc( $query1_result );

            $data = array();
            $data = json_decode( $query1_result['answers'], true);
            $keys=array_keys($data);
            $order=join(",",$keys);

            $query = "select * from questions where id IN($order) ORDER BY FIELD(id,$order)";
            $response=mysqli_query( $this->_con, $query)   or die(mysqli_error());
            $questions = array();
            while($result=mysqli_fetch_array($response)){
                $id = trim($result['id']);
                if($result['answer']==$data[$id]){
                    $right_answer++;
                }else if($data[$id]=='smart_quiz'){
                    $unanswered++;
                }
                else{
                    $wrong_answer++;
                }
                $result['user_answer'] = $data[$id];
                $questions[] = $result;
            }

            $results = array();
            $results['right_answer'] = $right_answer;
            $results['wrong_answer'] = $wrong_answer;
            $results['unanswered'] = $unanswered;

            mysqli_close($this->_con);
            $questions['results'] = $results;
            return $questions;
        }
    }

    public function getAnswers(array $data) {
        if( !empty( $data ) ){
            $right_answer=0;
            $wrong_answer=0;
            $unanswered=0;

            $answers = json_encode($data);
            $keys=array_keys($data);
            $order=join(",",$keys);
            $query = "select * from questions where id IN($order) ORDER BY FIELD(id,$order)";
            $response=mysqli_query( $this->_con, $query)   or die(mysqli_error());

            $user_id = $_SESSION['id'];
            $score_id = $_SESSION['score_id'];
            $questions = array();
            while($result=mysqli_fetch_array($response)){
                if($result['answer']==$data[$result['id']]){
                    $right_answer++;
                }else if($data[$result['id']]=='smart_quiz'){
                    $unanswered++;
                }
                else{
                    $wrong_answer++;
                }
                $result['user_answer'] = $data[$result['id']];
                $questions[] = $result;
            }
            $results = array();
            $results['right_answer'] = $right_answer;
            $results['wrong_answer'] = $wrong_answer;
            $results['unanswered'] = $unanswered;
            $uuid = md5(time()*rand(1, 100));
            echo $update_query = "update scores set right_answer='$right_answer', wrong_answer = '$wrong_answer', unanswered = '$unanswered', answers = '$answers', uuid='$uuid' where user_id='$user_id' and id ='$score_id' ";
            mysqli_query( $this->_con, $update_query)   or die(mysqli_error());
            mysqli_close($this->_con);

            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?uuid=$uuid";
            header('Location:'.$actual_link);exit;


            /* $questions['results'] = $results;
            return $questions; */
        }
    }

}
?>
