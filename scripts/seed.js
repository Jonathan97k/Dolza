if (process.env.NODE_ENV !== 'production') require('dotenv').config({ path: require('path').join(__dirname, '..', '.env') });
const mongoose = require('mongoose');
const slugify = require('slugify');

const Property = require('../models/Property');
const TeamMember = require('../models/TeamMember');
const Testimonial = require('../models/Testimonial');
const ContentBlock = require('../models/ContentBlock');
const Setting = require('../models/Setting');
const Inquiry = require('../models/Inquiry');

const seedData = {
  "properties": [
    { "name": "Prime Plot - Area 47", "type": "land", "location": "Lilongwe", "price": 8500000, "details": "800 sqm plot in prime location", "image": "property1.jpg", "featured": 1, "area": "800 sqm" },
    { "name": "Farm Land - Salima", "type": "farms", "location": "Salima", "price": 25000000, "details": "5 acres fertile farmland with water access", "image": "property2.jpg", "featured": 1, "area": "5 acres" },
    { "name": "3 Bedroom House", "type": "residential", "location": "Salima", "price": 18000000, "details": "3 beds · 2 baths - Modern residential house", "image": "property3.jpg", "featured": 1, "bedrooms": "3", "bathrooms": "2" },
    { "name": "Commercial Plot", "type": "commercial", "location": "Blantyre", "price": 35000000, "details": "1200 sqm commercial plot", "image": "property4.jpg", "featured": 1, "area": "1200 sqm" },
    { "name": "Residential Plot - Zomba", "type": "land", "location": "Zomba", "price": 6500000, "details": "600 sqm residential plot", "image": "property5.jpg", "featured": 0, "area": "600 sqm" },
    { "name": "Agriculture Farm - Kasungu", "type": "farms", "location": "Kasungu", "price": 45000000, "details": "12 acres agriculture farm", "image": "property6.jpg", "featured": 1, "area": "12 acres" },
    { "name": "2 Bedroom House for Rent", "type": "rentals", "location": "Salima", "price": 120000, "details": "2 beds · 1 bath - Cozy rental house", "image": "two_bed_house.png", "featured": 0, "bedrooms": "2", "bathrooms": "1" },
    { "name": "Shop Space - Town Centre", "type": "commercial", "location": "Salima", "price": 85000, "details": "45 sqm prime shop space", "image": "property2.jpg", "featured": 0, "area": "45 sqm" },
    { "name": "Large Farm - Dowa", "type": "farms", "location": "Dowa", "price": 60000000, "details": "20 acres with title deed", "image": "large_dowa_farm.png", "featured": 0, "area": "20 acres" }
  ],
  "team": [
    { "name": "Patrick Weston Kamefu", "role": "CEO & Founder", "bio": "With over 15 years of experience in the Malawian real estate market, Patrick brings deep local knowledge and an extensive network of contacts.", "image": "patrick.jpg", "email": "patrick@dolzaproperties.com", "phone": "+265 994 369 985" },
    { "name": "Grace Kamangale", "role": "Head Surveyor", "bio": "Grace has been with Dolza since 2018 and brings precision and expertise to every surveying project across Central Malawi.", "image": "grace.jpg", "email": "grace@dolzaproperties.com", "phone": "+265 882 995 600" },
    { "name": "James Chidalo", "role": "Legal Advisor", "bio": "James handles all title deed processing and legal documentation, ensuring every transaction complies with Malawian property law.", "image": "james.jpg", "email": "james@dolzaproperties.com" }
  ],
  "testimonials": [
    { "name": "James M.", "role": "Home Buyer", "content": "Dolza helped me find my dream farm in Salima. Their team was knowledgeable and professional throughout the process.", "rating": 5 },
    { "name": "Grace T.", "role": "Property Seller", "content": "I sold my property quickly with Dolza's assistance. They know the Malawian real estate market inside out.", "rating": 5 },
    { "name": "Thomas K.", "role": "Client", "content": "Professional service from start to finish. The team guided me through title deed processing with ease.", "rating": 4 }
  ],
  "content": [
    { "section": "hero", "data": "{\"title\":\"Your Trusted Partner for Land, Farms & Property in Malawi\",\"subtitle\":\"Buy · Build · Invest — Salima's Most Trusted Real Estate Agency\",\"buttonText\":\"View Properties\",\"buttonLink\":\"/properties\",\"badge\":\"Premium Real Estate\"}" },
    { "section": "about", "data": "{\"heading\":\"Our Story\",\"content\":\"Established in 2016, Dolza Real Properties & Estate Agency has grown to become Salima's most trusted real estate partner. Founded by Malawian real estate expert Patrick Weston Kamefu, our agency was born from a vision to provide professional, transparent, and reliable property services across Malawi. Over the past 8+ years, we've helped hundreds of clients buy, sell, and develop properties throughout Salima, Lilongwe, Blantyre, and beyond.\",\"stats\":[{\"number\":\"8+\",\"label\":\"Years Experience\"},{\"number\":\"500+\",\"label\":\"Properties Sold\"},{\"number\":\"350+\",\"label\":\"Satisfied Clients\"},{\"number\":\"3\",\"label\":\"Districts Covered\"}]}" },
    { "section": "services", "data": "[{\"title\":\"We Sell Properties\",\"description\":\"Find your perfect property from our curated selection of premium listings.\",\"icon\":\"fa-home\"},{\"title\":\"We Buy Properties\",\"description\":\"We offer fair prices for your land and property with quick cash purchases.\",\"icon\":\"fa-tag\"},{\"title\":\"Land Surveying\",\"description\":\"Professional land surveying and boundary marking services.\",\"icon\":\"fa-draw-polygon\"},{\"title\":\"Title Deed Processing\",\"description\":\"We handle all title deed and legal documentation for smooth transactions.\",\"icon\":\"fa-file-signature\"},{\"title\":\"Business Advertisement\",\"description\":\"Advertise your business to thousands of potential clients across Malawi.\",\"icon\":\"fa-bullhorn\"},{\"title\":\"Property Development Consultation\",\"description\":\"Expert guidance on land suitability and development potential.\",\"icon\":\"fa-compass\"}]" },
    { "section": "footer", "data": "{\"about\":\"Your trusted partner for real estate solutions in Malawi. Buy · Build · Invest with confidence.\",\"email\":\"dolzaestateagency@gmail.com\",\"phone\":\"+265 994 369 985\",\"address\":\"Salima Office, Malawi\"}" }
  ],
  "settings": [
    { "key": "siteName", "value": "Dolza Real Properties & Estate Agency" },
    { "key": "siteDescription", "value": "Premium real estate services in Salima, Malawi" },
    { "key": "contactEmail", "value": "dolzaestateagency@gmail.com" },
    { "key": "contactPhone", "value": "+265 994 369 985" },
    { "key": "address", "value": "Salima Office, Malawi" },
    { "key": "currency", "value": "MWK" },
    { "key": "logo", "value": "" }
  ]
};

