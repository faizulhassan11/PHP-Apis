<?php

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
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data['id'])) {
        $student->id = $data['id'];

        if (!empty($data['name'])) {
            $student->name = $data['name'];
        }
        if (!empty($data['email'])) {
            $student->email = $data['email'];
        }
        if (!empty($data['mobile'])) {
            $student->mobile = $data['mobile'];
        }

        if ($student->update()) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Student updated successfully"));
        } else {
            http_response_code(500);
            echo json_encode(array("status" => 0, "message" => "Failed to update student"));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("status" => 0, "message" => "Please fill all fields"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 0, "message" => "Access denied"));
}
