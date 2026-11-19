// resources/js/product-filter.js
// Filtres par catégorie + recherche des montures. Avant, ce code était dans le layout et se chargeait
// sur TOUTES les pages ; maintenant il est dans le bundle et ne fait rien s'il n'y a pas de montures.

(() => {
    const filterButtons = document.querySelectorAll('[data-category-filter]');
    const productCards = document.querySelectorAll('[data-category-card]');
    if (!productCards.length) return;

    const searchInput = document.querySelector('[data-product-search]');
    const resultCount = document.querySelector('[data-product-count]');
    const emptyState = document.querySelector('[data-product-empty]');
    const resetButton = document.querySelector('[data-reset-products]');
    let activeCategory = 'Toutes';

    const applyFilters = () => {
        const query = (searchInput?.value || '').trim().toLocaleLowerCase('fr');
        let visibleCount = 0;

        productCards.forEach(card => {
            const categoryMatches = activeCategory === 'Toutes' || card.dataset.categoryCard === activeCategory;
            const searchMatches = !query || (card.dataset.search || '').toLocaleLowerCase('fr').includes(query);
            const visible = categoryMatches && searchMatches;
            const wasHidden = card.hidden;
            card.hidden = !visible;
            if (visible) {
                visibleCount++;
                if (wasHidden) {
                    card.classList.add('is-visible');
                    if (card.animate && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                        card.animate([{ opacity: 0, transform: 'translateY(10px)' }, { opacity: 1, transform: 'translateY(0)' }], { duration: 260, easing: 'ease-out' });
                    }
                }
            }
        });

        filterButtons.forEach(button => {
            const selected = button.dataset.categoryFilter === activeCategory;
            button.setAttribute('aria-pressed', String(selected));
            button.classList.toggle('bg-optique-red', selected);
            button.classList.toggle('text-white', selected);
            button.classList.toggle('border-optique-red', selected);
            button.classList.toggle('shadow-md', selected);
            button.classList.toggle('shadow-optique-red/15', selected);
            button.classList.toggle('bg-white', !selected);
            button.classList.toggle('text-optique-gray', !selected);
            button.classList.toggle('border-optique-border', !selected);
        });

        if (resultCount) resultCount.textContent = `${visibleCount} modèle${visibleCount > 1 ? 's' : ''}`;
        if (emptyState) emptyState.hidden = visibleCount > 0;
    };

    filterButtons.forEach(button => button.addEventListener('click', () => {
        activeCategory = button.dataset.categoryFilter || 'Toutes';
        applyFilters();
    }));
    searchInput?.addEventListener('input', applyFilters);
    resetButton?.addEventListener('click', () => {
        activeCategory = 'Toutes';
        if (searchInput) searchInput.value = '';
        applyFilters();
    });
    applyFilters();
})();

/* ------------------------------------------------------------------
   resources/js/app.js — AJOUTE ces lignes à la fin (dans cet ordre) :

   import './product-carousel';
   import './product-filter';
   import './immersive';

   L'ordre compte : le carrousel doit s'installer avant les filtres,
   comme avant (la page chargeait le carrousel, puis le script du layout).
------------------------------------------------------------------- */