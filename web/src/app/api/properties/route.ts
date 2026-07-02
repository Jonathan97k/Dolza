import { NextResponse } from "next/server"
import { prisma } from "@/lib/prisma"
import { auth } from "@/lib/auth"

export async function GET() {
  const properties = await prisma.property.findMany({ orderBy: { createdAt: "desc" } })
  return NextResponse.json(properties)
}

export async function POST(req: Request) {
  const session = await auth()
  if (!session) return NextResponse.json({ error: "Unauthorized" }, { status: 401 })

  const body = await req.json()
  const property = await prisma.property.create({
    data: {
      title: body.title,
      description: body.description,
      price: parseFloat(body.price),
      surface: body.surface ? parseFloat(body.surface) : null,
      rooms: body.rooms ? parseInt(body.rooms) : null,
      bedrooms: body.bedrooms ? parseInt(body.bedrooms) : null,
      bathrooms: body.bathrooms ? parseInt(body.bathrooms) : null,
      location: body.location,
      city: body.city,
      type: body.type || "sale",
      status: body.status || "available",
      features: body.features || "[]",
      images: body.images || "[]",
      videoUrl: body.videoUrl,
      virtualTour: body.virtualTour,
      latitude: body.latitude ? parseFloat(body.latitude) : null,
      longitude: body.longitude ? parseFloat(body.longitude) : null,
      featured: body.featured || false,
    },
  })
  return NextResponse.json(property, { status: 201 })
}
