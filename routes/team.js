const TeamMember = require('../models/TeamMember');
const { cloudinary, upload } = require('../models/cloudinary');

const router = require('express').Router();

router.get('/', async (req, res) => {
  const members = await TeamMember.find().sort({ order: 1, createdAt: -1 });
  res.json(members);
});

router.post('/', upload.single('image'), async (req, res) => {
  const data = JSON.parse(JSON.stringify(req.body));
  if (req.file) data.image = req.file.path;
  const member = await TeamMember.create(data);
  res.json(member);
});

router.put('/:id', upload.single('image'), async (req, res) => {
  const data = JSON.parse(JSON.stringify(req.body));
  if (req.file) data.image = req.file.path;
  if (data._id) delete data._id;
  const member = await TeamMember.findByIdAndUpdate(req.params.id, data, { new: true });
  res.json(member);
});

router.delete('/:id', async (req, res) => {
  const member = await TeamMember.findById(req.params.id);
  if (member && member.image) {
    const publicId = member.image.split('/').pop().split('.')[0];
    await cloudinary.uploader.destroy('dolza/' + publicId).catch(() => {});
  }
  await TeamMember.findByIdAndDelete(req.params.id);
  res.json({ success: true });
});

module.exports = router;
