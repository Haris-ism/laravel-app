const title = document.querySelector('meta[name="page-title"]')?.content;

async function fetchPost() {
    try {
        const res = await fetch(`/api/blog/${encodeURIComponent(title)}`);
        const json = await res.json();

        if (!json.data) throw new Error();

        hide('loading');
        renderPost(json.data);
    } catch (e) {
        hide('loading');
        show('error');
    }
}

function renderPost(post) {
    document.getElementById('post-title').textContent = post.title;
    document.getElementById('post-date').textContent = formatDate(post.created_at);
    document.getElementById('post-avatar').textContent = post.title.charAt(0).toUpperCase();
    document.getElementById('post-content').textContent = post.content;
    document.title = post.title + ' — The Blog';
    show('post');
}

function show(id) { document.getElementById(id).classList.remove('hidden'); }
function hide(id) { document.getElementById(id).classList.add('hidden'); }

function formatDate(dateStr) {
    if (!dateStr) return '';
    return new Date(dateStr).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

fetchPost();
