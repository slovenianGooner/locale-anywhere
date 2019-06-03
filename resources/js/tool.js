Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'locale-anywhere',
            path: '/locale-anywhere',
            component: require('./components/Tool'),
        },
    ]);

    Vue.component('locale-anywhere-dropdown', require('./components/Dropdown'));
    Vue.component('custom-detail-toolbar', require('./components/CustomDetailToolbar'));
    Vue.component('index-locale-anywhere', require('./components/IndexField'));
    Vue.component('detail-locale-anywhere', require('./components/DetailField'));
    Vue.component('form-locale-anywhere', require('./components/FormField'));
});
