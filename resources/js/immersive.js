// resources/js/immersive.js
// À importer dans resources/js/app.js :  import './immersive';

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/* ------------------------------------------------------------------
   1) PARALLAXE
   Chaque <img data-parallax> est plus haute que son conteneur (124 %).
   Pendant le scroll, on la fait glisser du haut vers le bas du conteneur.
   On modifie seulement `transform` : le navigateur le traite sur le GPU,
   sans recalculer la mise en page (contrairement à `top`).
------------------------------------------------------------------- */
const layers = [...document.querySelectorAll('[data-parallax]')];

if (layers.length && !reduceMotion) {
    let ticking = false;

    const update = () => {
        const vh = window.innerHeight;
        layers.forEach(img => {
            const box = img.parentElement.getBoundingClientRect();
            if (box.bottom < 0 || box.top > vh) return;           // hors écran : on ne calcule rien
            const extra = img.offsetHeight - box.height;           // marge disponible
            const p = Math.min(1, Math.max(0, (vh - box.top) / (vh + box.height))); // 0 → 1 pendant le passage
            img.style.transform = `translate3d(0, ${(-p * extra).toFixed(1)}px, 0)`;
        });
        ticking = false;
    };

    // requestAnimationFrame : au plus un calcul par image affichée (~60/s), même si scroll tire 200 événements/s
    const onScroll = () => {
        if (!ticking) { ticking = true; requestAnimationFrame(update); }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll);
    update();
}

/* ------------------------------------------------------------------
   2) LIGHTBOX (agrandissement des photos de la galerie)
   On utilise l'élément HTML natif <dialog> : le navigateur gère déjà
   le fond sombre, la touche Échap et le piégeage du focus clavier.
------------------------------------------------------------------- */
const dialog = document.getElementById('lightbox');

if (dialog) {
    const items = [...document.querySelectorAll('[data-lightbox]')];
    const img = dialog.querySelector('[data-lightbox-img]');
    const caption = dialog.querySelector('[data-lightbox-caption]');
    let index = 0;

    const show = i => {
        index = (i + items.length) % items.length;                 // revient au début/à la fin
        const { src, alt, caption: text } = items[index].dataset;
        img.src = src;
        img.alt = alt || '';
        caption.textContent = text || '';
    };

    items.forEach((button, i) => button.addEventListener('click', () => { show(i); dialog.showModal(); }));
    dialog.querySelector('[data-lightbox-prev]').addEventListener('click', () => show(index - 1));
    dialog.querySelector('[data-lightbox-next]').addEventListener('click', () => show(index + 1));
    dialog.querySelector('[data-lightbox-close]').addEventListener('click', () => dialog.close());
    dialog.addEventListener('click', event => { if (event.target === dialog) dialog.close(); }); // clic hors de la photo
    dialog.addEventListener('keydown', event => {
        if (event.key === 'ArrowRight') show(index + 1);
        if (event.key === 'ArrowLeft') show(index - 1);
    });
}