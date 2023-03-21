<?php


    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $category = new Category($db);

    //Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    //Set ID to update
    $category->id = $data->id;

    //Delete category
    if($category->delete()) {
        $message = array("message" => "Category Deleted");
        echo json_encode($message);
    } else {
        $message = array("message" => "category_id Not Found");
        echo json_encode($message);
    }
?>