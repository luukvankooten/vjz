window.vjz = new Vue({
    el: '#container',
    data: {
        expand: true,
    },
    methods: {
        toggle() {
            this.expand = !this.expand;
        },

        subMenu(event) {
            let clicked = event.path[0].classList;
            let item = event.path[2].querySelector('.expand-content').classList;
            let prefix = 'fa-caret-';
            if (clicked.contains(prefix + 'down')) {
                clicked.remove(prefix + 'down');
                clicked.add(prefix +'up');
            } else {
                clicked.remove(prefix + 'up');
                clicked.add(prefix +'down');
            }

            if (item.contains('expand')) {
                item.remove('expand');
            } else {
                item.add('expand');
            }
        },

        mobile() {
            let width = document.querySelector('html').offsetWidth;
            window.addEventListener('resize', () => {

                if (width < 1025) {
                    this.expand = false;
                } else {
                    this.expand = true;
                }
            });

            if (width < 1025)  {
                this.expand = false;
            }

        },

    },

    beforeMount() {
        this.mobile();
    }
});

