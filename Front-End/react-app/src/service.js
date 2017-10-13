import axios from 'axios';

class HttpService {
    baseUrl = 'http://192.168.33.11';
    
    getAllLocations() {
        return axios.get(`${this.baseUrl}/location`).then(r => r.data);
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