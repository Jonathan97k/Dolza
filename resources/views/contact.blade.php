@extends('layouts.app')

@section('title', 'Contact Us - Dolza Real Properties &amp; Estate Agency')

@section('meta_description', 'Get in touch with Dolza Real Properties &amp; Estate Agency. Contact us for inquiries about land, farms, and properties in Malawi.')

@section('content')
    <section class="hero" style="min-height:50vh;">
        <div class="hero-content">
            <span class="hero-tag">Get in Touch</span>
            <h1>Contact Us</h1>
            <h2>{{ $content['contact']->data['subtitle'] ?? 'Get in Touch with Our Real Estate Experts' }}</h2>
        </div>
    </section>

    <div class="container">
        <div class="contact-grid">
            <div class="contact-form-box">
                <h2>Send Us a Message</h2>
                <form id="contactForm">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select id="subject" name="subject">
                            <option value="">Select a subject</option>
                            <option value="general">General Inquiry</option>
                            <option value="sale">Property for Sale</option>
                            <option value="purchase">Property Purchase</option>
                            <option value="surveying">Land Surveying</option>
                            <option value="deed">Title Deed Processing</option>
                            <option value="advertisement">Business Advertisement</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%;">Submit Request</button>
                </form>
                <div class="form-success" id="successMessage">&#9989; Thank you! We will contact you shortly. Your message has been sent to our team on WhatsApp.</div>
            </div>

            <div class="contact-details">
                <div class="info-card">
                    <h3>Our Office</h3>
                    <p id="contactAddress">&#128205; {{ $settings['address']->value ?? 'Salima Office, Malawi' }}</p>
                </div>
                <div class="info-card">
                    <h3>Contact Numbers</h3>
                    <p id="contactPhone">&#128222; {{ $settings['phone']->value ?? '+265 994 369 985' }}<br>{{ isset($settings['phone2']) ? '&#128222; ' . $settings['phone2']->value : '' }}</p>
                </div>
                <div class="info-card">
                    <h3>Email</h3>
                    <p id="contactEmail">&#9993;&#65039; {{ $settings['email']->value ?? 'dolzaestateagency@gmail.com' }}</p>
                </div>
                <div class="info-card">
                    <h3>Working Hours</h3>
                    <p>Mon-Fri: 8:00 AM - 5:00 PM<br>Sat: 9:00 AM - 1:00 PM<br>Sun: Closed</p>
                </div>
                <div class="map-placeholder">
                    <div class="map-content">
                        <h3>Find Us in Salima</h3>
                        <p>We're located in the heart of Salima, ready to serve all your real estate needs.</p>
                        <a href="https://wa.me/265994369985" target="_blank" class="btn-wa" style="display:inline-flex;">WhatsApp Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const subject = document.getElementById('subject').value;
        const message = document.getElementById('message').value;
        fetch('/api/inquiries', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, email: document.getElementById('email').value, phone, message, property: subject })
        }).catch(() => {});
        const waMessage = 'Hello Dolza Real Estate!\n\nName: ' + name + '\nPhone: ' + phone + '\nSubject: ' + subject + '\n\nMessage: ' + message;
        window.open('https://wa.me/265994369985?text=' + encodeURIComponent(waMessage), '_blank');
        const success = document.getElementById('successMessage');
        success.style.display = 'block';
        this.reset();
        setTimeout(() => { success.style.display = 'none'; }, 5000);
    });

    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', e => { e.preventDefault(); deferredPrompt = e; });

    (async function loadContact() {
        try {
            const [contRes, setRes] = await Promise.all([
                fetch('/api/content').then(r=>r.json()).catch(()=>null),
                fetch('/api/settings').then(r=>r.json()).catch(()=>null)
            ]);
            const f = contRes?.footer || {};
            const infoCards = document.querySelectorAll('.info-card p');
            if (f.address && infoCards[0]) infoCards[0].textContent = '\uD83D\uDCCD ' + f.address;
            if (f.phone && infoCards[1]) infoCards[1].innerHTML = '\uD83D\uDCDE ' + f.phone + (f.phone2 ? '<br>\uD83D\uDCDE ' + f.phone2 : '');
            if (f.email && infoCards[2]) infoCards[2].textContent = '\u2709\uFE0F ' + f.email;
            const contactLis = document.querySelectorAll('footer .contact-info li');
            if (f.address && contactLis[0]) contactLis[0].textContent = '\uD83D\uDCCD ' + f.address;
            if (f.phone && contactLis[1]) contactLis[1].textContent = '\uD83D\uDCDE ' + f.phone;
            if (f.email && contactLis[3]) contactLis[3].textContent = '\u2709\uFE0F ' + f.email;
        } catch(e) {}
    })();
</script>
@endpush
