<!DOCTYPE html>
<html>
<x-head :title="$title" />
<body class="container drawer drawer--left">
<div id="app" v-cloak>
    
    <vue-header></vue-header>
     
    <p style="color:red; font-size:20px">@{{ msg }}</p>

    <form method="post" action="{{ route('event.create') }}">
    @csrf

        <p>
            <select @change="selectItem($event)" name="select_id" v-model="selected">
                <option v-for="item in templateList" v-bind:key="item.id" v-bind:value="item.value">@{{ item.name }}</option>
            </select>
        </p>
        <p>タイトル<input class="form-control" type="text" v-model="event.title" name="title" required></p>
        <p>タイトル略称<input class="form-control" type="text" v-model="event.short_title" name="shortTitle" required></p>
        <p>日程<input class="form-control" type="date" name="gameDate" required></p>
        <p>開始時間<input class="form-control" type="time" step="600" name="startTime" required></p>
        <p>終了時間<input class="form-control" type="time" step="600" name="endTime" required></p>
        <p>場所<input class="form-control" type="text" v-model="event.place" name="place" required></p>
        <p>人数上限<input class="form-control" type="number" name="limitNumber" min="1" required></p>
        <p>詳細<textarea class="form-control" name="detail"></textarea></p>
        <p>
            参加費<br>
            <label>社会人　<input type="number" class="form-control form-price" v-model="event.price1" name="price1" required>円</label><br>
            <label>大学・専門　<input type="number" class="form-control form-price" v-model="event.price2" name="price2" required>円</label><br>
            <label>高校　<input type="number" class="form-control form-price" v-model="event.price3" name="price3" required>円</label>
        </p>
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
            selected: '',
            templateList: {},
            event: {},
        },
        methods: {
            getTemplateList() {
                axios.get('/api/eventTemplate/getList')
                .then(response => {
                    this.templateList = response.data
                });
            },
            selectItem(){
                axios.get('api/eventTemplate/get/' + this.selected)
                .then(response => {
                    this.event = response.data
                })
            },
        },
        created: function() {
            this.getTemplateList();
        }
    })
</script>
</body>
</html>