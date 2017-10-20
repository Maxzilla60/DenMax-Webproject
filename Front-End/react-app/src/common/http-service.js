import axios from 'axios';

class HttpService {
    baseUrl = 'http://192.168.33.11';
    
    getAllLocations() {
        return axios.get(`${this.baseUrl}/locations`).then(r => r.data);
    }

    getLocationByCompany(id) {
        return axios.get(`${this.baseUrl}/locations/company/${id}`).then(r => r.data);
    }

    getProblemsByLocation(id) {
        return axios.get(`${this.baseUrl}/problems/${id}`).then(r => r.data);
    }

    getAllStatusReports() {
        return axios.get(`${this.baseUrl}/statusreports`).then(r => r.data);
    }

    getStatusReportByLocation(id) {
        return axios.get(`${this.baseUrl}/statusreports/location/${id}`).then(r => r.data);
    }
}

const httpService = new HttpService();

export default httpService;