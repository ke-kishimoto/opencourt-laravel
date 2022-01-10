<!DOCTYPE html>
<html>
<x-head :title="$title" />
<body class="container drawer drawer--left">
<div id="app" v-cloak>

<x-header></x-header>
        ユーザー名：@{{ user.name }} <br>
        性別：@{{ user.gender_name }} <br>
        メールアドレス：@{{ user.email }} <br>
        LINEユーザー：@{{ user.is_line_user }} <br>
        権限：@{{ user.role_name }} <br>
        ステータス：@{{ user.status_name }} <br>
        <br>
        <button class="btn btn-info" type="button" @click="changeBlacklist">ブラックリスト登録</button>
        <button class="btn btn-info" type="button" @click="changeAuthority">権限の変更</button>
    <x-footer/>

</div>
<script src="/js/common.js"></script>
<script src="/js/vue.min.js"></script>
<script>
    const app = new Vue({
        el:"#app",
        data: {
            user: {},
            user_id: location.pathname.replace('/userDetail/', ''),
        },
        methods: {
            getUser() {
                axios.get('/api/userDetail/' + this.user_id)
                .then(response => this.user = response.data)
            },
            changeBlacklist() {
                axios.post('/api/userDetail/'+ this.user_id + '/blacklist')
                .then(response => this.user = response.data)
            },
            changeAuthority() {
                axios.post('/api/userDetail/'+ this.user_id + '/authority')
                .then(response => this.user = response.data)
            },
        },
        created: function() {
            this.getUser();
        }
    })
</script>
</body>
</html>