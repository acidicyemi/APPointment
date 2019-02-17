<template>
  <v-layout>
    <v-flex
    md-12
      xs12>
      <v-sheet height="500">
        <v-calendar
          ref="calendar"
          v-model="start"
          :type="type"
          :end="end"
          color="primary"
        >
          <template
            slot="day"
            slot-scope="{ date }"
          >
            <template v-for="event in eventsMap[date]">
              <v-menu
                :key="event.title"
                v-model="event.open"
                full-width
                offset-x
              >
                <div
                  v-if="!event.time"
                  slot="activator"
                  v-ripple
                  class="my-event"
                  v-html="event.title"
                ></div>
                <v-card
                  color="grey lighten-4"
                  min-width="350px"
                  flat
                >
                  <v-toolbar
                    color="primary"
                    dark
                  >
                    <v-btn icon 
                      @click="initUpdate(event.id)">
                      <v-icon>edit</v-icon>
                    </v-btn>
                    <v-toolbar-title v-html="event.title"></v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn icon>
                      <v-icon>favorite</v-icon>
                    </v-btn>
                    <v-btn icon>
                      <v-icon>more_vert</v-icon>
                    </v-btn>
                  </v-toolbar>
                  <v-card-title primary-title>
                    <span v-html="event.description"></span>
                  </v-card-title>
                  <v-card-actions>
                    <v-btn
                      flat
                      color="secondary"
                    >
                      Cancel
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-menu>
            </template>
          </template>
        </v-calendar>
      </v-sheet>
    </v-flex>
    <v-flex>
    <v-btn @click="$refs.calendar.prev()">
        <v-icon
          dark
          left
        >
          keyboard_arrow_left
        </v-icon>
        Prev
      </v-btn>
    </v-flex>
    <v-flex
      sm4
      xs12
      class="text-sm-right text-xs-center"
    >
      <v-btn @click="$refs.calendar.next()">
        Next
        <v-icon
          right
          dark
        >
          keyboard_arrow_right
        </v-icon>
      </v-btn>
    </v-flex>

    <!-- dialog -->
     <v-btn
      fab
      bottom
      right
      color="pink"
      dark
      fixed
      @click.stop="dialog = !dialog"
    >
      <v-icon>add</v-icon>
    </v-btn>
    <v-dialog v-model="dialog" width="800px">
      <v-card>
        <v-card-title
          class="grey lighten-4 py-4 title"
          v-if="appointmentIndex === -1 "
        >
          Schedule Appointment
        </v-card-title>
        <v-card-title
          class="grey lighten-4 py-4 title"
          v-if="appointmentIndex !== -1 "
        >
          Update Appointment
        </v-card-title>
        <v-container grid-list-sm class="pa-4">
          <v-layout row wrap>
            <v-flex xs12 align-center justify-space-between>
              <v-layout align-center>
                <v-avatar size="40px" class="mr-3">
                  <img
                    src="//ssl.gstatic.com/s2/oz/images/sge/grey_silhouette.png"
                    alt=""
                  >
                </v-avatar>
                <v-text-field
                  placeholder="Title"
                  v-model="appointment.title" 
                ></v-text-field>
              </v-layout>
            </v-flex>
            <v-flex xs12>
              <v-text-field
                prepend-icon="notes"
                placeholder="Description"
                  v-model="appointment.description" 
              ></v-text-field>
            </v-flex>
            <v-flex xs12>
                  <v-flex xs12>
              <v-menu
                ref="menu"
                v-model="menu"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="appointment.date"
                lazy
                transition="scale-transition"
                offset-y
                full-width
                min-width="290px"
              >
                <v-text-field
                  slot="activator"
                  v-model="appointment.date"
                  label="Picker in menu"
                  prepend-icon="event"
                  readonly
                ></v-text-field>
                <v-date-picker v-model="appointment.date" no-title scrollable>
                  <v-spacer></v-spacer>
                  <v-btn flat color="primary" @click="menu = false" >Cancel</v-btn>
                  <v-spacer></v-spacer>
                  <v-btn flat color="primary" @click="$refs.menu.save(appointment.date)">OK</v-btn>
                </v-date-picker>
              </v-menu>
    </v-flex>
 
            </v-flex>
          </v-layout>
        </v-container>
        <v-card-actions>
          <v-btn flat color="primary" @click="reset()">Cancel</v-btn>
          <v-btn flat @click="save()">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
import axios  from 'axios'
import {mapGetters} from 'vuex' 
  export default {
    data: () => ({
      menu: false,
      appointmentIndex: -1,
      dialog: false,
      default: {
          title:  '',
          description:  '',
          date: new Date().toISOString().substr(0, 10),
          open: false,
      },
      appointment: {
          title:  '',
          description:  '',
          date: new Date().toISOString().substr(0, 10),
          open: '',
      },
      type: 'month',
      start:  new Date().toISOString().substr(0, 10),
      end: '2020-01-06',
      today: '2019-02-16'
    }),
    computed: {
        ...mapGetters([
            'appointments'
        ]),
      // convert the list of events into a map of lists keyed by date
      eventsMap () {
        const map = {}        
        this.appointments.data.forEach(e => (map[e.date] = map[e.date] || []).push(e))        
        return map
      },
    },
    created() {
        this.$store.dispatch('getAppointmentsList')
    },
    methods: {
      reset() {
          this.dialog = false
          this.appointment = Object.assign({}, this.default)
          this.appointmentIndex = -1
      },
      save() {
            if(this.appointmentIndex === -1) {
                this.create()
            }else {
                this.updateItem();
            }
        },
      create () {
            axios.post('list-appointments', {
                title: this.appointment.title,
                description: this.appointment.description,
                date: this.appointment.date,
            }).then((response) => {              
                    let i = Object.assign({id: response.data.id}, this.appointment);
                    
                    this.$store.getters.appointments.data.push(i);
                    
                    this.reset()
                }).catch(function (error) {
                        // handle error
                        console.log(error);
                    }).then( () => {

                        });
        },
        initUpdate(payload) {
          console.log(payload);
            this.appointmentIndex = payload - 1 // use in the if() statment for saving
            // console.log(this.$store.getters.appointments[this.calenderIndex]);
            this.appointment = Object.assign({}, this.$store.getters.appointments.data[this.appointmentIndex])
            console.log(this.appointment);
            this.dialog = true
        },
        updateItem () {
          alert('hi')
            axios.put(`update-appointments/${this.appointment.id}`, {
                title: this.appointment.title,
                description: this.appointment.description,
                date: this.appointment.date,
            }).then( (response) => {
                    Object.assign(this.$store.getters.appointments.data[this.appointmentIndex], this.appointment)
                    this.$store.dispatch('getAppointmentsList')
                    this.reset()
                }).catch( (error) => {
                        // handle error
                        console.log(error);
                    }).then( () => {
                      
                        });
                
        },

        deleteItem (event) {
            axios.delete(`update-appointments/${event.appointment.id}`)
                .then( (response) => {
                  
                    // handle success
                    this.$store.dispatch('getAppointmentsList')
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                }).then( () => {
                  
                    });
        },
        
    }
  }
</script>
<style scoped>
  .my-event {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    border-radius: 2px;
    background-color: #1867c0;
    color: #ffffff;
    border: 1px solid #1867c0;
    width: 100%;
    font-size: 12px;
    padding: 3px;
    cursor: pointer;
    margin-bottom: 1px;
  }
</style>