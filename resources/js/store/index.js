
import axios  from 'axios'
export default {
    state: {
        appointments: [],
    },
    mutations: {
        
        updateAppointmentsList(state, payload) {
            state.appointments = payload
        },
    },
    getters: {
        appointments(state) {
            return state.appointments;
        },
    },
    actions: {
        // Action that getAppointmentsList starts here
        getAppointmentsList(context) {
            axios.get('/list-appointments')
            .then((response) => {
                context.commit('updateAppointmentsList', response.data)
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
        },
        // Action that getAppointmentsList ends here
    }
}