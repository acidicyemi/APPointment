<template>
  <v-app id="inspire">
    <v-navigation-drawer
      fixed
      :clipped="$vuetify.breakpoint.mdAndUp"
      app
      v-model="drawer"
    >
      <v-list dense>
        <template v-for="item in items">
          <v-layout
            row
            v-if="item.heading"
            align-center
            :key="item.heading"
          >
            <v-flex xs6>
              <v-subheader v-if="item.heading">
                {{ item.heading }}
              </v-subheader>
            </v-flex>
            <v-flex xs6 class="text-xs-center">
              <a href="#!" class="body-2 black--text">EDIT</a>
            </v-flex>
          </v-layout>
          <v-list-group
            v-else-if="item.children"
            v-model="item.model"
            :key="item.text"
            :prepend-icon="item.model ? item.icon : item['icon-alt']"
            append-icon=""
          >
            <v-list-tile slot="activator">
              <v-list-tile-content>
                <v-list-tile-title>
                  {{ item.text }}
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
              v-for="(child, i) in item.children"
              :key="i"
              @click="navigate(item.appRoute)"
            >
              <v-list-tile-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title>
                  {{ child.text }}
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
          </v-list-group>
          <v-list-tile v-else @click="navigate(item.appRoute)" :key="item.text">
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                {{ item.text }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar
      color="blue darken-3"
      dark
      app
      :clipped-left="$vuetify.breakpoint.mdAndUp"
      fixed
    >
      <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <span class="hidden-sm-and-down">APPointment</span>
      </v-toolbar-title>
      <v-text-field
        flat
        solo-inverted
        prepend-icon="search"
        label="Search"
        class="hidden-sm-and-down"
      ></v-text-field>
      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon>apps</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>notifications</v-icon>
      </v-btn>
      <v-btn icon large>
        <v-avatar size="32px" tile>
          <img
            src="https://cdn.vuetifyjs.com/images/logos/logo.svg"
            alt="Vuetify"
          >
        </v-avatar>
      </v-btn>
    </v-toolbar>
    <v-content>
      <v-container>
        <v-layout child-flex>
          <transition name="component-fade" mode="out-in">
            <router-view></router-view>
          </transition>
        </v-layout>
      </v-container>
    </v-content>
   
  </v-app>
</template>
<script>

import {mapGetters} from 'vuex' 
export default {
  data: function (){
        return {
            drawer: null,
            date: new Date().toISOString().substr(0, 10),
            items: [
                { icon: 'contacts', text: 'Show Appointments', appRoute: 'show.appointment' },
                { icon: 'history', text: 'List Appointments', appRoute: 'show.list' },
                { icon: 'content_copy', text: 'Duplicates', appRoute: 'show.appointment' },
                {
                icon: 'keyboard_arrow_up',
                'icon-alt': 'keyboard_arrow_down',
                text: 'Labels', appRoute: 'show.appointment',
                model: true,
                children: [
                    { icon: 'add', text: 'Create label' }
                ]
                },
                {
                icon: 'keyboard_arrow_up',
                'icon-alt': 'keyboard_arrow_down', appRoute: 'show.appointment',
                text: 'More',
                model: false,
                children: [
                    { text: 'Import' },
                    { text: 'Export' },
                    { text: 'Print' },
                    { text: 'Undo changes' },
                    { text: 'Other contacts' }
                ]
                },
                { icon: 'settings', text: 'Settings', appRoute: 'show.appointment' },
                { icon: 'chat_bubble', text: 'Send feedback', appRoute: 'show.appointment' },
                { icon: 'help', text: 'Help', appRoute: 'show.appointment' },
                { icon: 'phonelink', text: 'App downloads', appRoute: 'show.appointment' },
                { icon: 'keyboard', text: 'Go to the old version', appRoute: 'show.appointment' }
            ]
        }
    },
    props: {
      source: String
    },
    computed: {
        ...mapGetters([
            'appointments'
        ]),
    },
    methods: {
      navigate: function (name) {
         this.$router.push({ name: name })
      },
    created() {
        this.$store.dispatch('getAppointmentsList')
    },
    },
}


</script>