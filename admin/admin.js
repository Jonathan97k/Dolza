let currentId = null;

function $(id) { return document.getElementById(id); }

const navLinks = document.querySelectorAll('.admin-sidebar nav a');
navLinks.forEach(a => a.addEventListener('click', e => {
  e.preventDefault();
  navLinks.forEach(l => l.classList.remove('active'));
  a.classList.add('active');
  loadSection(a.dataset.section);
}));

async function api(path, opts = {}) {
  const res = await fetch('/api' + path, {
    headers: { 'Accept': 'application/json', ...(opts.body && !(opts.body instanceof FormData) ? { 'Content-Type': 'application/json' } : {}) },
    ...opts,
  });
  if (!res.ok) { const e = await res.json().catch(() => ({ error: res.statusText })); throw new Error(e.error); }
  return opts.raw ? res : res.json();
}

function loadSection(section) {
  $('sectionTitle').textContent = section.charAt(0).toUpperCase() + section.slice(1);
  const el = $('adminContent');
  if (section === 'dashboard') renderDashboard(el);
  else if (section === 'properties') renderProperties(el);
  else if (section === 'team') renderTeam(el);
  else if (section === 'testimonials') renderTestimonials(el);
  else if (section === 'inquiries') renderInquiries(el);
  else if (section === 'content') renderContent(el);
  else if (section === 'settings') renderSettings(el);
}

async function renderDashboard(el) {
  const d = await api('/counts');
  el.innerHTML = `<div class="card-grid">
    <div class="stat-card"><h3>${d.properties}</h3><p>Properties</p></div>
    <div class="stat-card"><h3>${d.team}</h3><p>Team</p></div>
    <div class="stat-card"><h3>${d.testimonials}</h3><p>Testimonials</p></div>
    <div class="stat-card"><h3>${d.inquiries}</h3><p>Inquiries</p></div>
    <div class="stat-card"><h3>${d.settings}</h3><p>Settings</p></div>
  </div>`;
}

// ─── Properties ────────────────────────────────────────────

async function renderProperties(el) {
  const props = await api('/properties?published=true');
  el.innerHTML = `<button class="btn btn-primary" onclick="openPropertyModal()">Add Property</button>
    <table class="table"><thead><tr><th>Title</th><th>Location</th><th>Price</th><th>Type</th><th>Actions</th></tr></thead>
    <tbody>${props.map(p => `<tr>
      <td>${p.title}</td><td>${p.location}</td><td>${p.price}</td><td>${p.type}</td>
      <td><button class="btn btn-sm btn-primary" onclick="openPropertyModal('${p._id}')">Edit</button>
      <button class="btn btn-sm btn-danger" onclick="deleteProperty('${p._id}')">Delete</button></td>
    </tr>`).join('')}</tbody></table>`;
}

async function openPropertyModal(id) {
  currentId = id;
  const p = id ? await api('/properties/' + id) : {};
  showModal(`
    <h2>${id ? 'Edit' : 'Add'} Property</h2>
    <div class="form-row">
      <div class="form-group"><label>Title</label><input id="pf-title" value="${esc(p.title||'')}"></div>
      <div class="form-group"><label>Slug</label><input id="pf-slug" value="${esc(p.slug||'')}"></div>
    </div>
    <div class="form-row">
      <div class="form-group"><label>Location</label><input id="pf-location" value="${esc(p.location||'')}"></div>
      <div class="form-group"><label>Price (display)</label><input id="pf-price" value="${esc(p.price||'')}"></div>
    </div>
    <div class="form-row">
      <div class="form-group"><label>Price Value (numeric)</label><input id="pf-priceValue" type="number" value="${p.priceValue||0}"></div>
      <div class="form-group"><label>Size</label><input id="pf-size" value="${esc(p.size||'')}"></div>
    </div>
    <div class="form-row">
      <div class="form-group"><label>Bedrooms</label><input id="pf-bedrooms" type="number" value="${p.bedrooms||0}"></div>
      <div class="form-group"><label>Bathrooms</label><input id="pf-bathrooms" type="number" value="${p.bathrooms||0}"></div>
    </div>
    <div class="form-row">
      <div class="form-group"><label>Type</label><input id="pf-type" value="${esc(p.type||'')}"></div>
      <div class="form-group"><label>Status</label><input id="pf-status" value="${esc(p.status||'')}"></div>
    </div>
    <div class="form-group"><label>Description</label><textarea id="pf-description">${esc(p.description||'')}</textarea></div>
    <div class="form-group"><label>Features (comma separated)</label><input id="pf-features" value="${esc((p.features||[]).join(', '))}"></div>
    <div class="form-group"><label>Images</label><div class="image-upload-area" onclick="document.getElementById('pf-images').click()">Click to upload images</div><input id="pf-images" type="file" multiple accept="image/*" style="display:none">
    ${(p.imageUrls||[]).length ? '<div class="image-grid">' + p.imageUrls.map(u => '<img src="'+u+'">').join('') + '</div>' : ''}</div>
    <div class="form-row">
      <div class="form-group"><label><input id="pf-featured" type="checkbox" ${p.featured?'checked':''}> Featured</label></div>
      <div class="form-group"><label>Order</label><input id="pf-order" type="number" value="${p.order||0}"></div>
    </div>
    <div class="modal-actions">
      <button class="btn btn-primary" onclick="saveProperty()">Save</button>
      <button class="btn" onclick="closeModal()">Cancel</button>
    </div>`);
}

