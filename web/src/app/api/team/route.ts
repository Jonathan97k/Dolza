import { NextResponse } from "next/server"
import { prisma } from "@/lib/prisma"
import { auth } from "@/lib/auth"

export async function GET() {
  const members = await prisma.team.findMany({ orderBy: { order: "asc" } })
  return NextResponse.json(members)
}

export async function POST(req: Request) {
  const session = await auth()
  if (!session) return NextResponse.json({ error: "Unauthorized" }, { status: 401 })

  const body = await req.json()
  const member = await prisma.team.create({
    data: {
      name: body.name,
      role: body.role,
      bio: body.bio,
      image: body.image,
      email: body.email,
      phone: body.phone,
      order: body.order ? parseInt(body.order) : 0,
    },
  })
  return NextResponse.json(member, { status: 201 })
}
