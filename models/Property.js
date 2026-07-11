const mongoose = require('mongoose');

const propertySchema = new mongoose.Schema({
  title: { type: String, required: true },
  slug: { type: String, required: true, unique: true },
  location: { type: String, default: '' },
  price: { type: String, default: '' },
  priceValue: { type: Number, default: 0 },
  size: { type: String, default: '' },
  bedrooms: { type: Number, default: 0 },
  bathrooms: { type: Number, default: 0 },
  type: { type: String, default: '' },
  status: { type: String, default: '' },
  description: { type: String, default: '' },
  features: [{ type: String }],
  images: [{ type: String }],
  imageUrls: [{ type: String }],
  featured: { type: Boolean, default: false },
  published: { type: Boolean, default: true },
  order: { type: Number, default: 0 },
}, { timestamps: true });

module.exports = mongoose.model('Property', propertySchema);
