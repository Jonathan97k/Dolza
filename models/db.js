const mongoose = require('mongoose');
const uri = process.env.MONGODB_URI;
if (!uri) {
  console.error('MONGODB_URI not set');
  process.exit(1);
}
mongoose.connect(uri).then(() => console.log('MongoDB connected')).catch(e => { console.error(e); process.exit(1); });
module.exports = mongoose;
