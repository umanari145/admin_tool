<template>
    <BasicHome>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ハンディリスト</div>

                    <!--<select class="form-select m-3 w-auto" v-model = "csvCategory" @change = "getCsvList">
                        <option value="" >未選択</option>
                        <option :value = "categoryVal" v-for = "(categoryName,categoryVal) in masterConfig.csv_category">
                            {{categoryName}}
                        </option>
                    </select>-->

                    <div class="d-flex justify-content-end" style="margin-top:10px;">
                        <button type="button" class="btn btn-danger" @click="deleteHandy" style="margin-right:10px;">削除</button>
                        <button type="button" class="btn btn-success mr-3" @click="bootModal">ハンディ追加</button>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" value="1" v-model="allDel" @change="allCheck">
                                    </th>
                                    <th>ID</th>
                                    <th>会社名</th>
                                    <th>MACアドレス</th>
                                    <th>メモ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for = "(handy,index) in handyList">
                                    <td>
                                        <input type="checkbox" v-model="handy.isDelete" value="1">
                                    </td>
                                    <td>
                                        {{handy.id}}
                                    </td>
                                    <td>
                                        <span>{{handy.company.company_name}}</span>
                                        
                                    </td>
                                    <td>
                                        <span v-show = "handy.isView" @click="inputField(index)">{{handy.mac_address}}</span>
                                        <input v-if="handy.isEdit" v-model="tmpVal.mac_address">
                                    </td>
                                    <td>           
                                        <span v-show="handy.isView" @click="inputField(index)">{{handy.name}}</span>
                                        <input v-if="handy.isEdit" v-model="tmpVal.name">
                                    </td>
                                    <td>
                                        <span @click = "updateField(index)" v-show = "handy.isEdit" style="margin-right:10px;">
                                            <img src="/img/save.png">
                                        </span>
                                        <span @click = "closeField(index)" v-show = "handy.isEdit">
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
import Loading from "../components/LoadingComponent";

export default {
    name:'handylist',
    components:{
        BasicHome,
        Loading,
        Modal
    },
    methods:{
        bootModal() {
            this.$modal.show('csv-add');
        },
        getHandyList() {
            let url = '/api/scan_terminal' + this.companyId;
            let query = "";
            if (this.companyId !== "") {
                query = "/?company_id=" + this.companyId;
            }
            url += query;
            // 単純なメソッドの呼び出しはこれ
            this.$refs.child.loadingOn();
            axios.get(url)
                .then((res) => {
                    if (res['status'] === 200) {
                        let handyData = res['data']['data'];
                        this.handyList = handyData.map((v) => {
                            v.isDelete = 0;
                            v.isEdit = 0;
                            v.isView = 1;
                            return v;
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
            let targetData = this.handyList[index];
            // 参照になっているのでここで値を変えるとcsvListもかわる
            targetData['isEdit'] = 1;
            targetData['isView'] = 0;

            // 最初に表示された後でvueの監視下におきたい場合はsetメソッド this.tmpVal.field_name = targetData['field_name']とやっても画面が変わらない
            this.$set(this.tmpVal, 'company_id', targetData['company_id']);
            this.$set(this.tmpVal, 'mac_address', targetData['mac_address']);
            this.$set(this.tmpVal, 'name', targetData['name']);
        },
        updateField(index) {
            this.$refs.child.loadingOn();
            let targetData = this.handyList[index];

            let url = '/api/scan_terminal/' + targetData['id'];
            let updateData = {
                'company_id':this.tmpVal['company_id'],
                'mac_address':this.tmpVal['mac_address'], 
                'name':this.tmpVal['name'], 
            };

            let postData = {
                'updateData':updateData,
            };

            axios.put(url, postData)
                .then((res) => {
                    if (res['status'] === 200) {
                        // 参照になっているのでここで値を変えるとcsvListもかわる
                        let data = res['data']['data']
                        this.handyList[index]['mac_address'] = data['mac_address'];
                        this.handyList[index]['name'] = data['name'];
                        this.handyList[index]['isEdit'] = 0;
                        this.handyList[index]['isView'] = 1;
                    } else {
                        alert("更新に失敗しました。")
                        console.log(res);
                    }
                })
                .catch((error) =>{
                    alert("更新に失敗しました。");
                    console.log(error);
                })
                .finally(() => {
                    this.$refs.child.loadingOff();
                });
        },
        closeField(index) {
            // 参照渡し
            let targetData = this.handyList[index];
            targetData['isEdit'] = 0;
            targetData['isView'] = 1;
        },
        allCheck() {
            this.handyList.forEach((element) => {
                element.isDelete = this.allDel;
            });
        },
        deleteHandy() {
            let url = '/api/scan_terminal';

            let deleteIds = this.handyList.filter((v)=> v.isDelete)
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
                    let targetData = this.handyList.filter((v)=> !v.isDelete);
                    this.handyList = targetData;
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
    },
    mounted() {
        // createdだとDOMできてないからダメ
        this.getHandyList();
    },
    data() {
        return {
            // CSVリスト
            handyList:[],
            companyId:"",
            allDel:0,
            tmpVal:{}
        }
    }
}
</script>
<style type="text/css">

</style>