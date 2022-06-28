
import HttpHelper from "./HttpHelper.js";

const httpHelper = new HttpHelper();

export default class AuthCheck {

    constructor() {
    }

    check() {
        return httpHelper.get('api/check');
    }
}