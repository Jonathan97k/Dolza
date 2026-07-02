"use client"

import { useEffect, useState } from "react"
import AdminSidebar from "../components/AdminSidebar"

type Member = { id: string; name: string; role: string; email: string | null; order: number }

export default function AdminTeam() {
  const [members, setMembers] = useState<Member[]>([])
  const [form, setForm] = useState({ name: "", role: "", bio: "", image: "", email: "", phone: "", order: "0" })
  const [editing, setEditing] = useState<string | null>(null)

  useEffect(() => { fetch("/api/team").then(r => r.json()).then(setMembers) }, [])

  const handleSave = async (e: React.FormEvent) => {
    e.preventDefault()
    const url = editing ? `/api/team/${editing}` : "/api/team"
    await fetch(url, { method: editing ? "PUT" : "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify(form) })
    setEditing(null); setForm({ name: "", role: "", bio: "", image: "", email: "", phone: "", order: "0" })
    fetch("/api/team").then(r => r.json()).then(setMembers)
  }

  const handleEdit = (m: Member) => { setEditing(m.id); setForm({ ...form, name: m.name, role: m.role, email: m.email || "", order: String(m.order) }) }

  const handleDelete = async (id: string) => {
    if (!confirm("Delete this member?")) return
    await fetch(`/api/team/${id}`, { method: "DELETE" })
    setMembers(members.filter(m => m.id !== id))
  }

  return (
    <div className="admin-layout">
      <AdminSidebar />
      <main className="admin-main">
        <h1 style={{ marginBottom: "2rem" }}>Team</h1>
        <form onSubmit={handleSave} style={{ background: "#fff", padding: "1.5rem", borderRadius: "0.75rem", marginBottom: "2rem", display: "grid", gap: "1rem", gridTemplateColumns: "1fr 1fr" }}>
          <input placeholder="Name" value={form.name} onChange={e => setForm({ ...form, name: e.target.value })} required style={s} />
          <input placeholder="Role" value={form.role} onChange={e => setForm({ ...form, role: e.target.value })} required style={s} />
          <textarea placeholder="Bio" value={form.bio} onChange={e => setForm({ ...form, bio: e.target.value })} style={{ ...s, gridColumn: "1 / -1" }} rows={2} />
          <input placeholder="Image URL" value={form.image} onChange={e => setForm({ ...form, image: e.target.value })} style={s} />
          <input placeholder="Email" value={form.email} onChange={e => setForm({ ...form, email: e.target.value })} style={s} />
          <input placeholder="Phone" value={form.phone} onChange={e => setForm({ ...form, phone: e.target.value })} style={s} />
          <input placeholder="Order" type="number" value={form.order} onChange={e => setForm({ ...form, order: e.target.value })} style={s} />
          <button type="submit" className="btn-primary" style={{ border: "none", cursor: "pointer", gridColumn: "1 / -1" }}>{editing ? "Update" : "Add"} Member</button>
        </form>
        <div style={{ background: "#fff", borderRadius: "0.75rem", overflow: "hidden" }}>
          <table style={{ width: "100%", borderCollapse: "collapse" }}>
            <thead><tr style={{ background: "#f8f9fa" }}>
              <th style={th}>Name</th><th style={th}>Role</th><th style={th}>Email</th><th style={th}>Order</th><th style={th}></th>
            </tr></thead>
            <tbody>
              {members.map(m => (
                <tr key={m.id} style={{ borderBottom: "1px solid #eee" }}>
                  <td style={td}>{m.name}</td><td style={td}>{m.role}</td><td style={td}>{m.email || "-"}</td><td style={td}>{m.order}</td>
                  <td style={td}>
                    <button onClick={() => handleEdit(m)} style={{ marginRight: "0.5rem", padding: "0.25rem 0.75rem", background: "var(--primary)", color: "#fff", border: "none", borderRadius: "0.25rem", cursor: "pointer" }}>Edit</button>
                    <button onClick={() => handleDelete(m.id)} style={{ padding: "0.25rem 0.75rem", background: "#ef4444", color: "#fff", border: "none", borderRadius: "0.25rem", cursor: "pointer" }}>Delete</button>
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
