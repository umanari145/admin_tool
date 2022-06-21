<template>
    <div>
        <Sidebar></Sidebar>
        <div class="wrapper main-wrapper d-flex flex-column min-vh-100 bg-light ">
            <Header></Header>
            <div class="body flex-grow-1 px-3">
                <div class="container-lg">
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for = "(handy,index) in handies">
                                                <td>
                                                    <input type="checkbox" v-model="handy.isDelete" value="1">
                                                </td>
                                                <td>
                                                    {{handy.id}}
                                                </td>
                                                <td>
                                                    <span>{{handy.company}}</span>
                                                </td>
                                                <td>
                                                    <span>{{handy.mac_address}}</span>
                                                </td>
                                                <td>
                                                    <span>{{handy.note}}</span>
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
                </div>
            </div>
            <Footer></Footer>
        </div>
    </div>
</template>

<script>

import Modal from "../components/ModalComponent";
import Loading from "../components/LoadingComponent";
import Header from "../components/Layout/Header";
import Sidebar from "../components/Layout/Sidebar";
import Footer from "../components/Layout/Footer";

export default {
    name:'handylist',
    components:{
        Loading,
        Modal,
        Header,
        Sidebar,
        Footer
    },
    methods:{
        bootModal() {
            this.$modal.show('csv-add');
        },
        getHandyList() {
            let url = '/api/handy/' + this.csvCategory;
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
                        alert("データの更新に失敗しました。");
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
        updateHandy(index) {
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
            this.handies.forEach((element) => {
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

    },
    data() {
        return {
            // CSVリスト
            handies:[
                {
                    'id':1,
                    'company':"カプコン",
                    'mac_address':"00-01-FC-0C-D6-05",
                    'note':"testtest",
                    'isDelete':0
                },
                {
                    'id':2,
                    'company':"ハドソン",
                    'mac_address':"00-01-FC-0C-D6-04",
                    'note':"testtest",
                    'isDelete':0                    
                }
            ],
            allDel:0,
            tmpVal:{}
        }
    }
}
</script>
<style type="text/css">

</style>