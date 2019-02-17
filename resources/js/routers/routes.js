
import AppCalender from '../components/CalenderComponent.vue'
import AppDatable from '../components/DataTable.vue'

export const routes = [
    {
        path: '/',
        name: 'list.appointment',
        component: AppDatable
    },
    {
        path: '/create',
        name: 'create.appointment',
        component: AppCalender
    },
    {
        path: '*',
        component: {template: '<h1 class="display-3"> PAGE NOT FOUND </h1>'}
    }
]