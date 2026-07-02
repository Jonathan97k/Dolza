import { NextResponse } from "next/server"
import { prisma } from "@/lib/prisma"
import { auth } from "@/lib/auth"

export async function GET() {
  const testimonials = await prisma.testimonial.findMany({ orderBy: { createdAt: "desc" } })
  return NextResponse.json(testimonials)
}

export async function POST(req: Request) {
  const session = await auth()
  if (!session) return NextResponse.json({ error: "Unauthorized" }, { status: 401 })

  const body = await req.json()
  const testimonial = await prisma.testimonial.create({
    data: {
      name: body.name,
      role: body.role,
      content: body.content,
      rating: body.rating ? parseInt(body.rating) : 5,
      image: body.image,
    },
  })
  return NextResponse.json(testimonial, { status: 201 })
}
