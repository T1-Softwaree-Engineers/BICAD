<?php
	@session_start();
	header("location: index");
	session_destroy();
?>