// resources/js/product-carousel.js
// Carrousel des montures de l'accueil. Même code qu'avant, mais déplacé hors du fichier Blade.
// Pourquoi : Vite le minifie, le navigateur le met en cache, et la page d'accueil reste lisible.

(() => {
    const track = document.querySelector('[data-product-carousel]');
    if (!track) return; // pas de carrousel sur cette page : on s'arrête, rien ne se passe

    const controls = document.querySelector('[data-carousel-controls]');
    const previous = document.querySelector('[data-carousel-prev]');
    const next = document.querySelector('[data-carousel-next]');
    const rotationToggle = document.querySelector('[data-carousel-toggle]');
    const pauseIcon = document.querySelector('[data-rotation-pause]');
    const playIcon = document.querySelector('[data-rotation-play]');
    const status = document.querySelector('[data-carousel-status]');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let rotationEnabled = !reduceMotion;
    let hoverPaused = false;
    let focusWithin = false;
    let rotationTimer = null;

    const updateRotationButton = () => {
        if (!rotationToggle) return;
        rotationToggle.hidden = reduceMotion;
        rotationToggle.setAttribute('aria-pressed', String(rotationEnabled));
        rotationToggle.setAttribute('aria-label', rotationEnabled ? 'Mettre le défilement automatique en pause' : 'Reprendre le défilement automatique');
        if (pauseIcon) pauseIcon.hidden = !rotationEnabled;
        if (playIcon) playIcon.hidden = rotationEnabled;
    };

    const updateControls = () => {
        const maxScroll = Math.max(0, track.scrollWidth - track.clientWidth);
        const hasOverflow = maxScroll > 4;
        if (controls) controls.classList.toggle('hidden', !hasOverflow);
        if (previous) previous.disabled = !hasOverflow || track.scrollLeft <= 2;
        if (next) next.disabled = !hasOverflow || track.scrollLeft >= maxScroll - 2;
        updateRotationButton();
    };

    const syncRotation = () => {
        window.clearInterval(rotationTimer);
        rotationTimer = null;
        const hasOverflow = track.scrollWidth - track.clientWidth > 4;
        if (!rotationEnabled || reduceMotion || hoverPaused || focusWithin || document.hidden || !hasOverflow) return;
        rotationTimer = window.setInterval(() => {
            const maxScroll = Math.max(0, track.scrollWidth - track.clientWidth);
            if (track.scrollLeft >= maxScroll - 3) {
                track.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                track.scrollBy({ left: Math.max(240, track.clientWidth * 0.82), behavior: 'smooth' });
            }
        }, 5000);
    };

    const stopForInteraction = () => {
        rotationEnabled = false;
        syncRotation();
        updateRotationButton();
    };

    const move = direction => {
        const distance = Math.max(240, track.clientWidth * 0.82) * direction;
        track.scrollBy({ left: distance, behavior: reduceMotion ? 'auto' : 'smooth' });
        if (status) status.textContent = direction > 0 ? 'Défilement vers les montures suivantes.' : 'Défilement vers les montures précédentes.';
    };

    previous?.addEventListener('click', () => { stopForInteraction(); move(-1); });
    next?.addEventListener('click', () => { stopForInteraction(); move(1); });
    rotationToggle?.addEventListener('click', () => {
        rotationEnabled = !rotationEnabled;
        syncRotation();
        updateRotationButton();
    });
    track.addEventListener('scroll', () => window.requestAnimationFrame(updateControls), { passive: true });
    track.addEventListener('mouseenter', () => { hoverPaused = true; syncRotation(); });
    track.addEventListener('mouseleave', () => { hoverPaused = false; syncRotation(); });
    track.addEventListener('pointerdown', stopForInteraction, { passive: true });
    track.addEventListener('wheel', stopForInteraction, { passive: true });
    track.addEventListener('focusin', () => {
        focusWithin = true;
        rotationEnabled = false;
        syncRotation();
        updateRotationButton();
    });
    track.addEventListener('focusout', event => {
        if (!track.contains(event.relatedTarget)) { focusWithin = false; syncRotation(); }
    });
    track.addEventListener('keydown', event => {
        if (event.target !== track) return;
        if (event.key === 'ArrowRight') { event.preventDefault(); stopForInteraction(); move(1); }
        if (event.key === 'ArrowLeft') { event.preventDefault(); stopForInteraction(); move(-1); }
    });

    controls?.addEventListener('focusin', event => {
        focusWithin = true;
        if (event.target !== rotationToggle) rotationEnabled = false;
        syncRotation();
        updateRotationButton();
    });
    controls?.addEventListener('focusout', event => {
        if (!controls.contains(event.relatedTarget)) { focusWithin = false; syncRotation(); }
    });

    const filters = document.querySelectorAll('[data-category-filter], [data-product-search], [data-reset-products]');
    filters.forEach(control => control.addEventListener('click', () => {
        stopForInteraction();
        track.scrollTo({ left: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
        window.requestAnimationFrame(updateControls);
    }));
    document.querySelector('[data-product-search]')?.addEventListener('input', () => {
        stopForInteraction();
        track.scrollTo({ left: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
        window.requestAnimationFrame(updateControls);
    });

    if ('MutationObserver' in window) {
        const visibilityObserver = new MutationObserver(() => {
            track.scrollTo({ left: 0, behavior: 'auto' });
            window.requestAnimationFrame(updateControls);
        });
        visibilityObserver.observe(track, { attributes: true, attributeFilter: ['hidden'], subtree: true });
    }

    document.addEventListener('visibilitychange', syncRotation);
    window.addEventListener('resize', () => { updateControls(); syncRotation(); }, { passive: true });
    updateControls();
    syncRotation();
})();