const ContentBlock = require('../models/ContentBlock');
const { upload } = require('../models/cloudinary');

const router = require('express').Router();

router.get('/', async (req, res) => {
  const blocks = await ContentBlock.find().sort({ createdAt: -1 });
  res.json(blocks);
});

router.get('/:key', async (req, res) => {
  const block = await ContentBlock.findOne({ key: req.params.key });
  if (!block) return res.status(404).json({ error: 'Not found' });
  res.json(block);
});

router.put('/:key', upload.single('image'), async (req, res) => {
  const data = JSON.parse(JSON.stringify(req.body));
  if (req.file) data.image = req.file.path;
  const block = await ContentBlock.findOneAndUpdate({ key: req.params.key }, data, { new: true, upsert: true });
  res.json(block);
});

router.put('/:key/extra', async (req, res) => {
  const block = await ContentBlock.findOneAndUpdate(
    { key: req.params.key },
    { $set: { extra: req.body } },
    { new: true, upsert: true }
  );
  res.json(block);
});

module.exports = router;
