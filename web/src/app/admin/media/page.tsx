"use client"

import { useState } from "react"
import AdminSidebar from "../components/AdminSidebar"

export default function AdminMedia() {
  const [uploading, setUploading] = useState(false)
  const [url, setUrl] = useState("")

  const handleUpload = async (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0]
    if (!file) return
    setUploading(true)
    const formData = new FormData()
    formData.append("file", file)
    const res = await fetch("/api/media", { method: "POST", body: formData })
    const data = await res.json()
    setUrl(data.url)
    setUploading(false)
  }

  return (
    <div className="admin-layout">
      <AdminSidebar />
      <main className="admin-main">
        <h1 style={{ marginBottom: "2rem" }}>Media</h1>
        <div style={{ background: "#fff", padding: "2rem", borderRadius: "0.75rem" }}>
          <input type="file" onChange={handleUpload} disabled={uploading} />
          {uploading && <p>Uploading...</p>}
          {url && (
            <div style={{ marginTop: "1rem" }}>
              <p>URL: <code>{url}</code></p>
              <img src={url} alt="Uploaded" style={{ maxWidth: 300, marginTop: "0.5rem", borderRadius: "0.375rem" }} />
            </div>
          )}
        </div>
      </main>
    </div>
  )
}
