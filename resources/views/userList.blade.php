<!DOCTYPE html>
<html>
<x-head :title="$title" />
<body class="container drawer drawer--left">
<div id="app" v-cloak>

    <x-header></x-header>

    <div class="regist">
        <button class="btn btn-primary" type="button">
            <a href="/userRegist">登録</a>
        </button>
    </div>

    <div class="search">
        <label>名前<input type="text" v-model="searchCondition.name"></label>
        <select v-model="searchCondition.category">
            <option>職種</option>
            <option>社会人</option>
            <option>大学生</option>
            <option>高校生</option>
        </select>
        <select v-model="searchCondition.gendor">
            <option value="">性別</option>
            <option value="1">男性</option>
            <option value="2">女性</option>
            <option value="3">その他</option>
        </select>
        <button class="btn btn-primary" type="button" @click="search">検索</button>
    </div>

    <h1>ユーザー一覧</h1>
    <div v-for="user in userList" v-bind:key="user.id">
        ユーザー名：@{{ user.name }} <br>
        職種：@{{ user.user_category.category_name }} <br>
        性別：@{{ user.gender_name }} <br>
        メールアドレス：@{{ user.email }} <br>
        LINEユーザー：@{{ user.is_line_user }} <br>
        権限：@{{ user.role_name }} <br>
        ステータス：@{{ user.status_name }} <br>
        <br>
        <button class="change-authority btn btn-info" type="button">
            <a :href='"/userDetail/" + user.id '>詳細</a>
        </button>
        <hr>
    </div>

    <x-footer/>

</div>
<script src="/js/common.js"></script>
<script src="/js/vue.min.js"></script>
<script>
    const app = new Vue({
        el:"#app",
        data: {
            searchCondition: {
                name: '',
            },
            userList: [],
        },
        methods: {
            search() {
                let params = new URLSearchParams();
                params.append('name', this.searchCondition.name);
                axios.post('/api/user/getList', params)
                .then(response => this.userList = response.data)
            },
        },
        mounted: function() {
            this.search()
        }
    })
</script>
</body>
</html>