-- Studwise International — seed data (verbatim content from studwise.in)
-- Import with: mysql -u root studwise_dev < database/seed.sql

SET NAMES utf8mb4;

-- ============ branches ============
INSERT INTO branches (name, is_head_office, address, phone, email, sort_order) VALUES
('Manjeri', 1, 'Rajiv Gandhi Bypass, near Malabar Hospital, Melakkam, Manjeri, Kerala 676121', '+91 91136 50884', 'info@studwise.in', 1),
('Valanchery', 0, 'Konnakkattil Towers, 2nd Floor, Calicut Road, Valanchery, Kerala', '+91 75106 50884', 'istudwise@gmail.com', 2),
('Calicut', 0, NULL, '+91 75919 80298', 'istudwise@gmail.com', 3);

-- ============ services ============
-- Home shows 6 (show_on_home=1); the Services hub page shows all 9.
-- detail_body/detail_image are used by the 9 individual service pages (public/services/*.php),
-- sourced from studwise.in's own per-service pages (e.g. /university-registration/).
INSERT INTO services (slug, title, summary, body, detail_body, detail_image, icon_key, show_on_home, sort_order) VALUES

('career-counselling', 'Career Counseling',
 'With a line of expert counselors, we are always open to helping our students channelize their dreams and passion into finding a successful career path.',
 'With a line of expert counselors, we are always open to helping our students channelize their dreams and passion into finding a successful career path.',
 'Studying abroad is not just about gaining academic knowledge — it''s also about immersing yourself in a new culture. Free study abroad career counselling helps you choose a destination that aligns with your interests and offers a rich cultural experience. Exploring different cultures develops a global mindset and cultural understanding, qualities highly valued by employers in today''s interconnected world.\n\nExperts at Studwise have in-depth knowledge of different study destinations, universities, and courses, offering insights and recommendations tailored to your specific academic and career goals. By leveraging our expertise, you can make informed decisions and avoid common pitfalls throughout your journey.\n\nChoosing the right career is crucial since it shapes one''s entire life — their way of living and the people they reach out to. With 5+ years of experience in counseling, Studwise International is the best study-abroad consultant in Kerala, Malappuram, guiding you toward a brilliant future overseas. Our experienced and professional counselors arm you with the knowledge and abilities you''ll need to make future career and life choices.',
 'hero/hero-main.webp',
 'compass', 0, 1),

('university-registration', 'University Registration',
 'We help you to take the best university in accordance with your academic qualification to secure your career aligned with top universities across the world.',
 'After an expert personal counseling with the students, our application team instigate the process of university registration.',
 'Are you dreaming of studying abroad? Our step-by-step guide to university registration is here to help you navigate the process with ease — from choosing the perfect destination to ensuring a seamless application. We cover researching universities and programs, understanding visa requirements, and financial considerations, so you gain the confidence and knowledge to embark on this life-changing experience.\n\nWe thoroughly review each university''s website and contact their international admissions office for any clarifications you may need. By understanding and fulfilling these requirements, we ensure a smooth and successful registration process — helping you secure a place at the best university in accordance with your academic qualification.\n\nWe can smoothly assist your admission to 150+ universities and colleges across the world, based on your ability and preferences, thanks to our excellent relationships with reputable overseas program providers, associates, and support officers. With a high success rate and error-free applications, Studwise guarantees a trouble-free admission procedure and consistently follows up with institutions to ensure quick admissions.',
 'hero/educational-consultants-malappuram.webp',
 'university', 1, 2),

('visa-processing', 'Visa Processing',
 'Around 1000+ students received our help with effortlessly obtaining their visas. To avert any delays in the verification procedure, we closely examine your documents.',
 'For our reputation as the best study abroad education consultants, our visa application team takes care of a large fraction of paperwork, and marks a 100% visa guarantee.',
 'The study abroad visa application process may seem overwhelming at first, but with the right guidance and preparation it can be a smooth and successful journey. A student visa is comparatively difficult because it involves a lot of paperwork — with our guidance, you can navigate the process with ease and confidence.\n\nFrom gathering the right paperwork to understanding the specific requirements of your destination country, we help turn your study abroad dreams into reality. Understanding the visa requirements, gathering the necessary documents, and avoiding common mistakes are key steps to a successful application.\n\nStudwise International provides certified visa guidance and has helped over 1000+ students obtain their student visas — from assisting with the application to setting up financial records and adhering to the international laws of the selected countries. For effective preparation, our education consultants also provide visa interview preparation and mock exams, and closely examine your documents to avert any delays in the verification procedure.',
 'hero/study-abroad-consultants.webp',
 'passport', 1, 3),

('ielts-toefl-ept', 'IELTS/TOEFL/EPT Preparation',
 'We conducts comprehensive IELTS/TOEFL/EPT classes that will boost your results on these important language tests. Our services aim at molding the student into a master.',
 'For admissions to top universities and courses, our team assist you in the preparation for the tests like IELTS, TOEFL, and EPT.',
 'Language proficiency tests like IELTS, TOEFL, and EPT play a crucial role in assessing your ability to communicate effectively in English. These tests are not only a requirement for admission to international universities but are also often required by employers to ensure candidates possess the necessary language skills for the job.\n\nIELTS is widely accepted in the United Kingdom, Australia, Canada, and New Zealand, while TOEFL is more commonly required by universities in the United States. EPT is specifically designed for individuals looking to study or work in English-speaking countries in Europe.\n\nStudwise conducts comprehensive IELTS/TOEFL/EPT test preparation classes that will boost your results on these important tests. Every session is customized to match the needs of the student, using the latest study materials so you''re equipped to face exams confidently — molding you into a master problem solver ready for admissions to top universities and courses.',
 'office/study-abroad-students.webp',
 'book-open', 1, 4),

('pre-landing-services', 'Pre-Landing Services',
 'Specialized services offered by us can smoothen the immigration process as simply and direct as possible and has promisingly supported many students to zone out in another country.',
 'Our pre-landing services broadly cover an insight and briefing regarding the country you are moving to and the setting up of necessary documents and paperwork.',
 'Pre-landing immigration services play a vital role in enhancing the study abroad experience by providing students with the necessary support to navigate the challenges they may face before even setting foot in their dream destination. By assisting with visa applications, our pre-landing services ensure students can start their journey without unnecessary delays or complications.\n\nStudwise assists with flight reservations well in advance to secure the greatest departure dates, routes, and rates, and can arrange regional trips, airport pickups, and other services — mentoring students professionally regarding their intended course of study, and helping them produce documents in the international standard format requested.\n\nOur pre-landing services also provide academic advising to help select courses that align with your interests and goals, along with essential information about the education system in your host country. We foster cultural integration through orientation and language classes, facilitating meaningful interactions with local students and a smoother, less stressful transition.',
 'hero/pre-landing-services.webp',
 'plane-takeoff', 1, 5),

('post-landing-services', 'Post-Landing Services',
 'Starting from airport pickup, our post-landing services extend to helping our students to settle down by opening a bank account and applying for necessary documents after reaching there.',
 'Starting from airport pickup, our post-landing services extend to helping our students to settle down by opening a bank account and applying for necessary documents after reaching there.',
 'Studying abroad helps with personal and academic growth, but to truly maximize the experience it''s crucial to have the right support system in place after you arrive. Post-landing services play a vital role in helping international students overcome the challenges they face after arriving in a new country — from finding accommodation and opening a bank account, to understanding local customs and regulations.\n\nStudwise''s post-landing services are designed to provide support and guidance tailored to the specific needs of students studying abroad, helping them settle in quickly and make the most of their study abroad experience.\n\nImmigration starts with the application process and ends with successfully settling into the new country. The professional guidance given by Studwise, starting from airport pickup, has promisingly supported many students to zone out in another country — smoothing the immigration process to make it as simple and direct as possible.',
 'office/valanchery-office.webp',
 'plane-landing', 0, 6),

('internship-services', 'Internship Services',
 'As internships provide a valuable platform, Studwise, as a top study abroad education consultancy has partnered with 100+ internship providing companies across the world.',
 'As internships provide a valuable platform, Studwise, as a top study abroad education consultancy has partnered with 100+ internship providing companies across the world.',
 'Studying abroad is a life-changing experience that broadens your horizons and deepens your appreciation for different cultures, developing adaptability and open-mindedness — qualities highly sought after by employers in today''s globalized world. Internship programs complement your academic studies with valuable, hands-on work experience.\n\nStudy abroad internship programs offer the best of both worlds — immersing you in a new culture while gaining real-world experience in your field of interest, applying what you''ve learned in the classroom to real projects and challenges.\n\nAn internship overseas helps develop a global perspective, improve skills, and build cross-cultural communication. Studwise gives proper guidance and support to students who wish to move abroad via an internship, partnered with 100+ internship-providing companies across the world, with a dedicated team to assist your search for opportunities and build a strong international network for future career prospects.',
 'office/gallery-2.jpeg',
 'briefcase', 0, 7),

('accommodation-assistance', 'Accommodation Assistance',
 'We at Studwise can assist you in locating the best and secured accommodation options under your budget with all basic infrastructure facilities of the student''s choice.',
 'We ensure only the safest and most secure accommodations for our students. We assist you in finding the best accommodation that comes well under your budget.',
 'Are you dreaming of studying abroad? One of the most crucial aspects of your international education journey is finding the perfect accommodation. Whether you''re looking for a homestay experience, a student residence, or a private apartment, our services cater to various budgets, locations, and preferences — because a safe, comfortable, and convenient place to live matters just as much as your academics.\n\nChoosing the right accommodation is a vital decision that can greatly impact your overall experience. By considering location, safety, cost, amenities, and reviews, we help you make an informed choice that suits your needs.\n\nOur dedicated team at Studwise can assist you in locating the best and most secure accommodation options under your budget, with basic infrastructure facilities close to your institution of choice — completing all documentation processes on your behalf where necessary, so finding housing never feels like a traumatic process.',
 'office/gallery-3.jpeg',
 'home', 1, 8),

('scholarship-assistance', 'Scholarship Assistance',
 'Students will be given proper guidance and reliable information on the scholarships that the Universities provide. We make sure that they are given support in a right pathway.',
 'As we realize the financial difficulties of studying abroad, we assist our clients in availing scholarships for our clients, hence eliminating financial hurdles.',
 'Overseas education is becoming more popular by the day, but the cost of it remains a real concern for many students. Students are given proper guidance and reliable information on the scholarships that universities provide — because the cost of tuition, living expenses, and travel can often seem overwhelming, but with the right approach and preparation, various scholarships and grants can make your dream a reality.\n\nScholarships matter beyond just financial aid — they enhance your resume, showcase your commitment to education and your ability to excel academically, and can open doors to networking and mentorship opportunities as you embrace new cultures and experiences.\n\nStudwise makes sure students are given support in the right pathway to scholarships offered by various countries across the world, aiding in scholarship acquisition and eliminating financial hurdles so more students can pursue their academic dreams without the burden of financial constraints.',
 'hero/overseas-education-consultants-kerala.webp',
 'scholarship-cap', 1, 9);

-- ============ stats ============
-- 'main' — used on Home, About, Services (the 5+ / 1000+ / 100% count-up block)
INSERT INTO stats (group_key, label, value_number, value_prefix, value_suffix, sort_order) VALUES
('main', 'Years of Experience', 5, '', '+', 1),
('main', 'Happy Students', 1000, '', '+', 2),
('main', 'Satisfaction', 100, '', '%', 3);

-- 'about_chips' — the About page's "Why Choose Us" stat chips
INSERT INTO stats (group_key, label, value_number, value_prefix, value_suffix, sort_order) VALUES
('about_chips', 'Customer Support', 24, '', '/7', 1),
('about_chips', 'Projects Completed', 1000, '', '+', 2),
('about_chips', 'Partnering Universities Worldwide', 150, '', '+', 3);

-- ============ faqs ============
INSERT INTO faqs (question, answer, sort_order) VALUES
('How long do study abroad programmes last?',
 'The duration of the study program actually depends on the program or level of degree you are pursuing. A undergraduate program generally takes three or four years, while, a master''s program usually takes one to two years. Some universities abroad offers even shorter durations programs like a year, a semester or even just few weeks. At the end of the day, it all depends on the program you choose.',
 1),
('How Much Will Studying Abroad Cost?',
 'Studying abroad is known to be an expensive process. Although it seems expensive for Indian students, there are several financial solutions to tackle those hurdles. There are several easy-to-avail scholarships available today that students can claim based on several criteria. There are also other funding options such as education loans for aspirants to eliminate financial hurdles.',
 2),
('Is it possible to work part-time while studying?',
 'Yes. You can find part-time jobs for earning during your study abroad program. There are a lot of part-time jobs available which you can find in various ways.',
 3);

-- ============ testimonials (real quotes, verbatim) ============
INSERT INTO testimonials (student_name, university, course, quote, photo_path, sort_order) VALUES
('Maria', 'UEL University', 'MSc Computer Science',
 'In my experience Studwise International was a best choice. They provided me good services for my dream education in the UK. I specially thank Mahmood for the immense support given to me for my student visa and my husband''s dependant visa. I really appreciate your follow up in each and everything for the entire journey. Once again thank you Mahmood and the team Studwise International!',
 NULL, 1),

('Ardra Ashok', 'ARU University', 'MSc Supply Chain Management',
 'I will encourage all my friends and those who are reading this review to approach studwise international if you have plans to study abroad. I had really good experience with studwise. I was properly guided and the entire process was hassle free. My sincere gratitude to mahmmod, Aswathy and the entire team for making my dream come true. Special thanks to aswathy for preparing me for CAS interview. I really appreciate your effort and I''m really thankful for everything.',
 NULL, 2),

('Abdul Basith', 'ARU University', 'International Business MSc',
 'Studwise has helped me achieve dream of studying abroad in a world class university like Anglia Ruskin University. They are quite professional and are always there to help you out through each and every step of the way. I am pleased with the overall support and attitude of the team. I would recommend Studwise to all the aspiring students out there.',
 NULL, 3),

('Amal Muhammed', 'ARU University', 'MSc International Business',
 'I would like to recommend studwise international to all abroad study aspirants since they have very professional staff who treat you well and make the process of applying to UK universities very easy. And all their services are Free of cost. There are so many other consultancies where they ask for fees and dont work well or treat you unprofessionally. Here they treated me well and handled my application very well, with no extra charges. Thank you Studwise for making my dream of abroad studies come true.',
 NULL, 4),

('Ameer', 'Hertfordshire University', 'MSc International Business',
 'Thank you Studwise for your service. I do recommend studwise International for those who looking for abroad study. They''re extremely helpful and transparent. I especially want to thank Aswathy for the whole support in the uk student visa process and Mehmood who picks up my calls anytime and who is ready to clear all of my doubts. Thank you team, keep it up.',
 NULL, 5),

('Asnaf Rehman', 'Roehampton University', 'MBA',
 'Thanks to Studwise International and Mahmoode for making my dreams comes true study in UK. On my view Studwise International is one of the genuine and trusted educational consultant in Malappuram district. If You have a drive and desire to study in abroad, Mahmoode and the Studwise International team will do the rest.',
 NULL, 6),

('Dilshan Afeed', 'UCLAN University', 'MBA',
 'I am really happy with the team studwise international. I would like to thank them for their assistance in each and every step of my processing. Fully satisfied with services and assistance from the team. Excellent support for the students. Highly suggesting for the students who planing to an abroad study and all. Very helpful staffs.',
 NULL, 7),

('Faris', 'University of Europe for Applied Sciences, Germany', 'MBA',
 'Such a great academic achievement helped me to achieve my dream. I am very happy with their team.',
 NULL, 8),

('Karishma', 'Hertfordshire University', 'MSc International Business',
 'I am very much satisfied with the service that Studwise gave me during every stages of my visa in a proper way and also guided me very well. I would like to give special thanks to Mahmood sir and my visa filing processing staff Aswathy, they really helped me and updated me everything very well.',
 NULL, 9),

('Fariz', 'LJMU University', 'MSc (240c) International Business and Management',
 'Its been a dream for me to study abroad. All thanks to studwise team for helping me to achieve my dreams as an international student. It''s been like a family to me. The staffs were so kind and friendly and helping me in every cases even in the credibility interview. Special Thanks to Aswathy maam and heena maam for guiding at every stage and the whole team. Thanks again for making my dream come true.',
 NULL, 10),

('Mohammed Nishad', 'UEL University', 'MBA',
 'Edwise Global Consultant is such a reliable and trustworthy overseas consultancy, special Thanks to counsellor Darsana for her constant support and optimistic guidance throughout the process starting from the selection of university to visa application process.',
 NULL, 11),

('Ajmal', 'Hertfordshire University', 'MSc International Business with Advanced Research',
 'Im so thankful to Team Studwise for supporting me to achieve my goal. For last few months we made lot of discussion regards to find out the path to move UK. As a mentor to our team, Mahmood kka helped me a lot by giving proper instructions and by encouraging me to move forward and also im thankful to Ashwathi miss for cope up with me throughout. Thank you Team Studwise.',
 NULL, 12),

('Shahaba', 'UCLAN University', 'Master of Business Administration with Professional Placement',
 'Studwise international is one of the best education consultant that helped me step in my admisssion consulting, choosing the suitable and affordable universities in the UK and assisting me in choosing a suitable Course. Studewise international helped me achieve dream of studying abroad in world class university. they are quit professional and are always there to help you out through each and every step of the way. I am pleased with the overall and attitude of the team at Studwise international. the counsellor assigned for my masters is Ms Razeena, who was very helpful and guided me through every step right from application to the university to the visa process. she is always available to clear my doubts and followed up the entire process. I would recommend Studewise international to all the aspiring students out there.',
 NULL, 13),

('Shaheem', 'Northampton University', 'MBA',
 'I had a wonderful involvement in Edwise. They helped me to seek after my dream career through appropriate direction. All the staffs were so agreeable and accommodating. Edwise who was there with me directly from the earliest starting point and helped me to pick the correct university. The confirmation and visa preparing was quick. At last, my dream to seek after higher studies in the UK is getting valid. All gratitude to Edwise worldwide specialist.',
 NULL, 14),

('Shibil', 'UEL University', 'MBA',
 'I was lucky enough to have found Edwise Global Consultant. In simple words, the only agency i have known to be straight forwarded and not MONEY ORIENTED. Hats off to the whole team all my regards and best wishes. And thank you very much for your esteemed presence and concern over me and all the rest of your students. I would recommend anyone who wish to study abroad to approach Edwise for any kind of help.',
 NULL, 15);

-- ============ team_members ============
-- branch_id: 1=Manjeri, 2=Valanchery, 3=Calicut
INSERT INTO team_members (name, role, branch_id, photo_path, category, sort_order) VALUES
('P S Mahmood', 'Founder & CEO', NULL, NULL, 'founder', 1),
('Shana Jasmin', 'Branch Head', 2, 'team/shana.webp', 'branch_head', 2),
('Mahroof', 'Branch Head', 1, 'team/mahroof.webp', 'branch_head', 3),
('Aswathy', 'Head of Partnership', NULL, 'team/ashwathy.webp', 'counselor', 4),
('Hashim', 'Student Counselor', NULL, 'team/hashim.webp', 'counselor', 5),
('Lubaba', 'Application Team', NULL, 'team/lubaba.webp', 'staff', 6),
('Sandra', 'Application Team', NULL, 'team/sandhra.webp', 'staff', 7),
('Badriya', 'Application Team', NULL, 'team/badriya.webp', 'staff', 8),
('Aparna', 'Application Team', NULL, 'team/aparna.webp', 'staff', 9),
('Jimsy', 'Application Team', NULL, 'team/jimsy.webp', 'staff', 10),
('Adharsha', 'Student Coordinator', 2, 'team/adarsha.webp', 'coordinator', 11),
('Faseela', 'Student Coordinator', 1, 'team/faseela.webp', 'coordinator', 12),
('Jalva', 'Student Coordinator', 3, NULL, 'coordinator', 13);

-- ============ partner_logos ============
-- Countries Studwise operates in (used for the marquee); decorative shared globe icon, not fabricated university logos.
INSERT INTO partner_logos (name, logo_path, sort_order) VALUES
('United Kingdom', 'partners/globe-icon.svg', 1),
('United States', 'partners/globe-icon.svg', 2),
('Canada', 'partners/globe-icon.svg', 3),
('Australia', 'partners/globe-icon.svg', 4),
('Malta', 'partners/globe-icon.svg', 5),
('Singapore', 'partners/globe-icon.svg', 6),
('Dubai', 'partners/globe-icon.svg', 7),
('Malaysia', 'partners/globe-icon.svg', 8);
