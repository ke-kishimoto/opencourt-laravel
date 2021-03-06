Vue.component('event-regist', {
    data: function() {
        return {
            mode: '',
            msg: '',
            selectedTemplate: '',
            templateList: [],
            title: '',
            short_title: '',
            game_date: '',
            start_time: '',
            end_time: '',
            place: '',
            limit_number: '',
            detail: '',
            price1: 0,
            price2: 0,
            price3: 0,
        }
    },
    methods: {
        clear() {
            this.selectedTemplate = ''
            this.title = ''
            this.short_title = ''
            this.game_date = ''
            this.start_time = ''
            this.end_time = ''
            this.place = ''
            this.limit_number = ''
            this.detail = ''
            this.price1 = 0
            this.price2 = 0
            this.price3 = 0
        },
        getGameInfo(id) {
            let params = new URLSearchParams();
            params.append('tableName', 'GameInfo');
            params.append('id', id);
            fetch('/api/data/selectById', {
                method: 'post',
                body: params
            })
            .then(res => res.json()
                .then(data => {
                    this.title = data.title
                    this.short_title = data.short_title
                    this.game_date = data.game_date
                    this.start_time = data.start_time
                    this.end_time = data.end_time
                    this.place = data.place
                    this.limit_number = data.limit_number
                    this.detail = data.detail
                    this.price1 = data.price1
                    this.price2 = data.price2
                    this.price3 = data.price3
                })
            )
            .catch(errors => console.log(errors))
        },
        getTemplateList() {
            let params = new URLSearchParams();
            params.append('tableName', 'EventTemplate');
            fetch('/api/data/selectAll', {
                method: 'post',
                body: params
            })
            .then(res => res.json()
                .then(json => {
                    this.templateList = json;
                    this.templateList.unshift({id:'', template_name: ''});
                })
            )
            .catch(errors => console.log(errors))
        },
        selectTemplate(){
            let params = new URLSearchParams();
            params.append('tableName', 'EventTemplate');
            params.append('id', event.target.value);
            fetch('/api/data/selectById', {
                method: 'post',
                body: params
            })
            .then(res => res.json()
                .then(data => {
                    this.title = data.title;
                    this.short_title = data.short_title;
                    this.place = data.place;
                    this.limit_number = data.limit_number;
                    this.detail = data.detail;
                    this.price1 = data.price1;
                    this.price2 = data.price2;
                    this.price3 = data.price3;
                })
            )
            .catch(errors => console.log(errors))
        },
        register() {
            if(this.title === '') {
                this.msg = '??????????????????????????????????????????'
                scrollTo(0, 0)
                return
            }
            if(this.short_title === '') {
                this.msg = '????????????????????????????????????'
                scrollTo(0, 0)
                return 
            }
            if(this.game_date === '') {
                this.msg = '????????????????????????????????????'
                scrollTo(0, 0)
                return
            }
            if(this.start_time === '') {
                this.msg = '??????????????????????????????????????????'
                scrollTo(0, 0)
                return
            }
            if(this.end_time === '') {
                this.msg = '??????????????????????????????????????????'
                scrollTo(0, 0)
                return
            }
            if(this.place === '') {
                this.msg = '????????????????????????????????????'
                scrollTo(0, 0)
                return
            }
            if (!confirm('????????????????????????????????????')) return;
            let type = 'insert';
            if(this.getParam('gameid') !== null) {
                type = 'update'
            }
            let params = new URLSearchParams();
            params.append('tableName', 'GameInfo');
            params.append('type', type);
            params.append('id', this.getParam('gameid'));
            params.append('title', this.title);
            params.append('short_title', this.short_title);
            params.append('game_date', this.game_date);
            params.append('start_time', this.start_time);
            params.append('end_time', this.end_time);
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
                    this.clear()
                    this.msg = '???????????????????????????'
                    scrollTo(0, 0)                    
                }
            })
        },
        deleteGame() {
            if (!confirm('????????????????????????????????????')) return;
            let params = new URLSearchParams();
            params.append('tableName', 'GameInfo');
            params.append('id', this.getParam('gameid'));
            fetch('/api/data/deleteById', {
                method: 'post',
                body: params
            })
            .then(res => {
                if(res.status !== 200) {
                    console.log(res);
                } else {
                    location.href = '/index'
                }
            })
        },
        getParam(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }
    },
    created: function(){
        this.getTemplateList()
        if(this.getParam('date') !== null) {
            this.game_date = this.getParam('date')
        }
        if(this.getParam('gameid') !== null) {
            this.getGameInfo(this.getParam('gameid'))
            this.mode = 'edit'
        } else {
            this.mode = 'new'
        }
    },
    template: 
    `
    <div>
        <br>
        <p style="color:red; font-size:20px">{{ msg }}</p>
        <div v-if="mode === 'new'">
            <p>
                ?????????????????????
                <select @change="selectTemplate($event)" v-model="selectedTemplate">
                    <option v-for="template in templateList" v-bind:key="template.id" v-bind:value="template.id">{{ template.template_name }}</option>
                </select>
            </p>
        </div>
        <p>????????????<input class="form-control" type="text" v-model="title" required></p>
        <p>??????????????????<input class="form-control" type="text" v-model="short_title" required></p>
        <p>??????<input class="form-control" type="date" v-model="game_date" required></p>
        <p>????????????<input class="form-control" type="time" step="600" v-model="start_time" required></p>
        <p>????????????<input class="form-control" type="time" step="600" v-model="end_time" required></p>
        <p>??????<input class="form-control" type="text" v-model="place" required></p>
        <p>????????????<input class="form-control" type="number" v-model="limit_number" min="1" required></p>
        <p>??????<textarea class="form-control" v-model="detail"></textarea></p>
        <p>
            ?????????<br>
            <label>????????????<input type="number" class="form-control form-price" v-model="price1" required>???</label><br>
            <label>??????????????????<input type="number" class="form-control form-price" v-model="price2" required>???</label><br>
            <label>?????????<input type="number" class="form-control form-price" v-model="price3" required>???</label>
        </p>
        <p>
            <button class="btn btn-primary" type="button" @click="register">
                <template v-if="mode === 'new'">??????</template>
                <template v-else>??????</template>
            </button>
            <button v-if="mode !== 'new'" class="btn btn-danger" type="button" @click="deleteGame">??????</button>
        </p>
    </div>
    `
})