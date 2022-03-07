<template>
    <div class="container">
        <modal name="csv-add" :draggable="true" :resizable="true" width = "60%" height = "80%">
            <div class="modal-header">
                <h2>項目追加</h2>
                <button @click="hide"><img src="/img/close.png"></button>
            </div>
            <div class="modal-body" v-show="viewStatus == 1">
                <div>
                    <div>CSVカテゴリー</div>
                    <select class="form-select" v-model = "csvCategory" style="margin-top:10px;">
                        <option value = "" >未選択</option>
                        <option :value = "categoryVal" v-for = "(categoryName,categoryVal) in masterConfig.csv_category">
                            {{categoryName}}
                        </option>
                    </select>
                    <div>
                        <span class="text-danger">
                            {{errorMessage.csvCategory}}
                        </span>
                    </div>
                </div>
                <div style="margin-top:10px;">
                    <textarea v-model="csvTextArea" placeholder="10,code,品番,0,DATE" style="display:block;width:100%;">
                    </textarea>

                    <span class="text-danger">
                        {{errorMessage.csvTextArea}}
                    </span>
                    <div style="text-align:right;margin-top:15px;">
                        <button type="button" class="btn btn-primary" @click="confirmCsvList" style="margin-right:10px;">追加</button>
                    </div>
                </div>
            </div>
            <div class="modal-body" v-show="viewStatus == 2">
                <div>
                    <div>CSVカテゴリー</div>
                    <div>{{viewMasterConfig}}</div>
                </div>
                <div style="margin-top:10px;">
                    <div style="text-align:right;margin-top:15px;">
                        <button type="button" class="btn btn-primary" @click="saveCsvList" style="margin-right:10px;">確定</button>
                    </div>
                </div>
            </div>
        </modal>
        <Loading ref="child"></Loading>
    </div>
</template>

<script>

import masterJson from "../config/master.json";
import Loading from "../components/LoadingComponent";

export default {
    name:'modal-component',
    components:{
        Loading
    },
    methods:{
        confirmCsvList() {
            if (this.csvTextArea =="") {
                this.errorMessage.csvTextArea = "CSV項目が未入力です。";
            }

            if (this.csvCategory == "") {
                this.errorMessage.csvCategory = "CSVカテゴリーが未入力です。";
            }

            this.viewStatus = 2;
            let csvCategory = parseInt(this.csvCategory);
            let masterStr = this.masterConfig['csv_category'][csvCategory];
            this.viewMasterConfig = masterStr;
        },
        saveCsvList() {
            this.$refs.child.loadingOn();
            let targetData = this.csvList[index];

            let url = '/api/csv_field/' + targetData['id'];
            let postData = {
                'updateData':updateData,
            };

            axios.put(url, postData)
            .then((res) => {
                // 参照になっているのでここで値を変えるとcsvListもかわる
                targetData['isEdit'] = 0;
                targetData['isView'] = 1;
                targetData= res['data']['data'];
            })
            .catch((error) =>{
                console.log(error);
            })
            .finally(() => {
                this.$refs.child.loadingOff();
            });
        },
        hide() {
            this.$modal.hide('csv-add');
        }
    },
    created() {
        this.masterConfig = masterJson;       
    },
    data() {
        return {
            // CSVリスト
            csvTextArea:"",
            masterConfig:{},
            csvCategory:"",
            errorMessage:{
                'csvCategory':'',
                'csvTextArea':''
            },
            viewMasterConfig:'',
            viewStatus:1
        }
    }
}
</script>
<style type="text/css">

</style>