<!DOCTYPE html>
<html>
<x-head :title="$title" />
<body class="container drawer drawer--left">
<div id="app" v-cloak>
    
    <vue-header></vue-header>
     
    <p style="color:red; font-size:20px">@{{ msg }}</p>

    <form method="post" action="{{ route('user.create') }}">
    @csrf
        権限
        <select name="role_level" class="custom-select mr-sm-2">
            <option v-for="item in roleLevels" v-bind:value="item.value">@{{ item.text }}</option>
        </select>
        職種
        <select name="user_category_id" class="custom-select mr-sm-2">
            <option v-for="item in categories" v-bind:value="item.value">@{{ item.text }}</option>
        </select>
        </p>
        <p>
        性別
        <select name="gender" class="custom-select mr-sm-2">
            <option v-for="item in genders" v-bind:value="item.value">@{{ item.text }}</option>
        </select>
        </p>
        <p>名前<input class="form-control" type="text" name="name" required></p>

        <p>
            メール<input class="form-control" type="email" name="email">
        </p>
        <p>
            パスワード
            <input class="form-control" type="password" name="password" required maxlength="50">
        </p>
        <p>
            パスワード(再入力)
            <input class="form-control" type="password" name="rePassword" required maxlength="50">
        </p>
        <p>備考<textarea class="form-control" name="remark"></textarea></p>
    
        <button class="btn btn-primary" type="submit">登録</button>

    </form>
    
    <x-footer/>

</div>
<script src="js/common.js"></script>
<script src="js/vue.min.js"></script>
<script src="js/header.js"></script>
<script>
    'use strict'
    const vue = new Vue({
        el:"#app",
        data: {
            msg: '',
            roleLevels: [
                {text: '一般', value: '3'},
                {text: '管理者', value: '2'},
            ],
            categories: [
                {text: '社会人', value: '1'},
                {text: '大学生', value: '2'},
                {text: '高校生', value: '3'},
            ],
            genders: [
                {text: '男性', value: '1'},
                {text: '女性', value: '2'},
                {text: 'その他', value: '3'},
            ],
        },
    })
</script>
</body>
</html>