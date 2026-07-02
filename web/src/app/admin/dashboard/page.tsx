"use client"

import { useEffect, useState } from "react"
import Link from "next/link"
import { signOut } from "next-auth/react"

export default function Dashboard() {
  const [stats, setStats] = useState({ properties: 0, inquiries: 0, team: 0, testimonials: 0 })

  useEffect(() => {
    Promise.all([
      fetch("/api/properties").then(r => r.json()),
      fetch("/api/inquiries").then(r => r.json()),
      fetch("/api/team").then(r => r.json()),
      fetch("/api/testimonials").then(r => r.json()),
    ]).then(([p, i, t, ts]) => setStats({ properties: p.length, inquiries: i.length, team: t.length, testimonials: ts.length }))
  }, [])

  const cards = [
    { label: "Properties", count: stats.properties, href: "/admin/properties" },
    { label: "Inquiries", count: stats.inquiries, href: "/admin/inquiries" },
    { label: "Team Members", count: stats.team, href: "/admin/team" },
    { label: "Testimonials", count: stats.testimonials, href: "/admin/testimonials" },
  ]

  return (
    <div className="admin-layout">
      <aside className="admin-sidebar">
        <h2 style={{ color: "var(--primary)", marginBottom: "2rem", paddingLeft: "1rem" }}>Dolza Admin</h2>
        <Link href="/admin/dashboard" className="active">Dashboard</Link>
        <Link href="/admin/properties">Properties</Link>
        <Link href="/admin/team">Team</Link>
        <Link href="/admin/testimonials">Testimonials</Link>
        <Link href="/admin/inquiries">Inquiries</Link>
        <Link href="/admin/content">Content</Link>
        <Link href="/admin/media">Media</Link>
        <Link href="/admin/settings">Settings</Link>
        <div style={{ marginTop: "auto", paddingTop: "2rem" }}>
          <Link href="/">View Site</Link>
          <button onClick={() => signOut({ callbackUrl: "/admin/login" })} style={{ background: "none", border: "none", color: "rgba(255,255,255,0.7)", padding: "0.75rem 1rem", cursor: "pointer", width: "100%", textAlign: "left", borderRadius: "0.375rem" }}>Sign Out</button>
        </div>
      </aside>
      <main className="admin-main">
        <h1 style={{ marginBottom: "2rem" }}>Dashboard</h1>
        <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill, minmax(220px, 1fr))", gap: "1.5rem" }}>
          {cards.map(c => (
            <Link key={c.label} href={c.href} style={{ background: "#fff", padding: "1.5rem", borderRadius: "0.75rem", boxShadow: "0 2px 8px rgba(0,0,0,0.06)", textDecoration: "none", color: "inherit" }}>
              <div style={{ fontSize: "2rem", fontWeight: 700, color: "var(--primary)" }}>{c.count}</div>
              <div style={{ color: "#777" }}>{c.label}</div>
            </Link>
          ))}
        </div>
      </main>
    </div>
  )
}
