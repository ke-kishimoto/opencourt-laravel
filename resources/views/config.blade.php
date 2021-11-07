<!DOCTYPE html>
<html>
<x-head :title="$title" />
<body class="container drawer drawer--left">
<div id="app" v-cloak>

<x-header></x-header>

    <p style="color:red; font-size:20px">@{{ msg }}</p>
    
    <h1>システム設定</h1>

    <form method="post" action="{{ route('config.update', $config) }}">
        @method('PATCH')
        @csrf
        <hr>
        <p>システム名設定</p>
        <p>
            システム名<input class="form-control" type="text" required name="system_title" v-model="systemTitle">
        </p>
        <hr>
        <p>背景色</p>
        <p>
            <select id="bg_color" name="bg_color" v-model="bgColor" class="custom-select mr-sm-2">
            <option v-for="item in colors" value="{{ $config->bg_color}}">
                @{{ item.text }}
            </option>
            </select>
        </p>
        <hr>
        <p>キャンセル待ちの更新</p>
        <p>
            <select id="waiting_flg_auto_update" name="waiting_flg_auto_update" v-model="waitingFlgAutoUpdate" class="custom-select mr-sm-2">
            <option v-for="item in waithingOptions" value="{{ $config->waiting_flg_auto_update }}">
                @{{ item.text }}
            </option>
            </select>
        </p>
        <hr>
        <p>
            <button class="btn btn-primary" type="submit">登録</button>
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
            msg: '',
            systemTitle: "{{ $config->system_title }}",
            bgColor: 'white',
            waitingFlgAutoUpdate: '1',
            colors: [
                {text: '白', value: "white"},
                {text: 'オレンジ', value: "orange"},
                {text: 'ピンク', value: "pink"},
            ],
            waithingOptions: [
                {text: '自動', value: '1'},
                {text: '手動', value: '2'},
            ],
            csrfToken: '',
        },
        methods: {
            // getCsrfToken() {
            //     fetch('/api/data/getCsrfToken',{
            //         method: 'post',
            //     }).then(res => res.json().then(data => this.csrfToken = data.csrfToken))
            //     .catch(errors => console.log(errors))
            // },
            // getConfig() {
            //     let params = new URLSearchParams();
            //     params.append('tableName', 'Config');
            //     params.append('id', 1);
            //     fetch('/api/data/selectById', {
            //         method: 'post',
            //         body: params
            //     })
            //     .then(res => res.json()
            //         .then(data => {
            //             this.systemTitle = data.system_title;
            //             this.bgColor = data.bg_color;
            //             this.waitingFlgAutoUpdate = data.waiting_flg_auto_update;
            //         })
            //     )
            //     .catch(errors => console.log(errors))
            // },
            register() {
                if (!confirm('登録してよろしいですか。')) return;
                let params = new URLSearchParams();
                params.append('tableName', 'Config');
                params.append('type', 'update');
                params.append('id', 1);
                // params.append('csrfToken', this.csrfToken);
                params.append('system_title', this.systemTitle);
                fetch('/api/data/updateRecord', {
                    method: 'post',
                    body: params
                })
                .then(res => {
                    if(res.status !== 200) {
                        res.json(data => console.log(data))
                    } else {
                        this.msg = '登録完了しました。'
                        scrollTo(0, 0)
                    }
                })
            }
        },
        created: function() {
            // this.getConfig()
            // this.getCsrfToken()
        }
    })
</script>
</body>
</html>