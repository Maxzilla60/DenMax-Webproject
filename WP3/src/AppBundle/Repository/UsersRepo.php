<?php

namespace AppBundle\Repository;

class UsersRepo {
	private $buzz;

	public function setBuzz($buzz) {
		$this->buzz = $buzz;
	}

    public function getUserByUsername($username) {
        return json_decode(file_get_contents("http://192.168.33.11/users/username/".$username));
    }

    public function getUsersByRole($role) {
    	return json_decode(file_get_contents("http://192.168.33.11/users/role/".$role));
    }

    public function updateTechnician($user_id, $username) {
		// Build JSON payload:
		$json = json_encode([
		    "name" => $username,
		    "role" => "0"
		]);
		// Set request headers
		$headers = ['Content-Type', 'application/json'];
		// Send POST to API
		$this->buzz->post('http://192.168.33.11/users/update/'.$user_id, $headers, $json);
    }

    public function deleteUser($user_id) {
    	$this->buzz->post('http://192.168.33.11/users/delete/'.$user_id);	
    }

    public function addTechnician($username) {
        // Build JSON payload:
        $json = json_encode([
            "name" => $username,
            "role" => "0"
        ]);
        // Set request headers
        $headers = ['Content-Type', 'application/json'];
        // Send POST to API
        $this->buzz->post('http://192.168.33.11/users/add/', $headers, $json);
    }
}