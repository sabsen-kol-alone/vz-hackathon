<?php
	class userauth {

		private $user;
		
		public function __construct() {
			global $_SESSION;
			$passwd_db = __DIR__ . '/../../passwd.db';
			$passwd_data = file( $passwd_db);
			$i = 0;
			foreach( $passwd_data as $p) {
				$arr = explode( ':', $p);
				$this->user[$i]['userid'] = $arr[0];
				$this->user[$i]['password'] = $arr[1];
				$this->user[$i]['name'] = $arr[2];
				$this->user[$i]['role'] = $arr[3];
				$this->user[$i]['email'] = $arr[4];
				$i++;
				if( empty( $_SESSION['token'])) {
					$_SESSION['token'] = $this->get_token(16);
				}
			}
		}

		public function login( $userid, $password, $token) {
			global $_SESSION;
			
			if( $_SESSION['token'] != $token) {
				return false;
			}
			
			$found = false;
			foreach( $this->user as $user) {
				if( $user['userid'] == $userid 
				&& $user['password'] == md5($password )) {
					$found = true;
					break;
				}
			}

			if( $found) {
				$_SESSION['userid'] = $user['userid'];
				$_SESSION['name'] = $user['name'];
				$_SESSION['role'] = $user['role'];
				$_SESSION['email'] = $user['email'];
				return true;
			} else {
				return false;
			}
		}

		public function logged_in() {
			global $_SESSION;
			if( !empty($_SESSION['userid'])) {
				return true;
			} else {
				return false;
			}
		}
		
		public function create_user() {
			$passwd_db = __DIR__ . '/../../passwd.db';
			$access_ini = __DIR__ . '/../../access.ini';
			
			$userid = $_POST['userid'];
			$password = $_POST['password'];
			$name = $_POST['name'];
			$role = 'developer';
			$email = $_POST['email'];
			
			$found = false;
			foreach( $this->user as $user) {
				if( $user['userid'] == $userid ) {
					$found = true;
					break;
				}
			}

			if( $found) {
				return false;
			} else {
				$str = $userid.':'.md5($password).':'.$name.':'.$role.':'.$email."\n";
				file_put_contents( $passwd_db, $str, FILE_APPEND);

				$str = "[" . $userid . "]\n";
				file_put_contents( $access_ini, $str, FILE_APPEND);
				$str = "  applist = " . $_SESSION['appstr'] . "\n";
				file_put_contents( $access_ini, $str, FILE_APPEND);
				return true;
			}
		}

		public function logout() {
			global $_SESSION;
			$_SESSION = null;
			session_destroy();
			return true;
		}
		
		function randomize($min, $max) {
			$range = $max - $min;
			if ($range < 1) return $min; 
			$log = ceil(log($range, 2));
			$bytes = (int) ($log / 8) + 1;
			$bits = (int) $log + 1;
			$filter = (int) (1 << $bits) - 1;
			do {
				$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
				$rnd = $rnd & $filter;
			} while ($rnd >= $range);
			return $min + $rnd;
		}

		function get_token($length) {
			$token = "";
			$string = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$string.= "abcdefghijklmnopqrstuvwxyz";
			$string.= "0123456789";
			$max = strlen($string) - 1;
			for ($i=0; $i < $length; $i++) {
				$token .= $string[$this->randomize(0, $max)];
			}
			return $token;
		}		
	}
	
/* Main application flow starts from here */
	
	session_start();
	
	$user = new userauth();
	
	if( $user->logged_in()) {
//		Do nothing!
	} else
	if( empty($_POST['userid'])) {
?>

  <link href="assets/style.css" rel="stylesheet" type="text/css">
	<div align=center>
	<h1>VZBehat User Login</h1>
	<div style="padding:10px; border:1px solid #777; background-color: #ddd; width:300px;">
		<body style="font-size:16px; font-family:Arial">
		<form id=login-form method=post action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<p>
				User ID<br><input class=behat-select-item type=text name=userid size=10 value="<?php echo @$_POST['userid']; ?>">
			</p><p>
				Password<br><input class=behat-select-item type=password name=password>
			</p><p>
			<input type=hidden name=token value='<?php echo $_SESSION['token']; ?>'>
       <br><br>
       <a href="#" onClick="getElementById('login-form').submit();" class=behat-button>LOGIN</a>
		</form>
	</div></div>

<?php
		exit;
	} else
	if( ! $user->login( filter_var($_POST['userid'], FILTER_SANITIZE_STRING), @$_POST['password'], @$_POST['token'] )) { 
		echo "<center><h1>Incorrect UserID or Password</h1></center>";
		exit;
	} else {
		header( 'Location: ' . $web_url . '?token=' . $_SESSION['token']);
	}
	
	
