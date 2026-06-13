@extends('layouts.app')

@section('title', 'Properties - Dolza Real Properties &amp; Estate Agency')

@section('meta_description', 'Browse premium land, farms, residential and commercial properties for sale and rent in Malawi. Dolza Real Properties &amp; Estate Agency.')

@push('head')
<style>
    .bg-slideshow { position:fixed; top:0; left:0; width:100%; height:100%; z-index:-1; overflow:hidden; }
    .bg-slide { position:absolute; top:0; left:0; width:100%; height:100%; background-size:cover; background-position:center; opacity:0; transition:opacity 2.5s ease-in-out; }
    .bg-slide.active { opacity:0.1; }
    .no-results { text-align:center; padding:80px 20px; color:var(--text-muted); }
    .no-results .empty-icon { font-size:4rem; margin-bottom:20px; opacity:0.3; display:block; }
    .no-results h3 { color:#fff; font-size:1.4rem; margin-bottom:10px; }
    .empty-state { text-align:center; padding:80px 20px; color:var(--text-muted); }
    @keyframes pcardIn { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:none; } }
    #propertiesGrid .property-card { opacity:1; }
    #propertiesGrid .property-card.pcard-in { animation: pcardIn 0.6s ease both; }
    @media (prefers-reduced-motion: reduce) { #propertiesGrid .property-card.pcard-in { animation:none; } }
</style>
@endpush

@section('content')
    <div class="bg-slideshow">
        @php
            $bgSlides = ['property1.jpg','property2.jpg','property3.jpg','property4.jpg','property5.jpg','property6.jpg'];
        @endphp
        @foreach($bgSlides as $i => $slide)
            <div class="bg-slide {{ $i === 0 ? 'active' : '' }}" style="background-image:url('{{ asset('images/' . $slide) }}')"></div>
        @endforeach
    </div>

    <section class="hero" style="min-height:65vh;">
        <div class="hero-particles" id="heroParticles"></div>
        <div class="hero-content">
            <span class="hero-tag">Premium Listings</span>
            <h1>Discover Your Perfect Property</h1>
            <p class="hero-subtitle" style="color:var(--text-secondary);font-size:1.15rem;margin:0 auto 30px;max-width:550px;font-weight:300;line-height:1.7;">Explore land, farms, residential and commercial properties across Malawi with Dolza Real Properties &amp; Estate Agency</p>
            <div class="hero-stats">
                <div class="hero-stat"><span class="stat-number" data-target="{{ $properties->count() }}">0</span><span class="stat-label">Properties</span></div>
                <div class="hero-stat"><span class="stat-number" data-target="12">0</span><span class="stat-label">Districts</span></div>
                <div class="hero-stat"><span class="stat-number" data-target="98">0</span><span class="stat-label">% Satisfied</span></div>
            </div>
        </div>
    </section>

    <div class="filter-section">
        <div class="filter-bar" id="filterBar">
            <button class="filter-btn active" data-filter="all">All Properties</button>
            <button class="filter-btn" data-filter="land">&#127758; Land</button>
            <button class="filter-btn" data-filter="farms">&#127806; Farms</button>
            <button class="filter-btn" data-filter="residential">&#127968; Residential</button>
            <button class="filter-btn" data-filter="commercial">&#127970; Commercial</button>
            <button class="filter-btn" data-filter="rentals">&#128273; Rentals</button>
        </div>
    </div>

    <section class="section" style="padding:30px 0 80px;">
        <div class="container">
            <div class="results-info" id="resultsInfo"></div>
            <div id="propertiesGrid" class="properties-grid"></div>
            <div class="empty-state" id="emptyState" style="display:none;">
                <span class="empty-icon">&#128270;</span>
                <h3>No Properties Found</h3>
                <p style="color:var(--text-muted);">No properties match your current filter. Try a different category.</p>
            </div>
        </div>
    </section>

    <!-- Property Modal -->
    <div class="modal-overlay" id="propertyModal">
        <div class="modal-box">
            <button class="modal-close" onclick="closeModal()">&times;</button>
            <img class="modal-image" id="modalImage" src="" alt="Property">
            <div class="modal-body">
                <div id="modalContent"></div>
                <a id="whatsappEnquiry" class="btn-wa" href="#" target="_blank" style="width:100%;justify-content:center;padding:14px;margin-top:20px;border-radius:12px;">&#128172; Enquire on WhatsApp</a>
                <a class="btn-secondary" href="tel:+265994369985" style="width:100%;justify-content:center;padding:14px;margin-top:10px;border-radius:12px;">&#128222; Call Us Directly</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const particlesContainer = document.getElementById('heroParticles');
        for (let i = 0; i < 30; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = (Math.random() * 100 + 100) + '%';
            particle.style.width = (Math.random() * 4 + 2) + 'px';
            particle.style.height = particle.style.width;
            particle.style.animationDuration = (Math.random() * 8 + 6) + 's';
            particle.style.animationDelay = (Math.random() * 6) + 's';
            particlesContainer.appendChild(particle);
        }

        const statNumbers = document.querySelectorAll('.hero-stat .stat-number[data-target]');
        const animateStats = () => {
            statNumbers.forEach(stat => {
                const target = parseInt(stat.getAttribute('data-target'));
                const step = target / (2000 / 16);
                let current = 0;
                const counter = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        stat.textContent = target + '+';
                        clearInterval(counter);
                    } else {
                        stat.textContent = Math.floor(current);
                    }
                }, 16);
            });
        };
        const heroObserver = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) { animateStats(); heroObserver.disconnect(); }
            });
        }, { threshold: 0.3 });
        const heroSection = document.querySelector('.hero');
        if (heroSection) heroObserver.observe(heroSection);

        loadProperties().then(function() {
            var params = new URLSearchParams(window.location.search);
            var filter = params.get('filter');
            if (filter) {
                var targetBtn = document.querySelector('.filter-btn[data-filter="' + filter + '"]');
                if (targetBtn) {
                    document.querySelectorAll('.filter-btn').forEach(function(b) { b.classList.remove('active'); });
                    targetBtn.classList.add('active');
                    filterProperties(filter);
                }
            }
        });

        document.querySelectorAll('.filter-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(function(b) { b.classList.remove('active'); });
                this.classList.add('active');
                filterProperties(this.getAttribute('data-filter'));
            });
        });

        const slides = document.querySelectorAll('.bg-slide');
        let currentSlide = 0;
        setInterval(() => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }, 5000);

        const modalOverlay = document.getElementById('propertyModal');
        modalOverlay.addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    });

    const defaultProperties = @json($properties->map(function($p) {
        return [
            'id' => (string)$p->id,
            'name' => $p->name,
            'location' => $p->location,
            'price' => (float)$p->price,
            'type' => $p->type,
            'status' => $p->status ?? 'approved',
            'size' => $p->size ?? '',
            'image' => $p->image ? asset('images/' . $p->image) : asset('images/property1.jpg'),
            'desc' => $p->description ?? '',
        ];
    })->toArray() ?: [
        { id:'1', name:'Prime Plot - Area 47', location:'Lilongwe', price:8500000, type:'land', status:'approved', size:'800 sqm', image:'{{ asset('images/property1.jpg') }}', desc:'A prime residential plot in the heart of Area 47, Lilongwe.'},
        { id:'2', name:'Farm Land - Salima', location:'Salima', price:25000000, type:'farms', status:'approved', size:'5 acres', image:'{{ asset('images/property2.jpg') }}', desc:'Fertile farmland in Salima district, ideal for commercial farming.'},
        { id:'3', name:'3 Bedroom House', location:'Salima', price:18000000, type:'residential', status:'approved', size:'3 beds · 2 baths', image:'{{ asset('images/property3.jpg') }}', desc:'A beautifully built 3-bedroom residential house.'},
        { id:'4', name:'Commercial Plot', location:'Blantyre', price:35000000, type:'commercial', status:'approved', size:'1200 sqm', image:'{{ asset('images/property4.jpg') }}', desc:'A strategically located commercial plot in Blantyre.'},
        { id:'5', name:'Residential Plot', location:'Zomba', price:6500000, type:'land', status:'approved', size:'600 sqm', image:'{{ asset('images/property5.jpg') }}', desc:'An affordable residential plot in Zomba.'},
        { id:'6', name:'Agriculture Farm', location:'Kasungu', price:45000000, type:'farms', status:'approved', size:'12 acres', image:'{{ asset('images/property6.jpg') }}', desc:'A large-scale agriculture farm in Kasungu.'},
        { id:'7', name:'2 Bedroom House for Rent', location:'Salima', price:120000, type:'rentals', status:'approved', size:'2 beds · 1 bath', image:'{{ asset('images/property2.jpg') }}', desc:'A cozy 2-bedroom rental house.'},
        { id:'8', name:'Shop Space - Town Centre', location:'Salima', price:85000, type:'commercial', status:'approved', size:'45 sqm', image:'{{ asset('images/property4.jpg') }}', desc:'Prime shop space in Salima Town Centre.'},
        { id:'9', name:'Large Farm - Dowa', location:'Dowa', price:60000000, type:'farms', status:'approved', size:'20 acres', image:'{{ asset('images/large_dowa_farm.png') }}', desc:'A massive farm in Dowa district.'},
    ];

    function getTypeLabel(type) {
        const labels = { 'land':'Land for Sale', 'farms':'Farm Land', 'residential':'Residential', 'commercial':'Commercial', 'rentals':'Rental Property' };
        return labels[type] || type;
    }

    let allProperties = [];

    function loadProperties() {
        return new Promise(function(resolve) {
            (async function() {
                let properties;
                try {
                    const apiProps = await fetch('/api/properties').then(r => r.json());
                    const approved = apiProps.filter(p => p.status === 'approved');
                    properties = approved.length > 0 ? approved : defaultProperties;
                } catch(e) {
                    const stored = JSON.parse(localStorage.getItem('properties')) || [];
                    const approved = stored.filter(p => p.status === 'approved');
                    properties = approved.length > 0 ? approved : defaultProperties;
                }
                allProperties = properties;
                const grid = document.getElementById('propertiesGrid');
                grid.innerHTML = '';
                properties.forEach((p, i) => { grid.innerHTML += createPropertyCard(p, i); });
                updateResultsInfo(properties.length, 'All Properties');
                resolve();
            })();
        });
    }

    function updateResultsInfo(count, category) {
        const info = document.getElementById('resultsInfo');
        if (info) info.innerHTML = 'Showing <span>' + count + '</span> ' + (count === 1 ? 'property' : 'properties') + ' in <span>' + category + '</span>';
    }

    function createPropertyCard(p, idx) {
        const badgeType = p.type === 'rentals' ? 'rent' : 'sale';
        const badgeText = p.type === 'rentals' ? 'For Rent' : 'For Sale';
        const priceText = p.type === 'rentals' ? 'MWK ' + Number(p.price).toLocaleString() + '/mo' : 'MWK ' + Number(p.price).toLocaleString();
        const sz = p.size || p.area || '';
        return '<div class="property-card pcard-in" style="animation-delay:' + (idx * 70) + 'ms" data-category="' + p.type + '" data-status="' + (p.status||'approved') + '">' +
            '<div class="property-image"><img src="' + (p.image || '{{ asset('images/property1.jpg') }}') + '" alt="' + p.name + '" loading="lazy" onerror="this.parentElement.style.background=\'linear-gradient(135deg,#1a1a2e,#0a0a0f)\'; this.style.display=\'none\'">' +
            '<span class="property-badge ' + badgeType + '">' + badgeText + '</span>' +
            '<div class="property-fav" onclick="toggleFav(this)" title="Save property">&#129293;</div></div>' +
            '<div class="property-content">' +
            '<span class="property-type-tag">' + getTypeIcon(p.type) + ' ' + getTypeLabel(p.type) + '</span>' +
            '<h3>' + p.name + '</h3>' +
            '<div class="property-location">&#128205; ' + p.location + ', Malawi</div>' +
            '<div class="property-price">' + priceText + '</div>' +
            '<div class="property-meta"><span class="meta-item"><span class="meta-icon">&#128144;</span> ' + sz + '</span><span class="meta-item"><span class="meta-icon">&#128203;</span> ' + (p.type==='rentals'?'Monthly':'Outright') + '</span></div>' +
            '<button class="btn-view" onclick="viewPropertyDetails(\'' + p.id + '\')">View Details <span class="arrow">&#8594;</span></button></div></div>';
    }

    function getTypeIcon(type) {
        const icons = { 'land':'&#127758;', 'farms':'&#127806;', 'residential':'&#127968;', 'commercial':'&#127970;', 'rentals':'&#128273;' };
        return icons[type] || '&#127968;';
    }

    function toggleFav(el) {
        el.classList.toggle('liked');
        el.textContent = el.classList.contains('liked') ? '&#10084;&#65039;' : '&#129293;';
    }

    function filterProperties(category) {
        const cards = document.querySelectorAll('.property-card');
        let visibleCount = 0;
        const labels = { 'all':'All Properties', 'land':'Land for Sale', 'farms':'Farms', 'residential':'Residential', 'commercial':'Commercial', 'rentals':'Rentals' };
        cards.forEach((card, i) => {
            const cat = card.getAttribute('data-category');
            if (category === 'all' || cat === category) {
                card.style.display = '';
                card.classList.remove('pcard-in');
                void card.offsetWidth;
                card.style.animationDelay = (visibleCount * 60) + 'ms';
                card.classList.add('pcard-in');
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        const emptyState = document.getElementById('emptyState');
        if (emptyState) emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        updateResultsInfo(visibleCount, labels[category] || category);
    }

    function viewPropertyDetails(propertyId) {
        const p = allProperties.find(x => String(x.id) === String(propertyId)) ||
                  defaultProperties.find(x => String(x.id) === String(propertyId));
        if (!p) return;
        const priceText = p.type === 'rentals' ? 'MWK ' + Number(p.price).toLocaleString() + '/month' : 'MWK ' + Number(p.price).toLocaleString();
        document.getElementById('modalImage').src = p.image || '{{ asset('images/property1.jpg') }}';
        document.getElementById('modalImage').alt = p.name;
        document.getElementById('modalContent').innerHTML = '<h2>' + p.name + '</h2><p class="modal-price">' + priceText + '</p><p class="modal-location">&#128205; ' + p.location + ', Malawi</p><p class="modal-size">&#128144; ' + (p.size || p.area || '') + '</p><hr class="modal-divider"><p class="modal-desc">' + (p.desc || p.details || 'This property is listed by <strong>Dolza Real Properties &amp; Estate Agency</strong>. Contact us today for viewing and more information.') + '</p>';
        document.getElementById('whatsappEnquiry').href = 'https://wa.me/265994369985?text=' + encodeURIComponent('Hello Dolza, I am interested in: ' + p.name + ' in ' + p.location + ' priced at ' + priceText);
        document.getElementById('propertyModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('propertyModal').classList.remove('active');
        document.body.style.overflow = '';
    }

    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', e => { e.preventDefault(); deferredPrompt = e; });
</script>
@endpush