async function saveProperty() {
  const fd = new FormData();
  fd.append('title', $('pf-title').value);
  fd.append('slug', $('pf-slug').value);
  fd.append('location', $('pf-location').value);
  fd.append('price', $('pf-price').value);
  fd.append('priceValue', $('pf-priceValue').value);
  fd.append('size', $('pf-size').value);
  fd.append('bedrooms', $('pf-bedrooms').value);
  fd.append('bathrooms', $('pf-bathrooms').value);
  fd.append('type', $('pf-type').value);
  fd.append('status', $('pf-status').value);
  fd.append('description', $('pf-description').value);
  fd.append('features', JSON.stringify($('pf-features').value.split(',').map(s => s.trim()).filter(Boolean)));
  fd.append('featured', $('pf-featured').checked);
  fd.append('order', $('pf-order').value);
  const fileInput = $('pf-images');
  if (fileInput.files.length) for (const f of fileInput.files) fd.append('images', f);
  await api('/properties' + (currentId ? '/' + currentId : ''), { method: currentId ? 'PUT' : 'POST', body: fd });
  closeModal();
  loadSection('properties');
}

async function deleteProperty(id) {
  if (!confirm('Delete this property?')) return;
  await api('/properties/' + id, { method: 'DELETE' });
  loadSection('properties');
}

// ─── Team ──────────────────────────────────────────────────

async function renderTeam(el) {
  const members = await api('/team');
  el.innerHTML = `<button class="btn btn-primary" onclick="openTeamModal()">Add Member</button>
    <table class="table"><thead><tr><th>Name</th><th>Role</th><th>Actions</th></tr></thead>
    <tbody>${members.map(m => `<tr>
      <td>${m.name}</td><td>${m.role}</td>
      <td><button class="btn btn-sm btn-primary" onclick="openTeamModal('${m._id}')">Edit</button>
      <button class="btn btn-sm btn-danger" onclick="deleteTeam('${m._id}')">Delete</button></td>
    </tr>`).join('')}</tbody></table>`;
}

async function openTeamModal(id) {
  currentId = id;
  const m = id ? (await api('/team')).find(x => x._id === id) : {};
  showModal(`
    <h2>${id ? 'Edit' : 'Add'} Team Member</h2>
    <div class="form-row">
      <div class="form-group"><label>Name</label><input id="tm-name" value="${esc(m.name||'')}"></div>
      <div class="form-group"><label>Role</label><input id="tm-role" value="${esc(m.role||'')}"></div>
    </div>
    <div class="form-group"><label>Bio</label><textarea id="tm-bio">${esc(m.bio||'')}</textarea></div>
    <div class="form-row">
      <div class="form-group"><label>Email</label><input id="tm-email" value="${esc(m.email||'')}"></div>
      <div class="form-group"><label>Phone</label><input id="tm-phone" value="${esc(m.phone||'')}"></div>
    </div>
    <div class="form-group"><label>Photo</label><div class="image-upload-area" onclick="document.getElementById('tm-image').click()">Click to upload photo</div><input id="tm-image" type="file" accept="image/*" style="display:none">
    ${m.image ? '<div class="image-grid"><img src="'+m.image+'"></div>' : ''}</div>
    <div class="modal-actions">
      <button class="btn btn-primary" onclick="saveTeam()">Save</button>
      <button class="btn" onclick="closeModal()">Cancel</button>
    </div>`);
}

async function saveTeam() {
  const fd = new FormData();
  fd.append('name', $('tm-name').value);
  fd.append('role', $('tm-role').value);
  fd.append('bio', $('tm-bio').value);
  fd.append('email', $('tm-email').value);
  fd.append('phone', $('tm-phone').value);
  const fi = $('tm-image');
  if (fi.files.length) fd.append('image', fi.files[0]);
  await api('/team' + (currentId ? '/' + currentId : ''), { method: currentId ? 'PUT' : 'POST', body: fd });
  closeModal();
  loadSection('team');
}

