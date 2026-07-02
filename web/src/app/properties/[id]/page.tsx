"use client"

import { useEffect, useState } from "react"
import { useParams } from "next/navigation"
import Link from "next/link"

type Property = {
  id: string; title: string; description: string; price: number
  surface: number | null; rooms: number | null; bedrooms: number | null
  bathrooms: number | null; location: string | null; city: string | null
  type: string; status: string; features: string; images: string
  videoUrl: string | null; virtualTour: string | null; latitude: number | null; longitude: number | null
}

export default function PropertyDetail() {
  const { id } = useParams<{ id: string }>()
  const [property, setProperty] = useState<Property | null>(null)
  const [form, setForm] = useState({ name: "", email: "", phone: "", message: "" })

  useEffect(() => {
    fetch(`/api/properties/${id}`).then(r => r.json()).then(setProperty)
  }, [id])

  if (!property) return <div style={{ padding: "4rem", textAlign: "center" }}>Loading...</div>

  const parseImages = (img: string) => { try { return JSON.parse(img) } catch { return [] } }
  const parseFeatures = (f: string) => { try { return JSON.parse(f) } catch { return [] } }
  const images = parseImages(property.images)
  const features = parseFeatures(property.features)
  const formatPrice = (p: number) => new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", maximumFractionDigits: 0 }).format(p)

  const handleInquiry = async (e: React.FormEvent) => {
    e.preventDefault()
    await fetch("/api/inquiries", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ ...form, propertyId: property.id }),
    })
    alert("Inquiry sent successfully!")
    setForm({ name: "", email: "", phone: "", message: "" })
  }

  return (
    <div>
      <nav style={{ padding: "1rem 2rem", display: "flex", justifyContent: "space-between", alignItems: "center", background: "#fff", boxShadow: "0 2px 10px rgba(0,0,0,0.05)" }}>
        <Link href="/" style={{ fontSize: "1.5rem", fontWeight: 700, color: "var(--primary)", textDecoration: "none" }}>Dolza</Link>
        <Link href="/properties" style={{ color: "var(--primary)", textDecoration: "none" }}>&larr; Back to Properties</Link>
      </nav>

      <div style={{ maxWidth: 1200, margin: "0 auto", padding: "2rem" }}>
        <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: "2rem" }}>
          <div>
            {images.length > 0 && <img src={images[0]} alt={property.title} style={{ width: "100%", borderRadius: "0.75rem" }} />}
            {images.length > 1 && (
              <div style={{ display: "flex", gap: "0.5rem", marginTop: "0.5rem" }}>
                {images.slice(1, 4).map((img: string, i: number) => (
                  <img key={i} src={img} alt="" style={{ width: "33%", borderRadius: "0.375rem", height: 120, objectFit: "cover" }} />
                ))}
              </div>
            )}
          </div>
          <div>
            <h1 style={{ fontSize: "2rem", marginBottom: "0.5rem" }}>{property.title}</h1>
            <div style={{ fontSize: "2rem", fontWeight: 700, color: "var(--primary)", marginBottom: "1rem" }}>{formatPrice(property.price)}</div>
            <div style={{ display: "flex", gap: "2rem", marginBottom: "1rem", flexWrap: "wrap" }}>
              {property.bedrooms && <div><strong>{property.bedrooms}</strong> Bedrooms</div>}
              {property.bathrooms && <div><strong>{property.bathrooms}</strong> Bathrooms</div>}
              {property.surface && <div><strong>{property.surface}</strong> m²</div>}
              {property.rooms && <div><strong>{property.rooms}</strong> Rooms</div>}
            </div>
            <p style={{ lineHeight: 1.8, color: "#555", marginBottom: "1.5rem" }}>{property.description}</p>
            {features.length > 0 && (
              <div>
                <h3 style={{ marginBottom: "0.5rem" }}>Features</h3>
                <div style={{ display: "flex", flexWrap: "wrap", gap: "0.5rem" }}>
                  {features.map((f: string, i: number) => (
                    <span key={i} style={{ background: "#f3f4f6", padding: "0.25rem 0.75rem", borderRadius: "1rem", fontSize: "0.9rem" }}>{f}</span>
                  ))}
                </div>
              </div>
            )}
          </div>
        </div>

        <div style={{ marginTop: "3rem", background: "#f8f9fa", padding: "2rem", borderRadius: "0.75rem" }}>
          <h2 style={{ marginBottom: "1rem" }}>Interested in this property?</h2>
          <form onSubmit={handleInquiry} style={{ display: "grid", gap: "1rem", maxWidth: 500 }}>
            <input placeholder="Name" value={form.name} onChange={e => setForm({ ...form, name: e.target.value })} required
              style={{ padding: "0.75rem", border: "1px solid #ddd", borderRadius: "0.375rem" }} />
            <input type="email" placeholder="Email" value={form.email} onChange={e => setForm({ ...form, email: e.target.value })} required
              style={{ padding: "0.75rem", border: "1px solid #ddd", borderRadius: "0.375rem" }} />
            <input placeholder="Phone" value={form.phone} onChange={e => setForm({ ...form, phone: e.target.value })}
              style={{ padding: "0.75rem", border: "1px solid #ddd", borderRadius: "0.375rem" }} />
            <textarea placeholder="Message" value={form.message} onChange={e => setForm({ ...form, message: e.target.value })} required rows={4}
              style={{ padding: "0.75rem", border: "1px solid #ddd", borderRadius: "0.375rem" }} />
            <button type="submit" className="btn-primary" style={{ border: "none", cursor: "pointer" }}>Send Inquiry</button>
          </form>
        </div>
      </div>
    </div>
  )
}
