# Student Education System Website

A modern, responsive, full-stack educational portal developed using **PHP, MySQL, HTML5, Vanilla CSS, and JavaScript**.

The platform provides structured, verified information on **schools, colleges, universities, degree courses, and educational study materials**, paired with an active student counseling inquiry pipeline and an administration console.

---

## 🌟 Key Features

### 1. Public Education Portal
- **Dynamic Homepage (`index.php`)**:
  - Live search with instant AJAX suggestions for institutions and courses.
  - Interactive stream categories (Engineering, Healthcare, Business, IT, Design, Secondary Schools).
  - Featured institutions carousel with ratings, NIRF rankings, and accreditation badges.
  - Trending courses with average salary packages and degree duration tags.
  - Free educational resources vault with one-click study material downloads.
  - Student and alumni testimonials with star ratings.
  - Animated statistics counters.

### 2. Institutions & Campuses Directory (`institutions.php`)
- Multi-faceted filtering by **Institution Type** (University, College, Premier School), **State/Region**, and **Sort Order** (Highest Rating, Name, Established Year).
- Detailed profiles for each campus (`institution-detail.php`) including facilities (Hostel, Labs, Sports, Incubation), offered degree programs, verified student reviews, and direct admission inquiry forms.

### 3. Academic Courses Catalog (`courses.php`)
- Comprehensive degree search filtering by **Discipline/Stream**, **Degree Level** (Undergraduate, Postgraduate, Diploma, Higher Secondary), and **Tuition Fee**.
- In-depth course view (`course-detail.php`) highlighting **Eligibility Criteria**, **Syllabus & Curriculum Overview**, **Career Prospects**, and campus salary packages.

### 4. Educational Resources Vault (`resources.php`)
- Free study materials: lecture notes, past board solved papers, lab manuals, and syllabus guides.
- Download tracking with live counter increments and format indicators (PDF, E-Book, DOCX).

### 5. Student Admission & Counseling Desk (`inquiry.php`)
- Interactive inquiry modal accessible from any card or page.
- Direct booking for counseling consultation.
- Automatic database recording with status tracking (`Pending`, `Contacted`, `Under Review`, `Enrolled`).

### 6. Bookmarking System
- Client-side saved colleges and courses drawer stored in `localStorage`.
- Quick-access drawer view without requiring student login.

### 7. Administration Management Dashboard (`admin/`)
- Live system analytics: Total Institutions, Courses, Resources, and Inquiries.
- Status management workflow for incoming student admission leads.
- Full CRUD operations to **Add, Edit, and Delete** institutions, courses, and study materials.

### 8. Interactive Database Setup & Migration Wizard (`setup.php`)
- Web-based setup console to inspect active database engine.
- 1-click test, auto-creation of database `student_education_db`, execution of `database/schema.sql`, and rich seed data population.
- Built-in zero-config SQLite auto-fallback so the system runs immediately out-of-the-box.

---

## 🛠️ Technology Stack

| Component | Technology | Description |
|---|---|---|
| **Backend** | PHP 8.1+ | Dynamic page rendering, RESTful APIs, PDO database layer |
| **Database** | MySQL 8.0+ / SQLite 3 | Relational schema with foreign keys, seed data, and PDO abstraction |
| **Frontend** | HTML5 & Vanilla CSS3 | Modern design system, Google Font (Plus Jakarta Sans), Font Awesome 6 |
| **JavaScript** | ES6+ Vanilla JS | Live AJAX autocomplete, inquiry modal, toasts, and bookmarking |

---

## 📁 Project Structure

```
d:/Student Education System/
├── config/
│   ├── constants.php          # Global site constants, base URL, metadata
│   └── database.php           # Database credentials (MySQL & SQLite)
├── database/
│   ├── schema.sql             # MySQL table schemas & constraints
│   ├── seed.php               # Realistic seed data for colleges, courses, resources
│   └── Database.php           # Singleton PDO handler with auto-fallback
├── assets/
│   ├── css/
│   │   ├── style.css          # Main design system, glassmorphism, responsive utilities
│   │   └── admin.css          # Administration portal styles
│   ├── js/
│   │   └── main.js            # Live search, inquiry modal, bookmarks, toast alerts
│   └── images/                # Vector SVG logos, campus banners, and illustrations
├── includes/
│   ├── header.php             # Global navigation bar & meta tags
│   ├── footer.php             # Footer links, inquiry modal, bookmarks drawer
│   └── functions.php          # Formatting helpers, sanitization, rating stars
├── api/
│   ├── search.php             # AJAX live search endpoint
│   └── inquiry.php            # AJAX inquiry submission endpoint
├── admin/
│   ├── index.php              # Administrative dashboard & inquiry status workflow
│   ├── institutions.php       # Manage institutions (Add / Edit / Delete)
│   ├── courses.php            # Manage academic programs (Add / Edit / Delete)
│   ├── resources.php          # Manage study resources
│   ├── inquiries.php          # Full student inquiry management
│   ├── header.php             # Admin sidebar layout
│   └── footer.php             # Admin footer
├── index.php                  # Homepage
├── institutions.php           # Institutions directory with filters
├── institution-detail.php     # Campus profile with courses & reviews
├── courses.php                # Degree courses catalog
├── course-detail.php          # Course curriculum & career outcomes
├── resources.php              # Free educational resources & notes
├── inquiry.php                # Dedicated admission guidance form
├── setup.php                  # Interactive DB Setup & Migration Console
└── README.md                  # Documentation
```

---

## 🚀 How to Run Locally

### Option 1: Using PHP Built-in Web Server (Fastest)

1. Open PowerShell / Command Prompt in this project root:
   ```powershell
   cd "d:\Student Education System"
   ```
2. Start the PHP development server:
   ```powershell
   & "C:\xampp\php\php.exe" -S 127.0.0.1:8000
   ```
3. Open your browser and visit:
   - Public Website: **http://127.0.0.1:8000**
   - Admin Console: **http://127.0.0.1:8000/admin**
   - Database Setup Console: **http://127.0.0.1:8000/setup.php**

### Option 2: Using XAMPP / Apache & MySQL

1. Copy or symlink this folder to your XAMPP `htdocs` directory:
   - Target: `C:\xampp\htdocs\student-education-system`
2. Start **Apache** and **MySQL** from the XAMPP Control Panel.
3. Visit **http://localhost/student-education-system/setup.php** in your browser.
4. Click **"Connect & Migrate to MySQL"** to automatically initialize the database and populate all sample institutions and courses.

---

## 🔐 Default Credentials

- **Admin Login Portal**: Accessible at `/admin` (Redirects to `/admin/login.php` when unauthorized)
  - **Admin ID / Username**: `admin`
  - **Password**: `password123`
- **Default Database**: `student_education_db`
- **MySQL User**: `root` (Default empty password or configure in `setup.php`)