async function deleteTeam(id) {
  if (!confirm('Delete this team member?')) return;
  await api('/team/' + id, { method: 'DELETE' });
  loadSection('team');
}

// ─── Testimonials ──────────────────────────────────────────

async function renderTestimonials(el) {
  const t = await api('/testimonials');
  el.innerHTML = `<button class="btn btn-primary" onclick="openTestimonialModal()">Add Testimonial</button>
    <table class="table"><thead><tr><th>Name</th><th>Content</th><th>Rating</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>${t.map(x => `<tr>
      <td>${x.name}</td><td>${(x.content||'').slice(0,50)}</td><td>${'★'.repeat(x.rating)}</td>
      <td><span class="badge ${x.published?'badge-success':'badge-warning'}">${x.published?'Active':'Hidden'}</span></td>
      <td><button class="btn btn-sm btn-primary" onclick="openTestimonialModal('${x._id}')">Edit</button>
      <button class="btn btn-sm btn-danger" onclick="deleteTestimonial('${x._id}')">Delete</button></td>
    </tr>`).join('')}</tbody></table>`;
}

async function openTestimonialModal(id) {
  currentId = id;
  const t = id ? (await api('/testimonials')).find(x => x._id === id) : {};
  showModal(`
    <h2>${id ? 'Edit' : 'Add'} Testimonial</h2>
    <div class="form-row">
      <div class="form-group"><label>Name</label><input id="ts-name" value="${esc(t.name||'')}"></div>
      <div class="form-group"><label>Role</label><input id="ts-role" value="${esc(t.role||'')}"></div>
    </div>
    <div class="form-group"><label>Content</label><textarea id="ts-content">${esc(t.content||'')}</textarea></div>
    <div class="form-row">
      <div class="form-group"><label>Rating (1-5)</label><input id="ts-rating" type="number" min="1" max="5" value="${t.rating||5}"></div>
      <div class="form-group"><label>Order</label><input id="ts-order" type="number" value="${t.order||0}"></div>
    </div>
    <div class="form-group"><label>Photo</label><div class="image-upload-area" onclick="document.getElementById('ts-image').click()">Click to upload photo</div><input id="ts-image" type="file" accept="image/*" style="display:none"></div>
    <div class="form-group"><label><input id="ts-published" type="checkbox" ${t.published !== false ? 'checked' : ''}> Published</label></div>
    <div class="modal-actions">
      <button class="btn btn-primary" onclick="saveTestimonial()">Save</button>
      <button class="btn" onclick="closeModal()">Cancel</button>
    </div>`);
}

async function saveTestimonial() {
  const fd = new FormData();
  fd.append('name', $('ts-name').value);
  fd.append('role', $('ts-role').value);
  fd.append('content', $('ts-content').value);
  fd.append('rating', $('ts-rating').value);
  fd.append('order', $('ts-order').value);
  fd.append('published', $('ts-published').checked);
  const fi = $('ts-image');
  if (fi.files.length) fd.append('image', fi.files[0]);
  await api('/testimonials' + (currentId ? '/' + currentId : ''), { method: currentId ? 'PUT' : 'POST', body: fd });
  closeModal();
  loadSection('testimonials');
}

async function deleteTestimonial(id) {
  if (!confirm('Delete this testimonial?')) return;
  await api('/testimonials/' + id, { method: 'DELETE' });
  loadSection('testimonials');
}

// ─── Inquiries ─────────────────────────────────────────────

async function renderInquiries(el) {
  const inquiries = await api('/inquiries');
  el.innerHTML = `<table class="table"><thead><tr><th>Date</th><th>Name</th><th>Email</th><th>Subject</th><th>Property</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>${inquiries.map(i => `<tr style="${i.read?'':'font-weight:bold;background:#f8f9ff'}">
      <td>${new Date(i.createdAt).toLocaleDateString()}</td><td>${esc(i.name)}</td><td>${esc(i.email)}</td>
      <td>${esc(i.subject||'')}</td><td>${esc(i.property||'')}</td>
      <td><span class="badge ${i.read?'badge-success':'badge-warning'}">${i.read?'Read':'New'}</span></td>
      <td><button class="btn btn-sm btn-primary" onclick="viewInquiry('${i._id}')">View</button>
      <button class="btn btn-sm btn-danger" onclick="deleteInquiry('${i._id}')">Delete</button></td>
    </tr>`).join('')}</tbody></table>`;
}

