import { NextResponse } from "next/server"
import { prisma } from "@/lib/prisma"
import { auth } from "@/lib/auth"

export async function GET() {
  const inquiries = await prisma.inquiry.findMany({
    orderBy: { createdAt: "desc" },
    include: { property: { select: { title: true } } },
  })
  return NextResponse.json(inquiries)
}

export async function POST(req: Request) {
  const body = await req.json()
  const inquiry = await prisma.inquiry.create({
    data: {
      propertyId: body.propertyId || null,
      name: body.name,
      email: body.email,
      phone: body.phone,
      message: body.message,
      type: body.type || "property",
    },
  })
  return NextResponse.json(inquiry, { status: 201 })
}
