const Setting = require('../models/Setting');

const router = require('express').Router();

router.get('/', async (req, res) => {
  const settings = await Setting.find();
  const map = {};
  settings.forEach(s => { map[s.key] = s.value; });
  res.json(map);
});

router.get('/:key', async (req, res) => {
  const setting = await Setting.findOne({ key: req.params.key });
  if (!setting) return res.status(404).json({ error: 'Not found' });
  res.json(setting);
});

router.put('/:key', async (req, res) => {
  const setting = await Setting.findOneAndUpdate(
    { key: req.params.key },
    { value: req.body.value },
    { new: true, upsert: true }
  );
  res.json(setting);
});

module.exports = router;
