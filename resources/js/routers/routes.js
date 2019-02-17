
import AppCalender from '../components/CalenderComponent.vue'
import AppDatable from '../components/Test.vue'

export const routes = [
    {
        path: '/',
        name: 'show.appointment',
        component: AppCalender
    },
    {
        path: '/list',
        name: 'show.list',
        component: AppDatable
    },
    {
        path: '*',
        component: {template: '<h1 class="display-3"> PAGE NOT FOUND </h1>'}
    }
]