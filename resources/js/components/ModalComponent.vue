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
                    <textarea v-model="csvTextArea" placeholder="code,品番,0,DATE" style="display:block;width:100%;">
                    </textarea>

                    <span class="text-danger" v-html="errorMessage.csvTextArea">
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
                <div>
                    <table class="table table-hover">
                        <thead> 
                            <tr>
                                <th>物理名</th>
                                <th>論理名</th>
                                <th>必須</th>
                                <th>データ型</th>
                                <th>パラメータ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="confirmEachCsv in confirmCsvData">
                                <td>{{confirmEachCsv.field_name}}</td>
                                <td>{{confirmEachCsv.field_disp_name}}</td>
                                <td>{{masterConfig['is_required'][confirmEachCsv.is_required]}}</td>
                                <td>{{confirmEachCsv.output_type}}</td>
                                <td>{{confirmEachCsv.param}}</td>
                            </tr>
                        </tbody>
                    </table>    
                </div>
                <div style="margin-top:10px;">
                    <div style="text-align:right;margin-top:15px;">
                        <button type="button" class="btn btn-success" @click="backStatus"  style="margin-right:10px;">戻る</button>
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
import Validator from 'validatorjs';

export default {
    name:'modal-component',
    components:{
        Loading
    },
    methods:{
        confirmCsvList() {
            this.errorMessage.csvCategory = "";
            this.errorMessage.csvTextArea = "";
            this.confirmCsvData = [];

            if (this.csvCategory == "") {
                this.errorMessage.csvCategory = "CSVカテゴリーが未入力です。";
                return false;
            }

            if (this.csvTextArea =="") {
                this.errorMessage.csvTextArea = "CSV項目が未入力です。";
                return false;
            }

            let lineArr = this.csvTextArea.split("\n");

            for (let i = 0; i < lineArr.length; i++) {
                let lineNumber = i + 1;
                let eachData = lineArr[i].split(",");

                if (eachData.length !== 5) {
                    this.errorMessage.csvTextArea =  `${lineNumber}行目 項目数があっていません。`;
                    return false;
                }

                let data = {
                    'field_name':eachData[0],
                    'field_disp_name':eachData[1],
                    'is_required':parseInt(eachData[2]),
                    'output_type':eachData[3],
                    'param':eachData[4]
                };

                let rules = {
                    'field_name': 'required',
                    'field_disp_name': 'required',
                    'is_required': 'integer|boolean',
                };

                let error_msg = {
                    "required.field_name": `${lineNumber}行目 物理名が未入力です。`,
                    "required.field_disp_name": `${lineNumber}行目 論理名が未入力です。`,
                    "required.is_required": `${lineNumber}行目 物理名が未入力です。`,
                    "boolean.is_required": `${lineNumber}行目 必須は0か1か(またはtrue or false)で入力してください`
                };

                let validation = new Validator(data, rules, error_msg);
                validation.check();
                if (validation.fails()) {
                    let errorMessage = validation.errors.all();
                    let errorValues = Object.values(errorMessage);
                    this.errorMessage.csvTextArea = errorValues.join("<br>");
                    return false;
                }

                this.confirmCsvData.push(data);
            }
            this.viewStatus = 2;
            let csvCategory = parseInt(this.csvCategory);
            let masterStr = this.masterConfig['csv_category'][csvCategory];
            this.viewMasterConfig = masterStr;
        },
        backStatus() {
            this.viewStatus = 1;
        },
        saveCsvList() {
            this.$refs.child.loadingOn();

            let url = '/api/csv_category/' + this.csvCategory;

            axios.post(url, this.confirmCsvData)
            .then((res) => {

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
            viewStatus:1,
            confirmCsvData:[]
        }
    }
}
</script>
<style type="text/css">

</style>