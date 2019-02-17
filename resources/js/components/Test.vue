<template>
  <v-layout>
      <v-flex xs12>
          
  <v-data-table
    :headers="headers"
    :items="appointments.data"
    class="elevation-1"
  >
    <template slot="items" slot-scope="props">
      <td>{{ props.index + 1 }}</td>
      <td class="text-xs-left">{{ props.item.title }}</td>
      <td class="text-xs-left">{{ props.item.description }}</td>
      <td class="text-xs-left">{{ props.item.date }}</td>
    </template>
  </v-data-table>
      </v-flex>
  </v-layout>
</template>

<script>
import {mapGetters} from 'vuex' 
  export default {
    data () {
      return {
        headers: [
          {
            text: 'ID',
            align: 'left',
            sortable: false,
            value: 'id'
          },
          { text: 'Title', value: 'title' },
          { text: 'Description', value: 'description' },
          { text: 'Date', value: 'date' }
        ]
      }
    }, 
    computed: {
        ...mapGetters([
            'appointments'
        ]),
    },
    created() {
        console.log(this.appointments.data);
        
        this.$store.dispatch('getAppointmentsList')
        
    },
  }
</script>