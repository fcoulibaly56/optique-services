@php
    $lightboxAppointmentUrl = \Illuminate\Support\Facades\Route::has('appointment.create') ? route('appointment.create') : '#';
@endphp

<div x-data="{ open: false, item: { src: '', title: '', note: '' } }"
     x-on:click.window="const trigger = $event.target.closest('[data-lightbox]'); if (trigger) { item = JSON.parse(trigger.dataset.lightbox); open = true }"
     x-on:keydown.escape.window="open = false"
     x-effect="document.body.classList.toggle('overflow-hidden', open); open && $nextTick(() => $refs.close.focus())"
     x-show="open" x-cloak x-transition.opacity.duration.200ms
     @click.self="open = false"
     class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 p-3 sm:p-6"
     role="dialog" aria-modal="true" aria-label="Photo agrandie">

    <div class="relative flex max-h-full w-full max-w-3xl flex-col overflow-hidden rounded-3xl bg-white shadow-2xl">
        <button type="button" x-ref="close" @click="open = false" aria-label="Fermer"
                class="absolute right-3 top-3 z-10 grid h-10 w-10 place-items-center rounded-full bg-white/90 text-lg text-optique-text shadow-md transition hover:bg-white hover:text-optique-red focus:outline-none focus-visible:ring-2 focus-visible:ring-optique-red">
            ✕
        </button>

        <div class="flex min-h-0 flex-1 items-center justify-center bg-[#f5f1ef] p-3 sm:p-6">
            <img :src="item.src || null" :alt="item.title" class="max-h-[65vh] w-auto max-w-full object-contain">
        </div>

        <div class="p-4 text-center sm:p-6">
            <h3 class="font-serif text-xl text-optique-text sm:text-2xl" x-text="item.title"></h3>
            <p class="mt-1 text-sm text-optique-gray" x-text="item.note"></p>
            <a href="{{ $lightboxAppointmentUrl }}"
               class="mt-4 inline-flex items-center gap-2 rounded-full bg-optique-red px-5 py-3 text-sm font-semibold text-white transition hover:bg-optique-redhover">
                Prendre rendez-vous <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>
</div>
