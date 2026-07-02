import Link from "next/link"
import { prisma } from "@/lib/prisma"
import PropertiesClient from "./PropertiesClient"

export const dynamic = "force-dynamic"

export default async function Properties() {
  const properties = await prisma.property.findMany({ orderBy: { createdAt: "desc" } })

  return (
    <div>
      <nav style={{ padding: "1rem 2rem", display: "flex", justifyContent: "space-between", alignItems: "center", background: "#fff", boxShadow: "0 2px 10px rgba(0,0,0,0.05)" }}>
        <Link href="/" style={{ fontSize: "1.5rem", fontWeight: 700, color: "var(--primary)", textDecoration: "none" }}>Dolza</Link>
        <div style={{ display: "flex", gap: "1.5rem" }}>
          <Link href="/" style={{ color: "var(--text)", textDecoration: "none" }}>Home</Link>
          <Link href="/properties" style={{ color: "var(--primary)", textDecoration: "none", fontWeight: 600 }}>Properties</Link>
          <Link href="/about" style={{ color: "var(--text)", textDecoration: "none" }}>About</Link>
          <Link href="/contact" style={{ color: "var(--text)", textDecoration: "none" }}>Contact</Link>
        </div>
      </nav>

      <section className="section">
        <h1 className="section-title">Our Properties</h1>
        <p className="section-subtitle">Browse our collection of premium real estate</p>

        <PropertiesClient properties={JSON.parse(JSON.stringify(properties))} />
      </section>
    </div>
  )
}
