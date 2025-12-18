(function () {
    const q = document.querySelector('[data-auto-slug]');
    if (!q) {
        return;
    }

    const src = document.querySelector(q.getAttribute('data-auto-slug'));
    const dst = q;

    function slugify(text) {
        return (text || '')
            .toString()
            .toLowerCase()
            .replace(/[^\p{L}\p{N}]+/gu, '-')
            .replace(/^-+|-+$/g, '')
            .replace(/-+/g, '-')
            .trim();
    }

    src.addEventListener('input', function () {
        dst.value = slugify(src.value);
    });
})();
