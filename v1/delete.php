<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Request-Method, Access-Control-Allow-Origin");

include_once('../config/database.php');
include_once('../classes/student.php');

$db = new Database();
$connection = $db->connect();
$student = new Student($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $param = json_decode(file_get_contents("php://input"), true);

    if (!empty($param['id'])) {
        $student->id = $param['id'];

        if ($student->delete_single_record()) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Student deleted successfully"));
        } else {
            http_response_code(404);
            echo json_encode(array("status" => 0, "message" => "No student found or failed to delete"));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("status" => 0, "message" => "Invalid request: ID is required"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 0, "message" => "Access denied"));
}
