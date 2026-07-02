"use client"

import { useEffect, useState } from "react"
import Link from "next/link"
import AdminSidebar from "../components/AdminSidebar"

type Property = { id: string; title: string; price: number; type: string; status: string; images: string }

export default function AdminProperties() {
  const [properties, setProperties] = useState<Property[]>([])
  const [showForm, setShowForm] = useState(false)
  const [form, setForm] = useState({ title: "", description: "", price: "", surface: "", rooms: "", bedrooms: "", bathrooms: "", location: "", city: "", type: "sale", status: "available", features: "", images: "", videoUrl: "", virtualTour: "", latitude: "", longitude: "" })
  const [editing, setEditing] = useState<string | null>(null)

  useEffect(() => { fetch("/api/properties").then(r => r.json()).then(setProperties) }, [])

  const handleSave = async (e: React.FormEvent) => {
    e.preventDefault()
    const url = editing ? `/api/properties/${editing}` : "/api/properties"
    const method = editing ? "PUT" : "POST"
    await fetch(url, { method, headers: { "Content-Type": "application/json" }, body: JSON.stringify(form) })
    setShowForm(false); setEditing(null)
    setForm({ title: "", description: "", price: "", surface: "", rooms: "", bedrooms: "", bathrooms: "", location: "", city: "", type: "sale", status: "available", features: "", images: "", videoUrl: "", virtualTour: "", latitude: "", longitude: "" })
    fetch("/api/properties").then(r => r.json()).then(setProperties)
  }

  const handleEdit = (p: Property) => {
    setEditing(p.id)
    setForm({ ...form, title: p.title, price: String(p.price) })
    setShowForm(true)
  }

  const handleDelete = async (id: string) => {
    if (!confirm("Delete this property?")) return
    await fetch(`/api/properties/${id}`, { method: "DELETE" })
    setProperties(properties.filter(p => p.id !== id))
  }

  const formatPrice = (p: number) => new Intl.NumberFormat("en-US", { style: "currency", currency: "USD", maximumFractionDigits: 0 }).format(p)

  return (
    <div className="admin-layout">
      <AdminSidebar />
      <main className="admin-main">
        <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center", marginBottom: "2rem" }}>
          <h1>Properties</h1>
          <button onClick={() => { setShowForm(true); setEditing(null) }} className="btn-primary" style={{ border: "none", cursor: "pointer" }}>Add Property</button>
        </div>

        {showForm && (
          <form onSubmit={handleSave} style={{ background: "#fff", padding: "1.5rem", borderRadius: "0.75rem", marginBottom: "2rem", display: "grid", gap: "1rem", gridTemplateColumns: "1fr 1fr" }}>
            <input placeholder="Title" value={form.title} onChange={e => setForm({ ...form, title: e.target.value })} required style={inputStyle} />
            <input placeholder="Price" type="number" value={form.price} onChange={e => setForm({ ...form, price: e.target.value })} required style={inputStyle} />
            <textarea placeholder="Description" value={form.description} onChange={e => setForm({ ...form, description: e.target.value })} style={{ ...inputStyle, gridColumn: "1 / -1" }} rows={3} />
            <input placeholder="Surface (m²)" type="number" value={form.surface} onChange={e => setForm({ ...form, surface: e.target.value })} style={inputStyle} />
            <input placeholder="Rooms" type="number" value={form.rooms} onChange={e => setForm({ ...form, rooms: e.target.value })} style={inputStyle} />
            <input placeholder="Bedrooms" type="number" value={form.bedrooms} onChange={e => setForm({ ...form, bedrooms: e.target.value })} style={inputStyle} />
            <input placeholder="Bathrooms" type="number" value={form.bathrooms} onChange={e => setForm({ ...form, bathrooms: e.target.value })} style={inputStyle} />
            <input placeholder="Location" value={form.location} onChange={e => setForm({ ...form, location: e.target.value })} style={inputStyle} />
            <input placeholder="City" value={form.city} onChange={e => setForm({ ...form, city: e.target.value })} style={inputStyle} />
            <select value={form.type} onChange={e => setForm({ ...form, type: e.target.value })} style={inputStyle}>
              <option value="sale">Sale</option><option value="rent">Rent</option>
            </select>
            <select value={form.status} onChange={e => setForm({ ...form, status: e.target.value })} style={inputStyle}>
              <option value="available">Available</option><option value="pending">Pending</option><option value="sold">Sold</option>
            </select>
            <button type="submit" className="btn-primary" style={{ border: "none", cursor: "pointer", gridColumn: "1 / -1" }}>{editing ? "Update" : "Create"} Property</button>
          </form>
        )}

        <div style={{ background: "#fff", borderRadius: "0.75rem", overflow: "hidden" }}>
          <table style={{ width: "100%", borderCollapse: "collapse" }}>
            <thead><tr style={{ background: "#f8f9fa" }}>
              <th style={thStyle}>Title</th><th style={thStyle}>Price</th><th style={thStyle}>Type</th><th style={thStyle}>Status</th><th style={thStyle}></th>
            </tr></thead>
            <tbody>
              {properties.map(p => (
                <tr key={p.id} style={{ borderBottom: "1px solid #eee" }}>
                  <td style={tdStyle}>{p.title}</td>
                  <td style={tdStyle}>{formatPrice(p.price)}</td>
                  <td style={tdStyle}>{p.type}</td>
                  <td style={tdStyle}>{p.status}</td>
                  <td style={tdStyle}>
                    <button onClick={() => handleEdit(p)} style={{ marginRight: "0.5rem", padding: "0.25rem 0.75rem", background: "var(--primary)", color: "#fff", border: "none", borderRadius: "0.25rem", cursor: "pointer" }}>Edit</button>
                    <button onClick={() => handleDelete(p.id)} style={{ padding: "0.25rem 0.75rem", background: "#ef4444", color: "#fff", border: "none", borderRadius: "0.25rem", cursor: "pointer" }}>Delete</button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </main>
    </div>
  )
}

const inputStyle = { padding: "0.75rem", border: "1px solid #ddd", borderRadius: "0.375rem" }
const thStyle = { padding: "0.75rem 1rem", textAlign: "left" as const, fontWeight: 600, fontSize: "0.9rem", color: "#555" }
const tdStyle = { padding: "0.75rem 1rem", fontSize: "0.95rem" }
