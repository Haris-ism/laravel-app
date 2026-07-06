import { authHeaders } from '../auth.js';

let allPosts = [];
let editedPosts = {};

// ── Fetch ────────────────────────────────────────────────────────────────────

async function fetchPosts() {
    show('loading');
    hide('table-wrap');
    hide('empty');

    try {
        const res  = await fetch('/api/blog?per_page=10');
        const json = await res.json();
        if (!json.data) throw new Error();

        allPosts   = json.data.blogs ?? [];
        editedPosts = {};

        hide('loading');

        if (allPosts.length === 0) { show('empty'); return; }

        renderTable(allPosts);
        show('table-wrap');
    } catch (e) {
        hide('loading');
        alert('Failed to load posts.');
    }
}

// ── Table ────────────────────────────────────────────────────────────────────

function renderTable(posts) {
    document.getElementById('table-body').innerHTML = posts.map(post => `
        <tr id="row-${post.id}" class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
            <td class="px-6 py-4 text-sm text-gray-400 w-12">${post.id}</td>
            <td class="px-6 py-4">
                <span id="title-${post.id}" class="text-sm font-semibold text-gray-900">${escapeHtml(post.title)}</span>
            </td>
            <td class="px-6 py-4">
                <span id="content-${post.id}" class="text-sm text-gray-500 line-clamp-2">${escapeHtml(post.content)}</span>
            </td>
            <td class="px-6 py-4 text-sm text-gray-400 whitespace-nowrap">${formatDate(post.created_at)}</td>
            <td class="px-6 py-4 text-right">
                <button onclick="openUpdateModal(${post.id})"
                    class="text-xs font-semibold text-gray-900 border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                    Edit
                </button>
            </td>
        </tr>
    `).join('');
}

// ── Create Modal ─────────────────────────────────────────────────────────────

window.openCreateModal = function () {
    document.getElementById('create-title').value   = '';
    document.getElementById('create-content').value = '';
    document.getElementById('create-error').textContent = '';
    show('create-modal');
}

window.closeCreateModal = function () { hide('create-modal'); }

window.submitCreate = async function () {
    const title   = document.getElementById('create-title').value.trim();
    const content = document.getElementById('create-content').value.trim();
    const errEl   = document.getElementById('create-error');
    errEl.textContent = '';

    if (!title)   { errEl.textContent = 'Title is required.'; return; }
    if (!content) { errEl.textContent = 'Content is required.'; return; }

    const btn = document.getElementById('create-submit');
    btn.disabled    = true;
    btn.textContent = 'Creating...';

    try {
        const res  = await fetch('/api/blog', {
            method:  'POST',
            headers: authHeaders(),
            body:    JSON.stringify({ title, content }),
        });
        const json = await res.json();

        if (!res.ok) {
            errEl.textContent = json.message ?? 'Failed to create post.';
            return;
        }

        closeCreateModal();
        await fetchPosts();
    } catch (e) {
        errEl.textContent = 'Something went wrong.';
    } finally {
        btn.disabled    = false;
        btn.textContent = 'Create';
    }
}

// ── Update Modal ─────────────────────────────────────────────────────────────

window.openUpdateModal = function (id) {
    const post = allPosts.find(p => p.id === id);
    if (!post) return;

    document.getElementById('update-id').value        = post.id;
    document.getElementById('update-title').value     = post.title;
    document.getElementById('update-content').value   = post.content;
    document.getElementById('update-error').textContent = '';
    show('update-modal');
}

window.closeUpdateModal = function () { hide('update-modal'); }

window.submitUpdate = function () {
    const id      = parseInt(document.getElementById('update-id').value);
    const title   = document.getElementById('update-title').value.trim();
    const content = document.getElementById('update-content').value.trim();
    const errEl   = document.getElementById('update-error');
    errEl.textContent = '';

    if (!title)   { errEl.textContent = 'Title is required.'; return; }
    if (!content) { errEl.textContent = 'Content is required.'; return; }

    editedPosts[id] = { id, title, content };

    document.getElementById(`title-${id}`).textContent   = title;
    document.getElementById(`content-${id}`).textContent = content;

    const row = document.getElementById(`row-${id}`);
    row.classList.add('bg-amber-50');

    closeUpdateModal();
    updateSaveBtn();
}

// ── Batch Save ────────────────────────────────────────────────────────────────

function updateSaveBtn() {
    const count  = Object.keys(editedPosts).length;
    const btn    = document.getElementById('save-btn');
    const badge  = document.getElementById('save-badge');
    btn.disabled = count === 0;
    badge.textContent = count;
    badge.style.display = count === 0 ? 'none' : 'flex';
}

window.saveAll = async function () {
    const posts = Object.values(editedPosts);
    if (posts.length === 0) return;

    const btn = document.getElementById('save-btn');
    btn.disabled = true;
    document.getElementById('save-btn-text').textContent = 'Saving...';

    try {
        const res  = await fetch('/api/blog', {
            method:  'PUT',
            headers: authHeaders(),
            body:    JSON.stringify({ blogs: posts }),
        });
        const json = await res.json();

        if (!res.ok) {
            alert(json.message ?? 'Failed to save.');
            return;
        }

        editedPosts = {};
        updateSaveBtn();
        await fetchPosts();

        showToast(`${posts.length} post${posts.length > 1 ? 's' : ''} saved successfully.`);
    } catch (e) {
        console.log("ieu err: ",e)
        alert('Something went wrong.');
    } finally {
        btn.disabled    = false;
        document.getElementById('save-btn-text').textContent = 'Save Changes';
    }
}

// ── Toast ─────────────────────────────────────────────────────────────────────

function showToast(msg) {
    const toast = document.getElementById('toast');
    toast.textContent = msg;
    toast.classList.remove('opacity-0', 'translate-y-4');
    toast.classList.add('opacity-100', 'translate-y-0');
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-4');
        toast.classList.remove('opacity-100', 'translate-y-0');
    }, 3000);
}

// ── Helpers ───────────────────────────────────────────────────────────────────

function show(id) { document.getElementById(id).classList.remove('hidden'); }
function hide(id) { document.getElementById(id).classList.add('hidden'); }

function formatDate(dateStr) {
    if (!dateStr) return '—';
    return new Date(dateStr).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

function escapeHtml(str) {
    const d = document.createElement('div');
    d.appendChild(document.createTextNode(str ?? ''));
    return d.innerHTML;
}

fetchPosts();
