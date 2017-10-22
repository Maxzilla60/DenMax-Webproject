import axios from 'axios';

class HttpService {
    baseUrl = 'http://192.168.33.11';
    
    getAllLocations() {
        return axios.get(`${this.baseUrl}/locations`).then(r => r.data);
    }

    getLocationByCompany(id) {
        return axios.get(`${this.baseUrl}/locations/company/${id}`).then(r => r.data);
    }

    addLocation(name, company_id) {
        return axios.post(`${this.baseUrl}/locations/add`, {
            "name": name,
            "company_id": company_id
        }).then(function (response) {
            console.log(response);
        }).catch(function (error) {
            console.log(error);
        });
    }

    getAllProblems() {
        return axios.get(`${this.baseUrl}/problems`).then(r => r.data);
    }

    getProblemByLocation(id) {
        return axios.get(`${this.baseUrl}/problems/location/${id}`).then(r => r.data);
    }

    addProblem(description, date, fixed, location_id) {
        return axios.post(`${this.baseUrl}/problems/add`, {
            "location_id": location_id,
            "description": description,
            "date": date,
            "fixed": fixed
        }).then(function (response) {
            console.log(response);
        }).catch(function (error) {
            console.log(error);
        });
    }

    updateTechnician(problem_id, technician) {
        return axios.post(`${this.baseUrl}/problems/updateTechnician/${problem_id}`, {
            "technician": technician
        }).then(function (response) {
            console.log(response);
        }).catch(function (error) {
            console.log(error);
        });
    }

    updateTechnician(problem_id) {
        return axios.post(`${this.baseUrl}/problems/deleteTechnician/${problem_id}`).then(function (response) {
            console.log(response);
        }).catch(function (error) {
            console.log(error);
        });
    }

    getAllStatusReports() {
        return axios.get(`${this.baseUrl}/statusreports`).then(r => r.data);
    }

    getStatusReportByLocation(id) {
        return axios.get(`${this.baseUrl}/statusreports/location/${id}`).then(r => r.data);
    }

    addStatusReport(date, location_id, status) {
        return axios.post(`${this.baseUrl}/statusreports/add`, {
            "location_id": location_id,
            "date": date,
            "status": status
        }).then(function (response) {
            console.log(response);
        }).catch(function (error) {
            console.log(error);
        });
    }
}

const httpService = new HttpService();

export default httpService;