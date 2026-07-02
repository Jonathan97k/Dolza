"use client"

import { useEffect, useState } from "react"
import AdminSidebar from "../components/AdminSidebar"

type Testimonial = { id: string; name: string; role: string | null; content: string; rating: number }

export default function AdminTestimonials() {
  const [testimonials, setTestimonials] = useState<Testimonial[]>([])
  const [form, setForm] = useState({ name: "", role: "", content: "", rating: "5", image: "" })
  const [editing, setEditing] = useState<string | null>(null)

  useEffect(() => { fetch("/api/testimonials").then(r => r.json()).then(setTestimonials) }, [])

  const handleSave = async (e: React.FormEvent) => {
    e.preventDefault()
    const url = editing ? `/api/testimonials/${editing}` : "/api/testimonials"
    await fetch(url, { method: editing ? "PUT" : "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify(form) })
    setEditing(null); setForm({ name: "", role: "", content: "", rating: "5", image: "" })
    fetch("/api/testimonials").then(r => r.json()).then(setTestimonials)
  }

  const handleEdit = (t: Testimonial) => { setEditing(t.id); setForm({ name: t.name, role: t.role || "", content: t.content, rating: String(t.rating), image: "" }) }

  const handleDelete = async (id: string) => {
    if (!confirm("Delete this testimonial?")) return
    await fetch(`/api/testimonials/${id}`, { method: "DELETE" })
    setTestimonials(testimonials.filter(t => t.id !== id))
  }

  return (
    <div className="admin-layout">
      <AdminSidebar />
      <main className="admin-main">
        <h1 style={{ marginBottom: "2rem" }}>Testimonials</h1>
        <form onSubmit={handleSave} style={{ background: "#fff", padding: "1.5rem", borderRadius: "0.75rem", marginBottom: "2rem", display: "grid", gap: "1rem" }}>
          <input placeholder="Name" value={form.name} onChange={e => setForm({ ...form, name: e.target.value })} required style={s} />
          <input placeholder="Role" value={form.role} onChange={e => setForm({ ...form, role: e.target.value })} style={s} />
          <textarea placeholder="Content" value={form.content} onChange={e => setForm({ ...form, content: e.target.value })} required style={s} rows={3} />
          <input placeholder="Rating (1-5)" type="number" min="1" max="5" value={form.rating} onChange={e => setForm({ ...form, rating: e.target.value })} style={s} />
          <button type="submit" className="btn-primary" style={{ border: "none", cursor: "pointer" }}>{editing ? "Update" : "Add"} Testimonial</button>
        </form>
        <div style={{ background: "#fff", borderRadius: "0.75rem", overflow: "hidden" }}>
          <table style={{ width: "100%", borderCollapse: "collapse" }}>
            <thead><tr style={{ background: "#f8f9fa" }}>
              <th style={th}>Name</th><th style={th}>Rating</th><th style={th}>Content</th><th style={th}></th>
            </tr></thead>
            <tbody>
              {testimonials.map(t => (
                <tr key={t.id} style={{ borderBottom: "1px solid #eee" }}>
                  <td style={td}>{t.name}</td><td style={td}>{t.rating}/5</td><td style={td}>{t.content.slice(0, 80)}...</td>
                  <td style={td}>
                    <button onClick={() => handleEdit(t)} style={{ marginRight: "0.5rem", padding: "0.25rem 0.75rem", background: "var(--primary)", color: "#fff", border: "none", borderRadius: "0.25rem", cursor: "pointer" }}>Edit</button>
                    <button onClick={() => handleDelete(t.id)} style={{ padding: "0.25rem 0.75rem", background: "#ef4444", color: "#fff", border: "none", borderRadius: "0.25rem", cursor: "pointer" }}>Delete</button>
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
const s = { padding: "0.75rem", border: "1px solid #ddd", borderRadius: "0.375rem" }
const th = { padding: "0.75rem 1rem", textAlign: "left" as const, fontWeight: 600, fontSize: "0.9rem", color: "#555" }
const td = { padding: "0.75rem 1rem", fontSize: "0.95rem" }
