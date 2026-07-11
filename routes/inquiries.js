const Inquiry = require('../models/Inquiry');

const router = require('express').Router();

router.get('/', async (req, res) => {
  const inquiries = await Inquiry.find().sort({ createdAt: -1 });
  res.json(inquiries);
});

router.post('/', async (req, res) => {
  const inquiry = await Inquiry.create(req.body);
  res.json(inquiry);
});

router.put('/:id', async (req, res) => {
  const inquiry = await Inquiry.findByIdAndUpdate(req.params.id, req.body, { new: true });
  res.json(inquiry);
});

router.delete('/:id', async (req, res) => {
  await Inquiry.findByIdAndDelete(req.params.id);
  res.json({ success: true });
});

module.exports = router;
