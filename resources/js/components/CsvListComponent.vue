<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">CSVリスト</div>

                    <label for="">CSVカテゴリー</label>
                    <select class="form-select" v-model = "csvCategory" @change = "getCsvList">
                        <option value = "" >未選択</option>
                        <option :value = "categoryVal" v-for = "(categoryName,categoryVal) in masterConfig.csv_category">
                            {{categoryName}}
                        </option>
                    </select>

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>物理名</th>
                                    <th>論理名</th>
                                    <th>必須</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for = "(eachCsv, index) in csvList">
                                    <td>
                                        <span @click = "inputField(index)" v-show = "eachCsv.isView">
                                            {{eachCsv.field_name}}
                                        </span>
                                        <input v-model = "eachCsv.field_name" v-show = "eachCsv.isEdit">
                                    </td>
                                    <td>
                                        <span @click = "inputField(index)" v-show = "eachCsv.isView">
                                            {{eachCsv.field_disp_name}}
                                        </span>
                                        <input v-model = "eachCsv.field_disp_name" v-show = "eachCsv.isEdit">
                                    </td>
                                    <td>
                                        <span v-show = "eachCsv.isView" @click = "inputField(index)">
                                            {{masterConfig['is_required'][eachCsv.is_required]}} 
                                        </span>
                                        <div v-show = "eachCsv.isEdit">
                                            <input type="radio" v-model = "eachCsv.is_required" value="0" id="req_0"><label for="req_0">必須でない</label>
                                            <input type="radio" v-model = "eachCsv.is_required" value="1" id="req_1"><label for="req_1">必須</label>
                                        </div>
                                    </td>
                                    <td>
                                        <span @click = "updateField(index)" v-show = "eachCsv.isEdit">
                                            保存ボタン
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <Loading ref="child"></Loading>
    </div>
</template>

<script>

import masterJson from "../config/master.json";
import Loading from "../components/LoadingComponent";

export default {
    name:'csvlist-component',
    components:{
        Loading
    },
    methods:{
        getCsvList() {
            let url = '/api/csv/' + this.csvCategory;
            // 単純なメソッドの呼び出しはこれ
            this.$refs.child.loadingOn();
            axios.get(url)
                .then((res) => {
                    if (res['status'] === 200) {
                        let csvData = res['data']['data'];
                        this.csvList = csvData.map((v) => {
                            v.isView = 1;
                            v.isEdit = 0;
                            return v
                        })
                    } else {
                        alert("データの読み込みに失敗しました。");
                    }
                })
                .finally(()=>{
                    this.$refs.child.loadingOff();
                });
        },
        inputField(index) {
            let targetData = this.csvList[index];
            // 参照になっているのでここで値を変えるとcsvListもかわる
            targetData['isEdit'] = 1;
            targetData['isView'] = 0;
        },
        updateField(index) {
            this.$refs.child.loadingOn();
            let targetData = this.csvList[index];

            let url = '/api/csv_field/' + targetData['id'];
            let updateData = {
                'field_name':targetData['field_name'], 
                'field_disp_name':targetData['field_disp_name'], 
                'is_required':targetData['is_required']
            };

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
        }
    },
    created() {
        this.masterConfig = masterJson;       
    },
    data() {
        return {
            // CSVリスト
            csvList:{},
            masterConfig:{},
            currentField:"",
            csvCategory:"",
            isView:true
        }
    }
}
</script>
<style type="text/css">

</style>