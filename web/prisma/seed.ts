import { PrismaClient } from "@prisma/client"
import bcrypt from "bcryptjs"

const prisma = new PrismaClient()

async function main() {
  const admin = await prisma.user.upsert({
    where: { email: "dolza@admin.com" },
    update: {},
    create: {
      name: "Admin",
      email: "dolza@admin.com",
      password: await bcrypt.hash("Dolza2008!", 10),
    },
  })
  console.log("Admin user:", admin.email)

  const prop = await prisma.property.upsert({
    where: { id: "demo-prop-1" },
    update: {},
    create: {
      id: "demo-prop-1",
      title: "Luxury Villa with Pool",
      description: "Beautiful modern villa with panoramic views, swimming pool, and spacious garden.",
      price: 850000,
      surface: 320,
      rooms: 8,
      bedrooms: 5,
      bathrooms: 3,
      location: "Beverly Hills",
      city: "Los Angeles",
      type: "sale",
      status: "available",
      features: '["Pool","Garden","Garage","AC","Fireplace"]',
      images: '["https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800"]',
    },
  })
  console.log("Demo property:", prop.title)

  const member = await prisma.team.upsert({
    where: { id: "demo-team-1" },
    update: {},
    create: {
      id: "demo-team-1",
      name: "John Smith",
      role: "CEO & Founder",
      bio: "Over 15 years of experience in luxury real estate.",
      email: "john@dolza.com",
      order: 1,
    },
  })
  console.log("Team member:", member.name)

  const testimonial = await prisma.testimonial.upsert({
    where: { id: "demo-test-1" },
    update: {},
    create: {
      id: "demo-test-1",
      name: "Sarah Johnson",
      role: "Home Buyer",
      content: "Dolza made our home buying journey seamless and enjoyable. Highly recommended!",
      rating: 5,
    },
  })
  console.log("Testimonial:", testimonial.name)
}

main()
  .catch(e => { console.error(e); process.exit(1) })
  .finally(() => prisma.$disconnect())
