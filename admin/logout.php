<?php
	session_start();
	session_destroy();
	unset($_SESSION['admin']);
	header("location: login");
