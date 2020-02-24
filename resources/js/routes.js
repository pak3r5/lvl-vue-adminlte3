import VueRouter from 'vue-router';


let routes = [
    {
        path: '/dashboard',
        component: require('./views/dashboard').default
    },
    {
        path: '/users',
        component: require('./views/users').default
    },
    {
        path: '/countries',
        component: require('./views/countries').default
    },
    {
        path: '/leagues',
        component: require('./views/leagues').default
    },
    {
        path: '/teams',
        component: require('./views/teams').default
    }
];


export default new VueRouter({
    base: '/admin/',
    mode: 'history',
    routes,
    linkActiveClass: 'active'
});
