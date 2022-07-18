<?php

    require '../controller/analyticsController.php';
    
    $controller = new AnalyticsController();
    
    $data = $controller->Analytics();
    
    header('Content-Type:application/json');
    echo json_encode($data);