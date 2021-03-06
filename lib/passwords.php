<?php
	declare(strict_types=1);

	require_once "utils.php";
	require_once "db.php";

	function hash_password(string $pass): string {
		return md5(md5("}2sa(<@!".$pass));
	}

	function check_password(string $login, string $pass) {
		$hash = hash_password($pass);
		$user = sql_query_assoc("SELECT * FROM `passwords` WHERE `LOGIN` = '$login'");

		if ($user['HASH'] == $hash)
			return $user["ROLE"];
		else
			return false;
	}

	function enter_user(string $login, string $pass): bool {
		if ($role = check_password($login, $pass)) {
			$_SESSION["login"] = $login;
			$_SESSION["role"] = $role;
			return true;
		}
		return false;
	}

	function register_user(string $login, string $pass, string $role): bool {
		if ($role != "student" && $role != "teacher")
			return false;

		$hash = hash_password($pass);
		sql_query("INSERT INTO `passwords` (`LOGIN`, `HASH`, `ROLE`) VALUES ('$login', '$hash', '$role')");
		return true;
	}
?>