const perPage = 5; // 5 blogs per page
let currentPage = 1;
let totalPages = 1;

async function fetchPosts(page) {
    show('loading');
    hide('blog-list');
    hide('pagination');
    hide('error');
    hide('empty');
    hide('page-info');

    try {
        const res = await fetch(`/api/blog?page=${page}&per_page=${perPage}`);
        const json = await res.json();
        if (!json.data) throw new Error();

        const { blogs, pagination: pg } = json.data;
        totalPages = pg.last_page;

        hide('loading');

        if (!blogs || blogs.length === 0) {
            show('empty');
            return;
        }

        renderCards(blogs);
        renderPagination(pg);
    } catch (e) {
        hide('loading');
        show('error');
    }
}

function renderCards(blogs) {
    document.getElementById('blog-list').innerHTML = blogs.map((post) => `
        <a href="/blog/${encodeURIComponent(post.title)}" class="block no-underline">
            <article class="bg-white border border-gray-100 rounded-2xl p-7 hover:-translate-y-1 hover:shadow-xl transition-all duration-200 cursor-pointer">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-sm font-bold text-gray-500">
                        ${escapeHtml(post.title.charAt(0).toUpperCase())}
                    </div>
                    <span class="text-xs text-gray-400 font-medium">${formatDate(post.created_at)}</span>
                </div>
                <h2 class="text-lg font-bold text-gray-900 tracking-tight leading-snug mb-2">
                    ${escapeHtml(post.title)}
                </h2>
                <p class="text-gray-500 text-sm leading-relaxed line-clamp-3">
                    ${escapeHtml(post.content)}
                </p>
                <div class="mt-5 pt-4 border-t border-gray-50 flex justify-end">
                    <span class="text-xs font-semibold text-gray-900 flex items-center gap-1">
                        Read article →
                    </span>
                </div>
            </article>
        </a>
    `).join('');
    show('blog-list');
}

function renderPagination(pg) {
    document.getElementById('prev-btn').disabled = pg.current_page <= 1;
    document.getElementById('next-btn').disabled = pg.current_page >= pg.last_page;

    document.getElementById('page-dots').innerHTML = Array.from({ length: pg.last_page }, (_, i) => i + 1).map(p => `
        <button onclick="goToPage(${p})" class="h-2 rounded-full transition-all duration-200 ${p === pg.current_page ? 'w-6 bg-gray-900' : 'w-2 bg-gray-300 hover:bg-gray-400'}"></button>
    `).join('');

    document.getElementById('page-info').textContent = `${pg.current_page} of ${pg.last_page} pages · ${pg.total} posts`;
    show('pagination');
    show('page-info');
}

function changePage(dir) {
    const next = currentPage + dir;
    if (next < 1 || next > totalPages) return;
    currentPage = next;
    window.scrollTo({ top: 0, behavior: 'smooth' });
    fetchPosts(currentPage);
}

function goToPage(p) {
    currentPage = p;
    window.scrollTo({ top: 0, behavior: 'smooth' });
    fetchPosts(currentPage);
}

function show(id) { document.getElementById(id).classList.remove('hidden'); }
function hide(id) { document.getElementById(id).classList.add('hidden'); }

function formatDate(dateStr) {
    if (!dateStr) return '';
    return new Date(dateStr).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

function escapeHtml(str) {
    const d = document.createElement('div');
    d.appendChild(document.createTextNode(str ?? ''));
    return d.innerHTML;
}

window.changePage = changePage;
window.goToPage = goToPage;

fetchPosts(currentPage);
