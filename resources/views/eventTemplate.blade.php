<!DOCTYPE html>
<html>
<x-head :title="$title" />
<body class="container drawer drawer--left">
<div id="app" v-cloak>

    <x-header></x-header>

    <p style="color:red; font-size:20px">@{{ msg }}</p>

    <h1>テンプレート設定</h1>
    <form method="post" action="{{ route('eventTemplate.create') }}">
        @csrf
        <p>
            <select @change="selectItem($event)" name="select_id" v-model="selected">
                <option v-for="item in list" v-bind:key="item.id" v-bind:value="item.value">@{{ item.name }}</option>
            </select>
            <input type="checkbox" name="isnew" id="isnew" v-model="isnew">
            <label for="isnew">コピーして新規作成</label> 
        </p>
        <p>
            テンプレート名<input class="form-control" type="text" name="template_name" v-model="localData.template_name" required >
        </p>
        <p>
            タイトル<input class="form-control" type="text" name="title" v-model="localData.title" required >
        </p>
        <p>
            タイトル略称<input class="form-control" type="text" name="short_title" v-model="localData.short_title" required >
        </p>
        <p>
            場所<input class="form-control" type="text" name="place" v-model="localData.place" required >
        </p>
        <p>
            人数上限<input class="form-control" type="number" name="limit_number" v-model="localData.limit_number" min="1" required>
        </p>
        <p>
            詳細<textarea class="form-control" name="detail" v-model="localData.detail"></textarea>
        </p>
        <p>
            参加費<br>
            <label>社会人　<input type="text" type="number" class="form-control form-price" name="price1" v-model="localData.price1" required value="0">円</label><br>
            <label>大学・専門　<input type="text" type="number" class="form-control form-price" name="price2" v-model="localData.price2"  required value="0">円</label><br>
            <label>高校　<input type="text" type="number" class="form-control form-price" name="price3" v-model="localData.price3" required value="0">円</label>
        </p>
        <p>
            <button class="btn btn-primary" type="submit" >登録</button>
            <button class="btn btn-secondary" type="button" @click="deleteItem">削除</button>
        </p>
    </form>

    <x-footer/>

</div>
<script src="/js/common.js"></script>
<script src="/js/vue.min.js"></script>
<script>
    const app = new Vue({
        el:"#app",
        data: {
            list: [],
            localData: {},
            selected: '',
            msg: '',
            isnew: false,
            csrfToken: '',
        },
        methods: {
            getCsrfToken() {
                fetch('/api/data/getCsrfToken',{
                    method: 'post',
                }).then(res => res.json().then(data => this.csrfToken = data.csrfToken))
                .catch(errors => console.log(errors))
            },
            clear() {
                this.isnew = false;
                this.selected = '';
                this.localData = {}
            },
            getList() {
                axios.get('/api/eventTemplate/getList')
                .then(response => {
                    console.log(response)
                    this.list = response.data
                });
            },
            selectItem(){
                axios.get('api/eventTemplate/get/' + this.selected)
                .then(response => this.localData = response.data)
            },
            register() {
                if(this.template_name === '') {
                    this.msg = 'テンプレート名を入力してください。'
                    scrollTo(0, 0)
                    return
                }
                if(this.title === '') {
                    this.msg = 'タイトルを入力してください。'
                    scrollTo(0, 0)
                    return
                }
                if(this.short_title === '') {
                    this.msg = '略称を入力してください。'
                    scrollTo(0, 0)
                    return
                }

                if (!confirm('登録してよろしいですか。')) return;
                let type = 'insert';
                if(this.isnew === false) {
                    type = 'update'
                }
                let params = new URLSearchParams();
                params.append('tableName', 'EventTemplate');
                params.append('type', type);
                params.append('csrfToken', this.csrfToken);
                params.append('template_name', this.template_name);
                params.append('title', this.title);
                params.append('short_title', this.short_title);
                params.append('place', this.place);
                params.append('limit_number', this.limit_number);
                params.append('detail', this.detail);
                params.append('price1', this.price1 ?? 0);
                params.append('price2', this.price2 ?? 0);
                params.append('price3', this.price3 ?? 0);
                fetch('/api/data/updateRecord', {
                    method: 'post',
                    body: params
                })
                .then(res => {
                    if(res.status !== 200) {
                        console.log(res);
                    } else {
                        this.getTemplateList()
                        this.clear()
                        this.msg = '登録完了しました。'
                        scrollTo(0, 0)
                    }
                })
            },
            deleteItem() {
                if (!confirm('削除してよろしいですか。')) return;
                axios.post('api/eventTemplate/delete/' + this.selected)
                .then(response => {
                    this.getList()
                    this.clear()
                    this.msg = '削除完了しました。'
                    scrollTo(0, 0)
                });
                // let params = new URLSearchParams();
                // params.append('tableName', 'EventTemplate');
                // params.append('id', this.templateId);
                // params.append('csrfToken', this.csrfToken);
                // fetch('/api/data/deleteById', {
                //     method: 'post',
                //     body: params
                // })
                // .then(res => {
                //     if(res.status !== 200) {
                //         console.log(res);
                //     } else {
                //         this.getList()
                //         this.clear()
                //         this.msg = '削除完了しました。'
                //         scrollTo(0, 0)
                //     }
                // })
            }
        },
        created: function(){
            this.getList()
            // this.getCsrfToken()
        }
    })
</script>
</body>
</html>