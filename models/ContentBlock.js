const mongoose = require('mongoose');

const contentBlockSchema = new mongoose.Schema({
  key: { type: String, required: true, unique: true },
  title: { type: String, default: '' },
  subtitle: { type: String, default: '' },
  body: { type: String, default: '' },
  image: { type: String, default: '' },
  extra: { type: mongoose.Schema.Types.Mixed, default: {} },
}, { timestamps: true });

module.exports = mongoose.model('ContentBlock', contentBlockSchema);
