<?php

// Generate a pop up error message with message $errorStr
function error($errorStr) {
	echo '<script>alert("' .  $errorStr . '")</script>';
}

// Generate current url keeping only parameters specified in array $names
function generateURL($names) {
	$url = "";
	$pre = "?";
	foreach ($names as $name) {
		$val = $_GET[$name];
		if ($val != "") {
			$url .= "{$pre}{$name}={$val}";
			$pre = "&";
		}
	}
	return $url;
}

?>