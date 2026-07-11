const { Property } = require('../models/Property');
const { cloudinary, upload } = require('../models/cloudinary');
const slugify = require('slugify');

const router = require('express').Router();

router.get('/', async (req, res) => {
  const filter = {};
  if (req.query.type) filter.type = req.query.type;
  if (req.query.status) filter.status = req.query.status;
  if (req.query.featured === 'true') filter.featured = true;
  if (req.query.published !== undefined) filter.published = req.query.published === 'true';
  const properties = await Property.find(filter).sort({ order: 1, createdAt: -1 });
  res.json(properties);
});

router.get('/:slug', async (req, res) => {
  const property = await Property.findOne({ slug: req.params.slug });
  if (!property) return res.status(404).json({ error: 'Not found' });
  res.json(property);
});

router.post('/', upload.array('images', 20), async (req, res) => {
  const data = JSON.parse(JSON.stringify(req.body));
  if (req.files) data.imageUrls = req.files.map(f => f.path);
  if (!data.slug) data.slug = slugify(data.title, { lower: true, strict: true });
  const property = await Property.create(data);
  res.json(property);
});

router.put('/:id', upload.array('images', 20), async (req, res) => {
  const data = JSON.parse(JSON.stringify(req.body));
  if (req.files && req.files.length) {
    const existing = await Property.findById(req.params.id);
    data.imageUrls = [...(existing.imageUrls || []), ...req.files.map(f => f.path)];
  }
  if (data._id) delete data._id;
  const property = await Property.findByIdAndUpdate(req.params.id, data, { new: true });
  res.json(property);
});

router.put('/:id/reorder-images', async (req, res) => {
  const { imageUrls } = req.body;
  await Property.findByIdAndUpdate(req.params.id, { imageUrls });
  res.json({ success: true });
});

router.delete('/:id', async (req, res) => {
  const property = await Property.findById(req.params.id);
  if (property && property.imageUrls) {
    for (const url of property.imageUrls) {
      const publicId = url.split('/').pop().split('.')[0];
      await cloudinary.uploader.destroy('dolza/' + publicId).catch(() => {});
    }
  }
  await Property.findByIdAndDelete(req.params.id);
  res.json({ success: true });
});

module.exports = router;
