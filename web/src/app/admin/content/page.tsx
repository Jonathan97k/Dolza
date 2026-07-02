"use client"

import { useEffect, useState } from "react"
import AdminSidebar from "../components/AdminSidebar"

type Content = { id: string; key: string; value: string; type: string }

export default function AdminContent() {
  const [content, setContent] = useState<Record<string, string>>({})
  const [items, setItems] = useState<Content[]>([])
  const [form, setForm] = useState({ key: "", value: "", type: "text" })

  useEffect(() => {
    fetch("/api/content").then(r => r.json()).then(d => { setContent(d) })
    fetch("/api/content?raw=true").then(r => r.json()).catch(() => {})
  }, [])

  const handleSave = async (e: React.FormEvent) => {
    e.preventDefault()
    await fetch("/api/content", { method: "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify(form) })
    setForm({ key: "", value: "", type: "text" })
    fetch("/api/content").then(r => r.json()).then(setContent)
  }

  return (
    <div className="admin-layout">
      <AdminSidebar />
      <main className="admin-main">
        <h1 style={{ marginBottom: "2rem" }}>Content</h1>
        <form onSubmit={handleSave} style={{ background: "#fff", padding: "1.5rem", borderRadius: "0.75rem", marginBottom: "2rem", display: "grid", gap: "1rem" }}>
          <input placeholder="Key" value={form.key} onChange={e => setForm({ ...form, key: e.target.value })} required style={s} />
          <textarea placeholder="Value" value={form.value} onChange={e => setForm({ ...form, value: e.target.value })} required style={s} rows={3} />
          <select value={form.type} onChange={e => setForm({ ...form, type: e.target.value })} style={s}>
            <option value="text">Text</option><option value="html">HTML</option><option value="markdown">Markdown</option>
          </select>
          <button type="submit" className="btn-primary" style={{ border: "none", cursor: "pointer" }}>Add Content</button>
        </form>
        <div style={{ background: "#fff", borderRadius: "0.75rem", padding: "1.5rem" }}>
          {Object.entries(content).map(([key, value]) => (
            <div key={key} style={{ padding: "0.75rem 0", borderBottom: "1px solid #eee" }}>
              <strong style={{ color: "var(--primary)" }}>{key}</strong>
              <p style={{ color: "#555", marginTop: "0.25rem", fontSize: "0.9rem" }}>{value}</p>
            </div>
          ))}
        </div>
      </main>
    </div>
  )
}
const s = { padding: "0.75rem", border: "1px solid #ddd", borderRadius: "0.375rem" }
