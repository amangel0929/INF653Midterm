<?php

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    $database = new Database();
    $db = $database->connect();

    $category = new Category($db);

    //Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $category->category = $data->category;


    if($category->create()) {
        $result = $category_arr = array(
            'id' => $category->id,
            'author' => $category->category
        );
        echo json_encode($result);
    } else {
        $message = array("message" => "category_id Not Found");
        echo json_encode($message);
    }
?>