// Dolza Public Site JS

async function api(path) {
  const res = await fetch('/api' + path);
  if (!res.ok) throw new Error('API error');
  return res.json();
}

function esc(s) { if (!s) return ''; return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

function renderProperties(container, properties) {
  container.innerHTML = properties.map(p => `
    <div class="property-card">
      <div class="prop-image">
        <img src="${esc(p.imageUrls?.[0] || 'https://placehold.co/600x400/1a1a2e/fff?text=Property')}" alt="${esc(p.title)}" loading="lazy">
        ${p.status ? '<div class="prop-badge">'+esc(p.status)+'</div>' : ''}
      </div>
      <div class="prop-body">
        <div class="prop-title"><a href="javascript:void(0)" onclick="openPropertyDetail('${p._id}')">${esc(p.title)}</a></div>
        <div class="prop-location">${esc(p.location)}</div>
        <div class="prop-price">${esc(p.price)}</div>
        <div class="prop-meta">
          ${p.bedrooms ? '<span>🛏️ '+p.bedrooms+' Beds</span>' : ''}
          ${p.bathrooms ? '<span>🚿 '+p.bathrooms+' Baths</span>' : ''}
          ${p.size ? '<span>📐 '+esc(p.size)+'</span>' : ''}
        </div>
      </div>
    </div>
  `).join('');
}

let allPropertiesCache = [];
let detailModal;

// Property Detail Modal
document.addEventListener('DOMContentLoaded', () => {
  detailModal = document.createElement('div');
  detailModal.className = 'property-detail-modal';
  detailModal.addEventListener('click', e => { if (e.target === detailModal) closePropertyDetail(); });
  document.body.appendChild(detailModal);
});

async function openPropertyDetail(id) {
  if (!allPropertiesCache.length) allPropertiesCache = await api('/properties');
  const p = allPropertiesCache.find(x => x._id === id);
  if (!p) return;
  detailModal.innerHTML = `
    <div class="property-detail-content">
      ${p.imageUrls?.length ? '<img class="detail-image" src="'+esc(p.imageUrls[0])+'" alt="'+esc(p.title)+'">' : ''}
      <div class="detail-body">
        <div class="price">${esc(p.price)}</div>
        <h2>${esc(p.title)}</h2>
        <p style="color:#888">${esc(p.location)}</p>
        ${p.size ? '<p><strong>Size:</strong> '+esc(p.size)+'</p>' : ''}
        <div class="detail-meta">
          ${p.bedrooms ? '<div><strong>'+p.bedrooms+'</strong><span>Bedrooms</span></div>' : ''}
          ${p.bathrooms ? '<div><strong>'+p.bathrooms+'</strong><span>Bathrooms</span></div>' : ''}
          ${p.type ? '<div><strong>'+esc(p.type)+'</strong><span>Type</span></div>' : ''}
          ${p.status ? '<div><strong>'+esc(p.status)+'</strong><span>Status</span></div>' : ''}
        </div>
        ${p.description ? '<p>'+esc(p.description)+'</p>' : ''}
        ${p.features?.length ? '<div style="margin-top:12px"><strong>Features:</strong><div class="tag-list" style="margin-top:8px;display:flex;flex-wrap:wrap;gap:8px">'+p.features.map(f => '<span class="tag" style="background:#eef;padding:4px 12px;border-radius:20px;font-size:0.85rem">'+esc(f)+'</span>').join('')+'</div></div>' : ''}
        <div style="margin-top:20px">
          <a class="btn btn-primary" href="contact.html?property=${esc(p.title)}">Inquire About This Property</a>
          <button class="btn btn-outline" onclick="closePropertyDetail()" style="margin-left:8px">Close</button>
        </div>
      </div>
    </div>`;
  detailModal.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closePropertyDetail() {
  detailModal.classList.remove('open');
  document.body.style.overflow = '';
}
