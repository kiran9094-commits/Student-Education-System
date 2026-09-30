<!-- Global Admission & Counseling Inquiry Modal -->
<div class="modal-overlay" id="inquiryModal">
    <div class="modal-content">
        <div class="modal-header">
            <div>
                <h3 class="modal-title">Student Admission Guidance</h3>
                <p style="font-size:0.85rem; color:#64748b; margin-top:2px;">Get personalized counseling and direct institute admission details</p>
            </div>
            <button type="button" class="modal-close" aria-label="Close Modal">&times;</button>
        </div>
        <div class="modal-body">
            <div id="inquiryTargetNote" style="display:none; padding:10px 14px; background:#eef2ff; border-radius:8px; color:#4338ca; font-size:0.85rem; margin-bottom:16px;"></div>

            <form id="inquiryForm">
                <input type="hidden" name="institution_id" value="">
                <input type="hidden" name="course_id" value="">

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="student_name" class="form-control" placeholder="KIRAN CHAUDHARY" value="KIRAN CHAUDHARY" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number *</label>
                        <input type="tel" name="phone" class="form-control" placeholder="7046483464" value="7046483464" required>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" class="form-control" placeholder="kiranchaudhary@gmail.com" value="kiranchaudhary@gmail.com" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">City / State</label>
                        <input type="text" name="city" class="form-control" placeholder="e.g. Ahmedabad, Gujarat" value="Ahmedabad, Gujarat">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Current Academic Qualification</label>
                    <input type="text" name="qualification" class="form-control" placeholder="e.g. 12th Standard / Graduate (B.Sc / B.Tech)">
                </div>

                <div class="form-group">
                    <label class="form-label">Questions / Admission Query</label>
                    <textarea name="message" class="form-control" placeholder="Ask about eligibility, fee structures, scholarship options, or cutoff ranks..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%; padding:14px; font-size:1rem;">
                    <i class="fas fa-paper-plane"></i> Submit Inquiry Request
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Saved Bookmarks Drawer Modal -->
<div class="modal-overlay" id="bookmarksModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-bookmark" style="color:#4f46e5; margin-right:8px;"></i> Saved Colleges & Courses</h3>
            <button type="button" class="modal-close" id="closeBookmarksModal">&times;</button>
        </div>
        <div class="modal-body">
            <div id="bookmarksListContent" style="display:flex; flex-direction:column; gap:12px;">
                <!-- Populated via JS -->
            </div>
            <div id="emptyBookmarksNotice" style="text-align:center; padding:30px 10px; color:#94a3b8;">
                <i class="far fa-folder-open" style="font-size:2.5rem; margin-bottom:12px; display:block;"></i>
                <p>No saved institutions or courses yet.<br>Click the bookmark icon on any card to save it here!</p>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand" style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                    <div class="brand-icon" style="width:40px; height:40px; font-size:1.15rem; flex-shrink:0;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="brand-text">
                        <span class="brand-main" style="color:#ffffff; font-size:1.15rem;">Student Education</span>
                        <span class="brand-sub" style="color:#818cf8; font-size:0.75rem;">System</span>
                    </div>
                </div>
                <p class="footer-desc">
                    A comprehensive web-based Student Education System empowering students, parents, and educators to discover top institutions, compare dynamic courses, access verified academic materials, and connect directly with admission mentors.
                </p>
                <div style="display:flex; gap:12px; font-size:1.1rem;">
                    <a href="#" style="color:#94a3b8;" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="#" style="color:#94a3b8;" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" style="color:#94a3b8;" title="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" style="color:#94a3b8;" title="GitHub"><i class="fab fa-github"></i></a>
                </div>
            </div>

            <div>
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="index.php"><i class="fas fa-home" style="margin-right:6px;"></i> Home</a></li>
                    <li><a href="courses.php"><i class="fas fa-book-open" style="margin-right:6px;"></i> Courses</a></li>
                    <li><a href="schools.php"><i class="fas fa-school" style="margin-right:6px;"></i> Schools</a></li>
                    <li><a href="colleges.php"><i class="fas fa-graduation-cap" style="margin-right:6px;"></i> Colleges</a></li>
                    <li><a href="resources.php"><i class="fas fa-file-alt" style="margin-right:6px;"></i> Study Resources</a></li>
                    <li><a href="inquiry.php"><i class="fas fa-headset" style="margin-right:6px;"></i> Admissions Guidance</a></li>
                    <li><a href="about.php"><i class="fas fa-info-circle" style="margin-right:6px;"></i> About Us</a></li>
                    <li><a href="feedback.php"><i class="fas fa-comment-dots" style="margin-right:6px;"></i> Feedback</a></li>
                    <li><a href="contact.php"><i class="fas fa-phone-alt" style="margin-right:6px;"></i> Contact</a></li>
                </ul>
            </div>

            <div>
                <h4 class="footer-title">Gujarat Education Hub</h4>
                <ul class="footer-links">
                    <li><a href="schools.php?district=Banaskantha">Banaskantha Schools (13 Talukas)</a></li>
                    <li><a href="colleges.php?city=Ahmedabad">Ahmedabad Universities</a></li>
                    <li><a href="courses.php?category=SCIENCE">Medical &amp; Science Courses</a></li>
                    <li><a href="courses.php?category=ENGINEERING">Engineering Degrees</a></li>
                    <li><a href="courses.php?category=COMPUTER+%2F+IT">Computer &amp; IT (BCA/MCA)</a></li>
                    <li><a href="courses.php?category=MANAGEMENT">Commerce &amp; Management</a></li>
                </ul>
            </div>

            <div>
                <h4 class="footer-title">Student Helpdesk</h4>
                <p style="font-size:0.88rem; color:#94a3b8; margin-bottom:12px; line-height:1.7;">
                    <i class="fas fa-user-tie" style="margin-right:8px; color:#818cf8;"></i> <strong>Kiran Chaudhary</strong><br>
                    <i class="fas fa-phone-alt" style="margin-right:8px; color:#818cf8;"></i> <?= SITE_PHONE ?><br>
                    <i class="fas fa-envelope" style="margin-right:8px; color:#818cf8;"></i> <?= SITE_EMAIL ?><br>
                    <i class="fas fa-map-marker-alt" style="margin-right:8px; color:#818cf8;"></i> <?= SITE_ADDRESS ?>
                </p>
                <div style="margin-top:16px;">
                    <a href="setup.php" class="db-status-pill" title="Check Database Engine and Connectivity">
                        <span class="status-dot"></span>
                        <span><?= sanitize($dbDriver ?? 'Database Connected') ?></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div>&copy; 2026 Student Education System. Developed by Kiran Chaudhary.</div>
            <div style="display:flex; gap:20px; flex-wrap:wrap;">
                <a href="setup.php" style="color:#94a3b8;"><i class="fas fa-database"></i> Setup</a>
                <a href="admin/index.php" style="color:#94a3b8;"><i class="fas fa-shield-alt"></i> Admin</a>
                <a href="about.php" style="color:#94a3b8;">About Portal</a>
                <a href="feedback.php" style="color:#94a3b8;">Feedback</a>
                <a href="contact.php" style="color:#94a3b8;">Contact</a>
            </div>
        </div>
    </div>
