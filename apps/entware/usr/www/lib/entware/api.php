<?php

$fn = $_GET["fn"];
switch ($fn) {
    case "log":
        $log = file_get_contents('/var/log/entware.log');
        if (!$log) {
            $log = "Log file doesn't exist. Install was not started yet";
        }
        break;

    case "install":
        $output = null;
        $retval = null;
        exec('/usr/local/entware/bin/install_wrap.sh', $output, $retval);
        if ($retval != 0) {
            $log = $retval;
        }
        break;

    default:
        $log = "Unknown action $fn";
}

echo($log);
