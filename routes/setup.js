const Property = require('../models/Property');
const TeamMember = require('../models/TeamMember');
const Testimonial = require('../models/Testimonial');
const ContentBlock = require('../models/ContentBlock');
const Setting = require('../models/Setting');

const router = require('express').Router();

router.get('/counts', async (req, res) => {
  const [properties, team, testimonials, inquiries, settings] = await Promise.all([
    Property.countDocuments(), TeamMember.countDocuments(), Testimonial.countDocuments(),
    require('../models/Inquiry').countDocuments(), Setting.countDocuments(),
  ]);
  res.json({ properties, team, testimonials, inquiries, settings });
});

router.get('/check-seed', async (req, res) => {
  const count = await Property.countDocuments();
  res.json({ seeded: count > 0, count });
});

module.exports = router;
