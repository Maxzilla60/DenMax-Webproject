<?php

namespace AppBundle\Repository;

class ProblemsRepo {
	private $buzz;

	public function setBuzz($buzz) {
		$this->buzz = $buzz;
	}

    public function getAllProblems() {
        return json_decode(file_get_contents("http://192.168.33.11/problems"));
    }
    
    public function getProblemsByLocation($location_id) {
        return json_decode(file_get_contents("http://192.168.33.11/problems/location/".$location_id));
    }

    public function getProblemsByTechnician($technician_id) {
    	return json_decode(file_get_contents("http://192.168.33.11/problems/technician/".$technician_id));
    }

    public function updateTechnicianForProblem($technician_id, $problem_id) {
        // Build JSON payload:
        $json = json_encode([
            "technician" => $technician_id
        ]);
        // Set request header
        $headers = ['Content-Type', 'application/json'];
        // Send POST to API
        $this->buzz->post('http://192.168.33.11/problems/updateTechnician/'.$problem_id, $headers, $json);
    }

    public function deleteTechnicianFromProblem($problem_id) {
		$this->buzz->post('http://192.168.33.11/problems/deleteTechnician/'.$problem_id);
    }

    public function fixProblem($problem_id) {
        $this->buzz->post('http://192.168.33.11/problems/fixProblem/'.$problem_id);
    }
}