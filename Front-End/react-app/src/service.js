import axios from 'axios';

class HttpService {
    baseUrl = 'http://192.168.33.11';
    
    getAllLocations() {
        return axios.get(`${this.baseUrl}/location`).then(r => r.data);
    }

    getProblemsByLocation(id) {
        return axios.get(`${this.baseUrl}/problems`).then(r => r.data);
    }
}

const httpService = new HttpService();

export default httpService;