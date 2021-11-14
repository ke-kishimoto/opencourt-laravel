<!DOCTYPE html>
<html>
<x-head :title="$title" />
<body class="container drawer drawer--left">
<div id="app" v-cloak>

<x-header></x-header>
        ユーザー名：@{{ member.name }} <br>
        性別：@{{ member.gender_name }} <br>
        メールアドレス：@{{ member.email }} <br>
        LINEユーザー：@{{ member.is_line_user }} <br>
        権限：@{{ member.role_name }} <br>
        ステータス：@{{ member.status_name }} <br>
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
            member: {},
            member_id: location.pathname.replace('/memberDetail/', ''),
        },
        methods: {
            getMember() {
                axios.get('/api/memberDetail/' + this.member_id)
                .then(response => this.member = response.data)
            },
            changeBlacklist() {
                axios.post('/api/memberDetail/'+ this.member_id + '/blacklist')
                .then(response => this.member = response.data)
            },
            changeAuthority() {
                axios.post('/api/memberDetail/'+ this.member_id + '/authority')
                .then(response => this.member = response.data)
            },
        },
        created: function() {
            this.getMember();
        }
    })
</script>
</body>
</html>