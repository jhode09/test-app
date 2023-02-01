<?php

if($_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'])) {        
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
    die( header( 'location: /corporatekeys-exam/403.php' ) );
}

include_once('../models/Crud.php');

class ItemController
{
	var $table;
	var $crud;

	function __construct() {
        $this->table = "items";
        $this->crud  = new Crud();
    }

	public function select($request = null) {
		try {
			$data = ($request) ? $this->crud->selectByID($this->table, $request->id) : $this->crud->selectAll($this->table);
			return json_encode($data);
		} catch (Exception $e) {
			return $e;
		}
	}

	public function insert($request) {
		try {
			$exists = $this->crud->selectAllByColumn($this->table, 'title', $request['title']);
			if($exists) {
				return [ "success" => "exists" ];
			} else {
				$upload = $this->uploadImage($request);
				if($upload["success"] != false) {
					$data = array(
						"title"    => $this->crud->escapeString($request['title']),
						"filename" => $upload["filename"]
					);
					$insert = $this->crud->insert($this->table, $data);
					return [ "success" => true ];
				} else {
					return "failed";
				}
			}

		} catch (Exception $e) {
			return "failed";
		}
	}

	public function update($request) {
		try {
			$exists = $this->crud->selectAllByColumn($this->table, 'title', $request['title'], $request["id"]);
			if($exists) {
				return [
					"success" => "exists"
				];
			} else {
				$item = $this->crud->selectByID($this->table, $request["id"]);
				$filename = $item["filename"];

				if($_FILES['filename']['name']) {
					unlink("../public/uploads/".$item["filename"]);
					$upload = $this->uploadImage($request);
					$filename = $upload["filename"];
				}

				$data = array(
					"title"     => $this->crud->escapeString($request['title']),
					"filename"  => $filename
				);

				$update = $this->crud->update($this->table, $data, $request["id"]);
				return [
					"success" => true
				];
			}
		} catch (Exception $e) {
			return "failed";
		}
	}

	public function delete($request) {
		try {
			$item = $this->crud->selectByID($this->table, $request["id"]);
			$path = "../public/uploads/".$item["filename"];
			if(file_exists($path)) {
	 			unlink($path);
			}

			$delete = $this->crud->delete($this->table, $request["id"]);
			return [
				"success" => true
			];
		} catch (Exception $e) {
			return "failed";
		}
	}

	private function uploadImage($request) {
		$file_name = $_FILES['filename']['name'];
	    $file_size = $_FILES['filename']['size'];
	    $file_tmp  = $_FILES['filename']['tmp_name'];
	    $file_type = $_FILES['filename']['type'];
	    $file_ext  = strtolower(explode('.',$_FILES['filename']['name'])[1]);

	    $date = date("Y-m-d H:i:s");
	    $time = strtotime($date);
	    $new_file_name = "FILE_".$time.".".$file_ext;
	    $file_path = "../public/uploads/".$new_file_name;

	    
	    if(empty($errors)==true){
         	move_uploaded_file($file_tmp, $file_path);
		    return [
		    	"success"  => true,
		    	"filename" => $new_file_name
		    ];
      	} else {
         	return ["success"  => false];
      	}
	}
}
?>