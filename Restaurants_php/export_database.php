<?php include('action.php');
$host = $obj->server_name = "localhost";
$username = $obj->user_name;
$password = $obj->password;
$database = $obj->database_name;

$filename = 'database_export_' . date('Y-m-d_H-i-s') . '.sql';

$command = "mysqldump --host=$host --user=$username --password=$password $database > $filename";

exec($command, $output, $returnVar);

if ($returnVar === 0) {
    print_r(["status" => "ok", "message" => $filename]);
} else {
    print_r(["status" => "failed", "message" => "something went wrong"]);
}
