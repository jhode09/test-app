<?php

	if($_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'])) {        
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location: /corporatekeys-exam/403.php' ) );
    }

	include_once ('../controllers/ItemController.php');

	$itemController = new ItemController();

	switch ($_POST['action']) {
		case 'selectAll':
			$data = $itemController->select();
			echo $data;
		break;
		case 'selectSingle':
			$data = $itemController->select($_POST);
			echo $data;
		break;
		case 'insert':
			$data = $itemController->insert($_POST);
			echo json_encode($data);
		break;
		case 'update':
			$data = $itemController->update($_POST);
			echo json_encode($data);
		break;
		case 'delete':
			$data = $itemController->delete($_POST);
			echo json_encode($data);
		break;
		default:
			// code...
		break;
	}
?>