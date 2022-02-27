<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">CSVリスト</div>

                    <div class="card-body">
                        <table>
                            <th>
                                <td>物理名</td>
                                <td>論理名</td>
                                <td>必須</td>
                            </th>
                            <tr v-for = "(eachCsv, index) in csvList">
                                <td>{{eachCsv.field_name}} </td>
                                <td>{{eachCsv.field_disp_name}} </td>
                                <td>{{eachCsv.is_required}} </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:'csvlist-component',
    methods:{
        getCsvList() {
            axios.get(`/api/csv/{this.csvCategory}`)
                .then((data) => {
                    console.log(data)
                })
                .finally(()=>{

                });
        }
    },
    created() {
        let url = '/api/csv/' + this.csvCategory;
        axios.get(url)
            .then((res) => {
                if (res['status'] === 200) {
                    this.csvList = res['data']['data'];
                } else {
                    alert("データの読み込みに失敗しました。");
                }
            })
            .finally(()=>{

            });
    },
    data() {
        return {
            // CSVリスト
            csvList:{},
            csvCategory:10
        }
    }
}
</script>
<style type="text/css">

</style>