@extends('layouts.app')

@section('title', 'Dolza Real Properties &amp; Estate Agency | Salima, Malawi')

@section('meta_description', 'Your trusted partner for land, farms and property in Malawi. Buy, build and invest with Malawi\'s most trusted real estate agency.')

@push('head')
<style>
    .hero-slideshow { position:absolute; inset:0; z-index:0; }
    .hero-slide { position:absolute; inset:0; background-size:cover; background-position:center; opacity:0; transition:opacity 1.2s ease; }
    .hero-slide.active { opacity:1; }
</style>
@endpush

@section('content')
    <!-- HERO -->
    <section class="hero">
        <div class="hero-slideshow">
            @php
                $slides = ['property2.jpg','property3.jpg','property4.jpg','property5.jpg','property6.jpg'];
            @endphp
            @foreach($slides as $i => $slide)
                <div class="hero-slide {{ $i === 0 ? 'active' : '' }}" style="background-image:url('{{ asset('images/' . $slide) }}')"></div>
            @endforeach
        </div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <span class="hero-tag">{{ $content['hero']->data['tag'] ?? "Malawi's Trusted Real Estate Agency" }}</span>
            <h1>{{ $content['hero']->data['title'] ?? 'Your Trusted Partner for Land, Farms &amp; Property in Malawi' }}</h1>
            <h2>{{ $content['hero']->data['subtitle'] ?? 'Buy &middot; Build &middot; Invest &mdash; Salima\'s Most Trusted Real Estate Agency' }}</h2>
            <div class="hero-animated-badge">
                <span class="active">Land for Sale</span>
                <span>Farms</span>
                <span>Residential</span>
                <span>Commercial</span>
            </div>
            <div class="hero-btns">
                <button class="btn-primary" onclick="window.location.href='{{ url('/properties') }}'">Browse Properties &rarr;</button>
                <button class="btn-secondary" onclick="window.location.href='{{ url('/contact') }}'">Contact Us</button>
            </div>
        </div>
        <div class="slide-dots" id="slideDots"></div>
    </section>

    <!-- SEARCH -->
    <div class="search-bar">
        <div class="container">
            <div class="search-form">
                <select class="search-dropdown" id="filterType">
                    <option value="">All Property Types</option>
                    <option value="land">Land for Sale</option>
                    <option value="farm">Farms</option>
                    <option value="residential">Residential</option>
                    <option value="commercial">Commercial</option>
                    <option value="rental">Rentals</option>
                </select>
                <select class="search-dropdown" id="filterLocation">
                    <option value="">All Locations</option>
                    <option value="salima">Salima</option>
                    <option value="lilongwe">Lilongwe</option>
                    <option value="blantyre">Blantyre</option>
                    <option value="zomba">Zomba</option>
                    <option value="kasungu">Kasungu</option>
                </select>
                <select class="search-dropdown" id="filterPrice">
                    <option value="">All Prices</option>
                    <option value="0-10">Under MWK 10M</option>
                    <option value="10-20">MWK 10M &ndash; 20M</option>
                    <option value="20-50">MWK 20M &ndash; 50M</option>
                    <option value="50-9999">Over MWK 50M</option>
                </select>
                <button class="btn-search" id="searchBtn">Search</button>
            </div>
        </div>
    </div>

    <!-- CATEGORIES -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">What Are You Looking For?</h2>
            <p class="section-subtitle">Browse our extensive collection of properties across Malawi</p>
            <div class="categories-grid" id="categoriesGrid">
                <div class="category-card reveal reveal-delay-1" onclick="window.location.href='{{ url('/properties?filter=land') }}'"><span class="category-icon">&#127758;</span><h3>Land for Sale</h3><p id="catCount-land">Loading...</p></div>
                <div class="category-card reveal reveal-delay-2" onclick="window.location.href='{{ url('/properties?filter=farms') }}'"><span class="category-icon">&#127806;</span><h3>Farms</h3><p id="catCount-farms">Loading...</p></div>
                <div class="category-card reveal reveal-delay-3" onclick="window.location.href='{{ url('/properties?filter=residential') }}'"><span class="category-icon">&#127968;</span><h3>Residential</h3><p id="catCount-residential">Loading...</p></div>
                <div class="category-card reveal reveal-delay-4" onclick="window.location.href='{{ url('/properties?filter=commercial') }}'"><span class="category-icon">&#127970;</span><h3>Commercial</h3><p id="catCount-commercial">Loading...</p></div>
                <div class="category-card reveal" onclick="window.location.href='{{ url('/properties?filter=rentals') }}'"><span class="category-icon">&#128273;</span><h3>Rentals</h3><p id="catCount-rental">Loading...</p></div>
            </div>
        </div>
    </section>

    <!-- FEATURED PROPERTIES -->
    <section class="section section-dark" id="featuredProperties">
        <div class="container">
            <h2 class="section-title">Featured Properties</h2>
            <p class="section-subtitle">Hand-picked properties from our portfolio</p>
            <div class="properties-grid" id="propertiesGrid">
                @forelse($properties as $i => $property)
                    <div class="property-card reveal reveal-delay-{{ ($i % 4) + 1 }}" data-type="{{ $property->type }}" data-location="{{ strtolower($property->location) }}" data-price="{{ $property->price / 1000000 }}">
                        <div class="property-image">
                            <img src="{{ $property->image ? asset('images/' . $property->image) : asset('images/property1.jpg') }}" alt="{{ $property->name }}">
                            <span class="property-badge sale">For Sale</span>
                        </div>
                        <div class="property-content">
                            <span class="property-type-tag">{{ $property->type_label ?? $property->type }}</span>
                            <h3>{{ $property->name }}</h3>
                            <div class="property-location">&#128205; {{ $property->location }}, Malawi</div>
                            <div class="property-price">MWK {{ number_format($property->price) }}</div>
                            <button class="btn-view" onclick="window.location.href='{{ url('/properties') }}'">View Details <span class="arrow">&rarr;</span></button>
                        </div>
                    </div>
                @empty
                    <div class="no-results" style="grid-column:1/-1;text-align:center;padding:40px;color:var(--text-muted);">&#128270; No featured properties available at the moment.</div>
                @endforelse
                <div class="no-results" id="noResults" style="display:none;grid-column:1/-1;text-align:center;padding:40px;color:var(--text-muted);">&#128270; No properties match your search. Try different filters.</div>
            </div>
        </div>
    </section>

    <!-- SERVICES -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">What We Offer</span>
                <h2 class="section-title">Our Services</h2>
                <p class="section-subtitle">Comprehensive real estate services tailored to your needs</p>
            </div>
            <div class="services-grid">
                @forelse($services as $i => $service)
                    <div class="service-card reveal reveal-delay-{{ ($i % 3) + 1 }}">
                        <div class="service-icon">{!! $service->icon ? '<i class="fas ' . e($service->icon) . '"></i>' : '<i class="fas fa-home"></i>' !!}</div>
                        <h3>{{ $service->title ?? $service->name }}</h3>
                        <p>{{ $service->description ?? $service->content }}</p>
                    </div>
                @empty
                    <div class="service-card reveal reveal-delay-1">
                        <div class="service-icon"><i class="fas fa-home"></i></div>
                        <h3>We Sell Properties</h3>
                        <p>Find your perfect property from our curated selection of premium listings across Malawi.</p>
                    </div>
                    <div class="service-card reveal reveal-delay-2">
                        <div class="service-icon"><i class="fas fa-tag"></i></div>
                        <h3>We Buy Properties</h3>
                        <p>We offer fair prices for your land and property with quick cash purchases and hassle-free transactions.</p>
                    </div>
                    <div class="service-card reveal reveal-delay-3">
                        <div class="service-icon"><i class="fas fa-draw-polygon"></i></div>
                        <h3>Land Surveying</h3>
                        <p>Professional land surveying and boundary marking services with certified surveyors.</p>
                    </div>
                    <div class="service-card reveal reveal-delay-1">
                        <div class="service-icon"><i class="fas fa-file-signature"></i></div>
                        <h3>Title Deed Processing</h3>
                        <p>We handle all title deed and legal documentation for smooth and secure property transactions.</p>
                    </div>
                    <div class="service-card reveal reveal-delay-2">
                        <div class="service-icon"><i class="fas fa-bullhorn"></i></div>
                        <h3>Business Advertisement</h3>
                        <p>Advertise your business to thousands of potential clients across Malawi through our platform.</p>
                    </div>
                    <div class="service-card reveal reveal-delay-3">
                        <div class="service-icon"><i class="fas fa-compass"></i></div>
                        <h3>Property Development Consultation</h3>
                        <p>Expert guidance on land suitability, development potential, and investment opportunities.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- STATS & BENEFITS -->
    <section class="section section-dark">
        <div class="container">
            <h2 class="section-title">Why Choose Dolza?</h2>
            <p class="section-subtitle">Over 8 years of trusted real estate service in Malawi</p>
            <div class="stats-grid" id="statsGrid">
                <div class="stat-card reveal reveal-delay-1"><span class="stat-number" data-target="500" data-suffix="+">0</span><p>Properties Listed</p></div>
                <div class="stat-card reveal reveal-delay-2"><span class="stat-number" data-target="350" data-suffix="+">0</span><p>Happy Clients</p></div>
                <div class="stat-card reveal reveal-delay-3"><span class="stat-number" data-target="8" data-suffix="+">0</span><p>Years Experience</p></div>
                <div class="stat-card reveal reveal-delay-4"><span class="stat-number" data-target="3" data-suffix="">0</span><p>Districts Covered</p></div>
            </div>
            <div class="benefits-grid">
                <div class="benefit-card reveal reveal-delay-1"><h3>Trusted Expertise</h3><p>Over 8 years of experience in the Malawian real estate market with a proven track record.</p></div>
                <div class="benefit-card reveal reveal-delay-2"><h3>Local Knowledge</h3><p>Deep understanding of Salima and surrounding areas, giving you the inside advantage.</p></div>
                <div class="benefit-card reveal reveal-delay-3"><h3>Transparent Process</h3><p>No hidden fees, clear communication throughout your entire property journey.</p></div>
                <div class="benefit-card reveal reveal-delay-4"><h3>Personalized Service</h3><p>Tailored solutions to meet your specific real estate needs and goals.</p></div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Client Testimonials</h2>
            <p class="section-subtitle">Hear from our satisfied clients</p>
            <div class="testimonials-grid">
                @forelse($testimonials as $i => $testimonial)
                    <div class="testimonial-card reveal reveal-delay-{{ ($i % 3) + 1 }}">
                        <div class="stars">{!! str_repeat('&#9733;', $testimonial->rating ?? 5) . str_repeat('&#9734;', 5 - ($testimonial->rating ?? 5)) !!}</div>
                        <p>&quot;{{ $testimonial->content }}&quot;</p>
                        <h4>{{ $testimonial->name }}</h4>
                        <p class="t-location">{{ $testimonial->role ?? $testimonial->location ?? '' }}</p>
                    </div>
                @empty
                    <div class="testimonial-card reveal reveal-delay-1"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p>&quot;Dolza helped me find my dream farm in Salima. Their team was knowledgeable and professional throughout the process.&quot;</p><h4>James M.</h4><p class="t-location">Lilongwe</p></div>
                    <div class="testimonial-card reveal reveal-delay-2"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div><p>&quot;I sold my property quickly with Dolza's assistance. They know the Malawian real estate market inside out.&quot;</p><h4>Grace T.</h4><p class="t-location">Blantyre</p></div>
                    <div class="testimonial-card reveal reveal-delay-3"><div class="stars">&#9733;&#9733;&#9733;&#9733;&#9734;</div><p>&quot;Professional service from start to finish. The team guided me through title deed processing with ease.&quot;</p><h4>Thomas K.</h4><p class="t-location">Zomba</p></div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- VALUATION -->
    <section class="section section-dark">
        <div class="container">
            <div class="two-col">
                <div class="two-col-text reveal">
                    <h2>Get a Free Property Valuation</h2>
                    <p>Wondering what your land or property is worth? Our expert team will give you an accurate, no-obligation valuation &mdash; completely free.</p>
                    <p>We know the Malawian market inside out. Get a realistic price and sell faster.</p>
                    <ul class="perks-list">
                        <li>100% free &mdash; no hidden charges</li>
                        <li>Response within 24 hours</li>
                        <li>Expert knowledge of local market prices</li>
                        <li>No obligation to sell with us</li>
                    </ul>
                </div>
                <div class="two-col-form reveal reveal-delay-2">
                    <h3>Request Your Free Valuation</h3>
                    <p class="form-sub">Fill in the form and we'll be in touch shortly.</p>
                    <form id="valuationForm">
                        <div class="form-row">
                            <div class="form-group"><label>Your Name</label><input type="text" id="val-name" placeholder="e.g. John Banda" required></div>
                            <div class="form-group"><label>Phone / WhatsApp</label><input type="tel" id="val-phone" placeholder="+265 ..." required></div>
                        </div>
                        <div class="form-group"><label>Property Type</label>
                            <select id="val-type" required><option value="">Select type</option><option>Land / Plot</option><option>Farm</option><option>Residential House</option><option>Commercial Property</option><option>Other</option></select>
                        </div>
                        <div class="form-row">
                            <div class="form-group"><label>Location</label><input type="text" id="val-location" placeholder="e.g. Salima Town" required></div>
                            <div class="form-group"><label>Size (approx.)</label><input type="text" id="val-size" placeholder="e.g. 800sqm / 2 acres"></div>
                        </div>
                        <button type="submit" class="btn-primary" style="width:100%;margin-top:4px;">Get My Free Valuation &rarr;</button>
                    </form>
                    <div class="form-success" id="val-success">&#9989; Request received! We'll contact you within 24 hours.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="container">
            <h2>Ready to Find Your Dream Property?</h2>
            <div class="cta-btns">
                <button class="btn-primary" onclick="window.location.href='{{ url('/properties') }}'">Browse Properties</button>
                <button class="btn-secondary" onclick="window.location.href='tel:+265994369985'">Call Us Now</button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    /* Slideshow */
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.getElementById('slideDots');
    let cur = 0;
    slides.forEach((_, i) => { const d = document.createElement('button'); d.className = 'slide-dot' + (i===0?' active':''); d.addEventListener('click', () => go(i)); dots.appendChild(d); });
    function go(n) { slides[cur].classList.remove('active'); dots.children[cur].classList.remove('active'); cur=n; slides[cur].classList.add('active'); dots.children[cur].classList.add('active'); }
    setInterval(() => go((cur+1)%slides.length), 5000);

    /* Animated text */
    const txts = document.querySelectorAll('.hero-animated-badge span'); let ct=0;
    setInterval(() => { txts[ct].classList.remove('active'); ct=(ct+1)%txts.length; txts[ct].classList.add('active'); }, 2200);

    /* Filter */
    function filter() {
        const t=document.getElementById('filterType').value.toLowerCase(), l=document.getElementById('filterLocation').value.toLowerCase(), p=document.getElementById('filterPrice').value;
        let vis=0;
        document.querySelectorAll('#propertiesGrid .property-card').forEach(c => {
            const ok = (!t||c.dataset.type===t) && (!l||c.dataset.location===l) && (!p||(()=>{const[mn,mx]=p.split('-').map(Number);return+c.dataset.price>=mn&&+c.dataset.price<=mx;})());
            c.style.display = ok ? '' : 'none'; if(ok) vis++;
        });
        document.getElementById('noResults').style.display = vis===0?'block':'none';
    }
    document.getElementById('searchBtn').addEventListener('click', () => { filter(); document.getElementById('featuredProperties').scrollIntoView({behavior:'smooth',block:'start'}); });
    ['filterType','filterLocation','filterPrice'].forEach(id => document.getElementById(id).addEventListener('change', filter));

    /* WhatsApp */
    function toggleWa() { document.getElementById('waGreeting').classList.toggle('show'); document.getElementById('waBadge').style.display='none'; }
    setTimeout(() => document.getElementById('waGreeting').classList.add('show'), 4000);

    /* Counters */
    let done=false;
    new IntersectionObserver(es => { if(es[0].isIntersecting&&!done) { done=true; document.querySelectorAll('.stat-number').forEach(el => { const tgt=+el.dataset.target, sfx=el.dataset.suffix||''; let c=0; const t=setInterval(()=>{c+=tgt/60;if(c>=tgt){c=tgt;clearInterval(t);}el.textContent=Math.floor(c)+sfx;},30); }); } },{threshold:0.4}).observe(document.getElementById('statsGrid'));

    /* Valuation */
    document.getElementById('valuationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const msg='Hello Dolza!\n\uD83C\uDFE1 FREE VALUATION REQUEST\nName: '+document.getElementById('val-name').value+'\nPhone: '+document.getElementById('val-phone').value+'\nType: '+document.getElementById('val-type').value+'\nLocation: '+document.getElementById('val-location').value+'\nSize: '+(document.getElementById('val-size').value||'Not specified');
        window.open('https://wa.me/265994369985?text='+encodeURIComponent(msg),'_blank');
        document.getElementById('val-success').style.display='block'; this.reset();
        setTimeout(()=>document.getElementById('val-success').style.display='none',6000);
    });

    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', e => { e.preventDefault(); deferredPrompt = e; });

    /* Categories data */
    const categoriesData = [
        { icon:'\uD83C\uDF0D', name:'Land for Sale', type:'land', filter:'land' },
        { icon:'\uD83C\uDF3E', name:'Farms', type:'farms', filter:'farms' },
        { icon:'\uD83C\uDFE0', name:'Residential', type:'residential', filter:'residential' },
        { icon:'\uD83C\uDFE2', name:'Commercial', type:'commercial', filter:'commercial' },
        { icon:'\uD83D\uDD11', name:'Rentals', type:'rental', filter:'rentals' }
    ];

    function updateCategoryCounts(counts) {
        categoriesData.forEach(function(c) {
            var el = document.getElementById('catCount-' + c.type);
            if (el) {
                var count = counts[c.type] || 0;
                el.textContent = count + ' listing' + (count !== 1 ? 's' : '');
            }
        });
    }

    /* Load dynamic content from API */
    (async function loadDynamic() {
        try {
            const [contRes, propRes, testRes] = await Promise.all([
                fetch('/api/content').then(r=>r.json()).catch(()=>null),
                fetch('/api/properties').then(r=>r.json()).catch(()=>[]),
                fetch('/api/testimonials').then(r=>r.json()).catch(()=>[])
            ]);
            const content = contRes || {};

            /* Render categories with live counts */
            var props = Array.isArray(propRes) ? propRes : (propRes && propRes.value ? propRes.value : []);
            var approved = props.filter(function(p) { return p.status === 'approved'; });
            var counts = {};
            approved.forEach(function(p) {
                var t = p.type === 'rentals' ? 'rental' : p.type;
                counts[t] = (counts[t] || 0) + 1;
            });
            updateCategoryCounts(counts);

            if (content.hero) {
                const h = content.hero;
                const heroTitle = document.querySelector('.hero-content h1');
                const heroSub = document.querySelector('.hero-content h2');
                if (h.title && heroTitle) heroTitle.textContent = h.title;
                if (h.subtitle && heroSub) heroSub.textContent = h.subtitle;
                if (h.buttonText) { const btns = document.querySelectorAll('.hero-btns .btn-primary'); if (btns.length) btns[0].textContent = h.buttonText; }
                if (h.buttonLink) { const btns = document.querySelectorAll('.hero-btns .btn-primary'); if (btns.length) btns[0].onclick = function(){window.location.href=h.buttonLink}; }
                if (h.badge) { const badge = document.querySelector('.hero-animated-badge span.active'); if (badge) badge.textContent = h.badge; }
                if (h.backgroundImage) {
                    document.querySelectorAll('.hero-slideshow .hero-slide').forEach(function(sl) {
                        sl.style.backgroundImage = "url('" + h.backgroundImage + "')";
                    });
                }
            }

            if (content.services && content.services.length) {
                const grid = document.querySelector('.services-grid');
                if (grid) {
                    grid.innerHTML = content.services.map((s, i) =>
                        '<div class="service-card reveal reveal-delay-' + ((i%3)+1) + '">' +
                        '<div class="service-icon">' + (s.icon ? '<i class="fas ' + s.icon + '"></i>' : '<i class="fas fa-home"></i>') + '</div>' +
                        '<h3>' + s.title + '</h3>' +
                        '<p>' + s.description + '</p></div>'
                    ).join('');
                    grid.querySelectorAll('.service-card').forEach(c => c.classList.add('visible'));
                }
            }

            if (content.about && content.about.stats) {
                const cards = document.querySelectorAll('#statsGrid .stat-card');
                content.about.stats.forEach((st, i) => {
                    if (cards[i]) {
                        const num = cards[i].querySelector('.stat-number');
                        const lab = cards[i].querySelector('p');
                        if (num) { num.dataset.target = st.number.replace('+',''); num.dataset.suffix = st.number.includes('+') ? '+' : ''; }
                        if (lab) lab.textContent = st.label;
                    }
                });
            }

            if (testRes && testRes.length) {
                const grid = document.querySelector('.testimonials-grid');
                if (grid) {
                    grid.innerHTML = testRes.map((t, i) =>
                        '<div class="testimonial-card reveal reveal-delay-' + ((i%3)+1) + '"><div class="stars">' + '\u2605'.repeat(t.rating||5) + '\u2606'.repeat(5-(t.rating||5)) + '</div><p>"' + t.content + '"</p><h4>' + t.name + '</h4><p class="t-location">' + (t.role||'') + '</p></div>'
                    ).join('');
                    grid.querySelectorAll('.testimonial-card').forEach(c => c.classList.add('visible'));
                }
            }

            if (content.footer) {
                const f = content.footer;
                const footerAbout = document.querySelector('footer .footer-column:first-child p');
                if (f.about && footerAbout) footerAbout.textContent = f.about;
                const contactLis = document.querySelectorAll('footer .contact-info li');
                if (f.address && contactLis[0]) contactLis[0].textContent = '\uD83D\uDCCD ' + f.address;
                if (f.phone && contactLis[1]) contactLis[1].textContent = '\uD83D\uDCDE ' + f.phone;
                if (f.email && contactLis[3]) contactLis[3].textContent = '\u2709\uFE0F ' + f.email;
            }

            const approved = (Array.isArray(propRes) ? propRes : []).filter(p => p.status === 'approved');
            const featured = approved.filter(p => p.featured);
            if (featured.length) {
                const grid = document.getElementById('propertiesGrid');
                const noResults = document.getElementById('noResults');
                grid.innerHTML = '';
                featured.forEach((p, i) => {
                    const priceText = p.type === 'rentals' ? 'MWK ' + Number(p.price).toLocaleString() + '/mo' : 'MWK ' + Number(p.price).toLocaleString();
                    const details = p.area || p.details || '';
                    const delay = (i % 4) + 1;
                    grid.innerHTML += '<div class="property-card reveal reveal-delay-' + delay + '" data-type="' + (p.type==='rentals'?'rental':p.type) + '" data-location="' + p.location.toLowerCase() + '" data-price="' + (p.price/1000000).toFixed(1) + '">' +
                        '<div class="property-image"><img src="' + (p.image || '{{ asset('images/property1.jpg') }}') + '" alt="' + p.name + '"><span class="property-badge sale">For Sale</span></div>' +
                        '<div class="property-content">' +
                        '<span class="property-type-tag">' + (p.type||'Property') + '</span>' +
                        '<h3>' + p.name + '</h3><div class="property-location">\uD83D\uDCCD ' + p.location + ', Malawi</div>' +
                        '<div class="property-price">' + priceText + '</div>' +
                        '<button class="btn-view" onclick="window.location.href=\'{{ url('/properties') }}\'">View Details <span class="arrow">\u2192</span></button></div></div>';
                });
                if (noResults) grid.appendChild(noResults);
                grid.querySelectorAll('.property-card').forEach(c => c.classList.add('visible'));
            }
        } catch(e) {}
    })();
</script>
@endpush
