<?php
/**
 * Gujarat Schools and Colleges Database Seeder
 * Populates exactly 10 Schools and 10 Colleges for EVERY District in Gujarat (33 Districts = 330 Schools + 330 Colleges = 660 Institutions)
 * Student Education System
 */

function seedGujaratInstitutions(PDO $pdo): array {
    $districts = [
        'Ahmedabad' => [
            'cities' => ['Ahmedabad', 'Sanand', 'Dholka'],
            'pincode' => '380001',
            'school_names' => [
                'Delhi Public School (Bopal)', 'St. Xavier\'s High School (Loyola Hall)', 'The Riverside School',
                'Udgam School for Children', 'Zydus School for Excellence', 'Kendriya Vidyalaya (SAC ISRO)',
                'Shree Swaminarayan Gurukul Vidyalaya', 'Asia English School (Drive-In)', 'Ahmedabad International School', 'Anand Niketan School (Satellite)'
            ],
            'colleges' => [
                ['L.D. College of Engineering (LDCE)', 'Engineering & Tech', 1, 'College', 'GTU Affiliated, NAAC A Grade', 'Navrangpura, Ahmedabad'],
                ['B.J. Medical College & Civil Hospital', 'Medical & Healthcare', 2, 'College', 'MCI Approved, Top Medical College', 'Asarwa, Ahmedabad'],
                ['HL College of Commerce (Ahmedabad University)', 'Management & Commerce', 3, 'College', 'NAAC A+ Accredited', 'Navrangpura, Ahmedabad'],
                ['St. Xavier\'s College (Autonomous)', 'Sciences & Arts', 5, 'College', 'NIRF Top Ranked Autonomous College', 'Navrangpura, Ahmedabad'],
                ['Government Polytechnic Ahmedabad', 'Polytechnic Diploma', 1, 'College', 'AICTE Approved Diploma Campus', 'Ambawadi, Ahmedabad'],
                ['Nirma University Institute of Technology', 'Engineering & Tech', 1, 'University', 'NAAC A+ Accredited University', 'S.G. Highway, Ahmedabad'],
                ['L.M. College of Pharmacy', 'Pharmacy & Pharma Tech', 1, 'College', 'Pioneering Pharmacy Institute Est. 1947', 'Navrangpura, Ahmedabad'],
                ['Ahmedabad Dental College & Hospital', 'Dental & Healthcare', 2, 'College', 'DCI Approved Dental Campus', 'Santej, Ahmedabad'],
                ['Sir L.A. Shah Law College', 'Law & Legal Studies', 7, 'College', 'Gujarat University Affiliated Law Seat', 'Ellisbridge, Ahmedabad'],
                ['Government Arts & Commerce College (Gota)', 'Commerce & Humanities', 3, 'College', 'State Government College', 'Gota, Ahmedabad']
            ]
        ],
        'Surat' => [
            'cities' => ['Surat', 'Bardoli', 'Mandvi'],
            'pincode' => '395001',
            'school_names' => [
                'Delhi Public School (Dumas Road)', 'Tapti Valley International School', 'St. Xavier\'s High School (Ghod Dod Road)',
                'Essar International School (Hazira)', 'Kendriya Vidyalaya (Surat No. 1)', 'Lourdes Convent High School',
                'P.P. Savani International School', 'Shree Swaminarayan Mission School', 'G.D. Goenka International School', 'Ryan International School (Adajan)'
            ],
            'colleges' => [
                ['Sardar Vallabhbhai National Institute of Technology (SVNIT)', 'Engineering & Tech', 1, 'University', 'Institute of National Importance', 'Ichchanath, Surat'],
                ['Government Medical College (GMC Surat)', 'Medical & Healthcare', 2, 'College', 'MCI Approved Premier Medical Campus', 'Majura Gate, Surat'],
                ['Sir K.P. College of Commerce', 'Management & Commerce', 3, 'College', 'VNSGU Affiliated, NAAC A Grade', 'Athwalines, Surat'],
                ['Sarvajanik College of Engineering & Technology (SCET)', 'Engineering & Tech', 1, 'College', 'AICTE Approved, Premier Institute', 'Athwalines, Surat'],
                ['Government Polytechnic Surat', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Technical College', 'Majura Gate, Surat'],
                ['C.K. Pithawalla College of Engineering & Tech', 'Engineering & IT', 1, 'College', 'NBA Accredited High-Tech Campus', 'Dumas Road, Surat'],
                ['Maliba Pharmacy College (Bardoli)', 'Pharmacy & Research', 1, 'College', 'Uka Tarsadia University Campus', 'Gopal Vidyanagar, Bardoli, Surat'],
                ['Government Nursing College Surat', 'Nursing & Healthcare', 2, 'College', 'Government Multi-Specialty Institute', 'New Civil Hospital, Surat'],
                ['V.T. Choksi Sarvajanik Law College', 'Law & Legal Studies', 7, 'College', 'Oldest Premier Law Institute in South Gujarat', 'Athwalines, Surat'],
                ['Navyug Science & Arts College', 'Sciences & Mathematics', 5, 'College', 'VNSGU Affiliated Science Institute', 'Rander Road, Surat']
            ]
        ],
        'Vadodara' => [
            'cities' => ['Vadodara', 'Dabhoi', 'Waghodia'],
            'pincode' => '390001',
            'school_names' => [
                'Navrachana School (Sama)', 'Baroda High School (Alkapuri)', 'Delhi Public School (Kalali)',
                'St. Kabir School (Akota)', 'Bright Day School (Vasna)', 'Kendriya Vidyalaya (Harni Road)',
                'New Era Senior Secondary School', 'Anandalaya School', 'Billabong High International School', 'Ambe School (Manjalpur)'
            ],
            'colleges' => [
                ['Maharaja Sayajirao University of Baroda (MSU)', 'Engineering & Multidisciplinary', 1, 'University', 'NAAC A+ Historic Central University', 'Fatehgunj, Vadodara'],
                ['Medical College Baroda (SSG Hospital)', 'Medical & Healthcare', 2, 'College', 'Premier Government Medical College', 'Sayajiganj, Vadodara'],
                ['Parul Institute of Engineering & Technology', 'Engineering & Tech', 1, 'College', 'AICTE Approved, Parul University', 'Waghodia, Vadodara'],
                ['Government Polytechnic Vadodara', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Technical Campus', 'Near Polytechnic Ground, Vadodara'],
                ['Babaria Institute of Technology (BITS Edu Campus)', 'Engineering & Tech', 1, 'College', 'NBA Accredited Engineering Institute', 'Varnama, Vadodara'],
                ['ITM Universe Engineering College', 'Engineering & Management', 1, 'College', 'AICTE Approved Technical Campus', 'Dhanora Tank Road, Vadodara'],
                ['K.M. Shah Dental College & Hospital', 'Dental & Healthcare', 2, 'College', 'DCI Approved Super-Specialty Dental', 'Piparia, Waghodia, Vadodara'],
                ['Pioneer Pharmacy College', 'Pharmacy', 1, 'College', 'PCI Approved Modern Pharmacy Campus', 'Ajwa-Nimeta Road, Vadodara'],
                ['M.S. University Faculty of Law', 'Law & Legal Studies', 7, 'College', 'Premier Legal Studies Faculty', 'Fatehgunj, Vadodara'],
                ['Baroda College of Pharmacy & Sciences', 'Sciences & IT', 5, 'College', 'Gujarat University Affiliated', 'Limda, Waghodia, Vadodara']
            ]
        ],
        'Rajkot' => [
            'cities' => ['Rajkot', 'Gondal', 'Jetpur'],
            'pincode' => '360001',
            'school_names' => [
                'The Rajkumar College (RKC Heritage)', 'Saint Mary\'s High School', 'Delhi Public School (Kalawad Road)',
                'Kendriya Vidyalaya (Rajkot)', 'Shree Swaminarayan Gurukul Vidyalaya', 'Genius English Medium School',
                'Modi School (University Road)', 'S.N.K. School (Sadhu Vaswani Road)', 'Kadvibai Virani Kanya Vidyalaya', 'Masoom School (Gondal Road)'
            ],
            'colleges' => [
                ['All India Institute of Medical Sciences (AIIMS Rajkot)', 'Medical & Healthcare', 2, 'University', 'Apex Healthcare Institute of India', 'Khandheri, Rajkot'],
                ['Government Engineering College Rajkot (GEC Rajkot)', 'Engineering & Tech', 1, 'College', 'AICTE Approved Government Institute', 'Mavdi-Kankot Road, Rajkot'],
                ['V.V.P. Engineering College', 'Engineering & Tech', 1, 'College', 'NBA Accredited, GTU Affiliated', 'Kalawad Road, Rajkot'],
                ['Dharmendrasinhji Arts & Science College', 'Sciences & Arts', 5, 'College', 'Heritage Government College Est. 1937', 'Yagnik Road, Rajkot'],
                ['Government Polytechnic Rajkot', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Diploma Institute', 'Bhavnagar Road, Rajkot'],
                ['Marwadi University Faculty of Technology', 'Engineering & IT', 1, 'University', 'NAAC A+ Accredited Campus', 'Morbi Road, Rajkot'],
                ['Atmiya University Institute of Technology & Science', 'Engineering & Science', 1, 'University', 'UGC Recognized Green Campus', 'Kalawad Road, Rajkot'],
                ['B.K. Mody Government Pharmacy College', 'Pharmacy', 1, 'College', 'AICTE & PCI Approved Government College', 'Polytechnic Campus, Rajkot'],
                ['P.D.U. Government Medical College', 'Medical & Healthcare', 2, 'College', 'MCI Approved Teaching Hospital', 'Hospital Road, Rajkot'],
                ['A.M.P. Government Law College', 'Law & Legal Studies', 7, 'College', 'Saurashtra University Affiliated', 'Yagnik Road, Rajkot']
            ]
        ],
        'Bhavnagar' => [
            'cities' => ['Bhavnagar', 'Palitana', 'Sihor'],
            'pincode' => '364001',
            'school_names' => [
                'Silver Bells Public School', 'Fatima Convent High School', 'Shree Swaminarayan Gurukul School',
                'Kendriya Vidyalaya (Bhavnagar Para)', 'Gnanmanjari Vidyapith', 'B.M. Commerce High School',
                'St. Xavier\'s High School (Ghogha Road)', 'Shri Alfred High School', 'D.C.C. High School (Palitana)', 'Sunrise School (Sihor)'
            ],
            'colleges' => [
                ['Government Medical College Bhavnagar', 'Medical & Healthcare', 2, 'College', 'MCI Approved Government Hospital', 'Near Bus Stand, Bhavnagar'],
                ['Shantilal Shah Engineering College (SSEC)', 'Engineering & Tech', 1, 'College', 'AICTE Approved Government Institute', 'Sidsar Campus, Bhavnagar'],
                ['Sir P.P. Institute of Science (MKBU)', 'Sciences', 5, 'College', 'Maharaja Krishnakumarsinhji University', 'Waghawadi Road, Bhavnagar'],
                ['Government Polytechnic Bhavnagar', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Diploma College', 'Vidyanagar, Bhavnagar'],
                ['M.J. College of Commerce', 'Commerce & Management', 3, 'College', 'Premier Commerce College Est. 1949', 'Waghawadi Road, Bhavnagar'],
                ['Swami Sahajanand College of Commerce & Management', 'Management & IT', 3, 'College', 'Accredited Higher Education Center', 'Kaliyabid, Bhavnagar'],
                ['Smt. K.B. Parekh College of Computer Science', 'Computer Applications & BCA', 4, 'College', 'MKBU Affiliated IT College', 'Mahila College Campus, Bhavnagar'],
                ['Bhavnagar Institute of Medical Sciences & Nursing', 'Nursing & Health', 2, 'College', 'Nursing Council Approved', 'Ghogha Circle, Bhavnagar'],
                ['Sheth H.J. Law College', 'Law & Legal Studies', 7, 'College', 'Oldest Law Institution in Bhavnagar', 'Vidyanagar, Bhavnagar'],
                ['Samaldas Arts College (Heritage Est. 1885)', 'Arts & Humanities', 6, 'College', 'Historic College Mahatma Gandhi Attended', 'Waghawadi Road, Bhavnagar']
            ]
        ],
        'Jamnagar' => [
            'cities' => ['Jamnagar', 'Dhrol', 'Lalpur'],
            'pincode' => '361001',
            'school_names' => [
                'Sainik School Balachadi', 'Kendriya Vidyalaya No. 1 (Airforce Station)', 'St. Xavier\'s High School',
                'Reliance Foundation School (Motikhavdi)', 'Prime School Jamnagar', 'Shree Satya Sai Vidyalaya',
                'Sunflower English Medium School', 'Shree Swaminarayan Vidyalaya', 'Bhavan\'s A.K. Doshi Vidyalaya', 'Pranami High School'
            ],
            'colleges' => [
                ['M.P. Shah Government Medical College', 'Medical & Healthcare', 2, 'College', 'Premier Medical Teaching Hospital', 'Pandit Nehru Marg, Jamnagar'],
                ['Institute of Teaching & Research in Ayurveda (ITRA)', 'Ayurveda & Medical', 2, 'University', 'Institute of National Importance', 'Aryabhat Road, Jamnagar'],
                ['Government Polytechnic Jamnagar', 'Engineering & Polytechnic', 1, 'College', 'AICTE Approved Diploma Campus', 'Valsura Road, Jamnagar'],
                ['Shri D.K.V. Arts & Science College', 'Sciences & Arts', 5, 'College', 'Saurashtra University Affiliated', 'Pandit Nehru Marg, Jamnagar'],
                ['V.M. Mehta Municipal Arts & Commerce College', 'Commerce & Management', 3, 'College', 'Municipal Corporation College', 'Khambhalia Road, Jamnagar'],
                ['G.H.G. Smt. D.D. Patel B.Ed College', 'Education & Teaching', 6, 'College', 'NCTE Approved Education College', 'Patel Colony, Jamnagar'],
                ['Shri K.P. Shah Law College', 'Law & Legal Studies', 7, 'College', 'Professional Legal Education College', 'Seven Rasta, Jamnagar'],
                ['Jamnagar Institute of Nursing Sciences', 'Nursing & Paramedical', 2, 'College', 'Teaching Hospital Affiliated', 'Indira Marg, Jamnagar'],
                ['Patel Institute of Engineering & Technology', 'Engineering & IT', 1, 'College', 'AICTE Approved Campus', 'Dhrol Highway, Jamnagar'],
                ['Shri A.K. Doshi Mahila College', 'Arts & Commerce', 3, 'College', 'Women Empowerment Higher Education', 'Sardar Patel Road, Jamnagar']
            ]
        ],
        'Junagadh' => [
            'cities' => ['Junagadh', 'Keshod', 'Manavadar'],
            'pincode' => '362001',
            'school_names' => [
                'Carmel Convent High School', 'Jawahar Navodaya Vidyalaya (Kodial)', 'Kendriya Vidyalaya (Junagadh)',
                'Shree Swaminarayan Gurukul High School', 'Noble Public School (Bhesan Road)', 'Alpha High School',
                'Patel Boarding High School', 'Vidyut Board English School', 'Vidya Mandir School (Keshod)', 'Sarvodaya Vidyalaya (Manavadar)'
            ],
            'colleges' => [
                ['Junagadh Agricultural University (JAU)', 'Agriculture & Technology', 1, 'University', 'State Agricultural & Research University', 'Moti Baug, Junagadh'],
                ['GMERS Medical College Junagadh', 'Medical & Healthcare', 2, 'College', 'Government Multi-Specialty Hospital', 'Near Majewadi Gate, Junagadh'],
                ['Bahauddin Science College', 'Sciences', 5, 'College', 'Historic Heritage College Est. 1901', 'College Road, Junagadh'],
                ['Government Polytechnic Junagadh', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Technical College', 'Khamdhrol Road, Junagadh'],
                ['Noble Group of Institutions (Engineering & Tech)', 'Engineering & IT', 1, 'College', 'GTU Affiliated Engineering Institute', 'Bhesan Road, Junagadh'],
                ['Bahauddin Government Arts College', 'Arts & Humanities', 6, 'College', 'Heritage Higher Education Campus', 'College Road, Junagadh'],
                ['Sardar Patel Institute of Computer Science (SPICS)', 'IT & Computer Science', 4, 'College', 'BCA & MCA Programs', 'Joshipura, Junagadh'],
                ['Junagadh Institute of Pharmacy', 'Pharmacy', 1, 'College', 'PCI Approved Pharmacy College', 'Bhesan Highway, Junagadh'],
                ['Shri M.D. Arts & Commerce College (Keshod)', 'Commerce & Arts', 3, 'College', 'Bhakt Kavi Narsinh Mehta Univ', 'Keshod, Junagadh'],
                ['Dr. Subhash Technical Campus (Engineering & MBA)', 'Engineering & Management', 1, 'College', 'NBA Accredited High-Tech Campus', 'Khamdhrol Road, Junagadh']
            ]
        ],
        'Gandhinagar' => [
            'cities' => ['Gandhinagar', 'Kalol', 'Mansa'],
            'pincode' => '382010',
            'school_names' => [
                'Delhi Public School (Gandhinagar)', 'Kendriya Vidyalaya (Sector 30)', 'The H.B. Kapadia New High School',
                'Mount Carmel High School (Sector 21)', 'Chaudhari Ballmandir & High School', 'Swaminarayan Dham International School',
                'Podar International School (Koba)', 'Sainik School Kheroj (Mansa Branch)', 'Kalol English Medium High School', 'Vidhya Bharti High School'
            ],
            'colleges' => [
                ['Indian Institute of Technology Gandhinagar (IITGN)', 'Engineering & Tech', 1, 'University', 'Premier Apex Technological Institute', 'Palaj, Gandhinagar'],
                ['Pandit Deendayal Energy University (PDEU)', 'Energy & Engineering', 1, 'University', 'NAAC A++ Energy & Tech Campus', 'Raisan, Gandhinagar'],
                ['National Forensic Sciences University (NFSU)', 'Forensics & Cyber Tech', 4, 'University', 'Institute of National Importance', 'Sector 9, Gandhinagar'],
                ['Gujarat National Law University (GNLU)', 'Law & Legal Studies', 7, 'University', 'Top Tier National Law University', 'Attalika Avenue, Koba, Gandhinagar'],
                ['Government Engineering College Gandhinagar (GECG)', 'Engineering & Tech', 1, 'College', 'AICTE Approved Government Institute', 'Sector 28, Gandhinagar'],
                ['GMERS Medical College Gandhinagar', 'Medical & Healthcare', 2, 'College', 'Modern Medical Teaching Hospital', 'Civil Hospital Campus, Sector 12, Gandhinagar'],
                ['Government Polytechnic Gandhinagar', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Diploma Campus', 'Sector 26, Gandhinagar'],
                ['Karnavati University (Unitedworld School of Law & Business)', 'Management & Law', 3, 'University', 'Modern Industry Integrated Campus', 'Uvarsad, Gandhinagar'],
                ['Kadi Sarva Vishwavidyalaya (LDRP Institute of Tech)', 'Engineering & IT', 1, 'University', 'State Private Technical University', 'Sector 15, Gandhinagar'],
                ['Samarpan Arts & Commerce College', 'Commerce & Arts', 3, 'College', 'Gujarat University Affiliated', 'Sector 28, Gandhinagar']
            ]
        ],
        'Anand' => [
            'cities' => ['Anand', 'Vallabh Vidyanagar', 'Petlad'],
            'pincode' => '388001',
            'school_names' => [
                'Anandalaya National School (NDDB)', 'D.N. High School', 'St. Xavier\'s High School',
                'Vallabh Vidyanagar High School', 'Kendriya Vidyalaya (Anand)', 'Gyanodaya English High School',
                'Amul Model School', 'Charotar English School', 'Petlad High School', 'B.M. Patel Global English School'
            ],
            'colleges' => [
                ['Birla Vishvakarma Mahavidyalaya (BVM Engg)', 'Engineering & Tech', 1, 'College', 'Gujarat\'s First Engineering College Est. 1948', 'Vallabh Vidyanagar, Anand'],
                ['Pramukhswami Medical College (Karamsad)', 'Medical & Healthcare', 2, 'College', 'Premier Medical Teaching Institution', 'Gokalnagar, Karamsad, Anand'],
                ['Anand Agricultural University (AAU)', 'Agriculture & Dairy Tech', 5, 'University', 'National Pioneer in Dairy & Agri Tech', 'Anand Campus, Anand'],
                ['Institute of Rural Management Anand (IRMA)', 'Management & Rural Dev', 3, 'University', 'Premier Rural Management Institution', 'NDDB Road, Anand'],
                ['G.H. Patel College of Engineering & Technology (GCET)', 'Engineering & Tech', 1, 'College', 'AICTE Approved Leading College', 'Bakrol Road, Vallabh Vidyanagar, Anand'],
                ['A.D. Patel Institute of Technology (ADIT)', 'Engineering & Food Tech', 1, 'College', 'NBA Accredited High-Tech Institute', 'New Vallabh Vidyanagar, Anand'],
                ['B.J. Vanijya Mahavidyalaya (BJVM Commerce)', 'Commerce & Business', 3, 'College', 'Historic Commerce College Est. 1951', 'Mota Bazaar, Vallabh Vidyanagar, Anand'],
                ['Anand Pharmacy College', 'Pharmacy & Clinical Research', 1, 'College', 'NIRF Ranked Pharmacy Institute', 'Opposite Town Hall, Anand'],
                ['N.V. Patel College of Pure & Applied Sciences (NVPAS)', 'Sciences & IT', 5, 'College', 'NAAC A Grade Science College', 'Mota Bazaar, Vallabh Vidyanagar, Anand'],
                ['Anand Law College', 'Law & Legal Studies', 7, 'College', 'Sardar Patel University Affiliated', 'SRK Hostel Road, Anand']
            ]
        ],
        'Bharuch' => [
            'cities' => ['Bharuch', 'Ankleshwar', 'Jambusar'],
            'pincode' => '392001',
            'school_names' => [
                'Delhi Public School (Bharuch)', 'Queen of Angels Convent School', 'Amity High School (Bharuch)',
                'Kendriya Vidyalaya (GNFC Township)', 'Shree Narmada English Medium School', 'Lions Public School (Ankleshwar)',
                'Swami Vivekanand Academy', 'Shree Swaminarayan Gurukul School', 'Jambusar Model English School', 'Jay Ambe International School'
            ],
            'colleges' => [
                ['Government Engineering College Bharuch', 'Engineering & Tech', 1, 'College', 'AICTE Approved Government Institute', 'Old National Highway, Bharuch'],
                ['Shroff S.R. Rotary Institute of Chemical Technology (SRICT)', 'Chemical & Engg', 1, 'College', 'Premier Chemical & Environmental Engg', 'Valia, Ankleshwar, Bharuch'],
                ['Narmada College of Science & Commerce', 'Sciences & Commerce', 3, 'College', 'VNSGU Affiliated Campus', 'Shuklatirth Road, Bharuch'],
                ['Government Polytechnic Bharuch', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Technical Diploma', 'Bholav, Bharuch'],
                ['M.K. College of Commerce', 'Commerce & Management', 3, 'College', 'Premier Commerce College Est. 1958', 'Station Road, Bharuch'],
                ['J.P. Arts & Science College', 'Sciences & Humanities', 5, 'College', 'VNSGU Affiliated Pioneer College', 'College Road, Bharuch'],
                ['Ankleshwar Institute of Nursing', 'Nursing & Health', 2, 'College', 'Approved Nursing Teaching Hospital', 'GIDC, Ankleshwar, Bharuch'],
                ['SVM Institute of Technology (Sanatan)', 'Engineering & Polytechnic', 1, 'College', 'AICTE Approved Technical College', 'Old NH-8, Bharuch'],
                ['Smt. T.S.R. Commerce College', 'Commerce & Banking', 3, 'College', 'State Affiliated Degree College', 'Zadeshwar Road, Bharuch'],
                ['Sheth M.M. Shroff Law College', 'Law & Legal Studies', 7, 'College', 'VNSGU Affiliated Legal College', 'Court Road, Bharuch']
            ]
        ],
        'Mehsana' => [
            'cities' => ['Mehsana', 'Visnagar', 'Kadi', 'Unjha'],
            'pincode' => '384001',
            'school_names' => [
                'Kendriya Vidyalaya (ONGC Mehsana)', 'T.J. High School (Mehsana)', 'Gokul Global School (Siddhpur Highway)',
                'Sarvajanik English High School', 'Shree Swaminarayan Gurukul (Radhanpur Road)', 'Shri M.N. High School (Visnagar)',
                'Adarsh Vidyalaya (Kadi)', 'Kadva Patidar English School', 'Umiya Mataji Vidya Mandir (Unjha)', 'Podar Learn School (Mehsana)'
            ],
            'colleges' => [
                ['Ganpat University (U.V. Patel College of Engineering)', 'Engineering & Tech', 1, 'University', 'NAAC Accredited High-Tech Innovation Campus', 'Ganpat Vidyanagar, Mehsana'],
                ['Sankalchand Patel University (Faculty of Tech & Engg)', 'Engineering & Dental', 1, 'University', 'Comprehensive Research University', 'Visnagar, Mehsana'],
                ['Municipal Arts & Urban Bank Science College', 'Sciences & Arts', 5, 'College', 'Established 1964, HNGU Affiliated', 'Highway Road, Mehsana'],
                ['Government Engineering College Mehsana (Kadi)', 'Engineering & Tech', 1, 'College', 'State Government Technical Campus', 'Kadi Highway, Mehsana'],
                ['Government Polytechnic Mehsana', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Diploma Institute', 'Palanpur Highway, Mehsana'],
                ['Gujarat Power Engineering and Research Institute (GPERI)', 'Power & Renewable Energy Engg', 1, 'College', 'Pioneering Clean Energy Engineering', 'Mevad, Mehsana'],
                ['S.K. Pharmaceutical College (Visnagar)', 'Pharmacy', 1, 'College', 'PCI Approved Pharmacy Campus', 'Sankalchand Campus, Visnagar, Mehsana'],
                ['Mehsana Urban Institute of Sciences', 'Sciences & IT', 5, 'College', 'Ganpat University Campus', 'Kherva, Mehsana'],
                ['Sarvajanik Commerce College', 'Commerce & Accountancy', 3, 'College', 'HNGU Affiliated Premier College', 'Nagrik Hospital Road, Mehsana'],
                ['V.M. Patel College of Management Studies', 'Management & MBA', 3, 'College', 'Top Rated B-School Campus', 'Ganpat Vidyanagar, Mehsana']
            ]
        ],
        'Kutch' => [
            'cities' => ['Bhuj', 'Gandhidham', 'Anjar', 'Mandvi'],
            'pincode' => '370001',
            'school_names' => [
                'Delhi Public School (Gandhidham)', 'Army Public School (Bhuj Military Station)', 'Kendriya Vidyalaya (Air Force Station Bhuj)',
                'St. Xavier\'s High School (Bhuj)', 'Modern English School (Gandhidham)', 'Sheth D.L. High School (Bhuj)',
                'Twinkle Star English High School (Anjar)', 'Kutch Public School', 'Shree Swaminarayan Gurukul (Mandvi)', 'Jawahar Navodaya Vidyalaya (Kukma)'
            ],
            'colleges' => [
                ['Krantiguru Shyamji Krishna Verma Kachchh University', 'Multidisciplinary', 1, 'University', 'State University of Kutch District', 'Mundra Road, Bhuj, Kutch'],
                ['Gujarat Adani Institute of Medical Sciences (GAIMS)', 'Medical & Healthcare', 2, 'College', 'PPP Model Multi-Speciality Medical Campus', 'GK General Hospital, Bhuj, Kutch'],
                ['Government Engineering College Bhuj', 'Engineering & Mining', 1, 'College', 'AICTE Approved Engineering Institute', 'New Ravalwadi, Bhuj, Kutch'],
                ['Tolani College of Arts and Science (Adipur)', 'Sciences & Humanities', 5, 'College', 'Premier Higher Education Institute', 'Adipur, Gandhidham, Kutch'],
                ['Government Polytechnic Bhuj', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Technical Diploma', 'Mundra Road, Bhuj, Kutch'],
                ['Tolani Institute of Commerce (Gandhidham)', 'Commerce & Finance', 3, 'College', 'Established Commerce College', 'Adipur, Gandhidham, Kutch'],
                ['Sheth R.R. Lalan College (Bhuj Heritage)', 'Sciences & Arts', 5, 'College', 'Historic College Established 1953', 'College Road, Bhuj, Kutch'],
                ['D.N. High & Higher Technical College (Anjar)', 'Polytechnic & IT', 1, 'College', 'Technical Training Center', 'Anjar, Kutch'],
                ['Veernarayan College of Pharmacy & Nursing (Bhuj)', 'Healthcare & Nursing', 2, 'College', 'Health Sciences Campus', 'Airport Road, Bhuj, Kutch'],
                ['Shri D.G. Law College Bhuj', 'Law & Legal Studies', 7, 'College', 'Kachchh University Affiliated Law Seat', 'Mundra Road, Bhuj, Kutch']
            ]
        ],
        'Amreli' => [
            'cities' => ['Amreli', 'Savarkundla', 'Rajula'],
            'pincode' => '365601',
            'school_names' => [
                'Shree Swaminarayan Gurukul Vidyalaya (Amreli)', 'Jawahar Navodaya Vidyalaya (Mota Bhandariya)', 'Kamani Forward High School',
                'Oxford English Medium School', 'Shree J.K. Patel High School', 'Shree Shardamani High School (Savarkundla)',
                'Kendriya Vidyalaya (Amreli)', 'St. Mary\'s English School', 'Sanskar International School (Rajula)', 'K.K. Parekh English School'
            ],
            'colleges' => [
                ['Shanta Baa Medical College & Civil Hospital', 'Medical & Healthcare', 2, 'College', 'NMC Approved Modern Medical Campus', 'Lathi Road, Amreli'],
                ['Shree Leuva Patel Trust Engineering College', 'Engineering & IT', 1, 'College', 'Premier Women & Co-ed Tech Campus', 'Bhavnagar Highway, Amreli'],
                ['Kamani Science & Prataprai Arts College', 'Sciences & Arts', 5, 'College', 'Established 1961, Saurashtra Univ', 'College Campus, Amreli'],
                ['Government Polytechnic Amreli', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Diploma Institute', 'Rajkot Road, Amreli'],
                ['Smt. P.R. Dhami BBA & BCA College', 'Management & IT', 4, 'College', 'Professional Degree College', 'Lathi Road, Amreli'],
                ['K.K. Parekh Commerce College', 'Commerce & Finance', 3, 'College', 'Saurashtra University Affiliated', 'Station Road, Amreli'],
                ['Savarkundla College of Arts & Commerce', 'Arts & Commerce', 3, 'College', 'Govt Aided Established College', 'Bypass Road, Savarkundla, Amreli'],
                ['Shree Sardar Patel Nursing Institute', 'Nursing & Health', 2, 'College', 'Recognized Nursing Teaching Campus', 'Chital Road, Amreli'],
                ['G.M. Bilakhia College of Pharmacy', 'Pharmacy', 1, 'College', 'PCI Approved Modern Labs', 'Lathi Highway, Amreli'],
                ['Smt. V.V. Patel Law College Amreli', 'Law & Legal Studies', 7, 'College', 'Professional Legal Education Center', 'College Road, Amreli']
            ]
        ],
        'Banaskantha' => [
            'cities' => ['Palanpur', 'Deesa', 'Dhanera', 'Tharad'],
            'pincode' => '385001',
            'school_names' => [
                'Vidyamandir Trust English Medium School', 'Kendriya Vidyalaya (Palanpur)', 'St. Xavier\'s High School (Palanpur)',
                'Adarsh High School (Deesa)', 'Jawahar Navodaya Vidyalaya (Dantiwada)', 'Bright English Medium School (Dhanera)',
                'Royal Public School (Tharad)', 'Shree Swaminarayan Gurukul Vidyalaya (Palanpur)', 'Sharda Mandir High School (Bhabhar)', 'D.N.P. Higher Secondary School (Deesa)'
            ],
            'colleges' => [
                ['Government Engineering College Palanpur (GEC Palanpur)', 'Engineering & Tech', 1, 'College', 'AICTE Approved Government Institute', 'Jagana, Palanpur, Banaskantha'],
                ['Banas Medical College & Research Institute (BMCRI)', 'Medical & Healthcare', 2, 'College', 'NMC Approved Premier Medical College', 'Malan Gate, Palanpur, Banaskantha'],
                ['Sardarkrushinagar Dantiwada Agricultural University (SDAU)', 'Agriculture & Technology', 1, 'University', 'Pioneering Research State University', 'Sardarkrushinagar, Banaskantha'],
                ['R.R. Mehta College of Science & C.L. Parikh College of Commerce', 'Science & Commerce', 3, 'College', 'NAAC A Grade Premier College', 'GD Modi Campus, Palanpur, Banaskantha'],
                ['Government Polytechnic Palanpur', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Technical Diploma', 'Outdoor Stadium Road, Palanpur, Banaskantha'],
                ['D.N.P. Arts & Commerce College (Deesa)', 'Commerce & Arts', 3, 'College', 'HNGU Affiliated Premier Degree College', 'Highway Road, Deesa, Banaskantha'],
                ['G.D. Modi Arts College (Palanpur)', 'Humanities & Social Sciences', 5, 'College', 'Established 1964 Heritage College', 'College Campus, Palanpur, Banaskantha'],
                ['Banas Nursing College & Paramedical Institute', 'Nursing & Paramedical', 2, 'College', 'Modern Teaching Hospital Campus', 'Malan Gate, Palanpur, Banaskantha'],
                ['Chimanbhai S. Patel BBA & BCA College (Palanpur)', 'Management & IT', 4, 'College', 'Advanced Computing & Management Center', 'Vidyamandir Campus, Palanpur, Banaskantha'],
                ['Sir L.A. Law College Banaskantha (Palanpur)', 'Law & Legal Studies', 7, 'College', 'Premier Legal Studies College in North Gujarat', 'College Road, Palanpur, Banaskantha']
            ]
        ],
        'Dahod' => [
            'cities' => ['Dahod', 'Jhalod', 'Limkheda'],
            'pincode' => '389151',
            'school_names' => [
                'St. Stephen\'s High School (Dahod)', 'Kendriya Vidyalaya (Railway Colony Dahod)', 'Little Flowers English Medium School',
                'Jawahar Navodaya Vidyalaya (Muvaliya Dahod)', 'Hindi Higher Secondary School', 'Maharani Chimnabai High School',
                'Sarvajanik High School (Jhalod)', 'Model School (Limkheda)', 'Sunrise English School (Devgadh Baria)', 'Tribal Welfare Model English School'
            ],
            'colleges' => [
                ['Government Engineering College Dahod', 'Engineering & Tech', 1, 'College', 'AICTE Approved Engineering Institute', 'Jhalod Road, Dahod'],
                ['Zydus Medical College & Hospital Dahod', 'Medical & Healthcare', 2, 'College', 'NMC Approved Super-Specialty Medical Institute', 'Nimnaliya, Dahod'],
                ['Government Polytechnic Dahod', 'Polytechnic Engineering', 1, 'College', 'Technical Diploma Institute', 'Godhra Road, Dahod'],
                ['Navjivan Science College Dahod', 'Sciences', 5, 'College', 'SGGU Affiliated Pioneer Science Campus', 'Jhalod Road, Dahod'],
                ['Navjivan Arts & Commerce College', 'Commerce & Arts', 3, 'College', 'Govt Aided Established Degree College', 'Station Road, Dahod'],
                ['Y.S. Arts & K.S. Shah Commerce College (Devgadh Baria)', 'Commerce & Arts', 3, 'College', 'Heritage Degree College', 'Devgadh Baria, Dahod'],
                ['Dahod Institute of Nursing Sciences', 'Nursing & Health', 2, 'College', 'Recognized Nursing College', 'Zydus Hospital Campus, Dahod'],
                ['Gurjar Bharti College of Education & IT', 'IT & Teacher Education', 4, 'College', 'BCA & B.Ed Programs', 'Jhalod Highway, Dahod'],
                ['Jhalod Arts & Commerce College', 'Commerce & Humanities', 3, 'College', 'Affiliated Degree College', 'Jhalod, Dahod'],
                ['Government Polytechnic Limkheda', 'Technical Diploma', 1, 'College', 'State Technical Campus', 'Limkheda, Dahod']
            ]
        ],
        'Kheda' => [
            'cities' => ['Nadiad', 'Kapadvanj', 'Kheda'],
            'pincode' => '387001',
            'school_names' => [
                'St. Anne\'s High School (Nadiad)', 'Shree Vallabh Kanya Vidyalaya', 'Kendriya Vidyalaya (Nadiad)',
                'Sharda Mandir High School', 'Little Angels English School', 'The New English School (Nadiad)',
                'Parekh Brothers Science High School (Kapadvanj)', 'Shree Swaminarayan English School', 'Kheda Public High School', 'Vidyasagar High School (Mahudha)'
            ],
            'colleges' => [
                ['Dharmsinh Desai University (DDU)', 'Engineering, Pharmacy & Dental', 1, 'University', 'NAAC A Grade Renowned Technology University', 'College Road, Nadiad, Kheda'],
                ['M.S. Patel Institute of Technology (MBIT)', 'Engineering & IT', 1, 'College', 'AICTE Approved Technology Campus', 'New Vallabh Vidyanagar, Kheda'],
                ['J. & J. College of Science (Nadiad)', 'Sciences', 5, 'College', 'Established 1947, Premier Research Institute', 'Mission Road, Nadiad, Kheda'],
                ['C.B. Patel Arts & J.G. Patel Commerce College', 'Commerce & Management', 3, 'College', 'Accredited Degree College', 'College Road, Nadiad, Kheda'],
                ['Government Polytechnic Kheda', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Diploma Institute', 'Kheda-Dholka Highway, Kheda'],
                ['Dinsha Patel College of Nursing (Nadiad)', 'Nursing & Health', 2, 'College', 'Top Ranked Nursing Teaching College', 'Mahagujarat Hospital Campus, Nadiad, Kheda'],
                ['Dharmsinh Desai Faculty of Pharmacy', 'Pharmacy', 1, 'College', 'PCI Approved Premier Pharmacy Faculty', 'College Road, Nadiad, Kheda'],
                ['Parekh Brothers Science College (Kapadvanj)', 'Sciences & Chemistry', 5, 'College', 'Established Science Institution', 'Station Road, Kapadvanj, Kheda'],
                ['V.T. Patel College of Education & BBA', 'Management & Education', 3, 'College', 'Professional Degree Campus', 'Petlad Road, Nadiad, Kheda'],
                ['Nadiad Law College', 'Law & Legal Studies', 7, 'College', 'Gujarat University Affiliated Legal Seat', 'Mission Road, Nadiad, Kheda']
            ]
        ],
        'Navsari' => [
            'cities' => ['Navsari', 'Bilimora', 'Jalalpore'],
            'pincode' => '396445',
            'school_names' => [
                'Seth R.J.J. High School (Heritage)', 'St. Francis High School', 'Kendriya Vidyalaya (Navsari)',
                'Sir C.J. New High School (Gandevi)', 'D.D. Girls High School', 'Shree Sardar Patel High School (Jalalpore)',
                'Tata High School (Bilimora)', 'B.G. Parekh English School', 'Shree Vallabh Ashram International School', 'Modern English Medium School'
            ],
            'colleges' => [
                ['Navsari Agricultural University (NAU)', 'Agriculture, Forestry & Vet', 5, 'University', 'Premier Agricultural State University', 'Eru Char Rasta, Navsari'],
                ['B.P. Baria Science Institute', 'Sciences', 5, 'College', 'Heritage Science College Est. 1946', 'Sayaji Library Road, Navsari'],
                ['Mahatma Gandhi Institute of Technical Education & Research', 'Engineering & Tech', 1, 'College', 'AICTE Approved Engineering Institute', 'Bhanunagar, Navsari'],
                ['Government Polytechnic Navsari', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Technical Diploma', 'Matwad, Navsari'],
                ['Sorabji Burjorji Garda Arts & P.K. Patel Commerce College', 'Commerce & Arts', 3, 'College', 'Pioneer Heritage College Est. 1945', 'Sayaji Road, Navsari'],
                ['V.S. Patel College of Arts & Science (Bilimora)', 'Sciences & Arts', 5, 'College', 'VNSGU Affiliated Degree Center', 'Morarji Desai Road, Bilimora, Navsari'],
                ['Shri V.S. Pharmacy College Navsari', 'Pharmacy', 1, 'College', 'PCI Approved Technical Campus', 'Eru Road, Navsari'],
                ['Rotary Institute of Nursing & Healthcare', 'Nursing & Health', 2, 'College', 'Professional Nursing Training College', 'Lunsikui, Navsari'],
                ['S.S. Agrawal College of Commerce & Management', 'Management & IT', 3, 'College', 'BBA, BCA & MBA Campus', 'Gandevi Road, Navsari'],
                ['Dinshaw Daboo Law College Navsari', 'Law & Legal Studies', 7, 'College', 'Oldest Legal Studies College in District', 'Station Road, Navsari']
            ]
        ],
        'Panchmahal' => [
            'cities' => ['Godhra', 'Halol', 'Kalol'],
            'pincode' => '389001',
            'school_names' => [
                'St. Arnold\'s High School (Godhra)', 'Kendriya Vidyalaya (Godhra)', 'Jawahar Navodaya Vidyalaya (Tuwa)',
                'New English High School (Godhra)', 'Telco International School (Halol)', 'V.M. English Medium School',
                'Halol Public High School', 'Shree Swaminarayan Gurukul School (Godhra)', 'Kalol English High School', 'Saraswati Vidya Mandir (Shahera)'
            ],
            'colleges' => [
                ['Shri Govind Guru University (SGGU)', 'Multidisciplinary State Univ', 1, 'University', 'State University of Eastern Gujarat', 'Raska, Godhra, Panchmahal'],
                ['Government Engineering College Godhra', 'Engineering & Tech', 1, 'College', 'AICTE Approved Government Institute', 'Chhabanpur, Godhra, Panchmahal'],
                ['Sheth P.T. Arts & Science College Godhra', 'Sciences & Arts', 5, 'College', 'Govt Aided Pioneer College Est. 1957', 'Vavdi Road, Godhra, Panchmahal'],
                ['Government Polytechnic Godhra', 'Polytechnic Engineering', 1, 'College', 'Technical Diploma College', 'Near Civil Hospital, Godhra, Panchmahal'],
                ['Sheth M.N.C. College of Commerce', 'Commerce & Finance', 3, 'College', 'SGGU Affiliated Commerce College', 'Vavdi Road, Godhra, Panchmahal'],
                ['Halol Engineering & Technical Campus', 'Engineering & Industrial Tech', 1, 'College', 'AICTE Approved Engineering Center', 'GIDC Industrial Area, Halol, Panchmahal'],
                ['Godhra Medical & Paramedical Institute', 'Healthcare & Paramedical', 2, 'College', 'Civil Hospital Teaching Center', 'Hospital Road, Godhra, Panchmahal'],
                ['B.M. Patel College of Nursing', 'Nursing & Health', 2, 'College', 'Approved Professional Nursing Institute', 'Lal Baug, Godhra, Panchmahal'],
                ['Smt. B.C.J. BBA & BCA College Godhra', 'Management & IT', 4, 'College', 'Computer Science & BBA Center', 'Station Road, Godhra, Panchmahal'],
                ['Law College Godhra', 'Law & Legal Studies', 7, 'College', 'SGGU Affiliated Legal Studies Center', 'Civil Lines, Godhra, Panchmahal']
            ]
        ],
        'Patan' => [
            'cities' => ['Patan', 'Siddhpur', 'Radhanpur'],
            'pincode' => '384265',
            'school_names' => [
                'B.D. High School (Patan Heritage)', 'Kendriya Vidyalaya (Patan)', 'St. Xavier\'s High School (Siddhpur)',
                'Model School (Radhanpur)', 'Shree Swaminarayan Gurukul (Patan)', 'Sheth M.N. High School',
                'Adarsh Vidyalaya (Siddhpur)', 'Patan English Medium School', 'Shree Saraswati High School', 'Jawahar Navodaya Vidyalaya (Patan)'
            ],
            'colleges' => [
                ['Hemchandracharya North Gujarat University (HNGU)', 'Multidisciplinary', 1, 'University', 'NAAC A Grade Apex State University', 'University Road, Patan'],
                ['GMERS Medical College Dharpur-Patan', 'Medical & Healthcare', 2, 'College', 'Modern Medical College & Multi-Specialty Hospital', 'Dharpur, Patan'],
                ['Government Engineering College Patan', 'Engineering & Tech', 1, 'College', 'AICTE Approved Government Campus', 'Katpur, Patan'],
                ['Sheth M.N. Science College Patan', 'Sciences', 5, 'College', 'Established 1959 Pioneer Science College', 'Rajmahal Road, Patan'],
                ['Government Polytechnic Patan', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Technical Diploma', 'Chansama Road, Patan'],
                ['Smt. T.S.R. Commerce College Patan', 'Commerce & Management', 3, 'College', 'HNGU Affiliated Degree College', 'University Road, Patan'],
                ['Sheth B.D. Arts College (Heritage Est. 1959)', 'Arts & Languages', 6, 'College', 'Historic Higher Education Institution', 'Old Fort Area, Patan'],
                ['K.D. Polytech & Engineering Institute', 'Technical Engineering', 1, 'College', 'Diploma & Degree Technical College', 'Radhanpur Highway, Patan'],
                ['Patan Institute of Nursing Sciences', 'Nursing & Health', 2, 'College', 'Teaching Hospital Affiliated', 'Dharpur Highway, Patan'],
                ['Sheth M.N. Law College Patan', 'Law & Legal Studies', 7, 'College', 'HNGU Affiliated Legal Studies Seat', 'College Road, Patan']
            ]
        ],
        'Porbandar' => [
            'cities' => ['Porbandar', 'Ranavav', 'Kutiyana'],
            'pincode' => '360575',
            'school_names' => [
                'Birla Sagar Higher Secondary School', 'Kendriya Vidyalaya (Air Force Station Porbandar)', 'St. Joseph\'s Convent School',
                'Navy Children School (INS Sardar Patel)', 'Bhavan\'s Shri A.K. Doshi School', 'Maharani Baluba Kanya Vidyalaya',
                'Victoria Jubilee Madressa High School', 'Shree Swaminarayan Gurukul High School', 'Ranavav English Public School', 'Kutiyana Model High School'
            ],
            'colleges' => [
                ['Dr. V.R. Godhaniya College of Engineering & Tech', 'Engineering & IT', 1, 'College', 'AICTE Approved Degree College', 'Bhartiya Vidya Bhavan Campus, Porbandar'],
                ['Arya Kanya Gurukul & Mahila Arts & Commerce College', 'Women Higher Education', 3, 'College', 'Pioneering Heritage Women\'s College', 'Khapat, Porbandar'],
                ['Government Polytechnic Porbandar', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Technical Diploma Campus', 'NH-8B, Porbandar'],
                ['Maharshi Dayanand Science College', 'Sciences & Chemistry', 5, 'College', 'Bhakta Kavi Narsinh Mehta University', 'Khapat, Porbandar'],
                ['Shri K.H. Madhvani College of Commerce', 'Commerce & Finance', 3, 'College', 'Premier Commerce College', 'Sudama Chowk, Porbandar'],
                ['V.R. Godhaniya Institute of Computer Science (MCA & BCA)', 'Computer Science & IT', 4, 'College', 'Advanced Computing Education Center', 'MG Road, Porbandar'],
                ['Porbandar Medical Teaching Hospital & Nursing', 'Healthcare & Nursing', 2, 'College', 'Civil Hospital Affiliated Training', 'Chhaya, Porbandar'],
                ['Swaminarayan B.Ed & Education College', 'Education & Teaching', 6, 'College', 'NCTE Approved Education College', 'Bhavnath Road, Porbandar'],
                ['Shri R.P. Bhalodia College of Management', 'Management & BBA', 3, 'College', 'B-School Degree Campus', 'Khapat, Porbandar'],
                ['Porbandar Law College', 'Law & Legal Studies', 7, 'College', 'Bar Council of India Approved', 'Court Road, Porbandar']
            ]
        ],
        'Sabarkantha' => [
            'cities' => ['Himmatnagar', 'Idar', 'Prantij', 'Talod'],
            'pincode' => '383001',
            'school_names' => [
                'Himmat High School (Himmatnagar)', 'Kendriya Vidyalaya (Himmatnagar)', 'St. Xavier\'s High School (Himatnagar)',
                'Jawahar Navodaya Vidyalaya (Ramsan)', 'Sir Pratap High School (Idar Heritage)', 'Shree Swaminarayan Vidyalaya',
                'Modi Public School', 'Prantij English Medium High School', 'Talod Model School', 'Saraswati Vidya Mandir (Khedbrahma)'
            ],
            'colleges' => [
                ['GMERS Medical College Himmatnagar', 'Medical & Healthcare', 2, 'College', 'Government Teaching Hospital & Medical College', 'Motipura, Himmatnagar, Sabarkantha'],
                ['Grow More Foundation Engineering College', 'Engineering & Tech', 1, 'College', 'AICTE Approved Technology Hub', 'Ahmedabad-Udaipur Highway, Himmatnagar'],
                ['Sir P.T. Science College Himmatnagar', 'Sciences', 5, 'College', 'HNGU Affiliated Premier Science College', 'Idar Road, Himmatnagar, Sabarkantha'],
                ['Government Polytechnic Himmatnagar', 'Polytechnic Engineering', 1, 'College', 'Technical Diploma College', 'Motipura, Himmatnagar, Sabarkantha'],
                ['Himmat Arts & Commerce College', 'Commerce & Arts', 3, 'College', 'Established Degree Institution', 'Post Office Road, Himmatnagar, Sabarkantha'],
                ['Sabar Institute of Technology for Girls', 'Engineering & Women Empowerment', 1, 'College', 'Premier Women Technical Campus', 'Tajpur, Himmatnagar, Sabarkantha'],
                ['Idar Anjana Patidar H.K.M. Arts & P.N. Patel Commerce College', 'Commerce & Arts', 3, 'College', 'Historic College Campus', 'Jawanpura, Idar, Sabarkantha'],
                ['Grow More Institute of Nursing', 'Nursing & Health', 2, 'College', 'Nursing Council Approved Campus', 'Highway Road, Himmatnagar, Sabarkantha'],
                ['Shri S.S. Patel Pharmacy College', 'Pharmacy', 1, 'College', 'PCI Approved Modern Pharmacy', 'Motipura, Himmatnagar, Sabarkantha'],
                ['Sheth H.P. Law College Himmatnagar', 'Law & Legal Studies', 7, 'College', 'HNGU Affiliated Legal Studies Seat', 'Near Civil Court, Himmatnagar, Sabarkantha']
            ]
        ],
        'Surendranagar' => [
            'cities' => ['Surendranagar', 'Wadhwan', 'Dhrangadhra', 'Limbdi'],
            'pincode' => '363001',
            'school_names' => [
                'C.U. Shah English Medium School (Wadhwan)', 'Kendriya Vidyalaya (Dhrangadhra Military Station)', 'St. Mary\'s High School',
                'Shree Swaminarayan Gurukul (Surendranagar)', 'Sheth N.T.M. High School', 'Limbdi English Medium High School',
                'Adarsh Model School', 'Sanskar English Academy', 'Dhrangadhra People\'s High School', 'Vidyasagar High School (Chotila)'
            ],
            'colleges' => [
                ['C.U. Shah University (Faculty of Technology & Engg)', 'Engineering & Tech', 1, 'University', 'UGC Recognized Private University', 'Wadhwan City, Surendranagar'],
                ['C.U. Shah Medical College & Hospital', 'Medical & Healthcare', 2, 'College', 'MCI Approved Teaching Hospital', 'Dudhrej Road, Surendranagar'],
                ['M.P. Shah Commerce & Arts College', 'Commerce & Arts', 3, 'College', 'Saurashtra University Affiliated', 'Bus Station Road, Surendranagar'],
                ['Government Polytechnic Surendranagar', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Diploma Campus', 'GIDC, Wadhwan, Surendranagar'],
                ['C.U. Shah Pharmacy College', 'Pharmacy', 1, 'College', 'PCI Approved Leading Pharmacy Institute', 'Wadhwan City, Surendranagar'],
                ['Shri Sahu Chhatrapati Mills Science College', 'Sciences & Maths', 5, 'College', 'Government Aided Science College', 'Wadhwan, Surendranagar'],
                ['Dhrangadhra People\'s Arts & Commerce College', 'Commerce & Arts', 3, 'College', 'Established Degree Institution', 'Military Road, Dhrangadhra, Surendranagar'],
                ['Limbdi Institute of Engineering & Technology', 'Engineering & IT', 1, 'College', 'Technical Degree Center', 'Limbdi Highway, Surendranagar'],
                ['C.U. Shah Physiotherapy & Nursing College', 'Healthcare & Physiotherapy', 2, 'College', 'Modern Medical Allied Campus', 'Dudhrej Road, Surendranagar'],
                ['Sheth J.P. Law College Surendranagar', 'Law & Legal Studies', 7, 'College', 'Professional Legal Education Center', 'Tower Road, Surendranagar']
            ]
        ],
        'Valsad' => [
            'cities' => ['Valsad', 'Vapi', 'Pardi', 'Umbergaon'],
            'pincode' => '396001',
            'school_names' => [
                'St. Joseph\'s High School (Valsad)', 'Atul Vidyalaya (Atul Chemical Complex)', 'Delhi Public School (Vapi)',
                'Kendriya Vidyalaya (Valsad Railway Colony)', 'St. Xavier\'s School (Vapi)', 'Saraswati International School (Valsad)',
                'BKM High School', 'Laxmi International School (Sarigam)', 'Pardi English Medium High School', 'Umbergaon Public High School'
            ],
            'colleges' => [
                ['Government Engineering College Valsad (GEC Valsad)', 'Engineering & Tech', 1, 'College', 'AICTE Approved Government Institute', 'Tithal Road, Valsad'],
                ['GMERS Medical College Valsad', 'Medical & Healthcare', 2, 'College', 'Modern Medical College & Civil Hospital', 'Halar Road, Valsad'],
                ['Laxmi Institute of Technology (Sarigam Vapi)', 'Engineering & Architecture', 1, 'College', 'AICTE Approved High-Tech Campus', 'Sarigam, Valsad'],
                ['Government Polytechnic Valsad', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Technical Diploma', 'Kosamba Road, Valsad'],
                ['R.O. Patel Women\'s College of Commerce', 'Management & Commerce', 3, 'College', 'VNSGU Affiliated Campus', 'Kapadia Chal, Valsad'],
                ['BKM Science College Valsad', 'Sciences', 5, 'College', 'Established Science Research College', 'Tithal Road, Valsad'],
                ['Shah N.H. Commerce College', 'Commerce & Accountancy', 3, 'College', 'VNSGU Affiliated Leading Campus', 'Tithal Road, Valsad'],
                ['R.K. Desai Institute of Science & Computer Science (Vapi)', 'Computer Science & IT', 4, 'College', 'BCA & IT Degree College', 'GIDC, Vapi, Valsad'],
                ['Smt. C.D. Jobalia College of Nursing', 'Nursing & Health', 2, 'College', 'Professional Nursing Training College', 'Civil Hospital Campus, Valsad'],
                ['Shah K.M. Law College Valsad', 'Law & Legal Studies', 7, 'College', 'Bar Council of India Approved', 'Tithal Road, Valsad']
            ]
        ],
        'Aravalli' => [
            'cities' => ['Modasa', 'Bayad', 'Malpur', 'Bhiloda'],
            'pincode' => '383315',
            'school_names' => [
                'M.L. Gandhi Higher Secondary School (Modasa)', 'Kendriya Vidyalaya (Modasa)', 'St. John\'s High School',
                'Jawahar Navodaya Vidyalaya (Aravalli)', 'Model School (Bayad)', 'Shree Swaminarayan High School (Modasa)',
                'Sarvajanik Vidya Mandir (Bhiloda)', 'Malpur English Medium School', 'Shree K.M. Patel Vidyalaya', 'Shree Ambaji English School'
            ],
            'colleges' => [
                ['Government Engineering College Modasa (GEC Modasa)', 'Engineering & Tech', 1, 'College', 'Pioneering AICTE Govt College Est. 1984', 'Shamlaji Road, Modasa, Aravalli'],
                ['Sir P.T. Science College Modasa', 'Sciences', 5, 'College', 'Renowned Pure Sciences Research Institute', 'Dhansura Road, Modasa, Aravalli'],
                ['Shri B.D. Shah College of Education & Arts', 'Education & Humanities', 6, 'College', 'HNGU Affiliated Premier College', 'College Campus, Modasa, Aravalli'],
                ['Government Polytechnic Modasa', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Diploma Institute', 'Shamlaji Highway, Modasa, Aravalli'],
                ['Shri H.S. Shah College of Commerce Modasa', 'Commerce & Finance', 3, 'College', 'Pioneer Commerce Degree College', 'College Campus, Modasa, Aravalli'],
                ['Smt. S.B. Patel BBA & BCA College', 'Management & IT', 4, 'College', 'Professional Degree Programs', 'Malpur Road, Modasa, Aravalli'],
                ['Aravalli Institute of Nursing (Bhiloda)', 'Nursing & Health', 2, 'College', 'Approved Healthcare Training Center', 'Bhiloda, Aravalli'],
                ['Bayad Arts & Commerce College', 'Commerce & Arts', 3, 'College', 'Affiliated Degree Institution', 'Highway Road, Bayad, Aravalli'],
                ['Shamlaji Ayurvedic Medical College & Hospital', 'Ayurveda & Alternative Medicine', 2, 'College', 'CCIM Approved Ayurvedic Campus', 'Shamlaji, Aravalli'],
                ['Modasa Law College', 'Law & Legal Studies', 7, 'College', 'HNGU Affiliated Legal Studies Seat', 'Court Road, Modasa, Aravalli']
            ]
        ],
        'Botad' => [
            'cities' => ['Botad', 'Gadhada', 'Barwala', 'Ranpur'],
            'pincode' => '364710',
            'school_names' => [
                'Shree Swaminarayan Gurukul High School (Gadhada Heritage)', 'Sheth N.L. High School (Botad)', 'Kendriya Vidyalaya (Botad)',
                'Shree Krishna High School', 'G.B. Patel English Medium School', 'Barwala Model High School',
                'Shree Vallabh Vidya Mandir', 'Sarvodaya English School (Ranpur)', 'Adarsh Kanya High School', 'Sunrise English School (Botad)'
            ],
            'colleges' => [
                ['Kavi Shri Botadkar Arts & Commerce College', 'Commerce & Arts', 3, 'College', 'MKBU Affiliated Pioneer Institution', 'Paliyad Road, Botad'],
                ['Shree Swaminarayan College of Computer Science & IT', 'Computer Applications', 4, 'College', 'AICTE & University Approved', 'Gadhada Road, Botad'],
                ['Government Polytechnic Botad', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Diploma Technical Institute', 'Bhavnagar Highway, Botad'],
                ['Shree Botad Education Society Science College', 'Sciences & Mathematics', 5, 'College', 'MKBU Affiliated Science College', 'Station Road, Botad'],
                ['Gadhada Arts & Commerce College', 'Commerce & Arts', 3, 'College', 'Saurashtra University Affiliated', 'Gadhada Swaminarayan Mandir Road, Botad'],
                ['Smt. S.P. Patel B.Ed College Botad', 'Education & Teaching', 6, 'College', 'NCTE Approved Education Center', 'Paliyad Road, Botad'],
                ['Shree Swaminarayan Nursing Institute (Gadhada)', 'Nursing & Healthcare', 2, 'College', 'State Nursing Council Approved', 'Gadhada, Botad'],
                ['Botad Institute of Paramedical Sciences', 'Paramedical & Health', 2, 'College', 'Allied Healthcare Training Center', 'Hospital Road, Botad'],
                ['Barwala Arts & Commerce Degree College', 'Commerce & Humanities', 3, 'College', 'Higher Education Degree Center', 'Barwala, Botad'],
                ['Botad Law Academy', 'Law & Legal Studies', 7, 'College', 'Professional Legal Education Center', 'Court Road, Botad']
            ]
        ],
        'Chhota Udaipur' => [
            'cities' => ['Chhota Udaipur', 'Bodeli', 'Sankheda', 'Kawant'],
            'pincode' => '391165',
            'school_names' => [
                'Eklavya Model Residential School (Kawant)', 'Kendriya Vidyalaya (Chhota Udaipur)', 'Sheth S.F. High School',
                'Bodeli Public English School', 'Jawahar Navodaya Vidyalaya (Chhota Udaipur)', 'Shree Swaminarayan Vidyalaya',
                'Sankheda Model High School', 'Don Bosco High School (Kawant)', 'Nasvadi Tribal Higher Secondary School', 'Saraswati Vidya Mandir'
            ],
            'colleges' => [
                ['Government Arts & Science College Chhota Udaipur', 'Sciences & Arts', 5, 'College', 'State Government Higher Education College', 'Station Road, Chhota Udaipur'],
                ['Sheth T.C. Kapadia Arts & Commerce College (Bodeli)', 'Commerce & Management', 3, 'College', 'Govt Aided Established Degree Campus', 'Bodeli, Chhota Udaipur'],
                ['Government Polytechnic Chhota Udaipur', 'Engineering Diploma', 1, 'College', 'AICTE Approved Polytechnic Campus', 'Kawant Road, Chhota Udaipur'],
                ['Sankheda Arts & Commerce College', 'Arts & Commerce', 3, 'College', 'Affiliated Degree Institution', 'Sankheda, Chhota Udaipur'],
                ['Chhota Udaipur Tribal Nursing Institute', 'Nursing & Health', 2, 'College', 'Tribal Healthcare Training Center', 'Civil Hospital Campus, Chhota Udaipur'],
                ['Bodeli Institute of Computer Applications & IT', 'Computer Science & BCA', 4, 'College', 'Information Technology College', 'Alipura Road, Bodeli, Chhota Udaipur'],
                ['Kawant Government Degree College', 'Humanities & Commerce', 3, 'College', 'State Government College', 'Kawant, Chhota Udaipur'],
                ['Eklavya Polytechnic Institute (Nasvadi)', 'Polytechnic Engineering', 1, 'College', 'Tribal Technical Education Center', 'Nasvadi, Chhota Udaipur'],
                ['Shri S.K. Patel Education College (Bodeli)', 'Teacher Education & B.Ed', 6, 'College', 'NCTE Approved Education Center', 'Bodeli, Chhota Udaipur'],
                ['Chhota Udaipur Law & Social Studies College', 'Law & Legal Studies', 7, 'College', 'Bar Council Approved Legal Seat', 'Court Road, Chhota Udaipur']
            ]
        ],
        'Devbhumi Dwarka' => [
            'cities' => ['Khambhalia', 'Dwarka', 'Okha', 'Kalyanpur'],
            'pincode' => '361305',
            'school_names' => [
                'Bhavan\'s Shri A.K. Doshi School (Dwarka)', 'Kendriya Vidyalaya (Okha Port Navy Base)', 'St. Mary\'s English School (Khambhalia)',
                'Shree Shardapeeth Arts & Sanskrit Pathshala (Dwarka Heritage)', 'Reliance Public School (Kalyanpur)', 'Tata Chemicals DAV Public School (Mithapur)',
                'Khambhalia High School', 'Jawahar Navodaya Vidyalaya (Kalyanpur)', 'Okha Port High School', 'Dwarkadhish English Medium School'
            ],
            'colleges' => [
                ['Government Arts & Commerce College Khambhalia', 'Commerce & Arts', 3, 'College', 'Saurashtra University Affiliated', 'Ramnagar, Khambhalia, Devbhumi Dwarka'],
                ['Shri Shardapeeth College of Arts & Commerce (Dwarka)', 'Arts & Philosophy', 6, 'College', 'Historic Holy Seat Higher Education College', 'Near Dwarkadhish Temple, Dwarka'],
                ['Government Polytechnic Dwarka', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Diploma Institute', 'Mithapur Road, Okha, Devbhumi Dwarka'],
                ['Tata Chemicals Technology Institute (Mithapur)', 'Technical & Chemical Engineering', 1, 'College', 'Chemical & Industrial Technology Center', 'Mithapur, Devbhumi Dwarka'],
                ['Kalyanpur Government Arts College', 'Humanities & Social Sciences', 6, 'College', 'State Government Degree College', 'Kalyanpur, Devbhumi Dwarka'],
                ['Okha Port Marine & Commerce College', 'Marine Studies & Commerce', 3, 'College', 'Coastal Trade & Commerce Education', 'Port Road, Okha, Devbhumi Dwarka'],
                ['Dwarka Institute of Nursing & Paramedical', 'Nursing & Health', 2, 'College', 'Healthcare Teaching Center', 'Hospital Road, Dwarka'],
                ['Shree Dwarkadhish Sanskrit Mahavidyalaya', 'Classical Languages & Indology', 6, 'College', 'Traditional Sanskrit University Center', 'Temple Campus, Dwarka'],
                ['Khambhalia Institute of Computer Science & BBA', 'Management & IT', 4, 'College', 'BCA & BBA Degree Campus', 'Station Road, Khambhalia, Devbhumi Dwarka'],
                ['Devbhumi Law College Khambhalia', 'Law & Legal Studies', 7, 'College', 'Professional Legal Education Center', 'Court Campus, Khambhalia, Devbhumi Dwarka']
            ]
        ],
        'Gir Somnath' => [
            'cities' => ['Veraval', 'Somnath', 'Kodinar', 'Una', 'Talala'],
            'pincode' => '362265',
            'school_names' => [
                'Ambuja Vidya Niketan (Kodinar)', 'Kendriya Vidyalaya (Veraval)', 'Somnath English Medium School (Prabhas Patan)',
                'Aditya Birla Higher Secondary School (Veraval)', 'St. Mary\'s School (Veraval)', 'Shree Swaminarayan Gurukul (Una)',
                'Gir National High School (Talala)', 'Jawahar Navodaya Vidyalaya (Gir Somnath)', 'P.K. Chaudhari High School (Kodinar)', 'Saraswati Vidya Mandir (Veraval)'
            ],
            'colleges' => [
                ['College of Fisheries Science (JAU Veraval)', 'Fisheries & Marine Tech', 5, 'College', 'Pioneering Marine Sciences State College', 'Rajendra Bhuvan Road, Veraval, Gir Somnath'],
                ['Government Arts & Commerce College Kodinar', 'Commerce & Arts', 3, 'College', 'Govt Aided Degree Institution', 'Ambuja Road, Kodinar, Gir Somnath'],
                ['Shri Somnath Sanskrit University', 'Indology, Sanskrit & Arts', 6, 'University', 'Apex State University for Classical Sciences', 'Rajendra Bhuvan Road, Veraval, Gir Somnath'],
                ['Somnath Government Polytechnic (Veraval)', 'Polytechnic Engineering', 1, 'College', 'Technical Diploma College', 'Bypass Road, Veraval, Gir Somnath'],
                ['Somnath College of Science & IT (Veraval)', 'Sciences & BCA', 5, 'College', 'Saurashtra University Affiliated', 'Prabhas Patan Road, Veraval, Gir Somnath'],
                ['Una Arts & Commerce College', 'Commerce & Humanities', 3, 'College', 'Established Degree Institution', 'Delwada Road, Una, Gir Somnath'],
                ['Ambuja Foundation Institute of Technical Training (Kodinar)', 'Industrial & Technical Skills', 1, 'College', 'Vocational & Polytechnic Campus', 'Ambuja Nagar, Kodinar, Gir Somnath'],
                ['Gir Somnath Institute of Nursing Sciences', 'Nursing & Health', 2, 'College', 'Approved Nursing Training College', 'Civil Hospital Road, Veraval, Gir Somnath'],
                ['Talala Government Degree College', 'Arts & Social Sciences', 6, 'College', 'State Degree College', 'Talala Gir, Gir Somnath'],
                ['Veraval Law College', 'Law & Legal Studies', 7, 'College', 'Professional Legal Education Center', 'Court Road, Veraval, Gir Somnath']
            ]
        ],
        'Mahisagar' => [
            'cities' => ['Lunawada', 'Santrampur', 'Balasinor', 'Virpur'],
            'pincode' => '389230',
            'school_names' => [
                'Sheth S.C. High School (Lunawada)', 'Kendriya Vidyalaya (Lunawada)', 'Jawahar Navodaya Vidyalaya (Mahisagar)',
                'Eklavya Model Residential School (Santrampur)', 'Balasinor Public English School', 'Shree Swaminarayan High School',
                'Pratap High School (Santrampur Heritage)', 'Virpur Model School', 'Mahisagar International School', 'Saraswati Vidya Mandir (Kadana)'
            ],
            'colleges' => [
                ['Government Engineering College Lunawada', 'Engineering & Tech', 1, 'College', 'AICTE Approved Government Institute', 'Godhra Highway, Lunawada, Mahisagar'],
                ['Smt. S.B. Patel Arts & Commerce College (Balasinor)', 'Commerce & Arts', 3, 'College', 'SGGU Affiliated Campus', 'Sevaliya Road, Balasinor, Mahisagar'],
                ['Government Arts College Santrampur', 'Humanities & Sciences', 5, 'College', 'Government Degree Institution', 'Pratap Nagar, Santrampur, Mahisagar'],
                ['Government Polytechnic Lunawada', 'Polytechnic Engineering', 1, 'College', 'State Technical Diploma Campus', 'Modasa Road, Lunawada, Mahisagar'],
                ['Lunawada Science College', 'Sciences & Chemistry', 5, 'College', 'SGGU Affiliated Science College', 'College Road, Lunawada, Mahisagar'],
                ['Balasinor Institute of Nursing Sciences', 'Nursing & Health', 2, 'College', 'Approved Professional Nursing College', 'Hospital Campus, Balasinor, Mahisagar'],
                ['Virpur Government Commerce College', 'Commerce & Management', 3, 'College', 'State Commerce College', 'Virpur, Mahisagar'],
                ['Mahisagar Institute of Computer Science (BCA)', 'Computer Applications & IT', 4, 'College', 'Information Technology College', 'Santrampur Road, Lunawada, Mahisagar'],
                ['Santrampur Tribal Vocational & Polytechnic Campus', 'Vocational & Technical', 1, 'College', 'Skill Development Center', 'Santrampur, Mahisagar'],
                ['Mahisagar Law College Lunawada', 'Law & Legal Studies', 7, 'College', 'Professional Legal Studies Center', 'Court Road, Lunawada, Mahisagar']
            ]
        ],
        'Morbi' => [
            'cities' => ['Morbi', 'Wankaner', 'Halvad', 'Tankara'],
            'pincode' => '363641',
            'school_names' => [
                'The V.C. Tech High School (Morbi Heritage)', 'Kendriya Vidyalaya (Morbi)', 'Om V.V.I.M. English Medium School',
                'Nazarbaug High School', 'Shree Swaminarayan Gurukul (Morbi)', 'Amar High School (Wankaner)',
                'Model High School (Halvad)', 'Arya Samaj Dayanand Vidyalaya (Tankara Heritage)', 'Sardar Patel Public School', 'Bright International School (Morbi)'
            ],
            'colleges' => [
                ['Lukhdhirji Engineering College (LE College Morbi)', 'Engineering & Ceramic Tech', 1, 'College', 'Gujarat\'s Historic Premier Ceramic & Engg Institute Est. 1951', 'Nazarbaug, Morbi'],
                ['Lukhdhirji Polytechnic Institute Morbi', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Historic Technical College', 'Nazarbaug Campus, Morbi'],
                ['Smt. G.J. Sheth Commerce College', 'Commerce & Management', 3, 'College', 'Saurashtra University Affiliated', 'Old Ghuntu Road, Morbi'],
                ['M.M. Science College Morbi', 'Sciences & Industrial Chemistry', 5, 'College', 'Pioneer Ceramic & Science Campus', 'Sanala Road, Morbi'],
                ['Smt. J.A. Patel Mahila College (Morbi)', 'Women Commerce & Arts', 3, 'College', 'Empowering Women Higher Education', 'Sanala Road, Morbi'],
                ['Government Medical Teaching Hospital Morbi', 'Medical & Paramedical', 2, 'College', 'Civil Hospital Teaching Center', 'Hospital Road, Morbi'],
                ['Wankaner Arts & Commerce College', 'Commerce & Arts', 3, 'College', 'Affiliated Degree Institution', 'National Highway, Wankaner, Morbi'],
                ['Halvad Government Degree College', 'Humanities & Commerce', 3, 'College', 'State Degree College', 'Halvad, Morbi'],
                ['Om College of Nursing & Paramedical (Morbi)', 'Nursing & Health', 2, 'College', 'Recognized Healthcare Institute', 'Sanala Bypass, Morbi'],
                ['Smt. B.S. Patel Law College Morbi', 'Law & Legal Studies', 7, 'College', 'Saurashtra University Affiliated Law Seat', 'Court Road, Morbi']
            ]
        ],
        'Narmada' => [
            'cities' => ['Rajpipla', 'Dediapada', 'Tilakwada', 'Kevadia'],
            'pincode' => '393145',
            'school_names' => [
                'Shree Chhatrapati High School (Rajpipla Heritage)', 'Kendriya Vidyalaya (Statue of Unity Kevadia)', 'Eklavya Model School (Dediapada)',
                'Jawahar Navodaya Vidyalaya (Narmada)', 'Sardar Patel High School (Garudeshwar)', 'St. Xavier\'s High School (Rajpipla)',
                'Tilakwada Model School', 'Tribal Development English School', 'Shree Swaminarayan High School (Rajpipla)', 'Saraswati Vidya Mandir (Kevadia)'
            ],
            'colleges' => [
                ['Birsa Munda Tribal University (BMTU Tech Campus)', 'Multidisciplinary Tribal Univ', 1, 'University', 'Apex State University for Tribal Upliftment & Tech', 'Vavdi Road, Rajpipla, Narmada'],
                ['Shri M.R. Arts & Science College Rajpipla', 'Sciences & Arts', 5, 'College', 'Heritage Higher Education Campus Est. 1962', 'Station Road, Rajpipla, Narmada'],
                ['Government Polytechnic Narmada', 'Polytechnic Engineering', 1, 'College', 'AICTE Approved Technical Diploma Campus', 'Dediapada Highway, Rajpipla, Narmada'],
                ['Smt. M.J. Commerce College Rajpipla', 'Commerce & Banking', 3, 'College', 'VNSGU Affiliated Commerce College', 'Rajpipla, Narmada'],
                ['Narmada Institute of Nursing Sciences', 'Nursing & Health', 2, 'College', 'Nursing Council Approved Campus', 'Civil Hospital Road, Rajpipla, Narmada'],
                ['Kevadia Tourism & Hospitality Management Institute', 'Hospitality & Tourism Mgmt', 3, 'College', 'Statue of Unity Hospitality Center', 'Ekta Nagar, Kevadia, Narmada'],
                ['Dediapada Government Degree College', 'Arts & Social Studies', 6, 'College', 'State Degree Campus', 'Dediapada, Narmada'],
                ['Tilakwada Government Arts College', 'Humanities & Commerce', 3, 'College', 'Affiliated Degree College', 'Tilakwada, Narmada'],
                ['Rajpipla Ayurvedic Medical College', 'Ayurveda & Alternative Healthcare', 2, 'College', 'Approved Ayurvedic Teaching Center', 'Vavdi Road, Rajpipla, Narmada'],
                ['Narmada Law College Rajpipla', 'Law & Legal Studies', 7, 'College', 'Professional Legal Education Center', 'Court Road, Rajpipla, Narmada']
            ]
        ],
        'Tapi' => [
            'cities' => ['Vyara', 'Songadh', 'Valod', 'Uchchhal'],
            'pincode' => '394650',
            'school_names' => [
                'Shree J.B. & H.S. High School (Vyara)', 'Kendriya Vidyalaya (Vyara)', 'Eklavya Model Residential School (Songadh)',
                'Jawahar Navodaya Vidyalaya (Tapi)', 'Fort Songadh English Medium School', 'Vedchhi Gram Vidyalaya (Valod Gandhi Heritage)',
                'St. Joseph\'s Convent School (Vyara)', 'Model School (Uchchhal)', 'Ukai Thermal Power Station High School', 'Tapi Valley English School'
            ],
            'colleges' => [
                ['Government Arts, Science & Commerce College Vyara', 'Multidisciplinary', 5, 'College', 'State Government College, VNSGU Affiliated', 'Maliwad, Vyara, Tapi'],
                ['C.P. Patel College of Management & Technology', 'Management & IT', 3, 'College', 'AICTE Approved Technical Campus', 'Station Road, Vyara, Tapi'],
                ['Government Polytechnic Tapi', 'Engineering Diploma', 1, 'College', 'AICTE Approved Technical Campus', 'Songadh Highway, Vyara, Tapi'],
                ['Songadh Government Arts & Commerce College', 'Commerce & Arts', 3, 'College', 'VNSGU Affiliated Degree College', 'Fort Road, Songadh, Tapi'],
                ['Ukai Technical & Polytechnic Institute', 'Power Plant & Electrical Tech', 1, 'College', 'Thermal Power Station Tech Campus', 'Ukai Dam, Tapi'],
                ['Valod Gandhi Rural Studies & Arts College', 'Rural Development & Arts', 6, 'College', 'Gandhian Gram Seva Institute', 'Vedchhi, Valod, Tapi'],
                ['Tapi Institute of Nursing Sciences', 'Nursing & Health', 2, 'College', 'Healthcare Teaching Center', 'General Hospital Campus, Vyara, Tapi'],
                ['Uchchhal Tribal Degree College', 'Tribal Studies & Humanities', 6, 'College', 'Government Degree Institution', 'Uchchhal, Tapi'],
                ['Vyara College of Education (B.Ed)', 'Teacher Education', 6, 'College', 'NCTE Approved Education Center', 'Station Road, Vyara, Tapi'],
                ['Tapi Law College Vyara', 'Law & Legal Studies', 7, 'College', 'Professional Legal Studies Seat', 'Court Road, Vyara, Tapi']
            ]
        ],
        'Dang' => [
            'cities' => ['Ahwa', 'Waghai', 'Subir', 'Saputara'],
            'pincode' => '394710',
            'school_names' => [
                'Government Higher Secondary School (Ahwa Headquarters)', 'Jawahar Navodaya Vidyalaya (Saputara Hill Station)', 'Kendriya Vidyalaya (Ahwa Dangs)',
                'Eklavya Model Residential School (Ahwa)', 'Waghai Botanical High School', 'Shree Swaminarayan Gurukul (Saputara)',
                'Subir Model Higher Secondary School', 'Mission English School (Ahwa)', 'Dangs Tribal Residential Vidyalaya (Waghai)', 'Hill Range Public School (Saputara)'
            ],
            'colleges' => [
                ['Government Arts & Commerce College Ahwa', 'Arts, Commerce & Social Studies', 3, 'College', 'Premier Higher Education Institute in Dangs', 'Civil Hospital Road, Ahwa, Dang'],
                ['College of Agriculture Waghai (NAU)', 'Forestry, Agriculture & Ecology', 5, 'College', 'Navsari Agricultural University Research Campus', 'Botanical Garden Road, Waghai, Dang'],
                ['Government Polytechnic Dang (Saputara Highway)', 'Engineering & Tribal Technology', 1, 'College', 'State Technical Education Diploma Campus', 'Ahwa-Bilimora Road, Ahwa, Dang'],
                ['Dang Tribal Science College Ahwa', 'Sciences & Botany', 5, 'College', 'Forest Ecology & Science Center', 'Main Road, Ahwa, Dang'],
                ['Saputara Institute of Hospitality & Tourism', 'Hospitality & Tourism Mgmt', 3, 'College', 'Hill Station Tourism Education Center', 'Saputara Lake Road, Dang'],
                ['Waghai Botanical Research & Herbal Institute', 'Herbal Sciences & Pharmacy', 1, 'College', 'Medicinal Plants Research Center', 'Botanical Garden, Waghai, Dang'],
                ['Ahwa Government Nursing College', 'Nursing & Health', 2, 'College', 'Civil Hospital Teaching Center', 'Ahwa Headquarters, Dang'],
                ['Subir Tribal Higher Education Campus', 'Humanities & Tribal Culture', 6, 'College', 'State Government College', 'Subir, Dang'],
                ['Dang District Education & Vocational Training Institute', 'Vocational & Teacher Education', 6, 'College', 'Technical & Skill Center', 'Ahwa, Dang'],
                ['Dang Community College of Social Sciences & Law', 'Law & Community Development', 7, 'College', 'Affiliated Higher Education Seat', 'Civil Road, Ahwa, Dang']
            ]
        ]
    ];

    $driverName = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    $ignore = (strtolower($driverName) === 'mysql') ? 'INSERT IGNORE' : 'INSERT OR IGNORE';

    $instStmt = $pdo->prepare("
        {$ignore} INTO institutions (
            name, slug, type, category_id, accreditation, affiliation,
            city, state, address, established_year, ranking_nirf, rating,
            reviews_count, tuition_range, student_count, description,
            banner_image, logo_image, website, email, phone, facilities, is_featured
        ) VALUES (
            :name, :slug, :type, :category_id, :accreditation, :affiliation,
            :city, :state, :address, :established_year, :ranking_nirf, :rating,
            :reviews_count, :tuition_range, :student_count, :description,
            :banner_image, :logo_image, :website, :email, :phone, :facilities, :is_featured
        )
    ");

    $courseStmt = $pdo->prepare("
        {$ignore} INTO courses (
            institution_id, category_id, name, slug, degree_level,
            duration, tuition_fee, eligibility, seats, syllabus_summary,
            career_prospects, avg_package, is_popular
        ) VALUES (
            :institution_id, :category_id, :name, :slug, :degree_level,
            :duration, :tuition_fee, :eligibility, :seats, :syllabus_summary,
            :career_prospects, :avg_package, :is_popular
        )
    ");

    $schoolsCount = 0;
    $collegesCount = 0;

    foreach ($districts as $district => $info) {
        $pincode = $info['pincode'];
        $mainCity = $info['cities'][0];

        // 1. Seed 10 Schools for this district
        foreach ($info['school_names'] as $index => $schoolName) {
            $city = $info['cities'][$index % count($info['cities'])];
            $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', "{$schoolName}-{$city}-{$district}"));
            $rating = round(4.2 + (crc32($schoolName) % 8) / 10, 1);
            $reviews = 35 + (abs(crc32($schoolName)) % 250);
            $estYear = 1965 + (abs(crc32($schoolName)) % 55);
            $fees = '₹' . number_format(25000 + (abs(crc32($schoolName)) % 55000)) . ' - ₹' . number_format(65000 + (abs(crc32($schoolName)) % 45000)) . ' / yr';
            $board = ($index % 3 === 0) ? 'CBSE Board Affiliated' : (($index % 3 === 1) ? 'GSEB English & Gujarati Medium' : 'ICSE / CISCE Board');

            $instStmt->execute([
                ':name' => $schoolName,
                ':slug' => $slug,
                ':type' => 'School',
                ':category_id' => 8, // Secondary Schools
                ':accreditation' => $board,
                ':affiliation' => 'Gujarat State Education Board & Central CBSE Affiliation',
                ':city' => "{$city}, {$district}",
                ':state' => 'Gujarat',
                ':address' => "Station Campus, {$city}, {$district} District, Gujarat {$pincode}",
                ':established_year' => $estYear,
                ':ranking_nirf' => "District Top #{$index} Premier School",
                ':rating' => $rating,
                ':reviews_count' => $reviews,
                ':tuition_range' => $fees,
                ':student_count' => 1200 + (abs(crc32($schoolName)) % 2800),
                ':description' => "{$schoolName} is a top accredited school in {$city}, {$district} District, Gujarat. Offering quality education from Primary to Higher Secondary (10+2 Science, Commerce, and Arts) with high board pass percentages, modern laboratories, and all-round student development.",
                ':banner_image' => 'assets/images/college_banner_default.svg',
                ':logo_image' => 'assets/images/college_logo_default.svg',
                ':website' => 'https://schools.gujarat.gov.in',
                ':email' => 'principal.' . substr(md5($schoolName), 0, 8) . '@gujeducenter.in',
                ':phone' => '+91 70464 83464',
                ':facilities' => 'Smart Classrooms, Physics & Chemistry Labs, Computer Lab, Playground, Sports Complex, Central Library, GPS School Bus Transport',
                ':is_featured' => ($index === 0) ? 1 : 0
            ]);

            $instId = (int)$pdo->lastInsertId();
            if ($instId > 0) {
                // Add default standard school programs (10th Board, 12th Science, 12th Commerce)
                $courseStmt->execute([
                    ':institution_id' => $instId,
                    ':category_id' => 8,
                    ':name' => 'Higher Secondary Certificate (12th Science - PCM / PCB)',
                    ':slug' => "hsc-science-{$instId}",
                    ':degree_level' => 'Higher Secondary (10+2)',
                    ':duration' => '2 Years',
                    ':tuition_fee' => 45000.00,
                    ':eligibility' => 'Passed 10th Standard (SSC) with minimum 60% marks in Mathematics and Science.',
                    ':seats' => 120,
                    ':syllabus_summary' => 'Comprehensive preparation for GSEB/CBSE Board exams, GUJCET, JEE Main, and NEET medical entrance.',
                    ':career_prospects' => 'Direct eligibility for B.Tech Engineering, MBBS, BDS, Pharmacy, Architecture, and Pure Science research.',
                    ':avg_package' => 'Top Engineering & Medical Placements',
                    ':is_popular' => 1
                ]);

                $courseStmt->execute([
                    ':institution_id' => $instId,
                    ':category_id' => 8,
                    ':name' => 'Higher Secondary Certificate (12th Commerce & Accounts)',
                    ':slug' => "hsc-commerce-{$instId}",
                    ':degree_level' => 'Higher Secondary (10+2)',
                    ':duration' => '2 Years',
                    ':tuition_fee' => 38000.00,
                    ':eligibility' => 'Passed 10th Standard (SSC) from recognized education board.',
                    ':seats' => 120,
                    ':syllabus_summary' => 'Accountancy, Business Administration, Economics, Statistics, and Financial Mathematics foundation.',
                    ':career_prospects' => 'Chartered Accountancy (CA), B.Com, BBA, Company Secretary (CS), and Banking careers.',
                    ':avg_package' => 'Commerce & Corporate Finance Track',
                    ':is_popular' => 0
                ]);
            }

            $schoolsCount++;
        }

        // 2. Seed 10 Colleges for this district
        foreach ($info['colleges'] as $col) {
            $colName = $col[0];
            $stream = $col[1];
            $catId = $col[2];
            $colType = $col[3];
            $accred = $col[4];
            $colAddress = $col[5];

            $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', "{$colName}-{$district}"));
            $rating = round(4.3 + (crc32($colName) % 7) / 10, 1);
            $reviews = 120 + (abs(crc32($colName)) % 400);
            $estYear = 1950 + (abs(crc32($colName)) % 65);
            $fees = '₹' . number_format(45000 + (abs(crc32($colName)) % 80000)) . ' - ₹' . number_format(140000 + (abs(crc32($colName)) % 160000)) . ' / yr';

            $instStmt->execute([
                ':name' => $colName,
                ':slug' => $slug,
                ':type' => $colType,
                ':category_id' => $catId,
                ':accreditation' => $accred,
                ':affiliation' => 'UGC Recognized, Gujarat Technological University (GTU) / State University',
                ':city' => "{$mainCity}, {$district}",
                ':state' => 'Gujarat',
                ':address' => "{$colAddress}, {$district} District, Gujarat {$pincode}",
                ':established_year' => $estYear,
                ':ranking_nirf' => "NIRF Ranked Premier {$colType}",
                ':rating' => $rating,
                ':reviews_count' => $reviews,
                ':tuition_range' => $fees,
                ':student_count' => 3500 + (abs(crc32($colName)) % 7500),
                ':description' => "{$colName} is an elite institution located in {$district} District, Gujarat. Offering undergraduate and postgraduate degrees in {$stream} with advanced research centers, experienced faculty, and strong campus placement records.",
                ':banner_image' => 'assets/images/college_banner_default.svg',
                ':logo_image' => 'assets/images/college_logo_default.svg',
                ':website' => 'https://gujaratuniversity.ac.in',
                ':email' => 'admissions.' . substr(md5($colName), 0, 8) . '@gujaratcolleges.edu.in',
                ':phone' => '+91 70464 83464',
                ':facilities' => 'Modern Computing Labs, Hi-Tech Innovation Incubation Center, Digital Library, Hostels, Sports Complex, Wi-Fi 6, Placement Cell',
                ':is_featured' => 1
            ]);

            $colId = (int)$pdo->lastInsertId();
            if ($colId > 0) {
                // Add relevant degree
                $degName = ($catId === 1) ? 'Bachelor of Technology (B.Tech - Computer Engineering)' :
                           (($catId === 2) ? 'Bachelor of Medicine & Bachelor of Surgery (MBBS)' :
                           (($catId === 3) ? 'Bachelor of Business Administration (BBA Honours)' :
                           (($catId === 7) ? 'Integrated BA LLB (Honours)' : 'Bachelor of Science (B.Sc - Information Technology)')));

                $courseStmt->execute([
                    ':institution_id' => $colId,
                    ':category_id' => $catId,
                    ':name' => $degName,
                    ':slug' => strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', "{$degName}-{$colId}")),
                    ':degree_level' => 'Undergraduate',
                    ':duration' => ($catId === 2) ? '5.5 Years' : (($catId === 7) ? '5 Years' : (($catId === 1) ? '4 Years' : '3 Years')),
                    ':tuition_fee' => ($catId === 2) ? 120000.00 : (($catId === 1) ? 95000.00 : 55000.00),
                    ':eligibility' => 'Passed 10+2 Higher Secondary with minimum 55% aggregate and relevant entrance score (GUJCET / JEE / NEET / Merit).',
                    ':seats' => 120,
                    ':syllabus_summary' => 'Industry-aligned contemporary syllabus with hands-on lab training, internships, and capstone engineering projects.',
                    ':career_prospects' => 'Direct campus placements with top multinational corporations, government organizations, and research institutions.',
                    ':avg_package' => ($catId === 1) ? '₹6.5 - ₹18.0 LPA' : (($catId === 2) ? '₹8.0 - ₹24.0 LPA' : '₹4.5 - ₹10.0 LPA'),
                    ':is_popular' => 1
                ]);
            }

            $collegesCount++;
        }
    }

    return [
        'districts' => count($districts),
        'schools' => $schoolsCount,
        'colleges' => $collegesCount,
        'total' => $schoolsCount + $collegesCount
    ];
}
