import axios from "axios";
export default class HttpClient{
    constructor(){
        this.http = axios
    }
    request(method,url){
        return axios.get(method,url)
    }

}