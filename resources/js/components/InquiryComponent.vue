<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">入力フォーム</div>

                    <div class="card-body">
                        <div class="col-md-12">
                            <div>
                                <div>
                                    お名前
                                </div>
                                <div>
                                    <input type="text" v-model="customer.name">
                                </div>
                            </div>

                            <div>
                                <div>
                                    ふりがな
                                </div>
                                <div>
                                    <input type="text" v-model="customer.furigana">
                                </div>
                            </div>

                            <div>
                                <div>
                                    電話番号(ハイフンなしで登録してください)
                                </div>
                                <div>
                                    <input type="text" v-model="customer.tel" placeholder="0123456789">
                                </div>
                            </div>

                            <div>
                                <div>
                                    メールアドレス
                                </div>
                                <div>
                                    <input type="text" 
                                    v-model="customer.email" 
                                    @blur="checkEmail(1)"
                                    :class="{un_match:isUnmatch}">
                                </div>
                            </div>

                            <div>
                                <div>
                                    メールアドレス(確認用)
                                </div>
                                <div>
                                    <input type="text" 
                                    v-model="customer.email_confirm"  
                                    @blur="checkEmail(2)" 
                                    :class="{un_match:isUnmatch}">
                                </div>
                            </div>

                            <div>
                                <div>
                                    郵便番号
                                </div>
                                <div>
                                    <input type="text" 
                                    v-model="customer.zip1"  
                                    @blur="getAddress()"
                                    class="col-2">
                                    -<input type="text" 
                                    v-model="customer.zip2"  
                                    @blur="getAddress()"
                                    class="col-2">
                                </div>
                            </div>

                            <div>
                                <div>
                                    住所1
                                </div>
                                <div>
                                    <input type="text" 
                                    v-model="customer.address1"  
                                    class="col-2">
                                </div>
                            </div>

                            <div>
                                <div>
                                    住所2
                                </div>
                                <div>
                                    <input type="text" 
                                    v-model="customer.address2"
                                    class="col-2">
                                </div>
                            </div>

                            <div>
                                <div>
                                    お問い合わせ内容
                                </div>
                                <div>
                                    <textarea v-model="customer.note"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        methods:{
            //mode 1:本体 2:確認用
            checkEmail(mode) {

                //確認用の未入力フラグを更新
                if (mode === 2)　{
                    this.confirmNotEntered = false;
                }

                //確認用が未入力じゃない場合全て発動
                //(本体に入力して、まだ未入力という場合のみ動かない)
                if (this.confirmNotEntered === false) {
                    if (this.customer.email !== this.customer.email_confirm) {
                        this.isUnmatch = true;
                    } else {
                        this.isUnmatch = false;
                    }
                }
            },
            getAddress() {

                axios.get(url, headers)
                    .then((data) => {
                        console.log(data)
                    })
                    .finally(()=>{

                    });
            }

        },
        data() {
            return {
                customer:{},
                //確認用未入力
                confirmNotEntered:true,
                //不一致
                isUnmatch:false
            }
        }
    }
</script>
<style type="text/css">
.un_match{
    background: #ff0000;
}


</style>