"use client"

import { useState } from "react"
import Link from "next/link"

type Property = {
  id: string; title: string; price: number; surface: number | null
  bedrooms: number | null; bathrooms: number | null; location: string | null
  city: string | null; type: string; status: string; images: string
}

export default function PropertiesClient({ properties: initial }: { properties: Property[] }) {
  const [filter, setFilter] = useState("all")

  const parseImages = (img: string) => {
    try { const p = JSON.parse(img); return Array.isArray(p) ? p[0] : null } catch { return null }
  }

  const formatPrice = (p: number) => new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", maximumFractionDigits: 0 }).format(p)

  const filtered = filter === "all" ? initial : initial.filter(p => p.type === filter)

  return (
    <>
      <div style={{ display: "flex", justifyContent: "center", gap: "1rem", marginBottom: "2rem" }}>
        {["all", "sale", "rent"].map(f => (
          <button key={f} onClick={() => setFilter(f)}
            style={{ padding: "0.5rem 1.5rem", borderRadius: "0.375rem", border: "none", cursor: "pointer",
              background: filter === f ? "var(--primary)" : "#e5e7eb", color: filter === f ? "#fff" : "var(--text)", fontWeight: 600 }}>
            {f.charAt(0).toUpperCase() + f.slice(1)}
          </button>
        ))}
      </div>

      <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill, minmax(320px, 1fr))", gap: "2rem", maxWidth: 1200, margin: "0 auto" }}>
        {filtered.map(p => (
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
    </>
  )
}