"use client"

import { useEffect, useState } from "react"
import AdminSidebar from "../components/AdminSidebar"

type Inquiry = { id: string; name: string; email: string; phone: string | null; message: string; type: string; createdAt: string; property?: { title: string } | null }

export default function AdminInquiries() {
  const [inquiries, setInquiries] = useState<Inquiry[]>([])

  useEffect(() => { fetch("/api/inquiries").then(r => r.json()).then(setInquiries) }, [])

  const handleDelete = async (id: string) => {
    if (!confirm("Delete this inquiry?")) return
    await fetch(`/api/inquiries/${id}`, { method: "DELETE" })
    setInquiries(inquiries.filter(i => i.id !== id))
  }

  return (
    <div className="admin-layout">
      <AdminSidebar />
      <main className="admin-main">
        <h1 style={{ marginBottom: "2rem" }}>Inquiries</h1>
        <div style={{ background: "#fff", borderRadius: "0.75rem", overflow: "hidden" }}>
          <table style={{ width: "100%", borderCollapse: "collapse" }}>
            <thead><tr style={{ background: "#f8f9fa" }}>
              <th style={th}>Name</th><th style={th}>Email</th><th style={th}>Type</th><th style={th}>Property</th><th style={th}>Message</th><th style={th}>Date</th><th style={th}></th>
            </tr></thead>
            <tbody>
              {inquiries.map(i => (
                <tr key={i.id} style={{ borderBottom: "1px solid #eee" }}>
                  <td style={td}>{i.name}</td><td style={td}>{i.email}</td><td style={td}>{i.type}</td>
                  <td style={td}>{i.property?.title || "-"}</td><td style={td}>{i.message.slice(0, 60)}...</td>
                  <td style={td}>{new Date(i.createdAt).toLocaleDateString()}</td>
                  <td style={td}>
                    <button onClick={() => handleDelete(i.id)} style={{ padding: "0.25rem 0.75rem", background: "#ef4444", color: "#fff", border: "none", borderRadius: "0.25rem", cursor: "pointer" }}>Delete</button>
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
const th = { padding: "0.75rem 1rem", textAlign: "left" as const, fontWeight: 600, fontSize: "0.9rem", color: "#555" }
const td = { padding: "0.75rem 1rem", fontSize: "0.95rem" }
