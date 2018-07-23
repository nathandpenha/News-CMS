<?php
session_start();

define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PASS","root");
define("DB_NAME","blogdatabase");


$db = new mysqli(DB_HOST , DB_USER , DB_PASS , DB_NAME);
