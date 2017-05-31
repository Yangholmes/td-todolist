<template>
<div class="note-daily">
  <daily></daily>
    <history  v-for="(item,index) in historys" :key="index" :history="item"></history>
</div>
</template>

<script>
import daily from '../modules/daily.vue'
import history from '../modules/history.vue'

export default {
    data() {
        return {
            historys: [{
                date: '2017/5/5',
                checkList: ['本地'],
                dailys: [{
                    content: '11111',
                    status: 1
                },
                {
                    content: '2222',
                    status: 0
                }]
            },
            {
                date: '2017/5/4',
                checkList: ['外勤'],
                dailys: [{
                    content: '11111',
                    status: 1
                },
                {
                    content: '2222',
                    status: 0
                }]
            },
            {
                date: '2017/5/3',
                checkList: ['本地','加班'],
                dailys: [{
                    content: '11111',
                    status: 1
                },
                {
                    content: '2222',
                    status: 0
                }]
            }
          ]
        }
    },
    components: { // 注册组件，这很重要
        daily, // 相当于 entry: entry
        history
    }
}
</script>

<style>
.note-daily {
    padding: 1.5em;
    background-color: #EBEBEB;
}
</style>
