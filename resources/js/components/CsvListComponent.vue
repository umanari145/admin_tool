<template>
    <BasicHome>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">CSVリスト</div>
                    <label for="" class="m-3">CSVカテゴリー</label>
                    <select class="form-select m-3 w-auto" v-model = "csvCategory" @change = "getCsvList">
                        <option value = "" >未選択</option>
                        <option :value = "categoryVal" v-for = "(categoryName,categoryVal) in masterConfig.csv_category" :key="categoryVal">
                            {{categoryName}}
                        </option>
                    </select>

                    <div>
                        <div class="d-flex justify-content-end" style="margin-top:10px;">
                            <button v-show = "csvCategory" type="button" class="btn btn-danger" @click="deleteCsvList" style="margin-right:10px;">削除</button>
                            <button type="button" class="btn btn-success mr-3" @click="bootModal">一括追加</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" value="1" v-model="allDel" @change="allCheck">
                                    </th>
                                    <th>物理名</th>
                                    <th>論理名</th>
                                    <th>必須</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for = "(eachCsv, index) in csvList" :key="index">
                                    <td>
                                        <input type="checkbox" v-model="eachCsv.isDelete" value="1">
                                    </td>
                                    <td>
                                        <span @click = "inputField(index)" v-show = "eachCsv.isView">
                                            {{eachCsv.field_name}}
                                        </span>
                                        <input v-model = "tmpVal.field_name" v-if = "eachCsv.isEdit">
                                    </td>
                                    <td>
                                        <span @click = "inputField(index)" v-show = "eachCsv.isView">
                                            {{eachCsv.field_disp_name}}
                                        </span>
                                        <input v-model = "tmpVal.field_disp_name" v-if = "eachCsv.isEdit">
                                    </td>
                                    <td>
                                        <span v-show = "eachCsv.isView" @click = "inputField(index)">
                                            {{masterConfig['is_required'][eachCsv.is_required]}} 
                                        </span>
                                        <div v-if = "eachCsv.isEdit">
                                            <input type="radio" v-model = "tmpVal.is_required" value="0" :id="`req_${index}_0`"><label :for="`req_${index}_0`">必須でない</label>
                                            <input type="radio" v-model = "tmpVal.is_required" value="1" :id="`req_${index}_1`"><label :for="`req_${index}_1`">必須</label>
                                        </div>
                                    </td>
                                    <td>
                                        <span @click = "updateField(index)" v-show = "eachCsv.isEdit" style="margin-right:10px;">
                                            <img src="/img/save.png">
                                        </span>
                                        <span @click = "closeField(index)" v-show = "eachCsv.isEdit">
                                            <img src="/img/close.png">
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <Modal></Modal>
        <Loading ref="child"></Loading>
    </BasicHome>            
</template>

<script>

import BasicHome from "../components/Layout/BasicHome";
import Modal from "../components/ModalComponent";
import masterJson from "../config/master.json";
import Loading from "../components/LoadingComponent";

export default {
    name:'csvlist',
    components:{
        BasicHome,
        Loading,
        Modal
    },
    methods:{
        bootModal() {
            this.$modal.show('csv-add');
        },
        getCsvList() {
            let url = '/api/csv_category/' + this.csvCategory;
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
                        });
                    } else {
                        alert("データの取得に失敗しました。");
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
            // 最初に表示された後でvueの監視下におきたい場合はsetメソッド this.tmpVal.field_name = targetData['field_name']とやっても画面が変わらない
            this.$set(this.tmpVal, 'field_name', targetData['field_name']);
            this.$set(this.tmpVal, 'field_disp_name', targetData['field_disp_name']);
            this.$set(this.tmpVal, 'is_required', targetData['is_required']);
        },
        updateField(index) {
            this.$refs.child.loadingOn();
            let targetData = this.csvList[index];

            let url = '/api/csv_field/' + targetData['id'];
            let updateData = {
                'field_name':this.tmpVal['field_name'], 
                'field_disp_name':this.tmpVal['field_disp_name'], 
                'is_required':this.tmpVal['is_required']
            };

            let postData = {
                'updateData':updateData,
            };

            axios.put(url, postData)
                .then((res) => {
                    // 参照になっているのでここで値を変えるとcsvListもかわる
                    let data = res['data']['data']
                    this.csvList[index]['field_name'] = data['field_name'];
                    this.csvList[index]['field_disp_name'] = data['field_disp_name'];
                    this.csvList[index]['is_required'] = data['is_required'];
                    this.csvList[index]['isEdit'] = 0;
                    this.csvList[index]['isView'] = 1;
                })
                .catch((error) =>{
                    console.log(error);
                })
                .finally(() => {
                    this.$refs.child.loadingOff();
                });
        },
        closeField(index) {
            let targetData = this.csvList[index];
            targetData['isEdit'] = 0;
            targetData['isView'] = 1;
        },
        allCheck() {
            this.csvList.forEach((element) => {
                element.isDelete = this.allDel;
            });
        },
        deleteCsvList() {
            let url = '/api/csv_field';

            let deleteIds = this.csvList.filter((v)=> v.isDelete)
                .map((v)=> v.id);

            if (deleteIds.length == 0) {
                alert('選択されているフィールドが存在しません。')
                return null;
            }

            if (!window.confirm("削除してよろしいでしょうか?")) {
                return null;
            }
            
            let deleteIdData = {
                'delete_ids':deleteIds
            };
            this.$refs.child.loadingOn();

            axios.delete(url, {
                'data': deleteIdData
            })
            .then((res) => {
                if (res['status'] === 200) {
                    alert("無事削除を行いました。");
                    let targetData = this.csvList.filter((v)=> !v.isDelete);
                    this.csvList = targetData;
                } else {
                    alert("データの削除に失敗しました。");
                }
            })
            .finally(()=>{
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
            csvCategory:"",
            allDel:0,
            tmpVal:{}
        }
    }
}
</script>
<style type="text/css">

</style>