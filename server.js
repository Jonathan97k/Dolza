if (process.env.NODE_ENV !== 'production') require('dotenv').config();
const app = require('./lib/app');
const PORT = process.env.PORT || 5000;
app.listen(PORT, () => console.log('Dolza running on port ' + PORT));
