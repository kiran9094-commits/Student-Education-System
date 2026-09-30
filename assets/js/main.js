/**
 * EduPortal - Main Application JavaScript
 * Handles Live Search, Inquiry Modal, Bookmarks, and Dynamic Interactions
 */

document.addEventListener('DOMContentLoaded', () => {
    initLiveSearch();
    initInquiryModal();
    initBookmarks();
    initCounters();
    initMobileMenu();
    initMoreDropdown();
});

/**
 * Mobile Navigation Toggle
 */
function initMobileMenu() {
    const toggleBtn = document.getElementById('mobileMenuToggle');
    const navLinks = document.getElementById('primaryNav');
    if (toggleBtn && navLinks) {
        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            navLinks.classList.toggle('mobile-open');
        });
        document.addEventListener('click', (e) => {
            if (!navLinks.contains(e.target) && !toggleBtn.contains(e.target)) {
                navLinks.classList.remove('mobile-open');
            }
        });
    }
}

/**
 * Header More Options Dropdown Popup
 */
function initMoreDropdown() {
    const dropdown = document.getElementById('moreOptionsDropdown');
    const trigger = document.getElementById('moreMenuBtn');
    if (!dropdown || !trigger) return;

    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = dropdown.classList.toggle('active');
        dropdown.classList.toggle('mobile-expanded');
        trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    document.addEventListener('click', (e) => {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
            dropdown.classList.remove('mobile-expanded');
            trigger.setAttribute('aria-expanded', 'false');
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            dropdown.classList.remove('active');
            dropdown.classList.remove('mobile-expanded');
            trigger.setAttribute('aria-expanded', 'false');
        }
    });
}

/**
 * Live Search Autocomplete
 */
