<?php
class Account
{
	private $con;
	private $errorArray;

	public function __construct($con)
	{
		$this->con = $con;
		$this->errorArray = array();
	}

	public function login($username, $password)
	{
		$query = $this->con->prepare("SELECT password FROM users WHERE username = ?");
		$query->bind_param("s", $username);
		$query->execute();
		$result = $query->get_result();

		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			if (md5($password) === $row['password']) {
				return true;
			}
		}

		array_push($this->errorArray, Constants::$loginFailed);
		return false;
	}

	public function register($username, $firstName, $lastName, $email, $email2, $password, $password2)
	{
		$this->validateUsername($username);
		$this->validateFirstName($firstName);
		$this->validateLastName($lastName);
		$this->validateEmails($email, $email2);
		$this->validatePasswords($password, $password2);

		if (empty($this->errorArray)) {
			// Insert into database 
			return $this->insertUserDetails($username, $firstName, $lastName, $email, $password);
		} else {
			return false;
		}
	}

	public function getError($error)
	{
		if (!in_array($error, $this->errorArray)) {
			$error = "";
		}
		return "<span class='errorMessage'> $error </span>";
	}

	private function insertUserDetails($username, $firstName, $lastName, $email, $password)
	{
		// Encrypt password using MD5
		$encryptedPassword = md5($password);
		$profilePic = "assets/images/profile-pics/user.jpg";
		$date = date("Y-m-d");

		$query = $this->con->prepare("INSERT INTO users (username, firstName, lastName, email, password, signUpDate, profilePic) VALUES (?, ?, ?, ?, ?, ?, ?)");
		$query->bind_param("sssssss", $username, $firstName, $lastName, $email, $encryptedPassword, $date, $profilePic);

		return $query->execute();
	}

	private function validateUsername($un)
	{
		if (strlen($un) > 25 || strlen($un) < 5) {
			array_push($this->errorArray, Constants::$usernameCharacters);
			return;
		}

		// Check if username exists in the table
		$query = $this->con->prepare("SELECT username FROM users WHERE username = ?");
		$query->bind_param("s", $un);
		$query->execute();
		$result = $query->get_result();

		if ($result->num_rows != 0) {
			array_push($this->errorArray, Constants::$usernameTaken);
			return;
		}
	}

	private function validateFirstName($fn)
	{
		if (strlen($fn) > 25 || strlen($fn) < 2) {
			array_push($this->errorArray, Constants::$firstNameCharacters);
			return;
		}
	}

	private function validateLastName($ln)
	{
		if (strlen($ln) > 25 || strlen($ln) < 2) {
			array_push($this->errorArray, Constants::$lastNameCharacters);
			return;
		}
	}

	private function validateEmails($em, $em2)
	{
		if ($em != $em2) {
			array_push($this->errorArray, Constants::$emailsDoNotMatch);
			return;
		}
		if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
			array_push($this->errorArray, Constants::$emailInvalid);
			return;
		}

		// Check if the email exists in the database 
		$query = $this->con->prepare("SELECT email FROM users WHERE email = ?");
		$query->bind_param("s", $em);
		$query->execute();
		$result = $query->get_result();

		if ($result->num_rows != 0) {
			array_push($this->errorArray, Constants::$emailTaken);
			return;
		}
	}

	private function validatePasswords($pw, $pw2)
	{
		if ($pw != $pw2) {
			array_push($this->errorArray, Constants::$passwordsDoNoMatch);
			return;
		}
		if (preg_match("/[^a-zA-Z0-9_$!@%&*]/", $pw)) {
			array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
			return;
		}
		if (strlen($pw) > 30 || strlen($pw) < 4) {
			array_push($this->errorArray, Constants::$passwordCharacters);
			return;
		}
	}
}

?>