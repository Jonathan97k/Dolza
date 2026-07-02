import { NextResponse } from "next/server"
import { prisma } from "@/lib/prisma"
import { auth } from "@/lib/auth"

export async function GET() {
  const content = await prisma.content.findMany()
  const map: Record<string, string> = {}
  for (const c of content) map[c.key] = c.value
  return NextResponse.json(map)
}

export async function POST(req: Request) {
  const session = await auth()
  if (!session) return NextResponse.json({ error: "Unauthorized" }, { status: 401 })

  const body = await req.json()
  const item = await prisma.content.create({ data: body })
  return NextResponse.json(item, { status: 201 })
}
