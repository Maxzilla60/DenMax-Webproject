import axios from 'axios';

class HttpService {
    baseUrl = 'http://192.168.33.11';
    
    getAllLocations() {
        return axios.get(`${this.baseUrl}/locations`).then(r => r.data);
    }

    getLocationByCompany(id) {
        return axios.get(`${this.baseUrl}/location/${id}`).then(r => r.data);
    }

    getProblemsByLocation(id) {
        return axios.get(`${this.baseUrl}/problems/${id}`).then(r => r.data);
    }

    getStatusReportsByLocation(id) {
        return axios.get(`${this.baseUrl}/statusreports/${id}`).then(r => r.data);
    }
}

const httpService = new HttpService();

export default httpService;