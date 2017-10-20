import axios from 'axios';

class HttpService {
    userId = null;
    baseUrl = 'http://react-pxl.westeurope.cloudapp.azure.com';
    constructor(userId) {
        this.userId = userId;
    }

    getId() {
        return Math.random() * 10000000;
    }

    getCalories() {
        return axios.get(`${this.baseUrl}/calorieEntries?userId=${this.userId}`).then(r => r.data);
    }

    addCalorieEntry(date, calories, id) {
        return axios.post(`${this.baseUrl}/calorieEntries`, { id: id, userId: this.userId, date: date, weight: calories });
    }
    deleteCalorieEntry(id) {
        return axios.delete(`${this.baseUrl}/calorieEntries/${id}`)
    }
}

const httpService = new HttpService(1);

export default httpService;
