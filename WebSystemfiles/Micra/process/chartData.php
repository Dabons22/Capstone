<?php 
    require '../controller/chartController.php';

    $controller = new ChartController();

    $data = $controller->Data();

    header('Content-Type: application/json');
    echo json_encode($data);