</footer>

<!-- Toast notification anchor -->
<div class="toast-container" id="toastContainer"></div>

<!-- Core Scripts -->
<script src="assets/js/main.js"></script>
<script>
    // Bookmarks modal opener handler
    const bookmarksBtn = document.getElementById('savedBookmarksTrigger');
    const bookmarksModal = document.getElementById('bookmarksModal');
    const closeBookmarksBtn = document.getElementById('closeBookmarksModal');
    const bookmarksList = document.getElementById('bookmarksListContent');
    const emptyNotice = document.getElementById('emptyBookmarksNotice');

    if (bookmarksBtn && bookmarksModal) {
        bookmarksBtn.addEventListener('click', () => {
            const saved = JSON.parse(localStorage.getItem('eduportal_bookmarks') || '[]');
            if (saved.length === 0) {
                emptyNotice.style.display = 'block';
                bookmarksList.innerHTML = '';
            } else {
                emptyNotice.style.display = 'none';
                bookmarksList.innerHTML = saved.map(item => `
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:12px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px;">
                        <div>
                            <div style="font-weight:700; color:#0f172a;">${escapeHtml(item.name)}</div>
                            <div style="font-size:0.8rem; color:#64748b; text-transform:capitalize;">${escapeHtml(item.type)}</div>
                        </div>
                        <a href="${item.type === 'course' ? 'course-detail.php?id=' + item.id : 'institution-detail.php?id=' + item.id}" class="btn btn-outline btn-sm">
                            View <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                `).join('');
            }
            bookmarksModal.classList.add('active');
        });

        if (closeBookmarksBtn) {
            closeBookmarksBtn.addEventListener('click', () => {
                bookmarksModal.classList.remove('active');
            });
        }
        bookmarksModal.addEventListener('click', (e) => {
            if (e.target === bookmarksModal) bookmarksModal.classList.remove('active');
        });
    }
</script>

</body>
</html>
