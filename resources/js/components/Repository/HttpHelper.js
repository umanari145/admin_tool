
import store from "../../store";

export default class HttpHelper {

    constructor() {
        this.headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    }

    getHeaderIncToken(headers) {
        headers['Authorization'] = 'Bearer ' + store.getters['user/getAccessToken'];
        console.log(headers);
        return headers;
    }

    get(url) {
        return axios.get(url, {headers: this.getHeaderIncToken(this.headers)})
    }

}