@extends('layouts.public')

@section('title', 'Prendre rendez-vous — Optique Services')
@section('description', 'Demandez un rendez-vous chez Optique Services à ACI 2000. Choisissez un motif, une date et laissez vos coordonnées.')

@section('content')
@php
    $initialStep = $errors->hasAny(['name', 'phone', 'email', 'consent']) ? 3 : ($errors->hasAny(['date', 'time']) ? 2 : 1);
@endphp

<section class="relative isolate overflow-hidden bg-[#fbf8f6]">
    <div class="pointer-events-none absolute -right-24 -top-24 -z-10 h-80 w-80 rounded-full bg-[#f1deda]/70 blur-3xl sm:h-[34rem] sm:w-[34rem]" aria-hidden="true"></div>
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-14 lg:px-8 lg:py-16">
        <div class="mx-auto max-w-3xl text-center" data-reveal>
            <a href="{{ \Illuminate\Support\Facades\Route::has('home') ? route('home') : url('/') }}" class="mb-5 inline-flex items-center gap-2 text-xs font-semibold text-optique-gray transition hover:text-optique-red"><span aria-hidden="true">←</span> Accueil</a>
            <p class="text-xs font-bold uppercase tracking-[.2em] text-optique-red">En quelques étapes</p>
            <h1 class="mt-3 font-serif text-4xl leading-[1.05] tracking-[-.04em] text-optique-text sm:text-5xl lg:text-6xl">Prenons rendez-vous.</h1>
            <p class="mx-auto mt-4 max-w-2xl text-base leading-7 text-optique-gray sm:text-lg">Indiquez le motif de votre visite et le moment souhaité. L’équipe vous recontactera pour confirmer votre demande.</p>
        </div>

        <div class="mx-auto mt-8 grid max-w-5xl gap-6 lg:mt-12 lg:grid-cols-[minmax(0,1fr)_17rem] lg:items-start">
            <div class="overflow-hidden rounded-[1.75rem] border border-optique-border bg-white shadow-xl shadow-[#593b35]/[.06] sm:rounded-[2rem]" data-reveal>
                     @if(session('success'))
                    <div class="p-6 sm:p-10">
                        <div role="status" class="rounded-3xl border border-green-200 bg-green-50 p-6 text-center sm:p-8">
                            <span class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-white text-2xl text-green-600 shadow-sm" aria-hidden="true">✓</span>
                            <h2 class="mt-4 font-serif text-2xl text-green-900">Demande envoyée !</h2>
                            <p class="mt-2 text-sm leading-6 text-green-800">{{ session('success') }}</p>

                            @if(session('appointment_reference'))
                                <div class="mt-6 rounded-xl bg-white border-2 border-dashed border-green-300 p-4">
                                    <p class="text-xs uppercase font-bold text-gray-500 tracking-wide mb-2">Votre numéro de suivi</p>
                                    <p id="rdv-reference" class="text-2xl font-bold text-[#A33B36] tracking-wider">{{ session('appointment_reference') }}</p>
                                    <button type="button" onclick="copierReference()" class="mt-2 text-xs text-blue-600 hover:underline">
                                        📋 Copier le numéro
                                    </button>
                                </div>

                                <div class="mt-4 space-y-2 text-left">
                                    <a href="{{ route('appointment.track') }}"
                                       class="block w-full text-center bg-[#A33B36] text-white py-3 rounded-xl font-semibold hover:bg-[#8F302C] transition text-sm">
                                        🔍 Suivre mon rendez-vous
                                    </a>
                                    @if(session('appointment_phone'))
                                        <a href="https://wa.me/22376882712?text={{ rawurlencode('Bonjour, je viens de prendre un RDV. Ma référence est : ' . session('appointment_reference')) }}"
                                           target="_blank"
                                           class="block w-full text-center bg-green-500 text-white py-3 rounded-xl font-semibold hover:bg-green-600 transition text-sm">
                                            💬 Envoyer la référence sur WhatsApp
                                        </a>
                                        @if(!session('has_account'))
                                            <a href="{{ route('login.phone') }}"
                                               class="block w-full text-center border border-gray-300 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-50 transition text-sm">
                                                🔐 Créer mon compte pour les notifications
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            @endif

                            <p class="mt-4 text-xs text-green-700">L'équipe vous contactera pour confirmer votre rendez-vous.</p>
                            <a href="{{ route('home') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-[#A33B36]">← Retour à l'accueil</a>
                        </div>
                    </div>

                    <script>
                        function copierReference() {
                            const ref = document.getElementById('rdv-reference').textContent;
                            navigator.clipboard.writeText(ref).then(() => {
                                alert('Référence copiée : ' + ref);
                            });
                        }
                    </script>
                @else
                    
                    <form id="appointment-form" data-initial-step="{{ $initialStep }}" action="{{ route('appointment.store') }}" method="POST" class="p-5 sm:p-8 lg:p-10" novalidate>
                        @csrf
                        @if($errors->any())<div role="alert" class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-800"><p class="font-semibold">Il reste quelques informations à corriger.</p><ul class="mt-2 list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

                        <div class="relative mb-8 sm:mb-10">
                            <div class="absolute left-[16%] right-[16%] top-5 h-0.5 bg-[#eee7e4]" aria-hidden="true"></div>
                            <div id="step-progress-line" class="absolute left-[16%] top-5 h-0.5 bg-optique-red transition-all duration-500" style="width:0" aria-hidden="true"></div>
                            <ol class="relative grid grid-cols-3" aria-label="Étapes du formulaire">
                                @foreach([1 => 'Motif', 2 => 'Créneau', 3 => 'Coordonnées'] as $number => $stepLabel)
                                    <li class="flex flex-col items-center text-center"><span data-step-indicator="{{ $number }}" class="grid h-10 w-10 place-items-center rounded-full border-2 text-sm font-bold transition duration-300 {{ $initialStep >= $number ? 'border-optique-red bg-optique-red text-white shadow-md shadow-optique-red/20' : 'border-[#e9e1de] bg-white text-optique-gray' }}">{{ $number }}</span><span class="mt-2 text-[10px] font-semibold sm:text-xs {{ $initialStep >= $number ? 'text-optique-text' : 'text-optique-gray' }}">{{ $stepLabel }}</span></li>
                                @endforeach
                            </ol>
                        </div>

                        <div data-appointment-step="1" @if($initialStep !== 1) hidden @endif>
                            <div class="mb-5"><p class="text-xs font-bold uppercase tracking-[.16em] text-optique-red">Étape 1 sur 3</p><h2 tabindex="-1" class="mt-2 font-serif text-2xl sm:text-3xl">Quel est le motif de votre visite ?</h2><p class="mt-2 text-sm text-optique-gray">Choisissez l’option qui se rapproche le plus de votre besoin.</p></div>
                            <fieldset><legend class="sr-only">Motif du rendez-vous</legend><div class="grid gap-3 sm:grid-cols-2">
                                @php $motives = ['examen' => 'Examen de la vue', 'essayage' => 'Essayage de montures', 'retrait' => 'Retrait de lunettes', 'autre' => 'Autre motif']; @endphp
                                @foreach($motives as $value => $label)
                                    <label class="group cursor-pointer"><input type="radio" name="motive" value="{{ $value }}" class="peer sr-only" {{ old('motive') === $value ? 'checked' : '' }} required><span class="flex min-h-[4.5rem] items-center gap-3 rounded-2xl border border-optique-border bg-white p-4 transition duration-200 group-hover:-translate-y-0.5 group-hover:border-[#d9b0a8] peer-checked:border-optique-red peer-checked:bg-[#fff8f6] peer-checked:shadow-md peer-checked:shadow-optique-red/10 peer-focus-visible:ring-2 peer-focus-visible:ring-optique-red"><span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-[#fbefed] text-optique-red"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7" aria-hidden="true"><circle cx="12" cy="12" r="8"/><path stroke-linecap="round" d="M12 8v8m-4-4h8"/></svg></span><span class="flex-1 text-sm font-semibold text-optique-text">{{ $label }}</span><span class="grid h-5 w-5 place-items-center rounded-full border border-optique-border text-[10px] text-white transition peer-checked:bg-optique-red peer-checked:border-optique-red">✓</span></span></label>
                                @endforeach
                            </div>@error('motive')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror</fieldset>
                            <div class="mt-8 flex justify-end"><button type="button" data-step-next="1" class="group inline-flex min-h-12 items-center justify-center gap-3 rounded-full bg-optique-red px-6 py-3 text-sm font-bold text-white shadow-md shadow-optique-red/15 transition duration-300 hover:-translate-y-0.5 hover:bg-optique-redhover">Continuer <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">→</span></button></div>
                        </div>

                        <div data-appointment-step="2" @if($initialStep !== 2) hidden @endif>
                            <div class="mb-5"><p class="text-xs font-bold uppercase tracking-[.16em] text-optique-red">Étape 2 sur 3</p><h2 tabindex="-1" class="mt-2 font-serif text-2xl sm:text-3xl">Quand souhaitez-vous venir ?</h2><p class="mt-2 text-sm text-optique-gray">Choisissez une date et un créneau à proposer à l’équipe.</p></div>
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div><label for="date" class="mb-2 block text-sm font-semibold">Date souhaitée <span class="text-optique-red">*</span></label><input type="date" name="date" id="date" value="{{ old('date') }}" required class="block min-h-12 w-full rounded-xl border border-optique-border bg-[#fcfaf9] px-4 py-3 text-sm outline-none transition focus:border-optique-red focus:bg-white focus:ring-4 focus:ring-optique-red/10">@error('date')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror</div>
                                <div><label for="time" class="mb-2 block text-sm font-semibold">Créneau souhaité <span class="text-optique-red">*</span></label><select name="time" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#A33B36] focus:ring-[#A33B36]">
    <option value="">Choisir un créneau...</option>
    @foreach(config('shop.appointment_slots') as $slot)
        <option value="{{ $slot }}">{{ $slot }}</option>
    @endforeach
</select> @error('time')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror</div>
                            </div>
                            <p class="mt-4 rounded-xl bg-[#fbf8f6] p-3 text-xs leading-5 text-optique-gray"><span class="font-semibold text-optique-text">À noter :</span> le créneau demandé sera confirmé par le magasin selon les disponibilités.</p>
                            <div class="mt-8 flex items-center justify-between"><button type="button" data-step-back="2" class="rounded-full px-4 py-3 text-sm font-semibold text-optique-gray transition hover:bg-optique-bg hover:text-optique-text">← Retour</button><button type="button" data-step-next="2" class="group inline-flex min-h-12 items-center justify-center gap-3 rounded-full bg-optique-red px-6 py-3 text-sm font-bold text-white shadow-md shadow-optique-red/15 transition duration-300 hover:-translate-y-0.5 hover:bg-optique-redhover">Continuer <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">→</span></button></div>
                        </div>

                        <div data-appointment-step="3" @if($initialStep !== 3) hidden @endif>
                            <div class="mb-5"><p class="text-xs font-bold uppercase tracking-[.16em] text-optique-red">Étape 3 sur 3</p><h2 tabindex="-1" class="mt-2 font-serif text-2xl sm:text-3xl">Comment vous joindre ?</h2><p class="mt-2 text-sm text-optique-gray">L’équipe utilisera ces coordonnées pour donner suite à votre demande.</p></div>
                            <div class="space-y-4">
                                <div><label for="name" class="mb-1.5 block text-sm font-semibold">Nom complet <span class="text-optique-red">*</span></label><input type="text" name="name" id="name" value="{{ old('name') }}" autocomplete="name" required class="block min-h-12 w-full rounded-xl border border-optique-border bg-[#fcfaf9] px-4 py-3 text-sm outline-none transition focus:border-optique-red focus:bg-white focus:ring-4 focus:ring-optique-red/10">@error('name')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror</div>
                                <div class="grid gap-4 sm:grid-cols-2"><div><label for="phone" class="mb-1.5 block text-sm font-semibold">Téléphone <span class="text-optique-red">*</span></label><input type="tel" name="phone" id="phone" value="{{ old('phone') }}" autocomplete="tel" inputmode="tel" required class="block min-h-12 w-full rounded-xl border border-optique-border bg-[#fcfaf9] px-4 py-3 text-sm outline-none transition focus:border-optique-red focus:bg-white focus:ring-4 focus:ring-optique-red/10">@error('phone')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror</div><div><label for="email" class="mb-1.5 block text-sm font-semibold">Email <span class="font-normal text-optique-gray">(facultatif)</span></label><input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email" class="block min-h-12 w-full rounded-xl border border-optique-border bg-[#fcfaf9] px-4 py-3 text-sm outline-none transition focus:border-optique-red focus:bg-white focus:ring-4 focus:ring-optique-red/10">@error('email')<p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>@enderror</div></div>
                                <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-optique-border bg-[#fcfaf9] p-4"><input id="consent" name="consent" type="checkbox" value="1" required {{ old('consent') ? 'checked' : '' }} class="mt-0.5 h-4 w-4 rounded border-gray-300 text-optique-red focus:ring-optique-red"><span class="text-xs leading-5 text-optique-gray">J’accepte d’être recontacté(e) par téléphone ou email pour le suivi de cette demande. <span class="text-optique-red">*</span></span></label>@error('consent')<p class="-mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="mt-5 rounded-2xl border border-optique-border bg-[#fbf8f6] p-4"><p class="text-[10px] font-bold uppercase tracking-[.16em] text-optique-red">Récapitulatif de la demande</p><dl class="mt-2 grid grid-cols-2 gap-x-4 gap-y-1 text-xs"><dt class="text-optique-gray">Motif</dt><dd id="summary-motive" class="text-right font-semibold text-optique-text">À choisir</dd><dt class="text-optique-gray">Date</dt><dd id="summary-date" class="text-right font-semibold text-optique-text">À choisir</dd><dt class="text-optique-gray">Créneau</dt><dd id="summary-time" class="text-right font-semibold text-optique-text">À choisir</dd></dl></div>
                            <div class="mt-8 flex items-center justify-between gap-3"><button type="button" data-step-back="3" class="rounded-full px-4 py-3 text-sm font-semibold text-optique-gray transition hover:bg-optique-bg hover:text-optique-text">← Retour</button><button type="submit" class="group inline-flex min-h-12 items-center justify-center gap-2 rounded-full bg-optique-red px-6 py-3 text-sm font-bold text-white shadow-md shadow-optique-red/15 transition duration-300 hover:-translate-y-0.5 hover:bg-optique-redhover">Envoyer ma demande <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">→</span></button></div>
                        </div>
                    </form>
                @endif
            </div>

            <aside class="space-y-4" data-reveal>
                <div class="rounded-3xl border border-optique-border bg-white p-5 shadow-sm sm:p-6"><span class="grid h-11 w-11 place-items-center rounded-2xl bg-[#fbefed] text-optique-red"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 2"/></svg></span><h2 class="mt-4 font-serif text-xl">Demande, puis confirmation</h2><p class="mt-2 text-sm leading-6 text-optique-gray">L’heure choisie est une préférence. L’équipe vous contactera pour confirmer le rendez-vous.</p></div>
                <div class="rounded-3xl bg-[#8f403c] p-5 text-white sm:p-6"><p class="text-xs font-bold uppercase tracking-[.16em] text-white/70">Besoin d’aide ?</p><h2 class="mt-2 font-serif text-xl">On peut aussi en parler.</h2><p class="mt-2 text-sm leading-6 text-white/80">Appelez l’équipe si vous préférez organiser votre visite directement.</p>
<div class="mt-4 space-y-2">
    @foreach(config('shop.phones') as $phone)
        <a href="tel:{{ $phone['tel'] }}" class="flex items-center gap-2 text-sm font-bold hover:underline">
            {{ $phone['display'] }} <span aria-hidden="true">↗</span>
        </a>
    @endforeach
</div>
            </div>
            </aside>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
(() => {
    const form = document.getElementById('appointment-form');
    if (!form) return;
    const steps = [...form.querySelectorAll('[data-appointment-step]')];
    const indicators = [...form.querySelectorAll('[data-step-indicator]')];
    const progress = document.getElementById('step-progress-line');
    let currentStep = Number(form.dataset.initialStep);
    const displayStep = number => {
        currentStep = number;
        steps.forEach(panel => { panel.hidden = Number(panel.dataset.appointmentStep) !== number; });
        indicators.forEach(item => {
            const active = Number(item.dataset.stepIndicator) <= number;
            item.classList.toggle('bg-optique-red', active); item.classList.toggle('text-white', active); item.classList.toggle('border-optique-red', active); item.classList.toggle('shadow-md', active); item.classList.toggle('shadow-optique-red/20', active);
            item.classList.toggle('bg-white', !active); item.classList.toggle('text-optique-gray', !active); item.classList.toggle('border-[#e9e1de]', !active);
        });
        if (progress) progress.style.width = `${(number - 1) * 34}%`;
        const heading = steps.find(panel => Number(panel.dataset.appointmentStep) === number)?.querySelector('h2');
        heading?.focus?.({preventScroll:true});
    };
    const validateCurrentStep = () => {
        const panel = steps.find(item => Number(item.dataset.appointmentStep) === currentStep);
        if (!panel) return true;
        const controls = [...panel.querySelectorAll('input, select, textarea')].filter(control => !control.disabled);
        for (const control of controls) {
            if (!control.checkValidity()) { control.reportValidity(); control.focus(); return false; }
        }
        return true;
    };
    form.querySelectorAll('[data-step-next]').forEach(button => button.addEventListener('click', () => { if (validateCurrentStep()) displayStep(currentStep + 1); }));
    form.querySelectorAll('[data-step-back]').forEach(button => button.addEventListener('click', () => displayStep(currentStep - 1)));
    form.addEventListener('submit', event => { if (!validateCurrentStep()) event.preventDefault(); });
    const dateInput = document.getElementById('date');
    if (dateInput) {
        const today = new Date(); today.setMinutes(today.getMinutes() - today.getTimezoneOffset());
        dateInput.min = today.toISOString().slice(0, 10);
    }
    const updateSummary = () => {
        const selectedMotive = form.querySelector('input[name="motive"]:checked');
        const dateValue = dateInput?.value;
        const timeValue = document.getElementById('time')?.value;
        const motiveLabels = {examen:'Examen de la vue', essayage:'Essayage de montures', retrait:'Retrait de lunettes', autre:'Autre motif'};
        document.getElementById('summary-motive').textContent = selectedMotive ? motiveLabels[selectedMotive.value] || selectedMotive.value : 'À choisir';
        document.getElementById('summary-date').textContent = dateValue ? new Date(`${dateValue}T12:00:00`).toLocaleDateString('fr-FR',{day:'numeric',month:'long',year:'numeric'}) : 'À choisir';
        document.getElementById('summary-time').textContent = timeValue || 'À choisir';
    };
    form.addEventListener('change', updateSummary);
    dateInput?.addEventListener('input', updateSummary);
    updateSummary();
    displayStep(currentStep);
})();
</script>
@endpush
