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
        header('Content-type: application/json');
        echo json_encode([
            'result' => $retval,
            'output' => $output]);
        return;

    default:
        $log = "Unknown action $fn";
}

header('Content-type: text/plain');
echo($log);
