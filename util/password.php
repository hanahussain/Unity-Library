<?php

// Checks for password length and inclusion of necessary characters
// Returns true if password is valid, false otherwise
function verifyPassword($password){
	return strlen($password) >= 10 && hasDigitsAndChars($password);
}


// Uses built in preg_match function, which uses a regular expression, to ensure argument has at least
// one digit and one letter
function hasDigitsAndChars($password){
    return preg_match('/[a-zA-Z]/', $password) && preg_match('/[0-9]/', $password);
}

?>