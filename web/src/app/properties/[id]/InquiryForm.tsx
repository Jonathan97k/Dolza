"use client"

import { useState } from "react"

export default function InquiryForm({ propertyId }: { propertyId: string }) {
  const [form, setForm] = useState({ name: "", email: "", phone: "", message: "" })

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    await fetch("/api/inquiries", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ ...form, propertyId }),
    })
    alert("Inquiry sent successfully!")
    setForm({ name: "", email: "", phone: "", message: "" })
  }

  return (
    <form onSubmit={handleSubmit} style={{ display: "grid", gap: "1rem", maxWidth: 500 }}>
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
  )
}