function initLiveSearch() {
    const searchInput = document.getElementById('heroSearchInput');
    const dropdown = document.getElementById('searchDropdown');
    const categorySelect = document.getElementById('heroCategorySelect');

    if (!searchInput || !dropdown) return;

    let debounceTimer;

    searchInput.addEventListener('input', (e) => {
        clearTimeout(debounceTimer);
        const query = e.target.value.trim();
        const categoryId = categorySelect ? categorySelect.value : '';

        if (query.length < 2) {
            dropdown.style.display = 'none';
            dropdown.innerHTML = '';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`api/search.php?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (!data.success || (!data.schools?.length && !data.colleges?.length && !data.courses?.length && !data.institutions?.length)) {
                        dropdown.innerHTML = '<div class="autocomplete-item"><div class="item-title">No matching schools, colleges, or courses found</div></div>';
                        dropdown.style.display = 'block';
                        return;
                    }

                    let html = '';

                    // 1. Schools
                    if (data.schools && data.schools.length) {
                        html += '<div style="padding: 8px 16px; background:#eff6ff; font-size:0.75rem; font-weight:700; color:#1e40af; text-transform:uppercase; display:flex; justify-content:space-between;"><span><i class="fas fa-school"></i> Schools (' + data.schools.length + ')</span><span>District</span></div>';
                        data.schools.forEach(sch => {
                            html += `
                                <div class="autocomplete-item" onclick="window.location.href='school-detail.php?id=${sch.id}'">
                                    <div style="flex:1;">
                                        <div class="item-title">
                                            <i class="fas fa-school" style="color:#f59e0b; margin-right:8px;"></i>
                                            <span>${escapeHtml(sch.name)}</span>
                                            <span style="display:inline-block; font-size:0.7rem; font-weight:700; background:${sch.type === 'Government' ? '#dcfce7' : '#e0e7ff'}; color:${sch.type === 'Government' ? '#15803d' : '#3730a3'}; padding:2px 6px; border-radius:4px; margin-left:6px;">${escapeHtml(sch.type)}</span>
                                        </div>
                                        <div class="item-meta"><i class="fas fa-map-marker-alt" style="color:#ef4444; margin-right:4px;"></i>${escapeHtml(sch.district)} • ${escapeHtml(sch.address)}</div>
                                    </div>
                                    <span class="badge badge-outline" style="font-size:0.75rem;">View School &rarr;</span>
                                </div>
                            `;
                        });
                    }

                    // 2. Colleges
                    if (data.colleges && data.colleges.length) {
                        html += '<div style="padding: 8px 16px; background:#f0fdf4; font-size:0.75rem; font-weight:700; color:#166534; text-transform:uppercase; display:flex; justify-content:space-between;"><span><i class="fas fa-graduation-cap"></i> Colleges (' + data.colleges.length + ')</span><span>City</span></div>';
                        data.colleges.forEach(col => {
                            html += `
                                <div class="autocomplete-item" onclick="window.location.href='college-detail.php?id=${col.id}'">
                                    <div style="flex:1;">
                                        <div class="item-title">
                                            <i class="fas fa-university" style="color:#2563eb; margin-right:8px;"></i>
                                            <span>${escapeHtml(col.name)}</span>
                                            <span style="display:inline-block; font-size:0.7rem; font-weight:700; background:#dbeafe; color:#1e40af; padding:2px 6px; border-radius:4px; margin-left:6px;">${escapeHtml(col.type)}</span>
                                        </div>
                                        <div class="item-meta"><i class="fas fa-city" style="color:#2563eb; margin-right:4px;"></i>${escapeHtml(col.city)} • ${escapeHtml(col.courses_offered || '')}</div>
                                    </div>
                                    <span class="badge badge-outline" style="font-size:0.75rem;">View College &rarr;</span>
                                </div>
                            `;
                        });
                    }

                    // 3. Courses
                    if (data.courses && data.courses.length) {
                        html += '<div style="padding: 8px 16px; background:#fef3c7; font-size:0.75rem; font-weight:700; color:#92400e; text-transform:uppercase;"><span><i class="fas fa-book-open"></i> Courses (' + data.courses.length + ')</span></div>';
                        data.courses.forEach(crs => {
                            html += `
                                <div class="autocomplete-item" onclick="window.location.href='course-detail.php?id=${crs.id}'">
                                    <div style="flex:1;">
                                        <div class="item-title"><i class="fas fa-certificate" style="color:#0284c7; margin-right:8px;"></i>${escapeHtml(crs.name)}</div>
                                        <div class="item-meta">${escapeHtml(crs.category)} • ${escapeHtml(crs.duration)}</div>
                                    </div>
                                    <span class="badge badge-primary">${escapeHtml(crs.level || 'Degree')}</span>
                                </div>
                            `;
                        });
                    }

                    dropdown.innerHTML = html;
                    dropdown.style.display = 'block';
                })
                .catch(() => {
                    dropdown.style.display = 'none';
                });
        }, 220);
    });

    // Enter key submit handler
    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            const val = searchInput.value.trim();
            if (val) {
                window.location.href = `schools.php?q=${encodeURIComponent(val)}`;
            }
        }
    });

    // Close dropdown on outside click
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
}

/**
 * Student Admission & Guidance Inquiry Modal
 */
function initInquiryModal() {
    const modal = document.getElementById('inquiryModal');
    if (!modal) return;

    const closeBtn = modal.querySelector('.modal-close');
    const form = document.getElementById('inquiryForm');

    // Close handlers
    if (closeBtn) {
        closeBtn.addEventListener('click', () => closeModal(modal));
    }
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal(modal);
    });

    // Handle open inquiry buttons
    document.querySelectorAll('[data-open-inquiry]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const instId = btn.getAttribute('data-institution-id');
            const courseId = btn.getAttribute('data-course-id');
            const instName = btn.getAttribute('data-institution-name');
            const courseName = btn.getAttribute('data-course-name');

            if (instId && form.querySelector('[name="institution_id"]')) {
                form.querySelector('[name="institution_id"]').value = instId;
            }
            if (courseId && form.querySelector('[name="course_id"]')) {
                form.querySelector('[name="course_id"]').value = courseId;
            }
            
            const noteEl = document.getElementById('inquiryTargetNote');
            if (noteEl) {
                if (instName) {
                    noteEl.innerHTML = `Inquiring for: <strong>${escapeHtml(instName)}</strong> ${courseName ? '(' + escapeHtml(courseName) + ')' : ''}`;
                    noteEl.style.display = 'block';
                } else {
                    noteEl.style.display = 'none';
                }
            }

            openModal(modal);
        });
    });

    // AJAX Form submission
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

            const formData = new FormData(form);

            fetch('api/inquiry.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message || 'Inquiry submitted successfully! Our counselor will reach out shortly.', 'success');
                    form.reset();
                    closeModal(modal);
                } else {
                    showToast(data.message || 'Please check your inputs and try again.', 'error');
                }
            })
            .catch(() => {
                showToast('An unexpected error occurred. Please try again.', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            });
        });
    }
}

function openModal(modal) {
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal(modal) {
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

/**
 * Local Storage Bookmarks
 */
function initBookmarks() {
    const storageKey = 'eduportal_bookmarks';
    let bookmarks = JSON.parse(localStorage.getItem(storageKey) || '[]');

    function updateBookmarkIcons() {
        document.querySelectorAll('[data-bookmark-id]').forEach(btn => {
            const id = btn.getAttribute('data-bookmark-id');
            const type = btn.getAttribute('data-bookmark-type') || 'institution';
            const isBookmarked = bookmarks.some(b => b.id === id && b.type === type);
            if (isBookmarked) {
                btn.classList.add('active');
                btn.innerHTML = '<i class="fas fa-bookmark"></i>';
                btn.setAttribute('title', 'Remove from bookmarks');
            } else {
                btn.classList.remove('active');
                btn.innerHTML = '<i class="far fa-bookmark"></i>';
                btn.setAttribute('title', 'Bookmark this');
            }
        });

        // Update badge count if present
        const countBadge = document.getElementById('bookmarkCountBadge');
        if (countBadge) {
            countBadge.innerText = bookmarks.length;
            countBadge.style.display = bookmarks.length > 0 ? 'inline-flex' : 'none';
        }
    }

    document.querySelectorAll('[data-bookmark-id]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const id = btn.getAttribute('data-bookmark-id');
            const type = btn.getAttribute('data-bookmark-type') || 'institution';
            const name = btn.getAttribute('data-bookmark-name') || 'Item';

            const index = bookmarks.findIndex(b => b.id === id && b.type === type);
            if (index > -1) {
                bookmarks.splice(index, 1);
                showToast(`Removed "${name}" from saved bookmarks.`, 'info');
            } else {
                bookmarks.push({ id, type, name, addedAt: new Date().toISOString() });
                showToast(`Saved "${name}" to your bookmarks!`, 'success');
            }

            localStorage.setItem(storageKey, JSON.stringify(bookmarks));
            updateBookmarkIcons();
        });
    });

    updateBookmarkIcons();
}

/**
 * Number Counter Animation
 */
function initCounters() {
    const counters = document.querySelectorAll('[data-counter]');
    if (!counters.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.getAttribute('data-counter'), 10);
                const suffix = el.getAttribute('data-suffix') || '';
                let count = 0;
                const step = Math.ceil(target / 40);

                const timer = setInterval(() => {
                    count += step;
                    if (count >= target) {
                        el.innerText = target.toLocaleString() + suffix;
                        clearInterval(timer);
                    } else {
                        el.innerText = count.toLocaleString() + suffix;
                    }
                }, 30);

                observer.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(c => observer.observe(c));
}

/**
 * Dynamic Toast System
 */
function showToast(message, type = 'info') {
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    const icon = type === 'success' ? 'check-circle' : (type === 'error' ? 'exclamation-circle' : 'info-circle');
    toast.innerHTML = `<i class="fas fa-${icon}"></i> <span>${escapeHtml(message)}</span>`;

    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
