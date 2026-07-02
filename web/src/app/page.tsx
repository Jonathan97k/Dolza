"use client"

import { useEffect, useState } from "react"
import Link from "next/link"

type Property = {
  id: string; title: string; description: string; price: number
  surface: number | null; rooms: number | null; bedrooms: number | null
  bathrooms: number | null; location: string | null; city: string | null
  type: string; status: string; images: string
}

type Testimonial = { id: string; name: string; role: string | null; content: string; rating: number; image: string | null }

export default function Home() {
  const [properties, setProperties] = useState<Property[]>([])
  const [testimonials, setTestimonials] = useState<Testimonial[]>([])

  useEffect(() => {
    fetch("/api/properties").then(r => r.json()).then(setProperties)
    fetch("/api/testimonials").then(r => r.json()).then(setTestimonials)
  }, [])

  const parseImages = (img: string) => {
    try { const p = JSON.parse(img); return Array.isArray(p) ? p[0] : null } catch { return null }
  }

  const formatPrice = (p: number) => new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", maximumFractionDigits: 0 }).format(p)

  return (
    <div>
      <section className="hero-section">
        <div>
          <h1 className="hero-title">Find Your Dream Property</h1>
          <p className="hero-subtitle">Discover exceptional real estate opportunities with Dolza. Luxury homes, prime locations, and expert guidance.</p>
          <Link href="/properties" className="btn-primary">View Properties</Link>
        </div>
      </section>

      <section className="section">
        <h2 className="section-title">Featured Properties</h2>
        <p className="section-subtitle">Explore our hand-picked selection of premium properties</p>
        <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill, minmax(320px, 1fr))", gap: "2rem", maxWidth: 1200, margin: "0 auto" }}>
          {properties.slice(0, 6).map(p => (
            <Link key={p.id} href={`/properties/${p.id}`} className="property-card" style={{ textDecoration: "none", color: "inherit" }}>
              {parseImages(p.images) && <img src={parseImages(p.images)} alt={p.title} />}
              <div className="property-info">
                <div className="property-price">{formatPrice(p.price)}</div>
                <div className="property-title">{p.title}</div>
                <p style={{ color: "#777", fontSize: "0.9rem", margin: "0.25rem 0" }}>{p.location}{p.city ? `, ${p.city}` : ""}</p>
                <div className="property-meta">
                  {p.bedrooms && <span>{p.bedrooms} Beds</span>}
                  {p.bathrooms && <span>{p.bathrooms} Baths</span>}
                  {p.surface && <span>{p.surface} m²</span>}
                </div>
              </div>
            </Link>
          ))}
        </div>
      </section>

      <section className="section" style={{ background: "#f8f9fa" }}>
        <h2 className="section-title">What Our Clients Say</h2>
        <p className="section-subtitle">Hear from our satisfied clients</p>
        <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill, minmax(300px, 1fr))", gap: "2rem", maxWidth: 1000, margin: "0 auto" }}>
          {testimonials.slice(0, 3).map(t => (
            <div key={t.id} style={{ background: "#fff", padding: "1.5rem", borderRadius: "0.75rem", boxShadow: "0 2px 10px rgba(0,0,0,0.06)" }}>
              <p style={{ fontStyle: "italic", marginBottom: "1rem", lineHeight: 1.6 }}>"{t.content}"</p>
              <div style={{ fontWeight: 600 }}>{t.name}</div>
              {t.role && <div style={{ color: "#777", fontSize: "0.9rem" }}>{t.role}</div>}
            </div>
          ))}
        </div>
      </section>
    </div>
  )
}
