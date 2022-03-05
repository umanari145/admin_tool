<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">CSVリスト</div>

                    <label for="">CSVカテゴリー</label>
                    <select class="form-select" v-model = "csvCategory" @change = "getCsvList">
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
                                        <span @click = "updateField" v-show = "isView">
                                            {{eachCsv.field_name}}
                                        </span>
                                        <input v-model = "currentField" v-show = "isView == false">
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
                        this.csvList = res['data']['data'];
                    } else {
                        alert("データの読み込みに失敗しました。");
                    }
                })
                .finally(()=>{
                    this.$refs.child.loadingOff();
                });
        },
        updateField() {
            
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
            csvCategory:null,
            isView:true
        }
    }
}
</script>
<style type="text/css">

</style>