async function seed() {
  const uri = process.env.MONGODB_URI;
  if (!uri) { console.error('MONGODB_URI not set'); process.exit(1); }
  await mongoose.connect(uri);
  console.log('Connected to MongoDB');

  // Clear existing data
  await Promise.all([
    Property.deleteMany({}), TeamMember.deleteMany({}), Testimonial.deleteMany({}),
    ContentBlock.deleteMany({}), Setting.deleteMany({}), Inquiry.deleteMany({}),
  ]);
  console.log('Cleared existing data');

  // Seed properties
  for (const p of seedData.properties) {
    await Property.create({
      title: p.name,
      slug: slugify(p.name, { lower: true, strict: true }),
      location: p.location,
      price: 'MWK ' + Number(p.price).toLocaleString(),
      priceValue: Number(p.price),
      size: p.area || '',
      bedrooms: Number(p.bedrooms) || 0,
      bathrooms: Number(p.bathrooms) || 0,
      type: p.type,
      status: 'For ' + (p.type === 'rentals' ? 'Rent' : 'Sale'),
      description: p.details,
      features: [],
      images: [p.image],
      imageUrls: [],
      featured: Boolean(p.featured),
      published: true,
      order: 0,
    });
  }
  console.log('Seeded ' + seedData.properties.length + ' properties');

  // Seed team
  for (const m of seedData.team) {
    await TeamMember.create({
      name: m.name, role: m.role, bio: m.bio || '', image: m.image || '',
      email: m.email || '', phone: m.phone || '', order: 0,
    });
  }
  console.log('Seeded ' + seedData.team.length + ' team members');

  // Seed testimonials
  for (const t of seedData.testimonials) {
    await Testimonial.create({
      name: t.name, role: t.role || '', content: t.content,
      rating: t.rating || 5, image: t.image || '', published: true, order: 0,
    });
  }
  console.log('Seeded ' + seedData.testimonials.length + ' testimonials');

  // Seed content blocks
  const contentMap = {
    hero: 'home',
    services: 'home-services',
    footer: 'footer',
    about: 'about',
  };
  for (const c of seedData.content) {
    const parsed = JSON.parse(c.data);
    const key = contentMap[c.section] || c.section;
    const doc = { key, title: '', subtitle: '', body: '', image: '', extra: {} };
    if (c.section === 'hero') {
      doc.title = parsed.title;
      doc.subtitle = parsed.subtitle;
      doc.extra = { buttonText: parsed.buttonText, buttonLink: parsed.buttonLink, badge: parsed.badge };
    } else if (c.section === 'about') {
      doc.title = parsed.heading;
      doc.body = parsed.content;
      doc.extra = { stats: parsed.stats };
    } else if (c.section === 'services') {
      doc.key = 'home-services';
      doc.title = 'Our Services';
      doc.extra = { items: parsed };
    } else if (c.section === 'footer') {
      doc.extra = parsed;
    }
    await ContentBlock.create(doc);
  }
  console.log('Seeded ' + seedData.content.length + ' content blocks');

  // Seed settings
  for (const s of seedData.settings) {
    await Setting.create({ key: s.key, value: s.value });
  }
  console.log('Seeded ' + seedData.settings.length + ' settings');

  console.log('Seed complete!');
  process.exit(0);
}

seed().catch(e => { console.error(e); process.exit(1); });
