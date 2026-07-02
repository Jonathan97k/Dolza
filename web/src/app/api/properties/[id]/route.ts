import { NextResponse } from "next/server"
import { prisma } from "@/lib/prisma"
import { auth } from "@/lib/auth"

export async function GET(_req: Request, { params }: { params: Promise<{ id: string }> }) {
  const { id } = await params
  const property = await prisma.property.findUnique({ where: { id } })
  if (!property) return NextResponse.json({ error: "Not found" }, { status: 404 })
  return NextResponse.json(property)
}

export async function PUT(req: Request, { params }: { params: Promise<{ id: string }> }) {
  const session = await auth()
  if (!session) return NextResponse.json({ error: "Unauthorized" }, { status: 401 })
  const { id } = await params

  const body = await req.json()
  const property = await prisma.property.update({
    where: { id },
    data: {
      title: body.title,
      description: body.description,
      price: body.price ? parseFloat(body.price) : undefined,
      surface: body.surface !== undefined ? parseFloat(body.surface) : undefined,
      rooms: body.rooms !== undefined ? parseInt(body.rooms) : undefined,
      bedrooms: body.bedrooms !== undefined ? parseInt(body.bedrooms) : undefined,
      bathrooms: body.bathrooms !== undefined ? parseInt(body.bathrooms) : undefined,
      location: body.location,
      city: body.city,
      type: body.type,
      status: body.status,
      features: body.features,
      images: body.images,
      videoUrl: body.videoUrl,
      virtualTour: body.virtualTour,
      latitude: body.latitude !== undefined ? parseFloat(body.latitude) : undefined,
      longitude: body.longitude !== undefined ? parseFloat(body.longitude) : undefined,
      featured: body.featured,
    },
  })
  return NextResponse.json(property)
}

export async function DELETE(_req: Request, { params }: { params: Promise<{ id: string }> }) {
  const session = await auth()
  if (!session) return NextResponse.json({ error: "Unauthorized" }, { status: 401 })
  const { id } = await params
  await prisma.property.delete({ where: { id } })
  return NextResponse.json({ success: true })
}
