
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
        return headers;
    }

    get(url) {
        return axios.get(url, {headers: this.getHeaderIncToken(this.headers)});
    }

    post(url, data) {
        return axios.post(url, data, {headers: this.getHeaderIncToken(this.headers)});
    }

    put(url, data) {
        return axios.put(url, data, {headers: this.getHeaderIncToken(this.headers)});
    }

    delete(url, data) {
        return axios.delete(
            url, 
            {
                headers: this.getHeaderIncToken(this.headers), 
                data:data
            }
        );
    }

    errorHandling(err) {
        if (err.response.status === 401) {
            alert("認可されていないユーザーです。")
            location.href = "/";
        } else {
            alert("データの取得に失敗しました。");
        }
        console.log(err.response.data.message)
    }
}