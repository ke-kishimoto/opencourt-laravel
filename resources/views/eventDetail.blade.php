<!DOCTYPE html>
<html>
<x-head :title="$title" />
<body class="container drawer drawer--left">
<div id="app" v-cloak>

<x-header/>

    <p style="color:red; font-size:20px">@{{ msg }}</p>

    <h1></h1>

    <form method="post" >
    @csrf

        <p>タイトル<input class="form-control" type="text" v-model="event.title" name="title" required></p>
        <p>タイトル略称<input class="form-control" type="text" v-model="event.short_title" name="short_title" required></p>
        <p>日程<input class="form-control" type="date" v-model="event.event_date" name="event_date" required></p>
        <p>開始時間<input class="form-control" type="time" step="600" v-model="event.start_time" name="start_time" required></p>
        <p>終了時間<input class="form-control" type="time" step="600" v-model="event.end_time" name="end_time" required></p>
        <p>場所<input class="form-control" type="text" v-model="event.place" name="place" required></p>
        <p>人数上限<input class="form-control" type="number" v-model="event.limit_number" name="limit_number" min="1" required></p>
        <p>詳細<textarea class="form-control" v-model="event.detail" name="detail"></textarea></p>
        <p>
            参加費<br>
            <label>社会人　<input type="number" class="form-control form-price" v-model="event.price1" name="price1" required>円</label><br>
            <label>大学・専門　<input type="number" class="form-control form-price" v-model="event.price2" name="price2" required>円</label><br>
            <label>高校　<input type="number" class="form-control form-price" v-model="event.price3" name="price3" required>円</label>
        </p>
        <button class="btn btn-primary" type="submit" formaction="{{ route('event.update', $id) }}">更新</button>
        <button class="btn btn-danger" type="submit" formaction="{{ route('event.delete', $id) }}">削除</button>

    </form>

<x-footer/>
</div>

<script src="/js/common.js"></script>
<script src="/js/vue.min.js"></script>
<script>
    const app = new Vue({
        el:"#app",
        data: {
            msg: '',
            event: {},
            event_id: location.pathname.replace('/eventDetail/', ''),
        },
        methods: {
            getUser() {
                axios.get('/api/eventDetail/' + this.event_id)
                .then(response => this.event = response.data)
            },
        },
        created: function() {
            this.getUser();
        }
    })
</script>