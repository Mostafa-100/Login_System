<?php

require_once("../helpers/helpers.php");

session_start();
session_unset();
session_destroy();

redirect("../index.php");
