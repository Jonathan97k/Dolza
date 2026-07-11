const express = require('express');
const cors = require('cors');
const helmet = require('helmet');
const morgan = require('morgan');
const path = require('path');
require('../models/db');

const app = express();

app.use(helmet({ crossOriginResourcePolicy: { policy: 'cross-origin' }, contentSecurityPolicy: false }));
app.use(cors());
app.use(morgan('dev'));
app.use(express.json({ limit: '50mb' }));
app.use(express.urlencoded({ extended: true, limit: '50mb' }));
app.use(express.static(path.join(__dirname, '..')));

app.use('/api/properties', require('../routes/properties'));
app.use('/api/team', require('../routes/team'));
app.use('/api/testimonials', require('../routes/testimonials'));
app.use('/api/content', require('../routes/content'));
app.use('/api/inquiries', require('../routes/inquiries'));
app.use('/api/settings', require('../routes/settings'));
app.use('/api', require('../routes/setup'));

app.get('/admin*', (req, res) => res.sendFile(path.join(__dirname, '..', 'admin', 'index.html')));

app.get('*', (req, res) => {
  if (req.path.startsWith('/api')) return res.status(404).json({ error: 'API route not found' });
  if (req.path.startsWith('/admin') || req.path.startsWith('/images/') || req.path.startsWith('/data/')) return res.status(404).send('Not found');
  const page = req.path === '/' ? 'index.html' : req.path.replace(/^\//, '').replace(/\/$/, '') + '.html';
  res.sendFile(path.join(__dirname, '..', page), err => {
    if (err) res.sendFile(path.join(__dirname, '..', 'index.html'));
  });
});

app.use((err, req, res, next) => {
  console.error(err);
  res.status(500).json({ error: err.message || 'Internal server error' });
});

module.exports = app;
