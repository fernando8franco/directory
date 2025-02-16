<?php

$db_name = "directorio";
$db_file = "directorio.db";

$db = new SQLite3($db_file);
$db->enableExceptions(true);