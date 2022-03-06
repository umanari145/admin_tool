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
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for = "(eachCsv, index) in csvList">
                                    <td>
                                        <span @click = "inputField(index)" v-show = "eachCsv.isView">
                                            {{eachCsv.field_name}}
                                        </span>
                                        <input @blur = "updateField(index, eachCsv.id, 'field_name', eachCsv.field_name)" v-model = "eachCsv.field_name" v-show = "eachCsv.isEdit">
                                    </td>
                                    <td>{{eachCsv.field_disp_name}} </td>
                                    <td style="text-align:right;">{{eachCsv.is_required}} </td>
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
            targetData['isEdit'] = 1;
            targetData['isView'] = 0;
        },
        updateField(index,id, key, data) {
            this.$refs.child.loadingOn();
            let url = '/api/csvField/' + this.csvCategory;
            let updateData = {
                'id':id,
                'key':key,
                'updateData':data,
            };
            let targetData = this.csvList[index];

            axios.put(url, updateData)
                .then((res) => {
                    targetData['isEdit'] = 0;
                    targetData['isView'] = 1;
                })
                .catch((error) =>{
                    console.log("error----");
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