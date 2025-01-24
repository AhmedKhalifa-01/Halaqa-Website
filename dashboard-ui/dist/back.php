<?php
if (isset($_SERVER['HTTP_REFERER']) && filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL)) {
	// The HTTP_REFERER server variable is set and valid
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit;
  } else {
	// The HTTP_REFERER server variable is not set or invalid
	echo "Unable to redirect to the previous page.";
  }
?>