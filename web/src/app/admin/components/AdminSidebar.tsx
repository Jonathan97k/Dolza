"use client"

import Link from "next/link"
import { usePathname } from "next/navigation"
import { signOut } from "next-auth/react"

export default function AdminSidebar() {
  const pathname = usePathname()

  const links = [
    { href: "/admin/dashboard", label: "Dashboard" },
    { href: "/admin/properties", label: "Properties" },
    { href: "/admin/team", label: "Team" },
    { href: "/admin/testimonials", label: "Testimonials" },
    { href: "/admin/inquiries", label: "Inquiries" },
    { href: "/admin/content", label: "Content" },
    { href: "/admin/media", label: "Media" },
    { href: "/admin/settings", label: "Settings" },
  ]

  return (
    <aside className="admin-sidebar" style={{ display: "flex", flexDirection: "column" }}>
      <h2 style={{ color: "var(--primary)", marginBottom: "2rem", paddingLeft: "1rem" }}>Dolza Admin</h2>
      <nav style={{ flex: 1 }}>
        {links.map(l => (
          <Link key={l.href} href={l.href} className={pathname === l.href ? "active" : ""}>{l.label}</Link>
        ))}
      </nav>
      <div>
        <Link href="/">View Site</Link>
        <button onClick={() => signOut({ callbackUrl: "/admin/login" })}
          style={{ background: "none", border: "none", color: "rgba(255,255,255,0.7)", padding: "0.75rem 1rem", cursor: "pointer", width: "100%", textAlign: "left", borderRadius: "0.375rem" }}>Sign Out</button>
      </div>
    </aside>
  )
}
