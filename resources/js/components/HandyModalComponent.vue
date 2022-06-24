<template>
    <div class="container">
        <modal name="handy-add" 
            :draggable="true" 
            :resizable="true" 
            width = "60%" 
            height = "60%"
            @before-open="dataInit"
            @before-close="dataInit">
            <div class="modal-header">
                <h2>項目追加</h2>
                <button @click="hide"><img src="/img/close.png"></button>
            </div>
            <div class="modal-body" v-show="viewStatus == 1">
                <div>
                    <div>会社</div>
                    <select class="form-select" v-model = "companyId" style="margin-top:10px;">
                        <option value = "" >未選択</option>
                        <option :value = "companyId" v-for = "(companyName,companyId) in companies" :key="companyId">
                            {{companyName}}
                        </option>
                    </select>
                    <div>
                        <span class="text-danger">
                            {{errorMessage.companyId}}
                        </span>
                    </div>
                </div>
                <div style="margin-top:10px;">
                    <div class="mt-3">
                        <label class="form-label">MACアドレス</label>
                        <input class="form-control" v-model="macAddress">
                        <div>
                            <span class="text-danger">
                                {{errorMessage.macAddress}}
                            </span>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">メモ</label>
                        <input class="form-control" v-model="name">
                    </div>
                    <div style="text-align:right;margin-top:15px;">
                        <button type="button" class="btn btn-primary" @click="confirmHandy" style="margin-right:10px;">追加</button>
                    </div>
                </div>
            </div>
            <div class="modal-body" v-show="viewStatus == 2">
                <div class="mb-4">
                    <div class="mb-1">ハンディ</div>
                    <div>{{companyName}}</div>
                </div>
                <div class="mb-4">
                    <div class="mb-1">MACアドレス</div>
                    <div>{{macAddress}}</div>
                </div>
                <div class="mb-4">
                    <div class="mb-1">メモ</div>
                    <div>{{name}}</div>
                </div>
                <div style="margin-top:10px;">
                    <div style="text-align:right;margin-top:15px;">
                        <button type="button" class="btn btn-success" @click="backStatus"  style="margin-right:10px;">戻る</button>
                        <button type="button" class="btn btn-primary" @click="saveHandy" style="margin-right:10px;">確定</button>
                    </div>
                </div>
            </div>
        </modal>
        <Loading ref="child"></Loading>
    </div>
</template>

<script>

import Loading from "../components/LoadingComponent";
import Validator from 'validatorjs';

export default {
    name:'handyModal',
    components:{
        Loading
    },
    methods:{
        dataInit() {
            this.errorMessage.companyId = "";
            this.errorMessage.macAddress = "";
            this.viewStatus = 1;
            this.companyId = "";
            this.companyName = "";
            this.macAddress = "";
            this.name = "";
        },
        confirmHandy() {
            this.errorMessage.companyId = "";
            this.errorMessage.macAddress = "";

            let data = {
                'companyId':this.companyId,
                'macAddress':this.macAddress,
            };

            let rules = {
                'companyId': 'required',
                'macAddress': 'required',
            };

            let error_msg = {
                "required.companyId": "会社名が未入力です。",
                "required.macAddress": "MACアドレスが未入力です。"
            };

            let validation = new Validator(data, rules, error_msg);
            validation.check();
            if (validation.fails()) {
                let errorMessage = validation.errors.all();
                if (errorMessage['companyId'] !== undefined) {
                    this.errorMessage.companyId = errorMessage['companyId'][0];
                }
                if (errorMessage['macAddress'] !== undefined) {
                    this.errorMessage.macAddress = errorMessage['macAddress'][0];
                }
                return false;
            }
            this.viewStatus = 2;
            this.companyName = this.companies[this.companyId];
        },
        backStatus() {
            this.viewStatus = 1;
        },
        saveHandy() {
            this.$refs.child.loadingOn();
            let postData = {
                'company_id': this.companyId,
                'mac_address': this.macAddress,
                'name': this.name
            };

            let url = '/api/scan_terminal';

            axios.post(url, postData)
            .then((res) => {
                if (res['data']['http_status_code'] === 200) {
                    alert('ハンディの登録に成功しました。');
                    this.hide();
//                    location.href = "/handy";
                } else {
                    alert('ハンディの登録に失敗しました。');
                }
            })
            .catch((error) =>{
                console.log(error);
            })
            .finally(() => {
                this.$refs.child.loadingOff();
            });
        },
        hide() {
            this.$modal.hide('handy-add');
        }
    },
    mounted() {
        let url = '/api/company';
        // 単純なメソッドの呼び出しはこれ
        this.$refs.child.loadingOn();
        axios.get(url)
            .then((res) => {
                if (res['status'] === 200) {
                    let companyData = res['data']['data'];
                    this.companies = companyData; 
                } else {
                    alert("データの取得に失敗しました。");
                }
            })
            .finally(() => {
                this.$refs.child.loadingOff();
            })

    },
    data() {
        return {
            companies:{},
            companyId:"",
            companyName:"",
            macAddress:"",
            name:"",
            errorMessage:{
                'companyId':'',
                'macAddress':''
            },
            viewStatus:1
        }
    }
}
</script>
<style type="text/css">

</style>