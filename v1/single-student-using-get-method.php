<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Request-Method, Access-Control-Allow-Origin");

include_once('../config/database.php');
include_once('../classes/student.php');

$db = new Database();
$connection = $db->connect();
$student = new Student($connection);

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    
    $id = isset($_GET['id'])?intval($_GET['id']):"";

    if (!empty($id)) {
        $student->id = $id;
        $data = $student->read_single_record();

        if (!empty($data)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Student fetched successfully", "data" => $data));
        } else {
            http_response_code(404);
            echo json_encode(array("status" => 0, "message" => "No student found"));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("status" => 0, "message" => "Invalid request: ID is required"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 0, "message" => "Access denied"));
}
