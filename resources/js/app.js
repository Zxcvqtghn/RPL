const drawer = document.getElementById('mobile-admin-drawer');
const overlay = document.getElementById('mobile-admin-overlay');
const openButton = document.querySelector('[data-mobile-admin-open]');
const closeButton = document.querySelector('[data-mobile-admin-close]');

const openDrawer = () => {
    if (!drawer || !overlay) return;

    drawer.classList.remove('-translate-x-full');
    overlay.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
};

const closeDrawer = () => {
    if (!drawer || !overlay) return;

    drawer.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
};

openButton?.addEventListener('click', openDrawer);
closeButton?.addEventListener('click', closeDrawer);
overlay?.addEventListener('click', closeDrawer);

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        closeDrawer();
    }
});
