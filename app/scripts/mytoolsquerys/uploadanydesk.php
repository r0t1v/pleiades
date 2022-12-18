<?php
session_start();
require __DIR__.'\..\..\config.php';
include __DIR__.'\..\..\scripts\verifyauth.php';




mysqli_close($CONNECTION_DB);