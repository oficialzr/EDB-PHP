<?php

function checkValid($param, $user, $admin) {
	if ($param === $user || $admin == 1) {
		return True;
	} else {
		return False;
	    // header('Location:' . BASE_URL);
	}
}

function isAdmin($admin) {
	if ($admin == 1) {
		return True;
	} else {
		return False;
	}
}
