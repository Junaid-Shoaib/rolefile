<template>

  <div id="app" class="w-60 float-left">
    <treeselect v-model="value" :multiple="false" :alwaysOpen="true" :options="docopt" v-on:select="treeChange"/>
  </div>

  <!-- <div class="bg-green-100 shadow mx-auto lg:max-w-4xl">

    <div class="p-5">
      <label for="search">Search</label>
      <input id="search" type='text' v-model="term" @keyup="search" class="px-2 ml-2 text-sm rounded-lg border">
    </div> -->

    <!-- <table class="w-full">
      <tr class="bg-gray-900 text-white">
        <th class="px-2 py-1 text-sm font-bold text-left">ID</th>
        <th class="px-2 py-1 text-sm font-bold text-left">Name</th>
        <th class="px-2 py-1 text-sm font-bold text-left">Path</th>
      </tr>
      <tr v-for="(doc, index) in docs.data" :key="index" :class="{'bg-red-300': index%2===0}">
        <td class="px-2 py-1 text-sm text-left">{{doc.id}}</td>
        <td class="px-2 py-1 text-sm text-left">{{doc.name}}</td>
        <td class="px-2 py-1 text-sm text-left">{{doc.path}}</td>
      </tr>
    </table>

    <div class="p-5 flex justify-end">
      <inertia-link class="px-2" :href="docs.prev_page_url">Previous</inertia-link>
      <inertia-link class="px-2" :href="docs.next_page_url">Next</inertia-link>
    </div> -->

  <!-- </div> -->
  

  <!-- <div class="bg-green-100 shadow mx-auto lg:max-w-4xl">

    <div class="p-5">
      <label for="search2">Search 2</label>
      <input id="search2" type='text' v-model="params.search" class="px-2 ml-2 text-sm rounded-lg border">
    </div>

    <table class="w-full">
      <tr class="bg-gray-900 text-white">
        <th class="px-2 py-1 text-sm font-bold text-left"><span @click="sort('id')">ID</span></th>
        <th class="px-2 py-1 text-sm font-bold text-left"><span @click="sort('name')">Name</span></th>
        <th class="px-2 py-1 text-sm font-bold text-left"><span @click="sort('email')">Email</span></th>
      </tr>
      <tr v-for="(user, index) in users.data" :key="index" :class="{'bg-red-300': index%2===0}">
        <td class="px-2 py-1 text-sm text-left">{{user.id}}</td>
        <td class="px-2 py-1 text-sm text-left">{{user.name}}</td>
        <td class="px-2 py-1 text-sm text-left">{{user.email}}</td>
      </tr>
    </table>

    <div class="p-5 flex justify-end">
      <inertia-link class="px-2" :href="users.prev_page_url">Previous</inertia-link>
      <inertia-link class="px-2" :href="users.next_page_url">Next</inertia-link>
    </div>

  </div> -->

</template>
 
<script>
  import Treeselect from 'vue3-treeselect'
  import 'vue3-treeselect/dist/vue3-treeselect.css'
  import _ from 'lodash'

  export default {
    components: { Treeselect },

    props: {
      // docs : Object,
      // users : Object,
      // filters : Object,
      // optionss : Object,
      docopt : Object,
    },

    data() {
      return {

        value: null,

        // options: [ {
        //   id: 'a',
        //   label: 'apple',
        //   isFolder: false,
        //   children: [ {
        //     id: 'aa',
        //     label: 'appie',
        //     isFolder: true,
        //   }, {
        //     id: 'ab',
        //     label: 'abbie',
        //     isDisabled: true,
        //   } ],
        // }, {
        //   id: 'b',
        //   label: 'ball',
        // }, {
        //   id: 'c',
        //   label: 'cat',
        // } ],

        // term: '',

        // params: {
        //   search: this.filters.search,
        //   field: this.filters.field,
        //   direction: this.filters.direction,
        // },

      }
    },

    methods:{

      // search: _.throttle(function(){
      //   this.$inertia.replace(route('indexx', {term:this.term}))
      // }, 500),

      // sort(field){
      //   this.params.field = field;
      //   this.params.direction = this.params.direction === 'asc'? 'desc' : 'asc';
      // },

      treeChange(node, instanceId){
        alert(node.path + '---' + node.id*2)
      },

    },

    // watch: {
    //   params: {
    //     handler: _.throttle(function() {  // this will control the speed of change detection
    //       let params = _.pickBy(this.params); //removes unnecessary params from url
    //       this.$inertia.get(route('indexx'), params, {replace:true, preserveState:true});
    //     }, 200),
    //     deep: true, // this will make sure to detect any change within elements deep in array
    //   },
    // },
  }
  
  </script> 
 
