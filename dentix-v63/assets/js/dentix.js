/* ══════════════════════════════════════════════════════════════
   dentix.js — JavaScript compartido todas las páginas
   ══════════════════════════════════════════════════════════════ */

// ── Buscador dropdown ─────────────────────────────────────────
(function(){
  const block = document.querySelector('.search-block');
  const input = block && block.querySelector('input[type="search"]');
  const hint  = document.getElementById('searchHint');
  if (!input || !hint) return;

  let isOpen = false;

  function openHint()  { hint.style.display = 'flex'; isOpen = true; }
  function closeHint() { hint.style.display = '';     isOpen = false; }

  // Abrir al hacer foco en el input
  input.addEventListener('focus', openHint);

  // Cerrar con delay para que el click en tags tenga tiempo
  input.addEventListener('blur', () => setTimeout(closeHint, 150));

  // Cerrar al hacer click fuera
  document.addEventListener('click', (e) => {
    if (isOpen && !block.contains(e.target)) closeHint();
  });

  // Botón buscar y Enter → submit
  const form = input.closest('form');
  if (form) {
    const btn = form.querySelector('.search-btn');
    if (btn) btn.addEventListener('click', (e) => {
      e.preventDefault();
      if (input.value.trim()) form.submit();
    });
  }

  // Tags: navegan a la categoría directamente (son <a> con href)
  // Tags: <a> con href a categoría — NO cerrar en mousedown
  // El blur con 150ms deja tiempo al clic. Solo cerramos DESPUÉS del clic.
  hint.querySelectorAll('.search-tag').forEach(tag => {
    tag.addEventListener('click', () => setTimeout(closeHint, 80));
  });
})();

// ── Pills de filtro ───────────────────────────────────────────
document.querySelectorAll('.pill').forEach(p => {
  p.addEventListener('click', () => {
    const group = p.closest('.filter-pills');
    (group || document).querySelectorAll('.pill').forEach(x => x.classList.remove('on'));
    p.classList.add('on');
  });
});

// ── Wishlist toggle ───────────────────────────────────────────
document.querySelectorAll('.p-wish').forEach(w => {
  w.addEventListener('click', (e) => {
    e.stopPropagation();
    const liked = w.textContent.trim() === '♥';
    w.textContent = liked ? '♡' : '♥';
    w.style.color = liked ? '' : '#C0392B';
  });
});

// ── Nav: marca active según página actual ─────────────────────
(function(){
  const path = window.location.pathname.split('/').pop();
  document.querySelectorAll('.nav-item').forEach(el => {
    el.classList.remove('on');
    if(el.dataset.page && path.includes(el.dataset.page)) el.classList.add('on');
  });
})();
