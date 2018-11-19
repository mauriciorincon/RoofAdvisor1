<?php

// This holds functions and SQL connection information

/*$user = 'root';
$password = 'root';
$db = 'DTC';
$server = 'localhost:8889';*/

$server = "localhost";
$user = "root";
$password = "P@ssw0rd24";
$db='roofz';

$conn=mysqli_connect($server,$user,$password,$db) or
die("Could not connect: " . mysql_error());

// Checks a users sql query to make sure it is valid
function checkUserStmt($conn, $sql) {
	$stmt = mysqli_query($conn, $sql);
	if ($stmt === false) {
        echo("Error description: " . mysqli_error($conn));
	}
	return $stmt;
}

// Frees up both $stmt and $sql
function freeUserData($stmt, $sql) {

	// Frees up the statement
	//mysqli_free_result($stmt);
    unset($stmt);

	// Frees up $sql
	unset($sql);
}

// Searches a multidimensional array for if an item exists
function in_array_r($needle, $haystack, $strict = false) {
	foreach ($haystack as $item) {
		if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
			return true;
		}
	}
	return false;
}

// Prints out the array
function print_a($array_name) {
	print('<pre>');
	print_r($array_name);
	print('</pre>');
}

// Deletes chosen column in array
function delete_col(&$array, $offset) {
	return array_walk($array, function (&$v) use ($offset) {
		array_splice($v, $offset, 1);
	});
}

// Searches a given associative array for a string/number/etc at a given key
function search_array($haystack, $needle, $index) {
	foreach($haystack as $key => $product) {
		if ($product[$index] === $needle)
			return $key;
		}
	return false;
}


    // set timeout period in seconds
    $inactive = 6000;
    // check to see if $_SESSION['timeout'] is set
    if(isset($_SESSION['timeout']) ) {
    	$session_life = time() - $_SESSION['timeout'];
    	if($session_life > $inactive)
            { session_destroy(); header("Location: localhost/index.php"); }
    }
    $_SESSION['timeout'] = time();


?>
