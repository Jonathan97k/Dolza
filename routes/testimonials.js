const Testimonial = require('../models/Testimonial');
const { cloudinary, upload } = require('../models/cloudinary');

const router = require('express').Router();

router.get('/', async (req, res) => {
  const filter = {};
  if (req.query.published !== undefined) filter.published = req.query.published === 'true';
  const testimonials = await Testimonial.find(filter).sort({ order: 1, createdAt: -1 });
  res.json(testimonials);
});

router.post('/', upload.single('image'), async (req, res) => {
  const data = JSON.parse(JSON.stringify(req.body));
  if (req.file) data.image = req.file.path;
  const testimonial = await Testimonial.create(data);
  res.json(testimonial);
});

router.put('/:id', upload.single('image'), async (req, res) => {
  const data = JSON.parse(JSON.stringify(req.body));
  if (req.file) data.image = req.file.path;
  if (data._id) delete data._id;
  const testimonial = await Testimonial.findByIdAndUpdate(req.params.id, data, { new: true });
  res.json(testimonial);
});

router.delete('/:id', async (req, res) => {
  await Testimonial.findByIdAndDelete(req.params.id);
  res.json({ success: true });
});

module.exports = router;
