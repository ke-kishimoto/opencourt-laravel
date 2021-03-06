Vue.component('participant-breakdown', {
    data: function() {
        return {
            user: {},
            id: -1,
            all: 0,
            limit_number: 0,
            sya_women: 0,
            sya_men: 0,
            sya_all: 0,
            dai_women: 0,
            dai_men: 0,
            dai_all: 0,
            kou_women: 0,
            kou_men: 0,
            kou_all: 0,
            waiting_cnt: 0,
        }
    },
    methods: {
        getLoginUser() {
            fetch('/api/data/getLoginUser', {
                method: 'post',
            }).then(res => res.json()
                .then(data => {
                        this.user = data;
                })
            )
        },
        getParticipantBreakdown() {
            if(this.getParam('gameid') !== null) {
                this.id = this.getParam('gameid') 
                let params = new URLSearchParams();
                params.append('game_id', this.id);
                fetch('/api/event/getParticipantBreakdown', {
                    method: 'post',
                    body: params
                }).then(res => res.json().then(data => {
                    this.all = data.cnt ?? 0;
                    this.limit_number = data.limit_number ?? 0;
                    this.sya_women = data.sya_women ?? 0;
                    this.sya_men = data.sya_men ?? 0;
                    this.sya_all = data.sya_all ?? 0;
                    this.dai_women = data.dai_women ?? 0;
                    this.dai_men = data.dai_men ?? 0;
                    this.dai_all = data.dai_all ?? 0;
                    this.kou_women = data.kou_women ?? 0;
                    this.kou_men = data.kou_men ?? 0;
                    this.kou_all = data.kou_all ?? 0;
                    this.waiting_cnt = data.waiting_cnt ?? 0;
                }))
            }
        },
        getParam(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        },
    },
    created: function(){
        this.getLoginUser()
        this.getParticipantBreakdown()
    },
    template: `
    <div>
    <br>
    <p>??????????????? {{ all }} ??????????????? {{limit_number}} ??????</p>
        <table>
            <tr>
                <th>??????</th>
                <th>??????</th>
                <th>??????</th>
                <th>??????</th>
            </tr>
            <tr>
                <th>?????????</th>
                <th>                                   
                    <a v-if="id != -1 && sya_men != 0" v-bind:href="'/participant/ParticipantNameList?gameid=' + id + '&occupation=1&sex=1&waiting_flg=0'">
                        {{ sya_men }}???
                    </a>
                    <template v-else>
                        0???
                    </template>
                </th>
                <th>
                    <a v-if="id != -1 && sya_women != 0" v-bind:href="'/participant/ParticipantNameList?gameid=' + id + '&occupation=1&sex=2&waiting_flg=0'">
                        {{ sya_women }}???
                    </a>
                    <template v-else>
                        0???
                    </template>
                </th>
                <th>
                    <a v-if="id != -1 && sya_all != 0" v-bind:href="'/participant/ParticipantNameList?gameid=' + id + '&occupation=1&sex=0&waiting_flg=0'">
                        {{ sya_all }}???
                    </a>
                    <template v-else>
                        0???
                    </template>
                </th>
            </tr>
            <tr>
                <th>???????????????</th>
                <th>
                    <a v-if="id != -1 && dai_men != 0" v-bind:href="'/participant/ParticipantNameList?gameid=' + id + '&occupation=2&sex=1&waiting_flg=0'">
                        {{ dai_men }}???
                    </a>
                    <template v-else>
                        0???
                    </template>
                </th>
                <th>
                    <a v-if="id != -1 && dai_women != 0" v-bind:href="'/participant/ParticipantNameList?gameid=' + id + '&occupation=2&sex=2&waiting_flg=0'">
                        {{ dai_women}}???
                    </a>
                    <template v-else>
                        0???
                    </template>
                </th>
                <th>
                    <a v-if="id != -1 && dai_all != 0" v-bind:href="'/participant/ParticipantNameList?gameid=' + id + '&occupation=2&sex=0&waiting_flg=0'">
                        {{ dai_all }}???
                    </a>
                    <template v-else>
                        0???
                    </template>
                </th>
            </tr>
            <tr>
                <th>??????</th>
                <th>
                    <a v-if="id != -1 && kou_men != 0" v-bind:href="'/participant/ParticipantNameList?gameid=' + id + '&occupation=3&sex=1&waiting_flg=0'">
                        {{ kou_men}}???
                    </a>
                    <template v-else>
                        0???
                    </template>
                </th>
                <th>
                    <a v-if="id != -1 && kou_women != 0" v-bind:href="'/participant/ParticipantNameList?gameid=' + id + '&occupation=3&sex=2&waiting_flg=0'">
                        {{ kou_women}}???
                    </a>
                    <template v-else>
                        0???
                    </template>
                </th>
                <th>
                    <a v-if="id != -1 && kou_all != 0" v-bind:href="'/participant/ParticipantNameList?gameid=' + id + '&occupation=3&sex=0&waiting_flg=0'">
                        {{ kou_all }}???
                    </a>
                    <template v-else>
                        0???
                    </template>
                </th>
            </tr>
            <tr>
                <th>?????????????????????</th>
                <th>
                    -
                </th>
                <th>
                    -
                </th>
                <th>
                    <a v-if="id != -1 && waiting_cnt != 0" v-bind:href="'/participant/ParticipantNameList?gameid=' + id + '&occupation=0&sex=0&waiting_flg=1'">
                        {{ waiting_cnt }}???
                    </a>
                    <template v-else>
                        0???
                    </template>
                </th>
            </tr>
        </table>
    </div>
    `
})