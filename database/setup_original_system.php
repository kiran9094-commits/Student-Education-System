<?php
/**
 * Master Database Initializer for Original Student Education System
 * Creates tables: schools, colleges, courses, feedback, contacts
 * Populates all 33 Gujarat districts, Banaskantha talukas, landmark colleges, and distinct course datasets
 */

function initOriginalStudentEducationSystem(PDO $pdo): array {
    // 1. Create Tables
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS schools (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            type TEXT NOT NULL, -- 'Government' or 'Private'
            district TEXT NOT NULL,
            taluka TEXT DEFAULT NULL,
            address TEXT NOT NULL,
            board TEXT DEFAULT 'GSEB',
            website TEXT DEFAULT '#',
            phone TEXT DEFAULT '+91 70464 83464',
            rating REAL DEFAULT 4.5,
            reviews_count INTEGER DEFAULT 85,
            description TEXT,
            facilities TEXT,
            banner_image TEXT DEFAULT 'assets/images/college_banner_default.svg',
            logo_image TEXT DEFAULT 'assets/images/college_logo_default.svg',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS colleges (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            type TEXT NOT NULL, -- 'Government' or 'Private'
            city TEXT NOT NULL,
            district TEXT NOT NULL,
            address TEXT NOT NULL,
            website TEXT NOT NULL,
            category TEXT NOT NULL,
            courses_offered TEXT NOT NULL,
            description TEXT,
            accreditation TEXT DEFAULT 'UGC Approved',
            rating REAL DEFAULT 4.6,
            established_year INTEGER DEFAULT 1980,
            phone TEXT DEFAULT '+91 70464 83464',
            email TEXT DEFAULT 'info@college.edu.in',
            banner_image TEXT DEFAULT 'assets/images/college_banner_default.svg',
            logo_image TEXT DEFAULT 'assets/images/college_logo_default.svg',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS courses_catalog (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            category TEXT NOT NULL, -- 'SCIENCE / MEDICAL', 'ENGINEERING', 'COMPUTER / IT', 'MANAGEMENT', 'ARTS'
            degree_level TEXT NOT NULL,
            duration TEXT NOT NULL,
            eligibility TEXT NOT NULL,
            admission_info TEXT NOT NULL,
            career_options TEXT NOT NULL,
            description TEXT NOT NULL,
            syllabus_overview TEXT NOT NULL,
            related_colleges TEXT NOT NULL,
            avg_salary TEXT,
            slug TEXT NOT NULL UNIQUE,
            icon TEXT DEFAULT 'fas fa-graduation-cap',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS feedback (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            rating INTEGER NOT NULL,
            message TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS contacts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            mobile TEXT NOT NULL,
            subject TEXT NOT NULL,
            message TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");

    // Clear old data to rebuild fresh
    $pdo->exec("DELETE FROM courses_catalog;");
    $pdo->exec("DELETE FROM schools;");
    $pdo->exec("DELETE FROM colleges;");

    // ==========================================
    // 2. SEED COURSES (Separate, distinct datasets for every single course!)
    // ==========================================
    $courses = [
        // --- SCIENCE / MEDICAL ---
        [
            'name' => 'MBBS (Bachelor of Medicine, Bachelor of Surgery)',
            'category' => 'SCIENCE / MEDICAL',
            'degree_level' => 'Undergraduate',
            'duration' => '5.5 Years (4.5 Years Academic + 1 Year Mandatory Rotatory Internship)',
            'eligibility' => 'Passed 10+2 with Physics, Chemistry, Biology/Biotechnology & English with minimum 50% marks (40% for reserved category) and qualified NEET-UG examination.',
            'admission_info' => 'Centralized merit counseling conducted by ACPUGMEC (Admission Committee for Professional Under Graduate Medical Educational Courses, Gandhinagar) based on All India NEET-UG rank.',
            'career_options' => 'General Physician, Medical Officer (Govt PHC/CHC), Junior Resident Doctor, Clinical Pathologist, Medical Specialist (after MD/MS), Defense Medical Officer.',
            'description' => 'MBBS is the foundational medical degree in allopathic medicine. Students undergo rigorous theoretical and clinical rotations in Anatomy, Physiology, Pharmacology, Pathology, Forensic Medicine, ENT, Ophthalmology, Surgery, Medicine, and Obstetrics & Gynecology.',
            'syllabus_overview' => 'Pre-Clinical (Anatomy, Biochemistry, Physiology), Para-Clinical (Pathology, Microbiology, Pharmacology, Forensic Medicine), Clinical Phase (General Medicine, General Surgery, Orthopedics, Pediatrics, OBGY, Radiology, Anesthesia).',
            'related_colleges' => 'B.J. Medical College (Ahmedabad), Government Medical College (Surat), Medical College Baroda (SSG Hospital), Government Medical College (Bhavnagar), M.P. Shah GMC (Jamnagar), P.D.U. GMC (Rajkot), GMERS Medical College (Gandhinagar), Banas Medical College & Research Institute (Palanpur), Zydus Medical College (Dahod), GAIMS (GK General Hospital Bhuj).',
            'avg_salary' => '₹8.0 - ₹22.0 LPA',
            'slug' => 'mbbs',
            'icon' => 'fas fa-stethoscope'
        ],
        [
            'name' => 'BDS (Bachelor of Dental Surgery)',
            'category' => 'SCIENCE / MEDICAL',
            'degree_level' => 'Undergraduate',
            'duration' => '5 Years (4 Years Academic + 1 Year Compulsory Rotatory Paid Internship)',
            'eligibility' => '10+2 Higher Secondary with Physics, Chemistry, Biology and English with minimum 50% aggregate score and qualified NEET-UG cut-off for Dental colleges.',
            'admission_info' => 'Admissions administered through state centralized quota by ACPUGMEC Gandhinagar based on NEET-UG percentile.',
            'career_options' => 'Dental Surgeon, Private Dental Practitioner, Orthodontist, Periodontist, Oral & Maxillofacial Surgeon (after MDS), Dental Consultant in Corporate Hospitals, Public Dental Health Officer.',
            'description' => 'BDS is the premier professional degree in dental sciences and oral healthcare. It covers clinical dentistry, oral pathology, maxillofacial prosthetics, endodontics, orthodontics, oral surgery, and preventative dental sciences.',
            'syllabus_overview' => 'General Human Anatomy, Dental Anatomy & Oral Histology, General Pathology & Microbiology, Dental Materials, Oral Pathology, Conservative Dentistry, Oral & Maxillofacial Surgery, Prosthodontics, Pedodontics.',
            'related_colleges' => 'Government Dental College & Hospital (Civil Hospital Ahmedabad), Government Dental College (Jamnagar), Siddhpur Dental College & Hospital (Dethali, Patan), K.M. Shah Dental College (Sumandeep Vidyapeeth, Vadodara), Karnavati School of Dentistry (Gandhinagar), Ahmedabad Dental College & Hospital (Bhadaj-Santej), Dharmsinh Desai Faculty of Dental Science (Nadiad), Manubhai Patel Dental College (Vadodara).',
            'avg_salary' => '₹5.5 - ₹16.0 LPA',
            'slug' => 'bds',
            'icon' => 'fas fa-tooth'
        ],
        [
            'name' => 'BAMS (Bachelor of Ayurvedic Medicine & Surgery)',
            'category' => 'SCIENCE / MEDICAL',
            'degree_level' => 'Undergraduate',
            'duration' => '5.5 Years (4.5 Years Study + 1 Year Clinical Internship)',
            'eligibility' => '10+2 with Physics, Chemistry, Biology (minimum 50%) and Sanskrit or English, qualified NEET-UG.',
            'admission_info' => 'ACPUGMEC AYUSH State Quota Counseling under National Commission for Indian System of Medicine (NCISM) guidelines.',
            'career_options' => 'Ayurvedic Medical Officer (AMO), Panchakarma Specialist, Ayurvedic Physician, Clinical Research Associate in CCRAS, Ayurvedic Drug Manufacturer, Wellness Consultant.',
            'description' => 'BAMS blends classical Vedic Ayurveda with modern anatomical and medical diagnostics. It covers Tridosha Siddhanta, Herbology (Dravyaguna), Panchakarma therapies, Ayurvedic Surgery (Shalya Tantra), and Kayachikitsa.',
            'syllabus_overview' => 'Padartha Vigyan, Kriya Sharir (Physiology), Rachana Sharir (Anatomy), Dravyaguna Vigyana (Pharmacology), Rasashastra, Roganidan, Charaka Samhita, Shalya Tantra (Surgery), Shalakya Tantra (ENT & Eye), Kayachikitsa (Internal Medicine).',
            'related_colleges' => 'Institute of Teaching & Research in Ayurveda (ITRA Jamnagar - Institute of National Importance), Government Akhandanand Ayurvedic College (Ahmedabad), Government Ayurvedic College (Vadodara), Sheth J.P. Government Ayurvedic College (Bhavnagar), Parul Institute of Ayurveda (Vadodara), Shamlaji Ayurvedic Medical College (Aravalli), Netra Chikitsa Ayurvedic College (Amreli).',
            'avg_salary' => '₹4.5 - ₹12.0 LPA',
            'slug' => 'bams',
            'icon' => 'fas fa-mortar-pestle'
        ],
        [
            'name' => 'BHMS (Bachelor of Homeopathic Medicine and Surgery)',
            'category' => 'SCIENCE / MEDICAL',
            'degree_level' => 'Undergraduate',
            'duration' => '5.5 Years (including 1 year internship)',
            'eligibility' => '10+2 with PCB (minimum 50%) and qualified NEET-UG.',
            'admission_info' => 'Centralized merit counseling conducted by ACPUGMEC AYUSH committee.',
            'career_options' => 'Homeopathic Doctor, Clinical Homeopathy Consultant, Medical Officer in Ayush Hospitals, Homeopathic Pharmacy Specialist, Healthcare Researcher.',
            'description' => 'BHMS focuses on holistic healing through individualized homeopathic remedies and similia similibus curentur principles, integrated with modern pathology, diagnostics, and patient care.',
            'syllabus_overview' => 'Homeopathic Pharmacy, Organon of Medicine & Homeopathic Philosophy, Materia Medica, Repertory, Pathology & Microbiology, Community Medicine, Surgery & Homeopathic Therapeutics.',
            'related_colleges' => 'Government Homeopathic Medical College (Dethali, Siddhpur), Ahmedabad Homeopathic Medical College, Baroda Homeopathic Medical College (Vadodara), Anand Homeopathic Medical College, Smt. Malini Kishore Sanghvi Homeopathic Medical College (Karjan), Rajkot Homeopathic Medical College, Jawaharlal Nehru Homeopathic College (Parul University).',
            'avg_salary' => '₹4.0 - ₹10.0 LPA',
            'slug' => 'bhms',
            'icon' => 'fas fa-heartbeat'
        ],
        [
            'name' => 'BPT (Bachelor of Physiotherapy)',
            'category' => 'SCIENCE / MEDICAL',
            'degree_level' => 'Undergraduate',
            'duration' => '4.5 Years (4 Years Academic + 6 Months Rotatory Internship)',
            'eligibility' => '10+2 with Physics, Chemistry, Biology (minimum 50% for open category).',
            'admission_info' => 'Admission through Gujarat ACPUGMEC Allied Health Committee based on 12th Board PCB marks merit.',
            'career_options' => 'Physiotherapist, Sports Rehabilitation Specialist (IPL / National Sports Academies), Neuro Physiotherapist, ICU Chest Physiotherapist, Ergonomic Consultant.',
            'description' => 'BPT is an allied medical science dedicated to restoring physical movement, relieving musculoskeletal pain, and rehabilitating neurological, cardiac, and athletic trauma.',
            'syllabus_overview' => 'Human Anatomy, Human Physiology, Exercise Therapy, Electrotherapy, Biomechanics & Kinesiology, Orthopedic Physiotherapy, Neurological Physiotherapy, Community Rehabilitation.',
            'related_colleges' => 'Government Physiotherapy College (Civil Hospital Ahmedabad), Government Physiotherapy College (Jamnagar), S.B.B. College of Physiotherapy (VS Hospital Ahmedabad), K.M. Patel Institute of Physiotherapy (Karamsad, Anand), Pioneer Physiotherapy College (Vadodara), C.U. Shah Physiotherapy College (Surendranagar).',
            'avg_salary' => '₹4.2 - ₹10.5 LPA',
            'slug' => 'bpt',
            'icon' => 'fas fa-walking'
        ],
        [
            'name' => 'B.Sc Nursing',
            'category' => 'SCIENCE / MEDICAL',
            'degree_level' => 'Undergraduate',
            'duration' => '4 Years',
            'eligibility' => '10+2 with Physics, Chemistry, Biology and English with minimum 45% aggregate score.',
            'admission_info' => 'ACPUGMEC Nursing Admission Committee merit list based on 12th Science PCB marks.',
            'career_options' => 'Registered Staff Nurse, ICU / Operation Theatre Specialist Nurse, Pediatric Nurse, Community Health Officer (CHO), Nursing Educator, Overseas Healthcare Nurse (UK, Canada, USA).',
            'description' => 'B.Sc Nursing prepares professional healthcare nurses equipped with clinical pharmacology, critical patient care, maternal health, and acute emergency nursing skills.',
            'syllabus_overview' => 'Nursing Foundations, Applied Anatomy & Physiology, Nutrition & Dietetics, Medical-Surgical Nursing, Pharmacology, Mental Health Nursing, Child Health (Pediatrics), Midwifery & Obstetrical Nursing.',
            'related_colleges' => 'Government College of Nursing (Civil Hospital Ahmedabad), GMC College of Nursing (Surat), Dinsha Patel College of Nursing (Nadiad), Banas Nursing College (Palanpur), Zydus College of Nursing (Dahod), Manikaka Topawala Institute of Nursing (CHARUSAT), Rotary Institute of Nursing (Navsari).',
            'avg_salary' => '₹3.8 - ₹9.0 LPA',
            'slug' => 'bsc-nursing',
            'icon' => 'fas fa-user-nurse'
        ],
        [
            'name' => 'B.Sc (Pure & Applied Sciences)',
            'category' => 'SCIENCE / MEDICAL',
            'degree_level' => 'Undergraduate',
            'duration' => '3 Years',
            'eligibility' => 'Passed 10+2 Higher Secondary in Science stream (PCM / PCB) from recognized education board.',
            'admission_info' => 'Direct merit admission conducted by universities (Gujarat University, MSU Baroda, SPU, HNGU).',
            'career_options' => 'Analytical Chemist, Quality Control Executive in Pharma / Petrochemical industries, Research Assistant, Data Scientist, Scientific Officer in ONGC / PRL / ISRO, Higher Studies (M.Sc/Ph.D).',
            'description' => 'B.Sc provides foundational education across core scientific disciplines including Chemistry, Physics, Mathematics, Botany, Zoology, and Biotechnology.',
            'syllabus_overview' => 'Inorganic & Organic Chemistry, Classical & Quantum Physics, Advanced Calculus, Cellular Biology, Spectroscopy, Instrumental Chemical Analysis, Laboratory Practicals.',
            'related_colleges' => 'St. Xavier\'s College (Autonomous, Ahmedabad), M.G. Science Institute (Navrangpura, Ahmedabad), Sir P.P. Institute of Science (Bhavnagar), Bahauddin Science College (Junagadh), B.P. Baria Science Institute (Navsari), R.R. Mehta College of Science (Palanpur), Sheth M.N. Science College (Patan).',
            'avg_salary' => '₹3.5 - ₹8.0 LPA',
            'slug' => 'bsc',
            'icon' => 'fas fa-atom'
        ],
        [
            'name' => 'Pharmacy (B.Pharm / D.Pharm)',
            'category' => 'SCIENCE / MEDICAL',
            'degree_level' => 'Undergraduate / Diploma',
            'duration' => '4 Years (B.Pharm) / 2 Years (D.Pharm)',
            'eligibility' => '10+2 with Physics, Chemistry and Biology/Maths with GUJCET examination score.',
            'admission_info' => 'Centralized ACPC Gujarat pharmacy admission counseling based on merit calculation (50% 12th Board + 50% GUJCET).',
            'career_options' => 'Registered Pharmacist, Drug Inspector, Formulation R&D Scientist, Quality Assurance / QC Executive in Zydus, Sun Pharma, Cadila, Torrent Pharma, Clinical Research Associate.',
            'description' => 'Pharmacy education encompasses drug design, medicinal chemistry, pharmacology, dosage formulation, pharmaceutical biotechnology, and clinical drug evaluation.',
            'syllabus_overview' => 'Pharmaceutics, Pharmaceutical Chemistry, Pharmacology, Pharmacognosy, Biopharmaceutics, Medicinal Chemistry, Pharmaceutical Analysis, Industrial Pharmacy.',
            'related_colleges' => 'L.M. College of Pharmacy (Ahmedabad - Est. 1947), Nirma University Institute of Pharmacy, B.K. Mody Government Pharmacy College (Rajkot), Anand Pharmacy College, Maliba Pharmacy College (Bardoli, Surat), Dharmsinh Desai Faculty of Pharmacy (Nadiad), Parul Institute of Pharmacy (Vadodara).',
            'avg_salary' => '₹4.2 - ₹11.0 LPA',
            'slug' => 'pharmacy',
            'icon' => 'fas fa-pills'
        ],
        [
            'name' => 'Paramedical Courses (BMLT / BRIT / Dialysis Tech)',
            'category' => 'SCIENCE / MEDICAL',
            'degree_level' => 'Undergraduate / Diploma',
            'duration' => '2 to 3 Years',
            'eligibility' => '10+2 Science with PCB/PCM with minimum 45% aggregate marks.',
            'admission_info' => 'Admission through Gujarat State Paramedical Council merit counseling.',
            'career_options' => 'Medical Lab Technologist, MRI/CT Scan Radiographer, Dialysis Unit Specialist, Operation Theatre Technician, Blood Bank Technologist.',
            'description' => 'Paramedical professionals operate high-tech diagnostic pathology laboratories, clinical radiography imaging, and life-support dialysis systems in hospitals.',
            'syllabus_overview' => 'Clinical Biochemistry, Hematology & Blood Banking, Medical Microbiology, Diagnostic Radiography, Dialysis Principles, Medical Ethics & Patient Management.',
            'related_colleges' => 'B.J. Medical College Paramedical Institute (Civil Hospital Ahmedabad), Medical College Baroda Allied Health Center, U.N. Mehta Institute of Cardiology & Research Centre, Gujarat Cancer & Research Institute (GCRI Ahmedabad), Pramukhswami Medical College Allied Health Sciences (Karamsad).',
            'avg_salary' => '₹3.2 - ₹7.5 LPA',
            'slug' => 'paramedical-courses',
            'icon' => 'fas fa-x-ray'
        ],

        // --- ENGINEERING ---
        [
            'name' => 'Computer Engineering (B.Tech / B.E.)',
            'category' => 'ENGINEERING',
            'degree_level' => 'Undergraduate',
            'duration' => '4 Years',
            'eligibility' => '10+2 Science with Physics, Mathematics & Chemistry + GUJCET or JEE Main score.',
            'admission_info' => 'ACPC (Admission Committee for Professional Courses, Gujarat) centralized merit counseling.',
            'career_options' => 'Software Engineer, Full-Stack Developer, AI/Machine Learning Engineer, Cloud Architect, Cybersecurity Specialist, Product Engineer with TCS, Infosys, Microsoft, Amazon.',
            'description' => 'Comprehensive engineering curriculum covering algorithmic design, operating systems, cloud architecture, machine learning, artificial intelligence, and database technologies.',
            'syllabus_overview' => 'Data Structures & Algorithms, Object Oriented Programming (Java/C++), Database Management Systems (DBMS), Computer Networks, Operating Systems, Machine Learning, Web Technologies, Capstone Project.',
            'related_colleges' => 'L.D. College of Engineering (Ahmedabad), Vishwakarma Government Engineering College (VGEC Chandkheda), Nirma University (Ahmedabad), DA-IICT (Gandhinagar), Birla Vishvakarma Mahavidyalaya (BVM Vidyanagar), Faculty of Tech & Engg - MSU Baroda, Dharmsinh Desai University (DDU Nadiad), Government Engineering College Palanpur.',
            'avg_salary' => '₹6.5 - ₹20.0 LPA',
            'slug' => 'computer-engineering',
            'icon' => 'fas fa-laptop-code'
        ],
        [
            'name' => 'Information Technology (IT Engineering)',
            'category' => 'ENGINEERING',
            'degree_level' => 'Undergraduate',
            'duration' => '4 Years',
            'eligibility' => '10+2 Science with PCM + GUJCET / JEE Main.',
            'admission_info' => 'ACPC Gujarat engineering merit counseling.',
            'career_options' => 'Cloud Solutions Architect, DevOps Engineer, Network Administrator, Information Security Analyst, Enterprise Software Engineer.',
            'description' => 'Focuses on enterprise IT infrastructure, distributed cloud systems, cybersecurity, network protocols, and software deployment pipelines.',
            'syllabus_overview' => 'Information Security, Cloud Computing, Distributed Databases, Python for Data Science, Software Engineering, Mobile Computing, Web Services.',
            'related_colleges' => 'L.D. College of Engineering, VGEC Chandkheda, G.H. Patel College of Engineering & Technology (GCET Anand), Sarvajanik College of Engineering & Tech (SCET Surat), DDU Nadiad, A.D. Patel Institute of Technology (ADIT).',
            'avg_salary' => '₹6.0 - ₹18.0 LPA',
            'slug' => 'information-technology',
            'icon' => 'fas fa-network-wired'
        ],
        [
            'name' => 'Mechanical Engineering (B.Tech / B.E.)',
            'category' => 'ENGINEERING',
            'degree_level' => 'Undergraduate',
            'duration' => '4 Years',
            'eligibility' => '10+2 with Physics, Chemistry and Mathematics + GUJCET / JEE Main.',
            'admission_info' => 'Centralized ACPC Gujarat engineering counseling.',
            'career_options' => 'Mechanical Design Engineer, Automobile R&D Engineer, Thermal Power Plant Executive in L&T, Tata Motors, Suzlon, Adani, Reliance Industries.',
            'description' => 'Covers machine design, thermodynamics, fluid dynamics, robotics, additive manufacturing (3D printing), and industrial automation.',
            'syllabus_overview' => 'Engineering Thermodynamics, Fluid Mechanics, Kinematics & Dynamics of Machines, CAD/CAM, Heat Transfer, Manufacturing Technology, Robotics & Automation.',
            'related_colleges' => 'L.D. College of Engineering, SVNIT Surat, BVM Engineering College, MSU Baroda, Shantilal Shah Engineering College (Bhavnagar), GEC Bhuj, GEC Dahod, GEC Modasa, Lukhdhirji Engineering College (Morbi).',
            'avg_salary' => '₹5.0 - ₹14.0 LPA',
            'slug' => 'mechanical-engineering',
            'icon' => 'fas fa-cogs'
        ],
        [
            'name' => 'Civil Engineering (B.Tech / B.E.)',
            'category' => 'ENGINEERING',
            'degree_level' => 'Undergraduate',
            'duration' => '4 Years',
            'eligibility' => '10+2 with PCM + GUJCET / JEE Main.',
            'admission_info' => 'ACPC Gujarat centralized counseling.',
            'career_options' => 'Structural Engineer, Highway & Bridge Engineer, Metro Rail Project Engineer (G-Metro), Construction Project Manager, Urban Infrastructure Planner.',
            'description' => 'Specializes in planning, structural design, and supervision of massive public infrastructure including expressways, bridges, dams, and smart cities.',
            'syllabus_overview' => 'Structural Analysis, Geotechnical & Soil Engineering, Concrete Technology, Surveying, Transportation Engineering, Environmental Engineering, Hydrology & Water Resources.',
            'related_colleges' => 'L.D. College of Engineering, BVM Engineering College, MSU Baroda, SVNIT Surat, CEPT University (Ahmedabad), Shantilal Shah Engg College (Bhavnagar), GEC Godhra, GEC Bharuch, GEC Patan, GEC Valsad.',
            'avg_salary' => '₹4.5 - ₹12.5 LPA',
            'slug' => 'civil-engineering',
            'icon' => 'fas fa-building'
        ],
        [
            'name' => 'Electrical Engineering (B.Tech / B.E.)',
            'category' => 'ENGINEERING',
            'degree_level' => 'Undergraduate',
            'duration' => '4 Years',
            'eligibility' => '10+2 with PCM + GUJCET / JEE Main.',
            'admission_info' => 'ACPC Gujarat centralized merit counseling.',
            'career_options' => 'Power Systems Engineer, EV Charging Infrastructure Specialist, Renewable Solar/Wind Energy Consultant with GETCO, Torrent Power, Adani Power.',
            'description' => 'Encompasses electric power generation, high-voltage transmission, renewable solar/wind grids, electric vehicle motor drives, and smart energy systems.',
            'syllabus_overview' => 'Electrical Machines, Power Systems, Control Systems, Power Electronics, Microcontrollers, High Voltage Engineering, Renewable Energy Sources, Switchgear & Protection.',
            'related_colleges' => 'L.D. College of Engineering, BVM Engineering College, MSU Baroda, PDEU Gandhinagar, VGEC Chandkheda, GEC Gandhinagar, GPERI Mehsana, Lukhdhirji Engg College (Morbi).',
            'avg_salary' => '₹5.0 - ₹13.5 LPA',
            'slug' => 'electrical-engineering',
            'icon' => 'fas fa-bolt'
        ],
        [
            'name' => 'Electronics & Communication Engineering (EC)',
            'category' => 'ENGINEERING',
            'degree_level' => 'Undergraduate',
            'duration' => '4 Years',
            'eligibility' => '10+2 with PCM + GUJCET / JEE Main.',
            'admission_info' => 'ACPC Gujarat centralized counseling.',
            'career_options' => 'VLSI Chip Design Engineer, Embedded Systems Developer, 5G Telecom Engineer, IoT Device Specialist, Hardware Design Engineer in Intel, Qualcomm, ISRO.',
            'description' => 'Bridges microelectronics, semiconductor circuit fabrication, signal processing, satellite communications, and Internet of Things (IoT).',
            'syllabus_overview' => 'Analog & Digital Electronics, Signals & Systems, Microprocessors & Microcontrollers, VLSI Design, Antenna & Wave Propagation, Wireless Mobile Communication, Digital Signal Processing.',
            'related_colleges' => 'DA-IICT (Gandhinagar), L.D. College of Engineering, VGEC Chandkheda, Nirma University, DDU Nadiad, BVM Vidyanagar, SVNIT Surat.',
            'avg_salary' => '₹5.8 - ₹16.0 LPA',
            'slug' => 'electronics-communication-engineering',
            'icon' => 'fas fa-microchip'
        ],
        [
            'name' => 'Automobile Engineering (B.Tech / B.E.)',
            'category' => 'ENGINEERING',
            'degree_level' => 'Undergraduate',
            'duration' => '4 Years',
            'eligibility' => '10+2 with Physics, Chemistry and Mathematics + GUJCET / JEE Main.',
            'admission_info' => 'ACPC Gujarat engineering counseling.',
            'career_options' => 'Automotive Design Engineer, Electric Vehicle (EV) Powertrain Specialist, Vehicle Dynamics Engineer in Suzuki Motor Gujarat, Tata Motors, MG Motor.',
            'description' => 'Focuses on vehicle structural design, internal combustion engines, battery pack management, electric vehicle architectures, and crash safety engineering.',
            'syllabus_overview' => 'Automotive Engines, Automotive Chassis & Transmission, Vehicle Dynamics, Electric & Hybrid Vehicles, Automobile Safety, Auto Electrical & Electronics Systems.',
            'related_colleges' => 'L.D. College of Engineering (Ahmedabad), A.D. Patel Institute of Technology (ADIT Anand), Indus University (Ahmedabad), Parul University (Vadodara), Shankersinh Vaghela Bapu Institute of Technology (Gandhinagar).',
            'avg_salary' => '₹5.2 - ₹14.0 LPA',
            'slug' => 'automobile-engineering',
            'icon' => 'fas fa-car'
        ],

        // --- COMPUTER / IT ---
        [
            'name' => 'BCA (Bachelor of Computer Applications)',
            'category' => 'COMPUTER / IT',
            'degree_level' => 'Undergraduate',
            'duration' => '3 Years',
            'eligibility' => 'Passed 10+2 in any stream (Commerce / Science / Arts) with English and Mathematics / Statistics / Computer as one of the subjects.',
            'admission_info' => 'Centralized university merit admission (Gujarat University, MSU, SPU, HNGU, VNSGU).',
            'career_options' => 'Software Developer, Web Application Developer, Database Administrator, QA Tester, Frontend Specialist, Mobile App Developer.',
            'description' => 'BCA delivers practical software development and coding skills. It trains students in modern programming languages, database architecture, and web application building.',
            'syllabus_overview' => 'C & C++ Programming, Core & Advanced Java, Web Development (HTML/CSS/JS/PHP), Database Management (MySQL), Python Programming, Cloud Computing, Software Testing.',
            'related_colleges' => 'GLS Institute of Computer Applications (Ahmedabad), Som-Lalit Institute of Computer Applications (Ahmedabad), Natubhai V. Patel College (NVPAS Vidyanagar), Smt. K.B. Parekh College (Bhavnagar), Ganpat University (Kherva), Marwadi University (Rajkot), Chimanbhai S. Patel BCA College (Palanpur).',
            'avg_salary' => '₹4.0 - ₹9.5 LPA',
            'slug' => 'bca',
            'icon' => 'fas fa-code'
        ],
        [
            'name' => 'B.Sc IT (Information Technology)',
            'category' => 'COMPUTER / IT',
            'degree_level' => 'Undergraduate',
            'duration' => '3 Years',
            'eligibility' => '10+2 Science or Commerce with Mathematics / Statistics.',
            'admission_info' => 'Direct university merit application.',
            'career_options' => 'IT Infrastructure Specialist, Cloud Associate, Information Security Analyst, Network Operations Engineer, Full-Stack Developer.',
            'description' => 'Combines theoretical computer science with applied IT networking, Linux server administration, cybersecurity, and enterprise cloud frameworks.',
            'syllabus_overview' => 'Computer Fundamentals, Linux OS, Networking Protocols (TCP/IP), Python & Java Programming, Cyber Law & Security, Cloud Architecture, Mobile Application Development.',
            'related_colleges' => 'K.S. School of Business Management & Information Technology (Gujarat University), CHARUSAT CMPICA (Changa), Parul Institute of Applied Sciences (Vadodara), Ganpat University, RK University (Rajkot).',
            'avg_salary' => '₹4.2 - ₹10.0 LPA',
            'slug' => 'bsc-it',
            'icon' => 'fas fa-terminal'
        ],
        [
            'name' => 'MCA (Master of Computer Applications)',
            'category' => 'COMPUTER / IT',
            'degree_level' => 'Postgraduate',
            'duration' => '2 Years',
            'eligibility' => 'BCA, B.Sc (Computer Science / IT), or any Bachelor degree with Mathematics at 10+2 level with minimum 50% marks + CMAT Gujarat score.',
            'admission_info' => 'ACPC (Admission Committee for Professional Courses) centralized Gujarat MCA counseling based on CMAT score.',
            'career_options' => 'Senior Software Engineer, Technical Architect, Data Engineer, Cloud Solution Specialist, DevOps Manager in multinational IT firms.',
            'description' => 'Advanced postgraduate computer applications degree emphasizing enterprise software engineering, distributed systems, deep learning, and scalable cloud computing.',
            'syllabus_overview' => 'Advanced Data Structures, Cloud Computing, Big Data Analytics, Full-Stack Frameworks (React, Node, Django), Artificial Intelligence, Microservices, Enterprise Project.',
            'related_colleges' => 'L.D. College of Engineering (Ahmedabad), Nirma University (Ahmedabad), Rollwala Computer Centre (Gujarat University), Dharmsinh Desai University (DDU Nadiad), Sardar Patel University MCA Department (Vidyanagar), VNSGU Department of Computer Science (Surat).',
            'avg_salary' => '₹6.5 - ₹16.0 LPA',
            'slug' => 'mca',
            'icon' => 'fas fa-server'
        ],
        [
            'name' => 'B.Sc Computer Science',
            'category' => 'COMPUTER / IT',
            'degree_level' => 'Undergraduate',
            'duration' => '3 Years',
            'eligibility' => '10+2 with Mathematics/Science stream.',
            'admission_info' => 'University merit-based admissions.',
            'career_options' => 'Systems Programmer, Algorithm Engineer, Data Analyst, Quantitative Research Associate, Machine Learning Assistant.',
            'description' => 'Focuses deeply on the mathematical and scientific foundations of computation, algorithms, compiler design, and automata theory.',
            'syllabus_overview' => 'Discrete Mathematics, Algorithms & Complexity, Theory of Computation, Compiler Design, Database Architecture, Machine Learning Foundations, Computer Graphics.',
            'related_colleges' => 'St. Xavier\'s College (Autonomous Ahmedabad), Sir P.P. Institute of Science (Bhavnagar), Ganpat University (Mehsana), Atmiya University (Rajkot).',
            'avg_salary' => '₹4.5 - ₹11.0 LPA',
            'slug' => 'bsc-computer-science',
            'icon' => 'fas fa-brain'
        ],
        [
            'name' => 'PGDCA (Post Graduate Diploma in Computer Applications)',
            'category' => 'COMPUTER / IT',
            'degree_level' => 'Postgraduate Diploma',
            'duration' => '1 Year',
            'eligibility' => 'Graduation in any discipline (Arts / Science / Commerce) from a recognized university.',
            'admission_info' => 'Direct merit admission by university colleges.',
            'career_options' => 'IT Support Executive, Database Operator, Government Office Computer Assistant (GPSC / High Court / Talati / Clerk roles), Office Automation Specialist.',
            'description' => 'One-year job-oriented computer certification that equips graduates with practical proficiency in office automation, database management, and basic programming.',
            'syllabus_overview' => 'Computer Concepts & MS Office, C Programming, Database Management (SQL), Visual Basic / .NET, Internet & Web Concepts, Practical Project.',
            'related_colleges' => 'Gujarat University Computer Center (Ahmedabad), Hemchandracharya North Gujarat University (Patan), Saurashtra University (Rajkot), Sardar Patel University (Vallabh Vidyanagar), Maharaja Krishnakumarsinhji Bhavnagar University.',
            'avg_salary' => '₹2.8 - ₹5.5 LPA',
            'slug' => 'pgdca',
            'icon' => 'fas fa-desktop'
        ],

        // --- MANAGEMENT / COMMERCE ---
        [
            'name' => 'BBA (Bachelor of Business Administration)',
            'category' => 'MANAGEMENT',
            'degree_level' => 'Undergraduate',
            'duration' => '3 Years',
            'eligibility' => '10+2 Higher Secondary in Commerce, Science, or Arts with English as a compulsory subject.',
            'admission_info' => 'Merit-based admission through university admission committees.',
            'career_options' => 'Business Development Executive, Marketing Associate, HR Specialist, Financial Analyst, Operations Executive, Family Business Entrepreneur.',
            'description' => 'BBA provides structured training in business strategy, financial management, organizational behavior, marketing dynamics, and entrepreneurial leadership.',
            'syllabus_overview' => 'Principles of Management, Business Economics, Financial Accounting, Marketing Management, Human Resource Management, Business Law, Strategic Management.',
            'related_colleges' => 'B.K. School of Professional & Management Studies (Ahmedabad), B.J. Vanijya Mahavidyalaya (Anand), Som-Lalit Institute of Business Administration, C.P. Patel College (Anand), Shrimad Rajchandra Institute (Bardoli, Surat), Marwadi University (Rajkot).',
            'avg_salary' => '₹4.5 - ₹10.0 LPA',
            'slug' => 'bba',
            'icon' => 'fas fa-briefcase'
        ],
        [
            'name' => 'MBA (Master of Business Administration)',
            'category' => 'MANAGEMENT',
            'degree_level' => 'Postgraduate',
            'duration' => '2 Years',
            'eligibility' => 'Bachelor\'s degree in any discipline with minimum 50% marks + qualified CMAT Gujarat / CAT score.',
            'admission_info' => 'ACPC Gujarat MBA centralized counseling based on CMAT score.',
            'career_options' => 'Brand Manager, Investment Banking Associate, Management Consultant, Corporate Finance Manager, Supply Chain Director with Deloitte, HDFC, Reliance, Adani.',
            'description' => 'Premier management qualification offering specializations in Marketing, Finance, Human Resource Management, Business Analytics, and International Business.',
            'syllabus_overview' => 'Managerial Economics, Financial Management, Marketing Strategy, Corporate Governance, Quantitative Techniques, Supply Chain Analytics, Summer Internship, Capstone Dissertation.',
            'related_colleges' => 'Indian Institute of Management (IIM Ahmedabad), B.K. School of Management (Gujarat University), Nirma University Institute of Management, Institute of Rural Management Anand (IRMA), G.H. Patel Institute of Business Management (SPU), Shanti Business School (Ahmedabad), Auro University (Surat).',
            'avg_salary' => '₹8.0 - ₹24.0 LPA',
            'slug' => 'mba',
            'icon' => 'fas fa-chart-line'
        ],
        [
            'name' => 'B.Com (Bachelor of Commerce)',
            'category' => 'MANAGEMENT',
            'degree_level' => 'Undergraduate',
            'duration' => '3 Years',
            'eligibility' => '10+2 Higher Secondary in Commerce stream.',
            'admission_info' => 'Centralized online university admission portal.',
            'career_options' => 'Accountant, Tax Consultant, Financial Associate, Banking Executive, Audit Assistant, Foundation for Chartered Accountancy (CA) / CS / CMA.',
            'description' => 'Comprehensive education in corporate accounting, financial auditing, income tax laws, banking practices, and commercial jurisprudence.',
            'syllabus_overview' => 'Financial Accounting, Cost Accounting, Corporate Laws, Income Tax Law & Practice, Auditing, Business Mathematics & Statistics, Financial Management.',
            'related_colleges' => 'H.L. College of Commerce (Ahmedabad), Sir K.P. College of Commerce (Surat), M.J. College of Commerce (Bhavnagar), R.R. Mehta & C.L. Parikh College (Palanpur, Banaskantha), C.B. Patel Arts & J.G. Patel Commerce College (Nadiad), Tolani Institute of Commerce (Gandhidham).',
            'avg_salary' => '₹3.6 - ₹8.0 LPA',
            'slug' => 'bcom',
            'icon' => 'fas fa-calculator'
        ],
        [
            'name' => 'M.Com (Master of Commerce)',
            'category' => 'MANAGEMENT',
            'degree_level' => 'Postgraduate',
            'duration' => '2 Years',
            'eligibility' => 'B.Com / BBA degree from a recognized university.',
            'admission_info' => 'Direct university merit admissions.',
            'career_options' => 'Senior Financial Analyst, Corporate Auditor, College Assistant Professor (UGC NET / SLET), Tax Advisor, Banking Officer.',
            'description' => 'Advanced studies in financial reporting, corporate governance, forensic accounting, international taxation, and statistical research methods.',
            'syllabus_overview' => 'Advanced Financial Accounting, Corporate Financial Policy, International Business, Direct & Indirect Taxes, Strategic Financial Management, Research Methodology.',
            'related_colleges' => 'S.D. School of Commerce (Gujarat University Ahmedabad), Faculty of Commerce - MSU Baroda, VNSGU Department of Commerce (Surat), Sardar Patel University (Vallabh Vidyanagar), Saurashtra University (Rajkot).',
            'avg_salary' => '₹4.5 - ₹10.0 LPA',
            'slug' => 'mcom',
            'icon' => 'fas fa-coins'
        ],

        // --- ARTS & HUMANITIES ---
        [
            'name' => 'BA (Bachelor of Arts)',
            'category' => 'ARTS',
            'degree_level' => 'Undergraduate',
            'duration' => '3 Years',
            'eligibility' => 'Passed 10+2 Higher Secondary in any stream (Arts, Commerce, or Science).',
            'admission_info' => 'Direct university merit admission.',
            'career_options' => 'Civil Services (UPSC / GPSC Officer), Content Writer, Translator, Public Relations Executive, Secondary School Teacher, Social Activist.',
            'description' => 'Multidisciplinary liberal arts degree offering specializations in English Literature, Gujarati, Hindi, Economics, Psychology, History, and Political Science.',
            'syllabus_overview' => 'Selected Major Discipline (Literature / Economics / History / Psychology), Compulsory English, Environmental Studies, Social Research, Interdisciplinary Electives.',
            'related_colleges' => 'Gujarat Arts & Science College (Ahmedabad - Est. 1860), St. Xavier\'s College (Autonomous Ahmedabad), Samaldas Arts College (Bhavnagar), Bahauddin Government Arts College (Junagadh), Sheth B.D. Arts College (Patan), G.D. Modi Arts College (Palanpur).',
            'avg_salary' => '₹3.2 - ₹7.0 LPA',
            'slug' => 'ba',
            'icon' => 'fas fa-book'
        ],
        [
            'name' => 'MA (Master of Arts)',
            'category' => 'ARTS',
            'degree_level' => 'Postgraduate',
            'duration' => '2 Years',
            'eligibility' => 'Bachelor of Arts (BA) in relevant subject with minimum 50% marks.',
            'admission_info' => 'University post-graduate department merit admission.',
            'career_options' => 'College Professor / Lecturer (UGC NET / SLET), Policy Researcher, Senior Editor, Diplomatic / Cultural Officer, Archeologist.',
            'description' => 'Advanced theoretical scholarship, literary criticism, economic policy modeling, historical archives research, and psychological counseling methodologies.',
            'syllabus_overview' => 'Advanced Literary Theory, Econometric Analysis, Psychological Testing, Historiography, Public Administration, Research Dissertation.',
            'related_colleges' => 'School of Languages (Gujarat University), Faculty of Arts - MSU Baroda, SPU Department of Humanities (Vallabh Vidyanagar), Hemchandracharya North Gujarat University (Patan).',
            'avg_salary' => '₹4.0 - ₹9.0 LPA',
            'slug' => 'ma',
            'icon' => 'fas fa-feather-alt'
        ],
        [
            'name' => 'BJMC (Bachelor of Journalism & Mass Communication)',
            'category' => 'ARTS',
            'degree_level' => 'Undergraduate',
            'duration' => '3 Years',
            'eligibility' => 'Passed 10+2 Higher Secondary in any stream.',
            'admission_info' => 'University merit and communication aptitude test.',
            'career_options' => 'News Anchor, Investigative Reporter, Digital Content Producer, Public Relations Manager, Video Journalist with Sandesh, Divya Bhaskar, Gujarat Samachar, TV9 Gujarati.',
            'description' => 'Trains media professionals in print journalism, television news broadcasting, podcast production, digital social media strategy, and public relations.',
            'syllabus_overview' => 'News Reporting & Editing, Electronic Media Production, Media Law & Ethics, Public Relations & Corporate Communication, Digital Journalism, Media Photography & Video Editing.',
            'related_colleges' => 'Department of Journalism (Gujarat University Ahmedabad), National Institute of Mass Communication (NIMC Ahmedabad), H.L. Institute of Media Studies, Parul Institute of Journalism & Mass Communication (Vadodara).',
            'avg_salary' => '₹4.0 - ₹11.0 LPA',
            'slug' => 'bjmc',
            'icon' => 'fas fa-newspaper'
        ],
        [
            'name' => 'MSW (Master of Social Work)',
            'category' => 'ARTS',
            'degree_level' => 'Postgraduate',
            'duration' => '2 Years',
            'eligibility' => 'Graduation in any discipline from recognized university.',
            'admission_info' => 'University entrance test & personal interview.',
            'career_options' => 'Corporate Social Responsibility (CSR) Manager, NGO Project Director, Medical & Psychiatric Social Worker, Child Welfare Specialist, Labor Welfare Officer.',
            'description' => 'Dedicated professional degree training social change leaders in community development, tribal welfare, labor welfare legislation, and psychiatric rehabilitation.',
            'syllabus_overview' => 'Social Work History & Ideologies, Community Organization & Social Action, Social Work Research, Human Growth & Development, Labor Legislation, Rural & Urban Fieldwork Practicum.',
            'related_colleges' => 'Gujarat Vidyapith (Founded by Mahatma Gandhi, Ahmedabad), Faculty of Social Work - MSU Baroda, Sardar Patel University Department of Social Work (Vidyanagar), VNSGU Surat, Hemchandracharya North Gujarat University (Patan).',
            'avg_salary' => '₹4.2 - ₹10.0 LPA',
            'slug' => 'msw',
            'icon' => 'fas fa-hands-helping'
        ]
    ];

    $courseStmt = $pdo->prepare("
        INSERT INTO courses_catalog (
            name, category, degree_level, duration, eligibility,
            admission_info, career_options, description, syllabus_overview,
            related_colleges, avg_salary, slug, icon
        ) VALUES (
            :name, :category, :degree_level, :duration, :eligibility,
            :admission_info, :career_options, :description, :syllabus_overview,
            :related_colleges, :avg_salary, :slug, :icon
        )
    ");

    foreach ($courses as $c) {
        $courseStmt->execute($c);
    }

    // ==========================================
    // 3. SEED SCHOOLS (All 33 Gujarat Districts with Government / Private & Banaskantha Talukas)
    // ==========================================
    $districts = [
        'Ahmedabad', 'Amreli', 'Anand', 'Aravalli', 'Banaskantha', 'Bharuch',
        'Bhavnagar', 'Botad', 'Chhota Udepur', 'Dahod', 'Dang', 'Devbhumi Dwarka',
        'Gandhinagar', 'Gir Somnath', 'Jamnagar', 'Junagadh', 'Kheda', 'Kutch',
        'Mahisagar', 'Mehsana', 'Morbi', 'Narmada', 'Navsari', 'Panchmahal',
        'Patan', 'Porbandar', 'Rajkot', 'Sabarkantha', 'Surat', 'Surendranagar',
        'Tapi', 'Vadodara', 'Valsad'
    ];

    $banaskanthaTalukas = [
        'Palanpur', 'Deesa', 'Dhanera', 'Tharad', 'Vadgam', 'Danta',
        'Amirgadh', 'Deodar', 'Kankrej', 'Bhabhar', 'Lakhani', 'Suigam', 'Vav'
    ];

    $schoolStmt = $pdo->prepare("
        INSERT INTO schools (
            name, type, district, taluka, address, board, website, phone,
            rating, reviews_count, description, facilities
        ) VALUES (
            :name, :type, :district, :taluka, :address, :board, :website, :phone,
            :rating, :reviews_count, :description, :facilities
        )
    ");

    $schoolsCount = 0;

    foreach ($districts as $dist) {
        // Create 10 schools per district (5 Government, 5 Private)
        for ($i = 1; $i <= 10; $i++) {
            $isGovt = ($i % 2 === 1);
            $type = $isGovt ? 'Government' : 'Private';
            $board = ($i % 3 === 0) ? 'CBSE' : 'GSEB';
            $rating = round(4.2 + ($i % 7) * 0.1, 1);
            $reviews = 40 + ($i * 18);

            // Specific taluka for Banaskantha
            $taluka = null;
            if ($dist === 'Banaskantha') {
                $taluka = $banaskanthaTalukas[($i - 1) % count($banaskanthaTalukas)];
            }

            if ($dist === 'Banaskantha') {
                $schoolNames = [
                    'Vidyamandir Trust English Medium School',
                    'Government Model Higher Secondary School (Palanpur)',
                    'Adarsh High School (Deesa)',
                    'Government Secondary School (Dhanera)',
                    'St. Xavier\'s High School (Palanpur)',
                    'Government Kanya Shala (Tharad)',
                    'Shree Swaminarayan Gurukul Vidyalaya (Vadgam)',
                    'K.M. Patel High School (Danta)',
                    'Amirgadh Government Model School',
                    'Sharda Mandir High School (Bhabhar)'
                ];
                $name = $schoolNames[$i - 1] ?? "Banaskantha {$type} School {$i}";
                $city = $taluka;
            } elseif ($dist === 'Ahmedabad') {
                $schoolNames = [
                    'Government Higher Secondary School (Gota)',
                    'Delhi Public School (Bopal)',
                    'Government Girls High School (Ellisbridge)',
                    'St. Xavier\'s High School (Loyola Hall)',
                    'Kendriya Vidyalaya (SAC ISRO Campus)',
                    'Udgam School for Children (Thaltej)',
                    'Government High School (Sanand)',
                    'Zydus School for Excellence (Vejalpur)',
                    'Government Secondary School (Dholka)',
                    'Anand Niketan School (Satellite)'
                ];
                $name = $schoolNames[$i - 1];
                $city = 'Ahmedabad';
            } elseif ($dist === 'Surat') {
                $schoolNames = [
                    'Government Model Higher Secondary School (Surat)',
                    'Delhi Public School (Dumas Road)',
                    'Government Secondary School (Bardoli)',
                    'Tapti Valley International School',
                    'Kendriya Vidyalaya (Surat No. 1)',
                    'Essar International School (Hazira)',
                    'Government Kanya Vidyalaya (Katargam)',
                    'Lourdes Convent High School',
                    'Government High School (Mandvi)',
                    'P.P. Savani International School'
                ];
                $name = $schoolNames[$i - 1];
                $city = 'Surat';
            } elseif ($dist === 'Vadodara') {
                $schoolNames = [
                    'Government Higher Secondary School (Sayajiganj)',
                    'Navrachana School (Sama)',
                    'Government Secondary School (Dabhoi)',
                    'Baroda High School (Alkapuri)',
                    'Kendriya Vidyalaya (Harni Road)',
                    'Delhi Public School (Kalali)',
                    'Government Model School (Waghodia)',
                    'St. Kabir School (Akota)',
                    'Government Girls High School (Fatehgunj)',
                    'Bright Day School (Vasna)'
                ];
                $name = $schoolNames[$i - 1];
                $city = 'Vadodara';
            } elseif ($dist === 'Rajkot') {
                $schoolNames = [
                    'Government Higher Secondary School (Rajkot)',
                    'The Rajkumar College (RKC Heritage)',
                    'Government Secondary School (Gondal)',
                    'Saint Mary\'s High School',
                    'Kendriya Vidyalaya (Rajkot Para)',
                    'Delhi Public School (Kalawad Road)',
                    'Government Model School (Jetpur)',
                    'Shree Swaminarayan Gurukul Vidyalaya',
                    'Government Kanya Vidyalaya (Kothariya)',
                    'Genius English Medium School'
                ];
                $name = $schoolNames[$i - 1];
                $city = 'Rajkot';
            } else {
                $name = $isGovt ? "Government Higher Secondary School ({$dist} {$i})" : "Shree {$dist} Public English School {$i}";
                $city = $dist;
            }

            $schoolStmt->execute([
                ':name' => $name,
                ':type' => $type,
                ':district' => $dist,
                ':taluka' => $taluka,
                ':address' => "Station Road, {$city}, {$dist} District, Gujarat",
                ':board' => $board,
                ':website' => 'https://schools.gujarat.gov.in',
                ':phone' => '+91 70464 83464',
                ':rating' => $rating,
                ':reviews_count' => $reviews,
                ':description' => "{$name} is a leading {$type} educational institution in {$dist} District, Gujarat. Equipped with dedicated classrooms, laboratories, sports grounds, and comprehensive academic curricula.",
                ':facilities' => 'Smart Digital Classrooms, Science Laboratories, Computer Lab, Sports Ground, Central Library, Transportation'
            ]);

            $schoolsCount++;
        }
    }

    // ==========================================
    // 4. SEED COLLEGES (Include Important Landmark Gujarat Institutions)
    // ==========================================
    $landmarkColleges = [
        [
            'name' => 'L.D. College of Engineering (LDCE)',
            'type' => 'Government',
            'city' => 'Ahmedabad',
            'district' => 'Ahmedabad',
            'address' => 'Opposite Gujarat University, Navrangpura, Ahmedabad, Gujarat 380015',
            'website' => 'http://ldce.ac.in',
            'category' => 'Engineering',
            'courses_offered' => 'Computer Engineering, IT, Mechanical, Civil, Electrical, EC, Chemical, Automobile Engineering',
            'description' => 'Established in 1948, L.D. College of Engineering is Gujarat\'s premier government technological institution affiliated with Gujarat Technological University (GTU).',
            'accreditation' => 'AICTE Approved, GTU Affiliated, NBA Accredited',
            'established_year' => 1948,
            'rating' => 4.8
        ],
        [
            'name' => 'Gujarat University',
            'type' => 'Government',
            'city' => 'Ahmedabad',
            'district' => 'Ahmedabad',
            'address' => 'Navrangpura, Ahmedabad, Gujarat 380009',
            'website' => 'https://www.gujaratuniversity.ac.in',
            'category' => 'Multidisciplinary',
            'courses_offered' => 'B.Com, M.Com, BCA, MCA, B.Sc IT, BA, MA, MBA, BJMC, MSW, Law',
            'description' => 'Gujarat University is the state\'s largest and oldest public state university, empowering higher education with distinguished departments and research centers.',
            'accreditation' => 'UGC Recognized, NAAC A+ Grade Apex State University',
            'established_year' => 1949,
            'rating' => 4.7
        ],
        [
            'name' => 'Nirma University',
            'type' => 'Private',
            'city' => 'Ahmedabad',
            'district' => 'Ahmedabad',
            'address' => 'Sarkhej-Gandhinagar Highway, Gota, Ahmedabad, Gujarat 382481',
            'website' => 'https://nirmauni.ac.in',
            'category' => 'Engineering & Management',
            'courses_offered' => 'B.Tech Computer, Mechanical, Electrical, MBA, B.Pharm, M.Pharm, BBA LLB',
            'description' => 'Nirma University is a premier statutory private university renowned nationally for engineering, technology, management, and pharmacy excellence.',
            'accreditation' => 'UGC Recognized, NAAC A+ Accredited University',
            'established_year' => 2003,
            'rating' => 4.9
        ],
        [
            'name' => 'CEPT University',
            'type' => 'Private',
            'city' => 'Ahmedabad',
            'district' => 'Ahmedabad',
            'address' => 'Kasturbhai Lalbhai Campus, University Road, Navrangpura, Ahmedabad, Gujarat 380009',
            'website' => 'https://cept.ac.in',
            'category' => 'Architecture & Planning',
            'courses_offered' => 'Bachelor of Architecture, Civil Engineering, Urban Planning, Design, Interior Design',
            'description' => 'Centre for Environmental Planning and Technology (CEPT) is India\'s top premier institution for architecture, urban design, and habitat planning.',
            'accreditation' => 'Council of Architecture Approved, UGC Recognized',
            'established_year' => 1962,
            'rating' => 4.9
        ],
        [
            'name' => 'Vishwakarma Government Engineering College (VGEC)',
            'type' => 'Government',
            'city' => 'Gandhinagar',
            'district' => 'Gandhinagar',
            'address' => 'Near Visat Three Roads, Chandkheda, Gandhinagar Highway, Gujarat 382424',
            'website' => 'https://www.vgecg.ac.in',
            'category' => 'Engineering',
            'courses_offered' => 'Computer Engineering, Information Technology, EC, Electrical, Civil, Mechanical Engineering',
            'description' => 'A premier state government engineering college imparting world-class technical education and innovation incubations under GTU.',
            'accreditation' => 'AICTE Approved, Government of Gujarat, NBA Accredited',
            'established_year' => 1999,
            'rating' => 4.7
        ],
        [
            'name' => 'Dharmsinh Desai University (DDU)',
            'type' => 'Private',
            'city' => 'Nadiad',
            'district' => 'Kheda',
            'address' => 'College Road, Nadiad, Kheda District, Gujarat 387001',
            'website' => 'https://www.ddu.ac.in',
            'category' => 'Engineering & Pharmacy',
            'courses_offered' => 'Computer Engineering, IT, Chemical, Electronics, B.Pharm, BDS Dental, BCA, MCA',
            'description' => 'Dharmsinh Desai University is renowned for cutting-edge engineering, chemical technology, pharmacy, and dental sciences with high campus placement records.',
            'accreditation' => 'NAAC A Grade, UGC Recognized Autonomous University',
            'established_year' => 1968,
            'rating' => 4.8
        ],
        [
            'name' => 'Sardar Patel University (SPU)',
            'type' => 'Government',
            'city' => 'Anand',
            'district' => 'Anand',
            'address' => 'Mota Bazaar, Vallabh Vidyanagar, Anand District, Gujarat 388120',
            'website' => 'https://www.spuvvn.edu',
            'category' => 'Multidisciplinary',
            'courses_offered' => 'B.Com, M.Com, B.Sc, M.Sc, MBA, MCA, B.Ed, Social Work (MSW), Arts',
            'description' => 'Named after Sardar Vallabhbhai Patel, SPU is a landmark university fostering educational rural renaissance in the Charotar region.',
            'accreditation' => 'UGC Recognized, NAAC A Grade State University',
            'established_year' => 1955,
            'rating' => 4.7
        ],
        [
            'name' => 'Maharaja Sayajirao University of Baroda (MSU)',
            'type' => 'Government',
            'city' => 'Vadodara',
            'district' => 'Vadodara',
            'address' => 'Fatehgunj, Vadodara, Gujarat 390002',
            'website' => 'https://www.msubaroda.ac.in',
            'category' => 'Multidisciplinary',
            'courses_offered' => 'Engineering (FTE), Medical (Baroda Medical College), Commerce, Science, Arts, Fine Arts, Law, MSW',
            'description' => 'Founded in 1881 by Maharaja Sayajirao Gaekwad III, MSU Baroda is the only state university in Gujarat with English as the sole medium of instruction across all faculties.',
            'accreditation' => 'UGC Recognized, NAAC A+ Grade Centralized University',
            'established_year' => 1881,
            'rating' => 4.9
        ],
        [
            'name' => 'Veer Narmad South Gujarat University (VNSGU)',
            'type' => 'Government',
            'city' => 'Surat',
            'district' => 'Surat',
            'address' => 'Udhana-Magdalla Road, Surat, Gujarat 395007',
            'website' => 'https://www.vnsgu.ac.in',
            'category' => 'Multidisciplinary',
            'courses_offered' => 'B.Com, M.Com, B.Sc, M.Sc, MCA, MBA, Medicine, Rural Studies, BA, MA',
            'description' => 'Apex public state university serving Surat and South Gujarat districts, fostering multidisciplinary higher learning.',
            'accreditation' => 'UGC Recognized, NAAC A Grade State University',
            'established_year' => 1965,
            'rating' => 4.6
        ],
        [
            'name' => 'RK University',
            'type' => 'Private',
            'city' => 'Rajkot',
            'district' => 'Rajkot',
            'address' => 'Bhavnagar Highway, Kasturbadham, Rajkot, Gujarat 360020',
            'website' => 'https://rku.ac.in',
            'category' => 'Engineering & Healthcare',
            'courses_offered' => 'B.Tech Computer, Mechanical, Civil, B.Pharm, BPT Physiotherapy, MBA, MCA, B.Sc IT',
            'description' => 'RK University is a prominent private research university in Saurashtra offering multidisciplinary education in technology, healthcare, and business.',
            'accreditation' => 'UGC Recognized, NAAC Accredited Private University',
            'established_year' => 2011,
            'rating' => 4.6
        ],
        [
            'name' => 'Parul University',
            'type' => 'Private',
            'city' => 'Vadodara',
            'district' => 'Vadodara',
            'address' => 'P.O. Limda, Waghodia, Vadodara, Gujarat 391760',
            'website' => 'https://paruluniversity.ac.in',
            'category' => 'Multidisciplinary & Medical',
            'courses_offered' => 'B.Tech, MBBS, BAMS, BHMS, BPT, B.Sc Nursing, B.Pharm, MBA, MCA, BCA, BJMC',
            'description' => 'Parul University is one of India\'s largest multidisciplinary campuses, housing integrated faculties in engineering, medicine, Ayush, and design.',
            'accreditation' => 'NAAC A++ Grade, UGC Recognized Leading University',
            'established_year' => 2015,
            'rating' => 4.8
        ],
        [
            'name' => 'Dhirubhai Ambani Institute of Information and Communication Technology (DA-IICT)',
            'type' => 'Private',
            'city' => 'Gandhinagar',
            'district' => 'Gandhinagar',
            'address' => 'Near Indroda Circle, Gandhinagar, Gujarat 382007',
            'website' => 'https://www.daiict.ac.in',
            'category' => 'Computer / IT & Engineering',
            'courses_offered' => 'B.Tech ICT, Mathematics & Computing, M.Sc IT, M.Tech, Ph.D in Computing',
            'description' => 'DA-IICT is India\'s top institute dedicated to Information and Communication Technology, featuring exceptional placements and advanced research.',
            'accreditation' => 'UGC Recognized, NAAC A+ Grade Elite Technology Seat',
            'established_year' => 2001,
            'rating' => 4.9
        ],
        [
            'name' => 'Kadi Sarva Vishwavidyalaya (KSV)',
            'type' => 'Private',
            'city' => 'Kadi',
            'district' => 'Mehsana',
            'address' => 'Sarva Vidyalaya Campus, Kadi, Mehsana District, Gujarat 382715',
            'website' => 'https://ksv.ac.in',
            'category' => 'Multidisciplinary',
            'courses_offered' => 'Engineering (LDRP-ITR), Pharmacy, Nursing, Computer Applications (BCA/MCA), BBA, MBA',
            'description' => 'Founded by Sarva Vidyalaya Kelavani Mandal, KSV provides value-based professional education across Kadi and Gandhinagar campuses.',
            'accreditation' => 'UGC Recognized State Private University',
            'established_year' => 2007,
            'rating' => 4.7
        ],
        [
            'name' => 'B.J. Medical College & Civil Hospital',
            'type' => 'Government',
            'city' => 'Ahmedabad',
            'district' => 'Ahmedabad',
            'address' => 'New Civil Hospital Compound, Asarwa, Ahmedabad, Gujarat 380016',
            'website' => 'https://bjmcabd.edu.in',
            'category' => 'Medical',
            'courses_offered' => 'MBBS, MD, MS, Super-Specialty DM/MCh, B.Sc Nursing, Paramedical Courses',
            'description' => 'One of India\'s largest and most prestigious medical colleges attached to Civil Hospital Ahmedabad, providing apex tertiary clinical healthcare and training.',
            'accreditation' => 'National Medical Commission (NMC) Approved',
            'established_year' => 1871,
            'rating' => 4.9
        ],
        [
            'name' => 'Government Medical College Surat (GMC Surat)',
            'type' => 'Government',
            'city' => 'Surat',
            'district' => 'Surat',
            'address' => 'Majura Gate, Surat, Gujarat 395001',
            'website' => 'https://gmcsurat.edu.in',
            'category' => 'Medical',
            'courses_offered' => 'MBBS, MD, MS, B.Sc Nursing, Paramedical Diplomas',
            'description' => 'Premier government medical teaching college and tertiary healthcare hospital in South Gujarat.',
            'accreditation' => 'NMC Approved Government Medical College',
            'established_year' => 1964,
            'rating' => 4.8
        ],
        [
            'name' => 'Banas Medical College & Research Institute (BMCRI)',
            'type' => 'Government',
            'city' => 'Palanpur',
            'district' => 'Banaskantha',
            'address' => 'Malan Gate, Palanpur, Banaskantha District, Gujarat 385001',
            'website' => 'https://bmcri.co.in',
            'category' => 'Medical',
            'courses_offered' => 'MBBS, B.Sc Nursing, Paramedical Technology',
            'description' => 'Pioneering medical college in North Gujarat established under Gujarat Medical Education and Research Society (GMERS) / Banas Dairy Trust.',
            'accreditation' => 'National Medical Commission (NMC) Approved',
            'established_year' => 2018,
            'rating' => 4.7
        ],
        [
            'name' => 'Government Dental College & Hospital (GDCH)',
            'type' => 'Government',
            'city' => 'Ahmedabad',
            'district' => 'Ahmedabad',
            'address' => 'Civil Hospital Campus, Asarwa, Ahmedabad, Gujarat 380016',
            'website' => 'https://gdchahmedabad.org',
            'category' => 'Dental / Medical',
            'courses_offered' => 'BDS (Bachelor of Dental Surgery), MDS (Master of Dental Surgery)',
            'description' => 'Gujarat\'s apex government dental teaching hospital providing specialized oral maxillofacial surgery and advanced dental care.',
            'accreditation' => 'Dental Council of India (DCI) Approved',
            'established_year' => 1963,
            'rating' => 4.9
        ]
    ];

    $collegeStmt = $pdo->prepare("
        INSERT INTO colleges (
            name, type, city, district, address, website, category,
            courses_offered, description, accreditation, established_year, rating
        ) VALUES (
            :name, :type, :city, :district, :address, :website, :category,
            :courses_offered, :description, :accreditation, :established_year, :rating
        )
    ");

    // Insert Landmark colleges
    foreach ($landmarkColleges as $lc) {
        $collegeStmt->execute($lc);
    }

    // Now insert comprehensive colleges across Gujarat cities
    $gujaratCities = [
        'Ahmedabad', 'Gandhinagar', 'Vadodara', 'Surat', 'Rajkot', 'Kadi',
        'Mehsana', 'Bhavnagar', 'Anand', 'Nadiad', 'Vapi', 'Junagadh',
        'Jamnagar', 'Bharuch', 'Patan', 'Palanpur', 'Bhuj', 'Porbandar',
        'Himmatnagar', 'Morbi', 'Surendranagar', 'Navsari', 'Valsad', 'Godhra', 'Amreli'
    ];

    $colTypes = ['Government', 'Private'];
    $colStreams = [
        ['Engineering', 'Computer Engineering, IT, Mechanical, Civil, Electrical'],
        ['Medical', 'MBBS, B.Sc Nursing, Paramedical Courses'],
        ['Management', 'BBA, MBA, B.Com, M.Com'],
        ['Computer / IT', 'BCA, B.Sc IT, MCA, B.Sc Computer Science'],
        ['Sciences', 'B.Sc Chemistry, Physics, Mathematics, Biotechnology'],
        ['Arts', 'BA, MA, MSW, BJMC Journalism'],
        ['Pharmacy', 'B.Pharm, D.Pharm, M.Pharm'],
        ['Law', 'Integrated BA LLB, BBA LLB, LLM']
    ];

    foreach ($gujaratCities as $city) {
        // District determination
        $dist = match($city) {
            'Nadiad' => 'Kheda',
            'Vapi' => 'Valsad',
            'Palanpur' => 'Banaskantha',
            'Bhuj' => 'Kutch',
            'Himmatnagar' => 'Sabarkantha',
            'Godhra' => 'Panchmahal',
            'Kadi' => 'Mehsana',
            default => $city
        };

        // Add 4-6 colleges per major city
        for ($k = 1; $k <= 4; $k++) {
            $streamInfo = $colStreams[($k - 1) % count($colStreams)];
            $isGovt = ($k % 2 === 1);
            $type = $isGovt ? 'Government' : 'Private';
            $cName = $isGovt ? "Government {$streamInfo[0]} College ({$city})" : "Shree {$city} Institute of {$streamInfo[0]}";

            $collegeStmt->execute([
                ':name' => $cName,
                ':type' => $type,
                ':city' => $city,
                ':district' => $dist,
                ':address' => "College Campus, Near Highway, {$city}, {$dist} District, Gujarat",
                ':website' => 'https://gujaratuniversity.ac.in',
                ':category' => $streamInfo[0],
                ':courses_offered' => $streamInfo[1],
                ':description' => "{$cName} is a top accredited {$type} institution in {$city}, Gujarat. Offering certified higher education programs with modern facilities.",
                ':accreditation' => 'UGC / AICTE / State University Approved',
                ':established_year' => 1970 + ($k * 8),
                ':rating' => round(4.3 + ($k % 6) * 0.1, 1)
            ]);
        }
    }

    // 5. Seed sample feedback records
    $pdo->exec("
        INSERT INTO feedback (name, email, rating, message) VALUES
        ('Rohan Patel', 'rohan.patel@gmail.com', 5, 'Best educational portal for Gujarat schools and colleges! Found all 10 schools in Banaskantha easily.'),
        ('Pooja Shah', 'pooja.shah@yahoo.com', 5, 'The course information for BDS and MBBS is so detailed and accurate. Great initiative by Kiran Chaudhary!'),
        ('Jignesh Prajapati', 'jignesh.p@gmail.com', 4, 'Very helpful district-wise filtering. Helped me choose the right engineering college in Ahmedabad.');
    ");

    return [
        'schools' => (int)$pdo->query("SELECT COUNT(*) FROM schools")->fetchColumn(),
        'colleges' => (int)$pdo->query("SELECT COUNT(*) FROM colleges")->fetchColumn(),
        'courses' => (int)$pdo->query("SELECT COUNT(*) FROM courses_catalog")->fetchColumn(),
        'feedback' => (int)$pdo->query("SELECT COUNT(*) FROM feedback")->fetchColumn()
    ];
}
