<?php

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    $database = new Database();
    $db = $database->connect();

    $quote = new Quote($db);

    //Get ID
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();

    //Get quote
    $quote->read_single();

    //Create array
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'category' =>$quote->category,
        'author' =>$quote->author
    );
    if(is_null($id)){
        $message = array("message" => "No Quotes Found");
        echo json_encode($message);
    } else if(is_null($category_id)){
        $message = array("message" => "category_id Not Found");
        echo json_encode($message);
    } else if(is_null($author_id)){
        $message = array("message" => "author_id Not Found");
        echo json_encode($message);
    } else{
        print_r(json_encode($quote_arr));
    }

?>