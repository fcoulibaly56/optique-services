// resources/js/app.js
import './bootstrap';
import { createApp } from 'vue';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Monte automatiquement tout élément [data-vue="NomComposant"]
const islands = import.meta.glob('./islands/*.vue', { eager: true });

document.querySelectorAll('[data-vue]').forEach((el) => {
    const name = el.dataset.vue;
    const path = `./islands/${name}.vue`;
    if (islands[path]) {
        createApp(islands[path].default).mount(el);
    }
});
