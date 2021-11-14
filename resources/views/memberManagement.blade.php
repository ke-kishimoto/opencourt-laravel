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
        <button class="btn btn-primary" type="button">検索</button>
    </div>

    <h1>ユーザー一覧</h1>
    <div v-for="member in memberList" v-bind:key="member.id">
        ユーザー名：@{{ member.name }} <br>
        職種：@{{ member.member_category.category_name }} <br>
        性別：@{{ member.gender_name }} <br>
        メールアドレス：@{{ member.email }} <br>
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
            getMemberList() {
                let params = new URLSearchParams();
                params.append('searchCondition', this.searchCondition);
                axios.post('/api/member/getList', params)
                .then(response => this.memberList = response.data)
                // fetch('/api/data/selectAll', {
                //     method: 'post',
                //     body: params
                // })
                // .then(res => res.json()
                //     .then(data => {
                //         this.userList = data;
                //     })
                // )
                // .catch(errors => console.log(errors))
            },
            changeAuthority(user) {
                let params = new URLSearchParams();
                params.append('tableName', 'Users');
                params.append('id', user.id);
                fetch('/api/data/updateFlg', {
                    method: 'post',
                    body: params
                })
                .then(() => {
                    params = new URLSearchParams();
                    params.append('tableName', 'Users');
                    params.append('id', user.id);
                    fetch('/api/data/selectById', {
                        method: 'post',
                        body: params
                    }).then(res => res.json().then(data => user.authority_name = data.authority_name))
                })
                .catch(errors => console.log(errors))
            }
        },
        created: function() {
            this.getMemberList()
        }
    })
</script>
</body>
</html>