async function viewInquiry(id) {
  const inquiries = await api('/inquiries');
  const i = inquiries.find(x => x._id === id);
  if (!i.read) { i.read = true; await api('/inquiries/' + id, { method: 'PUT', body: JSON.stringify({ read: true }) }); }
  showModal(`
    <h2>Inquiry from ${esc(i.name)}</h2>
    <p><strong>Email:</strong> ${esc(i.email)}</p>
    <p><strong>Phone:</strong> ${esc(i.phone||'-')}</p>
    <p><strong>Subject:</strong> ${esc(i.subject||'-')}</p>
    <p><strong>Property:</strong> ${esc(i.property||'-')}</p>
    <p><strong>Date:</strong> ${new Date(i.createdAt).toLocaleString()}</p>
    <hr><p>${esc(i.message)}</p>
    <div class="modal-actions"><button class="btn" onclick="closeModal()">Close</button></div>`);
  loadSection('inquiries');
}

async function deleteInquiry(id) {
  if (!confirm('Delete this inquiry?')) return;
  await api('/inquiries/' + id, { method: 'DELETE' });
  loadSection('inquiries');
}

// ─── Content Blocks ────────────────────────────────────────

async function renderContent(el) {
  const blocks = await api('/content');
  el.innerHTML = `<p>Edit page content blocks below. Each block is identified by a unique key.</p>
    <div class="card-grid" style="margin-top:12px">${blocks.map(b => `<div class="card" style="cursor:pointer" onclick="openContentModal('${b.key}')">
      <strong>${b.key}</strong><br><small>${(b.title||'').slice(0,40) || 'no title'}</small>
    </div>`).join('')}</div>`;
}

async function openContentModal(key) {
  const b = await api('/content/' + key);
  showModal(`
    <h2>Edit: ${key}</h2>
    <div class="form-group"><label>Title</label><input id="cb-title" value="${esc(b.title||'')}"></div>
    <div class="form-group"><label>Subtitle</label><input id="cb-subtitle" value="${esc(b.subtitle||'')}"></div>
    <div class="form-group"><label>Body</label><textarea id="cb-body" style="min-height:150px">${esc(b.body||'')}</textarea></div>
    <div class="form-group"><label>Image</label><div class="image-upload-area" onclick="document.getElementById('cb-image').click()">Upload image</div><input id="cb-image" type="file" accept="image/*" style="display:none">
    ${b.image ? '<div class="image-grid"><img src="'+b.image+'"></div>' : ''}</div>
    <div class="modal-actions">
      <button class="btn btn-primary" onclick="saveContent('${key}')">Save</button>
      <button class="btn" onclick="closeModal()">Cancel</button>
    </div>`);
}

async function saveContent(key) {
  const fd = new FormData();
  fd.append('title', $('cb-title').value);
  fd.append('subtitle', $('cb-subtitle').value);
  fd.append('body', $('cb-body').value);
  const fi = $('cb-image');
  if (fi.files.length) fd.append('image', fi.files[0]);
  await api('/content/' + key, { method: 'PUT', body: fd });
  closeModal();
  loadSection('content');
}

// ─── Settings ──────────────────────────────────────────────

async function renderSettings(el) {
  const s = await api('/settings');
  el.innerHTML = Object.entries(s).map(([k, v]) => `<div class="card">
    <strong>${k}</strong>
    <div style="margin-top:8px;display:flex;gap:8px">
      <input id="set-${k}" value="${esc(typeof v === 'object' ? JSON.stringify(v) : String(v))}" style="flex:1;padding:6px 8px;border:1px solid #ddd;border-radius:6px">
      <button class="btn btn-primary btn-sm" onclick="saveSetting('${k}')">Save</button>
    </div>
  </div>`).join('');
}

async function saveSetting(key) {
  const val = $('set-' + key).value;
  await api('/settings/' + key, { method: 'PUT', body: JSON.stringify({ value: val }) });
  alert('Saved ' + key);
}

// ─── Modal helpers ─────────────────────────────────────────

function showModal(html) {
  let m = document.querySelector('.modal');
  if (!m) { m = document.createElement('div'); m.className = 'modal'; document.body.appendChild(m); }
  m.innerHTML = `<div class="modal-content">${html}</div>`;
  m.classList.add('open');
  m.addEventListener('click', e => { if (e.target === m) closeModal(); });
}

function closeModal() { const m = document.querySelector('.modal'); if (m) m.classList.remove('open'); }

function esc(s) { if (!s) return ''; return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

// ─── Init ──────────────────────────────────────────────────

loadSection('dashboard');
