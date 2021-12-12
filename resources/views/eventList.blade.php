<!DOCTYPE html>
<html>
<x-head :title="$title" />
<body class="container drawer drawer--left">
<div id="app" v-cloak>

<x-header/>

    <div class="search">
        <label>イベント名<input type="text" v-model="searchCondition.eventName"></label>
        <label>開始日付<input type="date" v-model="searchCondition.startDate"></label>
        <label>終了日付<input type="date" v-model="searchCondition.endDate"></label>
        <button class="btn btn-primary" type="button" @click="search">検索</button>        
    </div>

    <h1>
        イベント一覧
    </h1>

    <div v-for="event in eventList" v-bind:key="event.id">
        イベント名：@{{ event.title }}<br>
        日付：@{{ event.event_date }}<br>
        開始時間：@{{ event.start_time }}<br>
        終了時間：@{{ event.end_time }}<br>
        場所：@{{ event.place }}<br>
        上限：@{{ event.limit_number }}<br>
        詳細：@{{ event.detail }}<br>
        <br>
        <button class="change-authority btn btn-info" type="button">
            <a :href='"/eventDetail/" + event.id '>編集</a>
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
                title: '',
            },
            eventList: [],
        },
        methods: {
            search() {
                let params = new URLSearchParams();
                params.append('title', this.searchCondition.title);
                axios.post('/api/event/getList', params)
                .then(response => {
                    this.eventList = response.data
                    })
            }
        },
        mounted: function() {
            this.search()
        }
    })
</script>
</body>
</html>