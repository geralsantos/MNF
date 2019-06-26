//import Vue from 'vue'
let bus = new Vue()
export default bus

/*import Vue from 'vue'
let bus = new Vue({
    el:'#app2',
    methods:{
        customFilter (item, queryText, itemText) {
            const textOne = item.name.toLowerCase()
            const textTwo = item.abbr.toLowerCase()
            const searchText = queryText.toLowerCase()
    
            return textOne.indexOf(searchText) > -1 ||
            textTwo.indexOf(searchText) > -1
        }
    }
})
export default bus
*/