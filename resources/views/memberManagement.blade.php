<!DOCTYPE html>
<html>
<x-head :title="$title" />
<body class="container drawer drawer--left">
<div id="app" v-cloak>

    <x-header></x-header>

    <div class="search">
        <label>名前<input type="text" v-model="searchCondition.name"></label>
        <select v-model="searchCondition.category">
            <option>職種</option>
        </select>
        <select v-model="searchCondition.gendor">
            <option>性別</option>
            <option>男性</option>
            <option>女性</option>
            <option>その他</option>
        </select>
        <button class="btn btn-primary" type="button" @click="search">検索</button>
    </div>

    <h1>ユーザー一覧</h1>
    <div v-for="member in memberList" v-bind:key="member.id">
        ユーザー名：@{{ member.name }} <br>
        職種：@{{ member.member_category.category_name }} <br>
        性別：@{{ member.gender_name }} <br>
        メールアドレス：@{{ member.email }} <br>
        LINEユーザー：@{{ member.is_line_user }} <br>
        権限：@{{ member.role_name }} <br>
        ステータス：@{{ member.status_name }} <br>
        <br>
        <button class="change-authority btn btn-info" type="button">
            <a :href='"/memberDetail/" + member.id '>詳細</a>
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
            searchCondition: {},
            memberList: [],
        },
        methods: {
            search() {
                let params = new URLSearchParams();
                params.append('name', this.searchCondition.name);
                axios.post('/api/member/getList', params)
                .then(response => this.memberList = response.data)
            },
        },
        created: function() {
            this.search()
        }
    })
</script>
</body>
</html>