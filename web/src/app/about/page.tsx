import Link from "next/link"
import { prisma } from "@/lib/prisma"

export const dynamic = "force-dynamic"

export default async function About() {
  const team = await prisma.team.findMany({ orderBy: { order: "asc" } })

  return (
    <div>
      <nav style={{ padding: "1rem 2rem", display: "flex", justifyContent: "space-between", alignItems: "center", background: "#fff", boxShadow: "0 2px 10px rgba(0,0,0,0.05)" }}>
        <Link href="/" style={{ fontSize: "1.5rem", fontWeight: 700, color: "var(--primary)", textDecoration: "none" }}>Dolza</Link>
        <div style={{ display: "flex", gap: "1.5rem" }}>
          <Link href="/" style={{ color: "var(--text)", textDecoration: "none" }}>Home</Link>
          <Link href="/properties" style={{ color: "var(--text)", textDecoration: "none" }}>Properties</Link>
          <Link href="/about" style={{ color: "var(--primary)", textDecoration: "none", fontWeight: 600 }}>About</Link>
          <Link href="/contact" style={{ color: "var(--text)", textDecoration: "none" }}>Contact</Link>
        </div>
      </nav>

      <section className="section" style={{ maxWidth: 800, margin: "0 auto" }}>
        <h1 className="section-title">About Dolza</h1>
        <p className="section-subtitle">Your trusted partner in real estate</p>
        <p style={{ lineHeight: 1.8, color: "#555", marginBottom: "1rem" }}>
          Dolza is a premier real estate agency dedicated to helping clients find their perfect property. 
          With years of experience in the market, we provide expert guidance and personalized service 
          to make your real estate journey seamless and successful.
        </p>
        <p style={{ lineHeight: 1.8, color: "#555", marginBottom: "3rem" }}>
          Whether you are looking to buy, sell, or rent, our team of professionals is here to help you 
          every step of the way. We pride ourselves on our deep local knowledge, extensive network, 
          and commitment to excellence.
        </p>

        <h2 className="section-title" style={{ fontSize: "1.5rem" }}>Our Team</h2>
        <p className="section-subtitle">Meet the people behind Dolza</p>
        <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill, minmax(280px, 1fr))", gap: "2rem" }}>
          {team.map(m => (
            <div key={m.id} style={{ textAlign: "center", padding: "1.5rem", background: "#fff", borderRadius: "0.75rem", boxShadow: "0 2px 10px rgba(0,0,0,0.06)" }}>
              {m.image && <img src={m.image} alt={m.name} style={{ width: 120, height: 120, borderRadius: "50%", objectFit: "cover", marginBottom: "1rem" }} />}
              <h3 style={{ marginBottom: "0.25rem" }}>{m.name}</h3>
              <div style={{ color: "var(--primary)", fontWeight: 600, marginBottom: "0.5rem" }}>{m.role}</div>
              {m.bio && <p style={{ color: "#777", fontSize: "0.9rem", lineHeight: 1.6 }}>{m.bio}</p>}
            </div>
          ))}
        </div>
      </section>
    </div>
  )
}
