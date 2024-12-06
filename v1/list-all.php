<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Request-Method, Access-Control-Allow-Origin");

include_once('../config/database.php');
include_once('../classes/student.php');

$db = new Database();
$connection = $db->connect();
$student = new Student($connection);

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $data = $student->read();

    if ($data !== false && count($data) > 0) {
        $students["records"] = $data;

        http_response_code(200);
        echo json_encode(array("status" => 1, "message" => "Students fetched successfully", "data" => $students));
    } else {
        http_response_code(404);
        echo json_encode(array("status" => 0, "message" => "No students found"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 0, "message" => "Access denied"));
}
