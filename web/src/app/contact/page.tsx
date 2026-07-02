"use client"

import { useState } from "react"
import Link from "next/link"

export default function Contact() {
  const [form, setForm] = useState({ name: "", email: "", phone: "", message: "" })
  const [sent, setSent] = useState(false)

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    await fetch("/api/inquiries", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ ...form, type: "contact" }),
    })
    setSent(true)
    setForm({ name: "", email: "", phone: "", message: "" })
  }

  return (
    <div>
      <nav style={{ padding: "1rem 2rem", display: "flex", justifyContent: "space-between", alignItems: "center", background: "#fff", boxShadow: "0 2px 10px rgba(0,0,0,0.05)" }}>
        <Link href="/" style={{ fontSize: "1.5rem", fontWeight: 700, color: "var(--primary)", textDecoration: "none" }}>Dolza</Link>
        <div style={{ display: "flex", gap: "1.5rem" }}>
          <Link href="/" style={{ color: "var(--text)", textDecoration: "none" }}>Home</Link>
          <Link href="/properties" style={{ color: "var(--text)", textDecoration: "none" }}>Properties</Link>
          <Link href="/about" style={{ color: "var(--text)", textDecoration: "none" }}>About</Link>
          <Link href="/contact" style={{ color: "var(--primary)", textDecoration: "none", fontWeight: 600 }}>Contact</Link>
        </div>
      </nav>

      <section className="section" style={{ maxWidth: 700, margin: "0 auto" }}>
        <h1 className="section-title">Contact Us</h1>
        <p className="section-subtitle">Get in touch with our team</p>

        {sent ? (
          <div style={{ textAlign: "center", padding: "3rem", background: "#d1fae5", borderRadius: "0.75rem" }}>
            <h2 style={{ color: "#065f46" }}>Message Sent!</h2>
            <p style={{ color: "#065f46" }}>We will get back to you shortly.</p>
            <button onClick={() => setSent(false)} className="btn-primary" style={{ marginTop: "1rem", border: "none", cursor: "pointer" }}>Send Another</button>
          </div>
        ) : (
          <form onSubmit={handleSubmit} style={{ display: "grid", gap: "1rem" }}>
            <input placeholder="Name" value={form.name} onChange={e => setForm({ ...form, name: e.target.value })} required
              style={{ padding: "0.75rem", border: "1px solid #ddd", borderRadius: "0.375rem" }} />
            <input type="email" placeholder="Email" value={form.email} onChange={e => setForm({ ...form, email: e.target.value })} required
              style={{ padding: "0.75rem", border: "1px solid #ddd", borderRadius: "0.375rem" }} />
            <input placeholder="Phone" value={form.phone} onChange={e => setForm({ ...form, phone: e.target.value })}
              style={{ padding: "0.75rem", border: "1px solid #ddd", borderRadius: "0.375rem" }} />
            <textarea placeholder="Message" value={form.message} onChange={e => setForm({ ...form, message: e.target.value })} required rows={6}
              style={{ padding: "0.75rem", border: "1px solid #ddd", borderRadius: "0.375rem" }} />
            <button type="submit" className="btn-primary" style={{ border: "none", cursor: "pointer" }}>Send Message</button>
          </form>
        )}
      </section>
    </div>
  )
}
