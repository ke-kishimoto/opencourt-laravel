<!DOCTYPE html>
<html>
<x-head :title="$title" />
<body class="container drawer drawer--left">
<div id="app" v-cloak>

<x-header></x-header>
        ユーザー名：{{ $member->name }} <br>
        職種：{{ $member->member_category->category_name }} <br>
        性別：{{ $member->genderName }} <br>
        メールアドレス：{{ $member->email }} <br>
        権限：{{ $member->roleName }} <br>
        ステータス：{{ $member->statusName }} <br>
        <br>
        <button class="change-authority btn btn-info" type="button">ブラックリスト登録</button>
        <button class="change-authority btn btn-info" type="button">権限の変更</button>
    <x-footer/>

</div>
<script src="/js/common.js"></script>
<script src="/js/vue.min.js"></script>
<script>
    const app = new Vue({
        el:"#app",
    })
</script>
</body>
</html>