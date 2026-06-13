@php $siteName = \App\Models\Setting::where('key', 'siteName')->value('value'); $siteTitle = $siteName ?? 'Dolza Real Properties &amp; Estate Agency'; @endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $siteTitle)</title>
    <meta name="description" content="@yield('meta_description', 'Your trusted partner for land, farms and property in Malawi. Buy, build and invest with Malawi\'s most trusted real estate agency.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="apple-touch-icon" href="/images/apple-touch-icon.png">
    <meta name="theme-color" content="#0a0a0f">
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('head')
</head>
<body>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="container">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Dolza Logo">
                <div class="logo-text">
                    <span class="logo-main">DOLZA</span>
                    <span class="logo-sub">Real Properties & Estate Agency</span>
                </div>
            </a>
            <div class="nav-inner">
                <ul class="nav-links" id="navLinks">
                    <li><a href="{{ url('/') }}" @if(Route::currentRouteNamed('home')) class="active" @endif>Home</a></li>
                    <li><a href="{{ url('/properties') }}" @if(Route::currentRouteNamed('properties')) class="active" @endif>Properties</a></li>
                    <li><a href="{{ url('/about') }}" @if(Route::currentRouteNamed('about')) class="active" @endif>About</a></li>
                    <li><a href="{{ url('/contact') }}" @if(Route::currentRouteNamed('contact')) class="active" @endif>Contact</a></li>
                </ul>
                <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
            </div>
        </div>
    </header>

    @yield('content')

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-column">
                    <a href="{{ url('/') }}" class="footer-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Dolza">
                        <div class="logo-text"><span class="logo-main">DOLZA</span><span class="logo-sub">Real Properties & Estate Agency</span></div>
                    </a>
                    <p>Your trusted partner for real estate solutions in Malawi. Buy · Build · Invest with confidence.</p>
                    <div class="footer-socials">
                        <a href="https://facebook.com/dolzarealproperties" target="_blank" class="btn-fb">Facebook</a>
                        <a href="https://wa.me/265994369985" target="_blank" class="btn-wa">WhatsApp</a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/properties') }}">Properties</a></li>
                        <li><a href="{{ url('/about') }}">About Us</a></li>
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Our Services</h3>
                    <ul>
                        <li><a href="#">We Sell Properties</a></li>
                        <li><a href="#">We Buy Properties</a></li>
                        <li><a href="#">Land Surveying</a></li>
                        <li><a href="#">Title Deed Processing</a></li>
                        <li><a href="#">Business Advertisement</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contact Info</h3>
                    <ul class="contact-info">
                        <li id="footerAddress">📍 Salima Office, Malawi</li>
                        <li id="footerPhone1">📞 +265 994 369 985</li>
                        <li id="footerPhone2">📞 +265 882 995 600</li>
                        <li id="footerEmail">✉️ dolzaestateagency@gmail.com</li>
                        <li>📘 Dolza real properties & estate agency</li>
                    </ul>
                    <div class="hours">
                        <h4>Working Hours</h4>
                        <p>Mon–Fri: 8:00 AM – 5:00 PM<br>Sat: 9:00 AM – 1:00 PM<br>Sun: Closed</p>
                    </div>
                </div>
            </div>
            <div class="copyright"><p>&copy; 2026 Dolza Real Properties & Estate Agency. All Rights Reserved.</p></div>
        </div>
    </footer>

    <button class="back-to-top" id="backToTop">&uarr;</button>

    <!-- WHATSAPP -->
    <div class="wa-widget">
        <div class="wa-greeting" id="waGreeting">
            <button class="wa-close" onclick="document.getElementById('waGreeting').classList.remove('show')">&times;</button>
            <div class="wa-greeting-header">
                <div class="wa-avatar">&#128172;</div>
                <div><span class="wa-name">Dolza Real Estate</span><span class="wa-status"><span class="wa-dot"></span> Online now</span></div>
            </div>
            <p>Hello! Looking to buy, sell or get a free valuation? Chat with us &mdash; we reply fast!</p>
            <a class="wa-chat-link" href="https://wa.me/265994369985?text=Hello%20Dolza!%20I%27d%20like%20to%20enquire%20about%20a%20property." target="_blank">Start Chat &rarr;</a>
        </div>
        <button class="wa-btn" onclick="toggleWa()" aria-label="Chat on WhatsApp">
            <span class="wa-badge" id="waBadge">1</span>
            <svg viewBox="0 0 32 32"><path fill="white" d="M16 2.667C8.636 2.667 2.667 8.636 2.667 16c0 2.348.636 4.55 1.745 6.453L2.667 29.333l7.08-1.703A13.267 13.267 0 0016 29.333c7.364 0 13.333-5.97 13.333-13.333S23.364 2.667 16 2.667zm0 24A10.617 10.617 0 019.96 24.8l-.373-.24-3.867.933.973-3.76-.267-.4A10.597 10.597 0 015.333 16C5.333 10.12 10.12 5.333 16 5.333S26.667 10.12 26.667 16 21.88 26.667 16 26.667zm5.84-7.893c-.32-.16-1.893-.933-2.187-1.04-.293-.107-.507-.16-.72.16-.213.32-.827 1.04-.987 1.227-.16.186-.346.213-.666.053-.32-.16-1.347-.493-2.56-1.573-.947-.84-1.587-1.88-1.774-2.2-.186-.32-.02-.493.14-.653.147-.147.32-.373.48-.56.16-.187.213-.32.32-.533.107-.213.053-.4-.027-.56-.08-.16-.72-1.733-.987-2.373-.253-.613-.52-.533-.72-.547-.186-.013-.4-.013-.613-.013-.213 0-.56.08-.853.4-.293.32-1.12 1.093-1.12 2.667s1.147 3.093 1.307 3.307c.16.213 2.253 3.44 5.467 4.827.76.32 1.36.52 1.827.667.76.24 1.467.2 2.013.12.614-.093 1.893-.773 2.16-1.52.267-.747.267-1.387.187-1.52-.08-.133-.293-.213-.613-.373z"/></svg>
        </button>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
