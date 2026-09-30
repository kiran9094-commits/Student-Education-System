<?php
/**
 * Database Seeder
 * Populates realistic institutions, courses, resources, and inquiries
 */

function runDatabaseSeed(PDO $pdo, string $driver): void {
    // 1. Categories
    $categories = [
        ['Engineering & Technology', 'engineering-technology', 'fas fa-cogs', 'B.Tech, M.Tech, Computer Science, AI, Robotics, Electronics, and Mechanical streams.'],
        ['Medical & Healthcare', 'medical-healthcare', 'fas fa-heartbeat', 'MBBS, BDS, Nursing, Pharmacy, Physiotherapy, and Biomedical Sciences.'],
        ['Management & Business', 'management-business', 'fas fa-chart-line', 'MBA, BBA, Finance, Marketing, International Business, and Supply Chain.'],
        ['Computer Applications & IT', 'computer-applications', 'fas fa-laptop-code', 'BCA, MCA, Data Science, Cybersecurity, Cloud Computing, and Web Technologies.'],
        ['Sciences & Mathematics', 'sciences-mathematics', 'fas fa-atom', 'Physics, Chemistry, Biotechnology, Applied Mathematics, and Environmental Science.'],
        ['Arts, Design & Media', 'arts-design-media', 'fas fa-palette', 'Animation, Graphic Design, Fashion, Journalism, Film Production, and Fine Arts.'],
        ['Law & Legal Studies', 'law-legal-studies', 'fas fa-balance-scale', 'BA LLB, BBA LLB, LLM, Corporate Law, and Constitutional Law.'],
        ['Premier Secondary Schools', 'secondary-schools', 'fas fa-school', 'CBSE, ICSE, and International Baccalaureate high schools offering K-12 education.']
    ];

    $catStmt = $pdo->prepare("INSERT INTO categories (name, slug, icon, description) VALUES (?, ?, ?, ?)");
    foreach ($categories as $cat) {
        try {
            $catStmt->execute($cat);
        } catch (Exception $e) {}
    }

    // 2. Institutions
    $institutions = [
        [
            'name' => 'Apex Institute of Technology & Science',
            'slug' => 'apex-institute-of-technology-science',
            'type' => 'University',
            'category_id' => 1,
            'accreditation' => 'NAAC A++ Grade, NBA Accredited',
            'affiliation' => 'Autonomous Deemed University',
            'city' => 'Bengaluru',
            'state' => 'Karnataka',
            'address' => 'Knowledge Hub, Electronic City Phase 1, Bengaluru, Karnataka 560100',
            'established_year' => 1998,
            'ranking_nirf' => 'NIRF Rank #12 (Engg)',
            'rating' => 4.8,
            'reviews_count' => 342,
            'tuition_range' => '₹1,80,000 - ₹3,50,000 / yr',
            'student_count' => 8500,
            'description' => 'Apex Institute of Technology is a premier research university renowned for its world-class computer science and engineering programs, state-of-the-art incubation labs, and 98% placement record with global tech leaders.',
            'banner_image' => 'assets/images/college_apex.svg',
            'logo_image' => 'assets/images/logo_apex.svg',
            'website' => 'https://apex-tech.edu',
            'email' => 'admissions@apex-tech.edu',
            'phone' => '+91 (080) 2852-0199',
            'facilities' => 'High-Performance Supercomputing Lab, Central Digital Library, AC Hostels, Olympic Swimming Pool, Incubation Center, Smart Classrooms, Wi-Fi 6 Campus',
            'is_featured' => 1
        ],
        [
            'name' => 'St. Xavier National College of Arts & Commerce',
            'slug' => 'st-xavier-national-college',
            'type' => 'College',
            'category_id' => 3,
            'accreditation' => 'NAAC A+ Grade, UGC College with Potential for Excellence',
            'affiliation' => 'Affiliated to Central University',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'address' => '5 Mahapalika Marg, Dhobi Talao, Chhatrapati Shivaji Terminus Area, Mumbai, Maharashtra 400001',
            'established_year' => 1869,
            'ranking_nirf' => 'NIRF Rank #8 (Colleges)',
            'rating' => 4.7,
            'reviews_count' => 520,
            'tuition_range' => '₹45,000 - ₹1,20,000 / yr',
            'student_count' => 4200,
            'description' => 'A heritage institution offering transformative education in Commerce, Economics, Media, and Management. Known for distinguished alumni, rich campus heritage, and leadership development programs.',
            'banner_image' => 'assets/images/college_xavier.svg',
            'logo_image' => 'assets/images/logo_xavier.svg',
            'website' => 'https://xaviers-mumbai.edu',
            'email' => 'contact@xaviers-mumbai.edu',
            'phone' => '+91 (022) 2262-0661',
            'facilities' => 'Historic Heritage Hall, Modern Auditorium, Bloomberg Finance Terminal, Botanical Garden, Counseling Center, Multi-court Sports Arena',
            'is_featured' => 1
        ],
        [
            'name' => 'Metro Global School of Medical Sciences',
            'slug' => 'metro-global-medical-sciences',
            'type' => 'University',
            'category_id' => 2,
            'accreditation' => 'NMC (National Medical Commission) Recognized, WHO Listed',
            'affiliation' => 'Metro Health & Science University',
            'city' => 'New Delhi',
            'state' => 'Delhi NCR',
            'address' => 'Ring Road, Sector 7, RK Puram, New Delhi 110022',
            'established_year' => 2004,
            'ranking_nirf' => 'NIRF Rank #15 (Medical)',
            'rating' => 4.9,
            'reviews_count' => 280,
            'tuition_range' => '₹4,50,000 - ₹9,00,000 / yr',
            'student_count' => 3100,
            'description' => 'Pioneering healthcare education with a 1,200-bed super-specialty teaching hospital, simulation surgical suites, and intensive clinical internship programs.',
            'banner_image' => 'assets/images/college_metro_med.svg',
            'logo_image' => 'assets/images/logo_metro_med.svg',
            'website' => 'https://metromedical.edu',
            'email' => 'dean@metromedical.edu',
            'phone' => '+91 (011) 2619-8400',
            'facilities' => '1200-Bed Teaching Hospital, Cadaveric Dissection Hall, Robotic Surgery Lab, Residential Quarters, 24/7 Trauma Training Unit',
            'is_featured' => 1
        ],
        [
            'name' => 'Vanguard Business School & Leadership Institute',
            'slug' => 'vanguard-business-school',
            'type' => 'College',
            'category_id' => 3,
            'accreditation' => 'AACSB Accredited, AICTE Approved',
            'affiliation' => 'Autonomous Business Academy',
            'city' => 'Hyderabad',
            'state' => 'Telangana',
            'address' => 'Hitech City Phase 2, Gachibowli, Hyderabad, Telangana 500081',
            'established_year' => 2010,
            'ranking_nirf' => 'NIRF Rank #19 (Management)',
            'rating' => 4.6,
            'reviews_count' => 195,
            'tuition_range' => '₹3,00,000 - ₹6,50,000 / yr',
            'student_count' => 1800,
            'description' => 'Industry-aligned MBA and Executive Management programs co-designed with Fortune 500 tech leaders, offering live venture capital simulations and corporate mentorship.',
            'banner_image' => 'assets/images/college_vanguard.svg',
            'logo_image' => 'assets/images/logo_vanguard.svg',
            'website' => 'https://vanguard-bschool.edu',
            'email' => 'mba@vanguard-bschool.edu',
            'phone' => '+91 (040) 6789-2233',
            'facilities' => 'Case Study Amphitheatres, Stock Trading Simulation Room, Global Executive Lounge, Startup Accelerator Hub, Fitness Center',
            'is_featured' => 0
        ],
        [
            'name' => 'Greenwood International Senior Secondary School',
            'slug' => 'greenwood-international-school',
            'type' => 'School',
            'category_id' => 8,
            'accreditation' => 'CBSE & Cambridge International Board Affiliated',
            'affiliation' => 'Central Board of Secondary Education',
            'city' => 'Pune',
            'state' => 'Maharashtra',
            'address' => 'Survey 45, Viman Nagar, Pune, Maharashtra 411014',
            'established_year' => 2001,
            'ranking_nirf' => 'Top 10 Day-Cum-Boarding Schools',
            'rating' => 4.9,
            'reviews_count' => 410,
            'tuition_range' => '₹90,000 - ₹1,80,000 / yr',
            'student_count' => 2600,
            'description' => 'A premier co-educational campus emphasizing holistic STEM curriculum, international student exchange programs, arts, robotics, and sports mastery.',
            'banner_image' => 'assets/images/school_greenwood.svg',
            'logo_image' => 'assets/images/logo_greenwood.svg',
            'website' => 'https://greenwood-school.edu',
            'email' => 'principal@greenwood-school.edu',
            'phone' => '+91 (020) 2663-4411',
            'facilities' => 'STEM Maker Lab, Astroturf Football Field, Indoor Heated Pool, Performing Arts Theater, Organic Cafeteria, Transport Fleet with GPS',
            'is_featured' => 1
        ],
        [
            'name' => 'Prism Design & Architecture Academy',
            'slug' => 'prism-design-academy',
            'type' => 'College',
            'category_id' => 6,
            'accreditation' => 'Council of Architecture (COA) Approved',
            'affiliation' => 'Affiliated to State Technical University',
            'city' => 'Ahmedabad',
            'state' => 'Gujarat',
            'address' => 'SG Highway, Bodakdev, Ahmedabad, Gujarat 380054',
            'established_year' => 2012,
            'ranking_nirf' => 'NIRF Rank #14 (Architecture)',
            'rating' => 4.7,
            'reviews_count' => 165,
            'tuition_range' => '₹1,50,000 - ₹3,00,000 / yr',
            'student_count' => 1200,
            'description' => 'Dedicated to contemporary design thinking, urban sustainability, spatial architecture, and interaction design with world-class prototyping studios.',
            'banner_image' => 'assets/images/college_prism.svg',
            'logo_image' => 'assets/images/logo_prism.svg',
            'website' => 'https://prismdesign.edu',
            'email' => 'info@prismdesign.edu',
            'phone' => '+91 (079) 4001-9988',
            'facilities' => '3D Printing & Laser Cutting Lab, Materials Testing Workshop, Open-Air Exhibition Court, Material Library, VR Spatial Studio',
            'is_featured' => 0
        ]
    ];

    $instStmt = $pdo->prepare("INSERT INTO institutions 
        (name, slug, type, category_id, accreditation, affiliation, city, state, address, established_year, ranking_nirf, rating, reviews_count, tuition_range, student_count, description, banner_image, logo_image, website, email, phone, facilities, is_featured) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($institutions as $inst) {
        try {
            $instStmt->execute([
                $inst['name'], $inst['slug'], $inst['type'], $inst['category_id'],
                $inst['accreditation'], $inst['affiliation'], $inst['city'], $inst['state'],
                $inst['address'], $inst['established_year'], $inst['ranking_nirf'], $inst['rating'],
                $inst['reviews_count'], $inst['tuition_range'], $inst['student_count'], $inst['description'],
                $inst['banner_image'], $inst['logo_image'], $inst['website'], $inst['email'],
                $inst['phone'], $inst['facilities'], $inst['is_featured']
            ]);
        } catch (Exception $e) {}
    }

    // 3. Courses
    $courses = [
        [
            'institution_id' => 1,
            'category_id' => 1,
            'name' => 'B.Tech in Artificial Intelligence & Data Science',
            'slug' => 'btech-artificial-intelligence-data-science',
            'degree_level' => 'Undergraduate',
            'duration' => '4 Years (8 Semesters)',
            'tuition_fee' => 240000.00,
            'eligibility' => '10+2 with Physics, Mathematics & Chemistry (Min 60% aggregate) or valid entrance test score (JEE / State CET).',
            'seats' => 120,
            'syllabus_summary' => 'Foundations of Computer Science, Data Structures & Algorithms, Deep Learning, Natural Language Processing, MLOps, Big Data Engineering, Computer Vision, Capstone Project.',
            'career_prospects' => 'AI Engineer, Machine Learning Specialist, Data Scientist, MLOps Architect, NLP Engineer with top tech corporations.',
            'avg_package' => '₹9.5 - ₹28.0 LPA',
            'is_popular' => 1
        ],
        [
            'institution_id' => 1,
            'category_id' => 1,
            'name' => 'B.Tech in Computer Science & Engineering',
            'slug' => 'btech-computer-science-engineering',
            'degree_level' => 'Undergraduate',
            'duration' => '4 Years (8 Semesters)',
            'tuition_fee' => 220000.00,
            'eligibility' => '10+2 with Physics and Mathematics (Min 60%) + State / National Entrance Examination score.',
            'seats' => 180,
            'syllabus_summary' => 'Object-Oriented Programming, Operating Systems, Computer Networks, Database Management Systems, Cloud Computing, Distributed Systems, Compiler Design.',
            'career_prospects' => 'Full-Stack Software Engineer, Cloud Solutions Architect, DevOps Engineer, Cybersecurity Analyst.',
            'avg_package' => '₹8.0 - ₹24.0 LPA',
            'is_popular' => 1
        ],
        [
            'institution_id' => 1,
            'category_id' => 4,
            'name' => 'Master of Computer Applications (MCA)',
            'slug' => 'master-of-computer-applications-mca',
            'degree_level' => 'Postgraduate',
            'duration' => '2 Years (4 Semesters)',
            'tuition_fee' => 140000.00,
            'eligibility' => 'BCA, B.Sc (IT/CS) or any graduation with Mathematics at 10+2 or degree level with at least 50% marks.',
            'seats' => 60,
            'syllabus_summary' => 'Advanced Java, Enterprise Software Engineering, Microservices Architecture, Full-stack Web Frameworks, Mobile Application Development, InfoSec.',
            'career_prospects' => 'Senior Application Developer, Enterprise Architect, Systems Engineer, Technical Lead.',
            'avg_package' => '₹6.5 - ₹16.0 LPA',
            'is_popular' => 1
        ],
        [
            'institution_id' => 2,
            'category_id' => 3,
            'name' => 'Bachelor of Commerce (Honours) - B.Com (Hons)',
            'slug' => 'bcom-honours-financial-markets',
            'degree_level' => 'Undergraduate',
            'duration' => '3 Years (6 Semesters)',
            'tuition_fee' => 55000.00,
            'eligibility' => '10+2 from recognized board with Commerce or Mathematics background with min 65% aggregate.',
            'seats' => 150,
            'syllabus_summary' => 'Corporate Accounting, Financial Markets & Investments, Taxation Laws, Business Analytics, Auditing & Corporate Governance, FinTech Fundamentals.',
            'career_prospects' => 'Investment Banker, Financial Analyst, Chartered Accountant aspirant, Corporate Auditor, Risk Consultant.',
            'avg_package' => '₹5.5 - ₹14.0 LPA',
            'is_popular' => 1
        ],
        [
            'institution_id' => 2,
            'category_id' => 6,
            'name' => 'BA in Mass Communication & Digital Journalism',
            'slug' => 'ba-mass-communication-digital-journalism',
            'degree_level' => 'Undergraduate',
            'duration' => '3 Years (6 Semesters)',
            'tuition_fee' => 65000.00,
            'eligibility' => '10+2 in any stream with English proficiency and min 50% marks.',
            'seats' => 80,
            'syllabus_summary' => 'News Reporting & Editing, Broadcast Production, Digital Media Strategy, Media Ethics, Visual Storytelling, Investigative Journalism.',
            'career_prospects' => 'Digital Content Editor, News Anchor, Public Relations Specialist, Social Media Strategist, Broadcast Journalist.',
            'avg_package' => '₹4.0 - ₹9.0 LPA',
            'is_popular' => 0
        ],
        [
            'institution_id' => 3,
            'category_id' => 2,
            'name' => 'Bachelor of Medicine & Bachelor of Surgery (MBBS)',
            'slug' => 'mbbs-medicine-surgery',
            'degree_level' => 'Undergraduate',
            'duration' => '5.5 Years (Inc. 1 Year Internship)',
            'tuition_fee' => 680000.00,
            'eligibility' => '10+2 with Physics, Chemistry, Biology (min 50%) and valid NEET-UG ranking qualification.',
            'seats' => 150,
            'syllabus_summary' => 'Human Anatomy, Physiology, Biochemistry, Pathology, Pharmacology, Forensic Medicine, Community Medicine, General Surgery, Pediatrics, Obstetrics.',
            'career_prospects' => 'Medical Officer, Resident Physician, Clinical Specialist, Medical Researcher, Hospital Administration.',
            'avg_package' => '₹10.0 - ₹25.0 LPA',
            'is_popular' => 1
        ],
        [
            'institution_id' => 4,
            'category_id' => 3,
            'name' => 'Master of Business Administration (MBA)',
            'slug' => 'mba-business-analytics-marketing',
            'degree_level' => 'Postgraduate',
            'duration' => '2 Years (4 Semesters)',
            'tuition_fee' => 380000.00,
            'eligibility' => 'Bachelor degree in any discipline with min 50% + CAT/XAT/GMAT or Institute Aptitude Test.',
            'seats' => 120,
            'syllabus_summary' => 'Managerial Economics, Corporate Finance, Strategic Marketing, Business Analytics, Supply Chain Optimization, Leadership & Negotiations.',
            'career_prospects' => 'Management Consultant, Product Manager, Brand Strategy Director, Operations Lead, Business Operations Analyst.',
            'avg_package' => '₹12.0 - ₹32.0 LPA',
            'is_popular' => 1
        ],
        [
            'institution_id' => 5,
            'category_id' => 8,
            'name' => 'Senior Secondary (Grade 11 & 12) - Science & STEM Stream',
            'slug' => 'grade-11-12-science-stem',
            'degree_level' => 'Higher Secondary',
            'duration' => '2 Years',
            'tuition_fee' => 110000.00,
            'eligibility' => 'Successful completion of Grade 10 (CBSE/ICSE/State Board) with strong grades in Science & Math.',
            'seats' => 100,
            'syllabus_summary' => 'Physics, Chemistry, Advanced Mathematics, Computer Science / Biology, English Core, Integrated competitive exam foundation.',
            'career_prospects' => 'Direct pathway to premier Engineering, Medical, Research, and Architecture undergraduate institutes.',
            'avg_package' => 'Pathway to Top Universities',
            'is_popular' => 1
        ],
        [
            'institution_id' => 6,
            'category_id' => 6,
            'name' => 'Bachelor of Architecture (B.Arch)',
            'slug' => 'bachelor-of-architecture-barch',
            'degree_level' => 'Undergraduate',
            'duration' => '5 Years (10 Semesters)',
            'tuition_fee' => 185000.00,
            'eligibility' => '10+2 with Physics, Chemistry, and Mathematics (50%) + valid NATA or JEE Main Paper 2 score.',
            'seats' => 60,
            'syllabus_summary' => 'Architectural Design Studios, Climatology, Structural Systems, History of World Architecture, Urban Planning, Building Information Modeling (BIM).',
            'career_prospects' => 'Licensed Architect, Urban Planner, Landscape Architect, Sustainable Design Consultant, Interior Architect.',
            'avg_package' => '₹5.5 - ₹15.0 LPA',
            'is_popular' => 1
        ]
    ];

    $courseStmt = $pdo->prepare("INSERT INTO courses 
        (institution_id, category_id, name, slug, degree_level, duration, tuition_fee, eligibility, seats, syllabus_summary, career_prospects, avg_package, is_popular) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($courses as $c) {
        try {
            $courseStmt->execute([
                $c['institution_id'], $c['category_id'], $c['name'], $c['slug'],
                $c['degree_level'], $c['duration'], $c['tuition_fee'], $c['eligibility'],
                $c['seats'], $c['syllabus_summary'], $c['career_prospects'], $c['avg_package'],
                $c['is_popular']
            ]);
        } catch (Exception $e) {}
    }

    // 4. Educational Resources (Study Materials, Syllabus, Sample Papers)
    $resources = [
        [
            'title' => 'Complete Data Structures & Algorithms Notes (Handwritten & Digital)',
            'category_id' => 1,
            'course_id' => 2,
            'resource_type' => 'Lecture Notes',
            'format' => 'PDF',
            'file_size' => '4.8 MB',
            'description' => 'Comprehensive notes covering Arrays, Linked Lists, Trees, Graphs, Dynamic Programming, and Time Complexity with code snippets in C++ and Java.',
            'download_url' => 'assets/resources/dsa_complete_notes.pdf',
            'downloads_count' => 1420,
            'is_featured' => 1
        ],
        [
            'title' => 'CBSE Class 12 Physics & Chemistry 5-Year Solved Board Papers',
            'category_id' => 8,
            'course_id' => 8,
            'resource_type' => 'Sample Papers',
            'format' => 'PDF',
            'file_size' => '8.2 MB',
            'description' => 'Chapter-wise solved past board question papers with step-by-step marking scheme solutions and examiner tips for score maximization.',
            'download_url' => 'assets/resources/class12_solved_papers.pdf',
            'downloads_count' => 2890,
            'is_featured' => 1
        ],
        [
            'title' => 'Financial Accounting & Corporate Taxation Model Question Bank',
            'category_id' => 3,
            'course_id' => 4,
            'resource_type' => 'Study Guide',
            'format' => 'PDF',
            'file_size' => '3.5 MB',
            'description' => 'Important ledger balances, GST computation models, cash flow statements, and practice questions for university commerce examinations.',
            'download_url' => 'assets/resources/financial_accounting_bank.pdf',
            'downloads_count' => 970,
            'is_featured' => 1
        ],
        [
            'title' => 'Artificial Intelligence & Neural Networks Syllabus & Lab Manual',
            'category_id' => 1,
            'course_id' => 1,
            'resource_type' => 'Syllabus',
            'format' => 'PDF',
            'file_size' => '2.1 MB',
            'description' => 'Complete academic curriculum, week-by-week syllabus progression, and hands-on PyTorch / TensorFlow lab assignment instructions.',
            'download_url' => 'assets/resources/ai_lab_manual.pdf',
            'downloads_count' => 830,
            'is_featured' => 0
        ],
        [
            'title' => 'Medical Physiology & Anatomical Diagram Quick Reference Atlas',
            'category_id' => 2,
            'course_id' => 6,
            'resource_type' => 'E-Book',
            'format' => 'PDF',
            'file_size' => '12.4 MB',
            'description' => 'High-resolution colored anatomical diagrams, cardiovascular flowcharts, neuroanatomy maps, and clinical mnemonics for MBBS students.',
            'download_url' => 'assets/resources/medical_physiology_atlas.pdf',
            'downloads_count' => 1650,
            'is_featured' => 1
        ],
        [
            'title' => 'Architectural Drafting & Elevation Planning Guide (BIM Fundamentals)',
            'category_id' => 6,
            'course_id' => 9,
            'resource_type' => 'Study Guide',
            'format' => 'PDF',
            'file_size' => '6.3 MB',
            'description' => 'Essential architectural drafting conventions, isometric projection guidelines, and Revit/AutoCAD shortcut cheatsheets.',
            'download_url' => 'assets/resources/architectural_drafting_guide.pdf',
            'downloads_count' => 540,
            'is_featured' => 0
        ]
    ];

    $resStmt = $pdo->prepare("INSERT INTO resources 
        (title, category_id, course_id, resource_type, format, file_size, description, download_url, downloads_count, is_featured) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($resources as $res) {
        try {
            $resStmt->execute([
                $res['title'], $res['category_id'], $res['course_id'], $res['resource_type'],
                $res['format'], $res['file_size'], $res['description'], $res['download_url'],
                $res['downloads_count'], $res['is_featured']
            ]);
        } catch (Exception $e) {}
    }

    // 5. Inquiries
    $inquiries = [
        [
            'student_name' => 'Aarav Sharma',
            'email' => 'aarav.sharma@example.com',
            'phone' => '+91 98765 43210',
            'city' => 'Bengaluru',
            'institution_id' => 1,
            'course_id' => 1,
            'qualification' => 'Class 12 (PCM) - 94%',
            'message' => 'Interested in B.Tech in Artificial Intelligence. What are the scholarship criteria and upcoming counseling dates?',
            'status' => 'Contacted'
        ],
        [
            'student_name' => 'Priya Nair',
            'email' => 'priya.nair@example.com',
            'phone' => '+91 98112 34567',
            'city' => 'Mumbai',
            'institution_id' => 2,
            'course_id' => 4,
            'qualification' => 'Class 12 Commerce - 96%',
            'message' => 'Please provide information regarding B.Com Honours cutoffs and hostel accommodation options.',
            'status' => 'Pending'
        ],
        [
            'student_name' => 'Rohan Sen',
            'email' => 'rohan.sen@example.com',
            'phone' => '+91 97441 22890',
            'city' => 'Delhi',
            'institution_id' => 3,
            'course_id' => 6,
            'qualification' => 'NEET Qualified - Score 640',
            'message' => 'Looking for MBBS admission guidance and internship hospital affiliations details.',
            'status' => 'Under Review'
        ]
    ];

    $inqStmt = $pdo->prepare("INSERT INTO inquiries 
        (student_name, email, phone, city, institution_id, course_id, qualification, message, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($inquiries as $inq) {
        try {
            $inqStmt->execute([
                $inq['student_name'], $inq['email'], $inq['phone'], $inq['city'],
                $inq['institution_id'], $inq['course_id'], $inq['qualification'],
                $inq['message'], $inq['status']
            ]);
        } catch (Exception $e) {}
    }

    // 6. Reviews
    $reviews = [
        [
            'institution_id' => 1,
            'student_name' => 'Divya Ramesh',
            'course_name' => 'B.Tech AI & Data Science',
            'rating' => 5,
            'review_title' => 'Exceptional faculty and industry-ready labs!',
            'review_content' => 'The curriculum at Apex is updated every semester with input from industry practitioners. The high-performance labs and project mentoring helped me secure an internship at Microsoft.',
            'batch_year' => 'Class of 2024'
        ],
        [
            'institution_id' => 2,
            'student_name' => 'Aditya Verma',
            'course_name' => 'B.Com Honours',
            'rating' => 5,
            'review_title' => 'Rich legacy and unmatched campus life',
            'review_content' => 'St. Xavier offers a vibrant cultural experience alongside intense academics. The Bloomberg terminals in the library give commerce students a distinct edge in finance interviews.',
            'batch_year' => 'Class of 2023'
        ],
        [
            'institution_id' => 5,
            'student_name' => 'Meera Joshi (Parent)',
            'course_name' => 'Grade 11 & 12 Science',
            'rating' => 5,
            'review_title' => 'Best balanced curriculum and caring mentorship',
            'review_content' => 'Greenwood balanced board syllabus coaching with national entrance preparation so smoothly. The teachers are approachable and truly care about holistic growth.',
            'batch_year' => 'Batch 2024'
        ]
    ];

    $revStmt = $pdo->prepare("INSERT INTO reviews 
        (institution_id, student_name, course_name, rating, review_title, review_content, batch_year) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    foreach ($reviews as $rev) {
        try {
            $revStmt->execute([
                $rev['institution_id'], $rev['student_name'], $rev['course_name'],
                $rev['rating'], $rev['review_title'], $rev['review_content'], $rev['batch_year']
            ]);
        } catch (Exception $e) {}
    }

    // 7. Admin user (default username: admin, password: password123)
    $passwordHash = password_hash('password123', PASSWORD_DEFAULT);
    $adminStmt = $pdo->prepare("INSERT INTO admin_users (username, password_hash, full_name, role) VALUES (?, ?, ?, ?)");
    try {
        $adminStmt->execute(['admin', $passwordHash, 'Administrator', 'superadmin']);
    } catch (Exception $e) {}
}
