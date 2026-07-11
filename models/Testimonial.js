const mongoose = require('mongoose');

const testimonialSchema = new mongoose.Schema({
  name: { type: String, required: true },
  role: { type: String, default: '' },
  content: { type: String, default: '' },
  rating: { type: Number, default: 5 },
  image: { type: String, default: '' },
  published: { type: Boolean, default: true },
  order: { type: Number, default: 0 },
}, { timestamps: true });

module.exports = mongoose.model('Testimonial', testimonialSchema);
