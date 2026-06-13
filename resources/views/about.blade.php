@extends('layouts.app')

@section('title', 'About Us - Dolza Real Properties &amp; Estate Agency')

@section('meta_description', 'Learn about Dolza Real Properties &amp; Estate Agency, Malawi\'s most trusted real estate partner since 2016.')

@section('content')
    <section class="hero">
        <div class="about-hero" id="aboutHero"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content" style="position:relative;z-index:2;">
            <span class="hero-tag">Since 2016</span>
            <h1>{{ $content['about']->data['heading'] ?? 'About Dolza Real Estate' }}</h1>
            <h2>{{ $content['about']->data['subheading'] ?? 'Your Trusted Partner for Land and Property Solutions in Malawi' }}</h2>
        </div>
    </section>

    <div class="container" style="padding: 80px 20px 60px;">
        <section class="company-story">
            <div class="story-content">
                <h2>Our Story</h2>
                <p>{{ $content['about']->data['content'] ?? "Established in 2016, Dolza Real Properties &amp; Estate Agency has grown to become Salima's most trusted real estate partner. Founded by Malawian real estate expert Patrick Weston Kamefu, our agency was born from a vision to provide professional, transparent, and reliable property services across Malawi." }}</p>
                <p>{{ $content['about']->data['content_2'] ?? "Over the past 8+ years, we've helped hundreds of clients buy, sell, and develop properties throughout Salima, Lilongwe, Blantyre, and beyond. Our deep local knowledge combined with professional expertise makes us the go-to agency for all real estate needs in Malawi." }}</p>
            </div>
            <div class="story-image">
                <img src="{{ asset('images/office.jpg') }}" alt="Dolza Office" onerror="this.style.display='none'">
                <div class="overlay-text">Your Partner in Malawian Real Estate Since 2016</div>
            </div>
        </section>

        <section class="mission-vision">
            <div class="mv-card">
                <h2>Our Mission</h2>
                <p>{{ $content['about']->data['mission'] ?? 'To provide exceptional real estate services that empower our clients to make informed decisions about their property investments, while maintaining the highest standards of professionalism and integrity in the Malawian market.' }}</p>
            </div>
            <div class="mv-card">
                <h2>Our Vision</h2>
                <p>{{ $content['about']->data['vision'] ?? 'To be the most trusted and recognizable real estate brand across Malawi, expanding our services while maintaining our commitment to personalized, client-focused service.' }}</p>
            </div>
        </section>

        <section class="section" style="padding:0 0 60px;">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">What We Offer</span>
                    <h2 class="section-title">Our Services</h2>
                    <p class="section-subtitle">Comprehensive real estate services tailored to your needs</p>
                </div>
                <div class="services-grid">
                    @php $services = $content['services']->data ?? []; @endphp
                    @forelse($services as $i => $service)
                        <div class="service-card reveal reveal-delay-{{ ($i % 3) + 1 }}">
                            <div class="service-icon">{!! $service['icon'] ? '<i class="fas ' . e($service['icon']) . '"></i>' : '<i class="fas fa-home"></i>' !!}</div>
                            <h3>{{ $service['title'] }}</h3>
                            <p>{{ $service['description'] }}</p>
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

        <section class="team-section">
            <h2>Our Team</h2>
            <div class="team-grid">
                @forelse($team as $member)
                    <div class="team-member">
                        <div class="member-image">
                            <img src="{{ $member->image ? asset('images/' . $member->image) : asset('images/logo.png') }}" alt="{{ $member->name }}" onerror="this.style.display='none'">
                            <div class="member-overlay">{{ $member->role }}</div>
                        </div>
                        <h3>{{ $member->name }}</h3>
                        <span class="member-role">{{ $member->role }}</span>
                        <p>{{ $member->bio ?? $member->description ?? '' }}</p>
                    </div>
                @empty
                    <div class="team-member">
                        <div class="member-image">
                            <img src="{{ asset('images/patrick.jpg') }}" alt="Patrick Kamefu" onerror="this.style.display='none'">
                            <div class="member-overlay">CEO &amp; Founder</div>
                        </div>
                        <h3>Patrick Weston Kamefu</h3>
                        <span class="member-role">Real Estate Specialist</span>
                        <p>With over 15 years of experience in the Malawian real estate market, Patrick brings deep local knowledge and an extensive network of contacts.</p>
                    </div>
                    <div class="team-member">
                        <div class="member-image">
                            <img src="{{ asset('images/grace.jpg') }}" alt="Grace Kamangale" onerror="this.style.display='none'">
                            <div class="member-overlay">Head Surveyor</div>
                        </div>
                        <h3>Grace Kamangale</h3>
                        <span class="member-role">Certified Land Surveyor</span>
                        <p>Grace has been with Dolza since 2018 and brings precision and expertise to every surveying project across Central Malawi.</p>
                    </div>
                    <div class="team-member">
                        <div class="member-image">
                            <img src="{{ asset('images/james.jpg') }}" alt="James Chidalo" onerror="this.style.display='none'">
                            <div class="member-overlay">Legal Advisor</div>
                        </div>
                        <h3>James Chidalo</h3>
                        <span class="member-role">Property Lawyer</span>
                        <p>James handles all title deed processing and legal documentation, ensuring every transaction complies with Malawian property law.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <section>
            <h2 class="section-title" style="margin-bottom:40px;">Our Achievements</h2>
            <div class="stats-grid">
                <div class="stat-card"><span class="stat-number">8+</span><p>Years Experience</p></div>
                <div class="stat-card"><span class="stat-number">500+</span><p>Properties Sold</p></div>
                <div class="stat-card"><span class="stat-number" style="font-size:2.4rem;">350+</span><p>Satisfied Clients</p></div>
                <div class="stat-card"><span class="stat-number">3</span><p>Districts Covered</p></div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script>
    (function initAboutHero() {
        const heroContainer = document.getElementById('aboutHero');
        if (!heroContainer) return;
        const images = [
            '{{ asset('images/about-page-images/IMG-20260327-WA0010.jpg') }}',
            '{{ asset('images/about-page-images/IMG_20251231_175202.jpg') }}',
            '{{ asset('images/about-page-images/IMG-20260205-WA0000.jpg') }}',
            '{{ asset('images/about-page-images/IMG-20260217-WA0009.jpg') }}',
            '{{ asset('images/about-page-images/IMG-20260411-WA0002.jpeg') }}',
            '{{ asset('images/about-page-images/IMG-20260411-WA0000.jpeg') }}'
        ];
        let idx = 0;
        images.forEach((src, i) => {
            const img = document.createElement('img');
            img.src = src;
            img.alt = 'About image ' + (i+1);
            if (i === 0) img.classList.add('active');
            img.addEventListener('error', () => img.style.display = 'none');
            heroContainer.appendChild(img);
        });
        setInterval(() => {
            const imgs = heroContainer.querySelectorAll('img');
            if (!imgs.length) return;
            imgs[idx].classList.remove('active');
            idx = (idx + 1) % imgs.length;
            imgs[idx].classList.add('active');
        }, 3500);
    })();

    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', e => { e.preventDefault(); deferredPrompt = e; });

    (async function loadDynamic() {
        try {
            const [contRes, teamRes] = await Promise.all([
                fetch('/api/content').then(r=>r.json()).catch(()=>null),
                fetch('/api/team').then(r=>r.json()).catch(()=>[])
            ]);
            const content = contRes || {};

            if (content.about) {
                const a = content.about;
                const storyHeading = document.querySelector('.story-content h2');
                if (a.heading && storyHeading) storyHeading.textContent = a.heading;
                const storyParas = document.querySelectorAll('.story-content p');
                if (a.content && storyParas.length) storyParas[0].textContent = a.content;
            }

            if (content.about && content.about.stats) {
                const cards = document.querySelectorAll('.stats-grid .stat-card');
                content.about.stats.forEach((st, i) => {
                    if (cards[i]) {
                        const num = cards[i].querySelector('.stat-number');
                        const p = cards[i].querySelector('p');
                        if (num) num.textContent = st.number;
                        if (p) p.textContent = st.label;
                    }
                });
            }

            if (content.services && content.services.length) {
                const grids = document.querySelectorAll('.services-grid');
                if (grids.length) {
                    grids[0].innerHTML = content.services.map((s, i) =>
                        '<div class="service-card reveal visible reveal-delay-' + ((i % 3) + 1) + '"><div class="service-icon">' + (s.icon ? '<i class="fas ' + s.icon + '"></i>' : '<i class="fas fa-home"></i>') + '</div><h3>' + s.title + '</h3><p>' + s.description + '</p></div>'
                    ).join('');
                }
            }

            if (teamRes && teamRes.length) {
                const grid = document.querySelector('.team-grid');
                if (grid) {
                    grid.innerHTML = teamRes.map(m =>
                        '<div class="team-member"><div class="member-image"><img src="' + (m.image || '{{ asset('images/logo.png') }}') + '" alt="' + m.name + '" onerror="this.style.display=\'none\'"><div class="member-overlay">' + m.role + '</div></div><h3>' + m.name + '</h3><span class="member-role">' + m.role + '</span><p>' + (m.bio || '') + '</p></div>'
                    ).join('');
                }
            }

            if (content.footer) {
                const f = content.footer;
                const footerParas = document.querySelectorAll('footer .footer-column p');
                if (f.about && footerParas.length) footerParas[0].textContent = f.about;
                const contactLis = document.querySelectorAll('footer .contact-info li');
                if (f.address && contactLis.length) contactLis[0].textContent = '\uD83D\uDCCD ' + f.address;
                if (f.phone && contactLis.length > 1) contactLis[1].textContent = '\uD83D\uDCDE ' + f.phone;
                if (f.email && contactLis.length > 3) contactLis[3].textContent = '\u2709\uFE0F ' + f.email;
            }
        } catch(e) {}
    })();
</script>
@endpush
