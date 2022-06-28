<template>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4">
            <div class="card-group d-block d-md-flex row">
              <div class="card p-4 mb-0">
                <div class="card-body">
                  <h1>Login</h1>
                  <div class="input-group mb-3"><span class="input-group-text">
                      <img class="icon" src="icons/svg/free/cil-3d.svg">
                    </span>
                    <input class="form-control" type="text" v-model="user.user_code" placeholder="ユーザーコード">
                  </div>
                  <div class="input-group mb-4"><span class="input-group-text">
                      <img class="icon" src="icons/svg/free/cil-lock-locked.svg" >
                    </span>
                    <input class="form-control" type="password" v-model="user.password" placeholder="パスワード">
                  </div>
                  <div class="text-danger mb-4" v-show="errorMessage !='' ">
                    {{errorMessage}}
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <button class="btn btn-primary px-4" type="button" @click="doLogin">Login</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <Loading ref="child"></Loading>
      </div>
    </div>
</template>

<script>

import Loading from "../components/LoadingComponent";
export default {
    name:'login',
    components:{
        Loading
    },
    methods:{
        doLogin() {
            this.$refs.child.loadingOn();
            this.errorMessage = '';
            let url = '/api/login';
            const headers = {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            };

            let postData = {
                'email': this.user.user_code,
                'password': this.user.password
            };

            axios.post(url, postData, {headers:headers})
                .then((res) => {
                    if (res['status'] === 200) {  
                        this.$store.commit("user/setToken", res['data']['access_token']);
                        this.$router.push('/')
                    }
                })
                .catch((error) =>{
                    console.log('not success');
                    console.log(error);
                    this.errorMessage = 'ユーザーかパスワードが間違っています。';

                })
                .finally(() => {
                    this.$refs.child.loadingOff();
                });
        }
    },
    created() {

    },
    data() {
        return {
            user:{
                'user_code':'',
                'password':''
            },
            errorMessage:''
        }
    }
}
</script>
<style type="text/css">

</style>