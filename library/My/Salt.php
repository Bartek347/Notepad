<?php

class My_Salt
{
	public function getSalt()
	{
		$salt = '';
		for ($i = 0; $i < 32; $i++) {
			$salt .= chr(rand(33,126));
		}
		return $salt;
	}

	public static function getSalt2()
	{
		return md5(time());
	}

	public static function getSalt3()
	{
		return sha1(self::getSalt() . time . self::getSalt());
	}
}

?>