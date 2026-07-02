"use client"

import { signIn } from "next-auth/react"
import { useState } from "react"
import { useRouter } from "next/navigation"

export default function Login() {
  const [email, setEmail] = useState("")
  const [password, setPassword] = useState("")
  const [error, setError] = useState("")
  const router = useRouter()

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setError("")
    const result = await signIn("credentials", { email, password, redirect: false })
    if (result?.error) setError("Invalid credentials")
    else router.push("/admin/dashboard")
  }

  return (
    <div style={{ minHeight: "100vh", display: "flex", alignItems: "center", justifyContent: "center", background: "#f5f5f5" }}>
      <form onSubmit={handleSubmit} style={{ background: "#fff", padding: "2.5rem", borderRadius: "0.75rem", boxShadow: "0 4px 15px rgba(0,0,0,0.08)", width: 400 }}>
        <h1 style={{ textAlign: "center", marginBottom: "0.5rem", color: "var(--primary)" }}>Dolza Admin</h1>
        <p style={{ textAlign: "center", color: "#777", marginBottom: "2rem" }}>Sign in to your account</p>
        {error && <p style={{ color: "red", textAlign: "center", marginBottom: "1rem" }}>{error}</p>}
        <input type="email" placeholder="Email" value={email} onChange={e => setEmail(e.target.value)} required
          style={{ width: "100%", padding: "0.75rem", marginBottom: "1rem", border: "1px solid #ddd", borderRadius: "0.375rem" }} />
        <input type="password" placeholder="Password" value={password} onChange={e => setPassword(e.target.value)} required
          style={{ width: "100%", padding: "0.75rem", marginBottom: "1.5rem", border: "1px solid #ddd", borderRadius: "0.375rem" }} />
        <button type="submit" className="btn-primary" style={{ width: "100%", border: "none", cursor: "pointer" }}>Sign In</button>
      </form>
    </div>
  )
}
