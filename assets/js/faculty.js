// faculty.js - Complete Faculty Data for All Departments

// Load data from API (PHP backend) or use localStorage as fallback
async function loadFacultyData() {
  try {
    // Try to load from API first (optional backend support)
    // const response = await fetch('/backend/api/faculty');
    // if (response.ok) {
    //   const facultyData = await response.json();
    //   if (facultyData.status === 'success') {
    //     return facultyData.data;
    //   }
    // }

    // Fallback to localStorage
    const storedFaculty = JSON.parse(localStorage.getItem('faculty')) || [];

    // If no data in localStorage, use default data
    if (storedFaculty.length === 0) {
      return [
        // ---- Default Data (unchanged) ----
        // Principal and Vice Principal
        {
          id: 100,
          name: "Mr. A.K.Gaurh",
          designation: "Principal",
          qualification: "Ph.D. in Electrical Engineering, M.Tech (Power Systems)",
          experience: "25+ Years Experience",
          specialization: "Power Systems, Renewable Energy, Institutional Administration",
          department: "administration",
          category: "principal",
          image: "assets/images/principalpics.jpg",
          about: "Mr. A.K.Gaurh is the Principal of Government Polytechnic Nainital with over 25 years of experience in technical education and administration. He has been instrumental in the growth and development of the institution.",
          contact: "Email: principal@gpnainital.ac.in | Phone: +91-9876543200 | Office: Principal's Office, Main Building",
          priority: 1
        },
        {
          id: 101,
          name: "Mr.A.S.Bisht",
          designation: "Vice Principal",
          qualification: "Ph.D. in Computer Science, M.Tech (IT)",
          experience: "22+ Years Experience",
          specialization: "Software Engineering, Academic Administration, Quality Assurance",
          department: "administration",
          category: "vice-principal",
          image: "assets/images/facultyphotos/anandshinghbisht.jpg",
          about: "Mr.A.S.Bisht serves as the Vice Principal and brings extensive experience in academic administration and quality assurance in technical education.",
          contact: "Email: viceprincipal@gpnainital.ac.in | Phone: +91-9876543201 | Office: Vice Principal's Office, Main Building",
          priority: 2
        },
        // ... (keep all your remaining default faculty data unchanged)
         // IT Department
        {
          id: 1,
          name: "Mr.Neeraj Verma",
          designation: "Head of Department",
          qualification: "Ph.D. in Computer Science, M.Tech (IT)",
          experience: "18+ Years Experience",
          specialization: "Computer networking  , IT troubleshooting, Quantum Computing, SDN, AI technologies",
          department: "it",
          category: "hod",
          image: "assets/images/facultyphotos/neerajverma.jpg",
          about: "Mr.Neeraj Verma is an experienced   for more than 20 years in Computer networking , IT troubleshooting and as educator. Presently i m working on Quantum Computing, SDN and AI technologies",
          contact: "Email: vermneeraj18@gmail.com | Phone: +91-9876543210 | Office: IT Block, Room 201",
          priority: 3
        },
        {
          id: 2,
          name: "Mr. Rajesh Kumar Lohani",
          designation: "Assistant Professor",
          qualification: "M.Tech (Computer Science), B.Tech (IT)",
          experience: "12+ Years Experience",
          specialization: "Web Technologies, Database Systems, Cloud Computing",
          department: "it",
          category: "faculty",
          image: "assets/images/facultyphotos/rajeshlohani.jpg",
          about: "Mr. Rajesh kumar lohani is  specializes in web technologies and database systems. He has extensive industry experience and has worked on several web development projects before joining academia.",
          contact: "Email: rverma@gpnainital.ac.in | Phone: +91-9876543211 | Office: IT Block, Room 105",
          priority: 10
        },
        {
           id: 3,
          name: "Mrs. Anjali Prasad",
          designation: "Assistant Professor",
          qualification: "M.Tech (Computer Science), B.Tech (IT)",
          experience: "12+ Years Experience",
          specialization: "Web Technologies, Database Systems, Cloud Computing",
          department: "it",
          category: "faculty",
          image: "assets/images/facultyphotos/anjalimaam.jpg",
          about: " Mrs. Anjali Prasad is a passion for guiding students toward excellence in both technical skills and problem-solving abilities . My teaching philosophy centers on encouraging curiosity, fostering innovation. I believe in continuous learning and regular upgradation.",
          contact: "Email: anjaliprasad10@gmail.com | Phone: +91-9876543211 | Office: IT Block, Room 105",
          priority: 10
        },
        {
           id: 4,
          name: "Mr.Rajnish Bhutani",
          designation: "Assistant Professor",
          qualification: "M.Tech (Computer Science), B.Tech (IT)",
          experience: "12+ Years Experience",
          specialization: "Web Technologies, Database Systems, Cloud Computing",
          department: "it",
          category: "faculty",
          image: "assets/images/facultyphotos/bhutanisir.jpg",
          about: "Mr. Rajesh Verma specializes in web technologies and database systems. He has extensive industry experience and has worked on several web development projects before joining academia.",
          contact: "Email: rverma@gpnainital.ac.in | Phone: +91-9876543211 | Office: IT Block, Room 105",
          priority: 10
        },
        {
           id: 5,
          name: "Mr.Navneet Mishra",
          designation: "Assistant Professor",
          qualification: "AMIE(I), M.Tech.(IT)",
          experience: "26 Years Experience",
          specialization: "Computer Science ",
          department: "it",
          category: "faculty",
          image: "assets/images/facultyphotos/navneetmishra.jpg",
          about: "Mr. Navneet mishra Worked at GP Nainital for 5 years, UBTE, Roorkee for 7 years, GP Kaladhungi for 6 years, GP kashipur 03 months, presently working at GP Nainital since 2017.",
          contact: "Email: nmisra055@gmail.com | Phone: +91-9876543211 | Office: IT Block, Room 105",
          priority: 10
        },

        // Electronics Department
        {
          id: 3,
          name: "Mrs.Jayanti Khati",
          designation: "Head of Department",
          qualification: "Ph.D. in Electronics, M.Tech (VLSI Design)",
          experience: "20+ Years Experience",
          specialization: "VLSI Design, Embedded Systems, Digital Electronics",
          department: "electronics",
          category: "hod",
          image: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
          about: "Dr. Sanjay Kumar has extensive experience in VLSI design and embedded systems. He has guided numerous research projects and has industry collaborations with semiconductor companies.",
          contact: "Email: skumar@gpnainital.ac.in | Phone: +91-9876543213 | Office: Electronics Block, Room 301",
          priority: 3
        },
        {
          id: 13,
          name: "Mr. Ashutosh Sharan Singh",
          designation: "Assistant Professor",
          qualification: "M.Tech in Electronics, B.Tech in Electronics & Communication",
          experience: "8+ Years Experience",
          specialization: "Digital Signal Processing, Communication Systems",
          department: "electronics",
          category: "faculty",
          image: "assets/images/facultyphotos/ashutosh.jpg",
          about: "Prof. Neha Gupta specializes in digital signal processing and communication systems. She is passionate about teaching modern electronics and communication technologies.",
          contact: "Email: ngupta@gpnainital.ac.in | Phone: +91-9876543224 | Office: Electronics Block, Room 302",
          priority: 10
        },
         {
          id: 14,
          name: "Ms.Shalini",
          designation: "Assistant Professor",
          qualification: "M.Tech in Electronics, B.Tech in Electronics & Communication",
          experience: "10 Years Experience",
          specialization: "Digital Signal Processing, Communication Systems",
          department: "electronics",
          category: "faculty",
          image: "assets/images/facultyphotos/shalini.jpg",
          about: "Ms.Shalini specializes in digital signal processing and communication systems. She is passionate about teaching modern electronics and communication technologies.",
          contact: "Email: shalinimalik90@gmail.com | Phone: +91-9876543224 | Office: Electronics Block, Room 302",
          priority: 10
        },
         {
          id: 15,
          name: "Mr.Suresh Singh",
          designation: "Assistant Professor",
          qualification: "M.Tech in Electronics, B.Tech in Electronics & Communication",
          experience: "8+ Years Experience",
          specialization: "Digital Signal Processing, Communication Systems",
          department: "electronics",
          category: "faculty",
          image:"assets/images/facultyphotos/sureshnegi.jpg",
          about: "Prof. Neha Gupta specializes in digital signal processing and communication systems. She is passionate about teaching modern electronics and communication technologies.",
          contact: "Email:sureshnegintl@gmail.com | Phone: +91-9876543224 | Office: Electronics Block, Room 302",
          priority: 10
        },
         
        // Electrical Department
        {
          id: 4,
          name: "Mrs.Ranjana Rawat",
          designation: "Head of Department",
          qualification: "Ph.D. in Electrical Engineering, M.Tech (Power Systems)",
          experience: "22+ Years Experience",
          specialization: "Power Systems, Renewable Energy, Control Systems",
          department: "electrical",
          category: "hod",
          image: "assets/images/facultyphotos/ranjanamaam.jpg",
          about: "Mrs. Ranjana Rawat is an expert in power systems and renewable energy. He has consulted for several power distribution companies and has published extensively in his field.",
          contact: "Email: rsingh@gpnainital.ac.in | Phone: +91-9876543215 | Office: Electrical Block, Room 401",
          priority: 3
        },
        {
          id: 14,
          name: "Mr.Amit Joshi",
          designation: "Senior Lecturer",
          qualification: "M.Tech in Power Systems, B.Tech in Electrical Engineering",
          experience: "15+ Years Experience",
          specialization: "Electrical Machines, Power Electronics, Renewable Energy",
          department: "electrical",
          category: "faculty",
          image: "assets/images/facultyphotos/amitjoshi.jpg",
          about: "Mr.Amit Joshi specializes in electrical machines and power electronics. He has extensive industry experience in power systems and renewable energy projects.",
          contact: "Email: amishra@gpnainital.ac.in | Phone: +91-9876543225 | Office: Electrical Block, Room 402",
          priority: 10
        },

        // Civil Engineering Department
        {
          id: 9,
          name: "Ms Kavita Negi",
          designation: "Head of Department",
          qualification: "Ph.D. in Structural Engineering, M.Tech in Construction Technology",
          experience: "18+ Years Experience",
          specialization: "Structural Analysis, Concrete Technology, Earthquake Engineering",
          department: "civil",
          category: "hod",
          image: "assets/images/facultyphotos/kavita.jpg",
          about: "Ms.Kavita is an experienced academician with over 18 years of teaching and research experience in civil engineering.",
          contact: "Email: rkumar@gpnainital.ac.in | Phone: +91-9876543220 | Office: Civil Block, Room 501",
          priority: 3
        },
        {
          id: 10,
          name: "Prof. Sunita Sharma",
          designation: "Senior Lecturer",
          qualification: "M.Tech in Geotechnical Engineering, B.Tech in Civil Engineering",
          experience: "15+ Years Experience",
          specialization: "Soil Mechanics, Foundation Engineering, Slope Stability",
          department: "civil",
          category: "faculty",
          image: "https://images.unsplash.com/photo-1582750433449-648ed127bb54?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80",
          about: "Prof. Sunita Sharma specializes in geotechnical engineering and foundation design.",
          contact: "Email: ssharma@gpnainital.ac.in | Phone: +91-9876543221 | Office: Civil Block, Room 502",
          priority: 10
        },

        // Mechanical Engineering Department
        {
          id: 15,
          name: "Mrs.Ruchita Joshi",
          designation: "Head of Department",
          qualification: "Ph.D. in Mechanical Engineering, M.Tech in Thermal Engineering",
          experience: "20+ Years Experience",
          specialization: "Thermal Engineering, Fluid Mechanics, Heat Transfer",
          department: "mechanical",
          category: "hod",
          image: "assets/images/facultyphotos/ruchita.jpg",
          about: "Mrs.Ruchita Joshi is an expert in thermal engineering and fluid mechanics with over 20 years of teaching and research experience.",
          contact: "Email: vchauhan@gpnainital.ac.in | Phone: +91-9876543226 | Office: Mechanical Block, Room 601",
          priority: 3
        },
        {
          id: 16,
          name: "Prof. Anil Rawat",
          designation: "Assistant Professor",
          qualification: "M.Tech in Production Engineering, B.Tech in Mechanical Engineering",
          experience: "12+ Years Experience",
          specialization: "Production Engineering, CAD/CAM, Manufacturing Processes",
          department: "mechanical",
          category: "faculty",
          image: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
          about: "Prof. Anil Rawat specializes in production engineering and manufacturing processes.",
          contact: "Email: arawat@gpnainital.ac.in | Phone: +91-9876543227 | Office: Mechanical Block, Room 602",
          priority: 10
        },

        // Pharmacy Department
        {
          id: 17,
          name: "Mrs.Pratibha Arya",
          designation: "Head of Department",
          qualification: "Ph.D. in Pharmaceutical Sciences, M.Pharm",
          experience: "18+ Years Experience",
          specialization: "Pharmaceutics, Drug Delivery Systems, Pharmaceutical Technology",
          department: "pharmacy",
          category: "hod",
          image: "assets/images/facultyphotos/pratibha.jpg",
          about: "Mrs.Pratibha Arya is an experienced academician in pharmaceutical sciences with extensive research experience in drug delivery systems.",
          contact: "Email: pjoshi@gpnainital.ac.in | Phone: +91-9876543228 | Office: Pharmacy Block, Room 701",
          priority: 3
        },
        {
          id: 18,
          name: "Mrs.Ajali Agarwal",
          designation: "Assistant Professor",
          qualification: "M.Pharm in Pharmacology, B.Pharm",
          experience: "10+ Years Experience",
          specialization: "Pharmacology, Clinical Pharmacy, Medicinal Chemistry",
          department: "pharmacy",
          category: "faculty",
          image: "assets/images/facultyphotos/anjaliagrwal.jpg",
          about: "Mrs.Ajali Agarwal specializes in pharmacology and medicinal chemistry.",
          contact: "Email: rtiwari@gpnainital.ac.in | Phone: +91-9876543229 | Office: Pharmacy Block, Room 702",
          priority: 10
        },
         {
          id: 19,
          name: "Mrs.Savita Pandey",
          designation: "Assistant Professor",
          qualification: "M.Pharm in Pharmacology, B.Pharm",
          experience: "10+ Years Experience",
          specialization: "Pharmacology, Clinical Pharmacy, Medicinal Chemistry",
          department: "pharmacy",
          category: "faculty",
          image: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
          about: "Prof. Rakesh Tiwari specializes in pharmacology and medicinal chemistry.",
          contact: "Email: rtiwari@gpnainital.ac.in | Phone: +91-9876543229 | Office: Pharmacy Block, Room 702",
          priority: 10
        },

         {
          id: 18,
          name: "Mrs.Bhawna Arya",
          designation: "Assistant Professor",
          qualification: "M.Pharm in Pharmacology, B.Pharm",
          experience: "10+ Years Experience",
          specialization: "Pharmacology, Clinical Pharmacy, Medicinal Chemistry",
          department: "pharmacy",
          category: "faculty",
          image: "assets/images/facultyphotos/bhawana.jpg",
          contact: "Email: rtiwari@gpnainital.ac.in | Phone: +91-9876543229 | Office: Pharmacy Block, Room 702",
          priority: 10
        },

         {
          id: 18,
          name: "Mrs.Laxmi Goswami",
          designation: "Assistant Professor",
          qualification: "M.Pharm in Pharmacology, B.Pharm",
          experience: "10+ Years Experience",
          specialization: "Pharmacology, Clinical Pharmacy, Medicinal Chemistry",
          department: "pharmacy",
          category: "faculty",
          image: "assets/images/facultyphotos/laxmimaam.png",
          about: "Mrs.Laxmi Goswami specializes in pharmacology and medicinal chemistry.",
          contact: "Email: rtiwari@gpnainital.ac.in | Phone: +91-9876543229 | Office: Pharmacy Block, Room 702",
          priority: 10
        },


        // First Year Department
        {
          id: 5,
          name: "Dr. Meera Joshi",
          designation: "First Year Coordinator",
          qualification: "Ph.D. in Physics, M.Sc. (Physics)",
          experience: "15+ Years Experience",
          specialization: "Applied Physics, Engineering Mathematics",
          department: "first-year",
          category: "faculty",
          image: "https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
          about: "Dr. Meera Joshi coordinates the first year program and teaches applied physics to all engineering students.",
          contact: "Email: mjoshi@gpnainital.ac.in | Phone: +91-9876543216 | Office: Main Building, Room 101",
          priority: 10
        },
        {
          id: 6,
          name: "Mr. Alok Pandey",
          designation: "Assistant Professor",
          qualification: "M.Tech (Mathematics), M.Sc. (Mathematics)",
          experience: "10+ Years Experience",
          specialization: "Engineering Mathematics, Calculus, Differential Equations",
          department: "first-year",
          category: "faculty",
          image: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
          about: "Mr. Alok Pandey specializes in engineering mathematics and has developed comprehensive course materials for first year students.",
          contact: "Email: apandey@gpnainital.ac.in | Phone: +91-9876543217 | Office: Main Building, Room 102",
          priority: 10
        },

        // Workshop Department
        {
          id: 7,
          name: "Mr. H.N.Upreti",
          designation: "Workshop Superintendent",
          qualification: "Diploma in Mechanical Engineering, ITI (Fitter)",
          experience: "25+ Years Experience",
          specialization: "Carpentry, Fitting, Welding, Smithy",
          department: "workshop",
          category: "instructor",
          image: "assets/images/facultyphotos/hnupreti.jpg",
          about: "Mr. H.N.Upreti has extensive industrial experience and manages all workshop activities.",
          contact: "Email: vrawat@gpnainital.ac.in | Phone: +91-9876543218 | Office: Workshop Building",
          priority: 10
        },
        {
          id: 8,
          name: "Mr.Shobit Kumar Chauhan",
          designation: "Workshop Instructor",
          qualification: "B.Tech (Mechanical Engineering), ITI (Welding)",
          experience: "8+ Years Experience",
          specialization: "Welding Technology, Sheet Metal Work",
          department: "workshop",
          category: "instructor",
          image: "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
          about: "Ms. Sunita Bisht specializes in welding technology and sheet metal work.",
          contact: "Email: sbisht@gpnainital.ac.in | Phone: +91-9876543219 | Office: Workshop Building",
          priority: 10
        },
          {
          id: 8,
          name: "Mr.Vinod Kumar",
          designation: "Workshop Instructor",
          qualification: "B.Tech (Mechanical Engineering), ITI (Welding)",
          experience: "8+ Years Experience",
          specialization: "Welding Technology, Sheet Metal Work",
          department: "workshop",
          category: "instructor",
          image: "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
          about: "Mr. Vinod Kumar specializes in welding technology and sheet metal work.",
          contact: "Email: sbisht@gpnainital.ac.in | Phone: +91-9876543219 | Office: Workshop Building",
          priority: 10
        },
          {
          id: 8,
          name: "Mr.Teg Bahadur",
          designation: "Workshop Instructor",
          qualification: "B.Tech (Mechanical Engineering), ITI (Welding)",
          experience: "8+ Years Experience",
          specialization: "Welding Technology, Sheet Metal Work",
          department: "workshop",
          category: "instructor",
          image: "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
          about: " Mr.Teg Bahadur specializes in welding technology and sheet metal work.",
          contact: "Email: sbisht@gpnainital.ac.in | Phone: +91-9876543219 | Office: Workshop Building",
          priority: 10
        },
          {
          id: 8,
          name: "Mr.Harender Dev",
          designation: "Workshop Instructor",
          qualification: "B.Tech (Mechanical Engineering), ITI (Welding)",
          experience: "8+ Years Experience",
          specialization: "Welding Technology, Sheet Metal Work",
          department: "workshop",
          category: "instructor",
          image: "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
          about: "Mr.Harender Dev specializes in welding technology and sheet metal work.",
          contact: "Email: sbisht@gpnainital.ac.in | Phone: +91-9876543219 | Office: Workshop Building",
          priority: 10
        },
          {
          id: 8,
          name: "Mr.Vidyasagar Kumar",
          designation: "Workshop Instructor",
          qualification: "B.Tech (Mechanical Engineering), ITI (Welding)",
          experience: "8+ Years Experience",
          specialization: "Welding Technology, Sheet Metal Work",
          department: "workshop",
          category: "instructor",
          image: "assets/images/facultyphotos/vidyasagar.jpg",
          about: "Mr.Vidyasagar Kumar specializes in welding technology and sheet metal work.",
          contact: "Email: sbisht@gpnainital.ac.in | Phone: +91-9876543219 | Office: Workshop Building",
          priority: 10
        },
          {
          id: 8,
          name: "Mr.Kamal Pant",
          designation: "Workshop Instructor",
          qualification: "B.Tech (Mechanical Engineering), ITI (Welding)",
          experience: "8+ Years Experience",
          specialization: "Welding Technology, Sheet Metal Work",
          department: "workshop",
          category: "instructor",
          image: "assets/images/facultyphotos/kamalpant.jpg",
          about: "Mr.Kamal Pant specializes in welding technology and sheet metal work.",
          contact: "Email: sbisht@gpnainital.ac.in | Phone: +91-9876543219 | Office: Workshop Building",
          priority: 10
        },
          {
          id: 8,
          name: "Mr.Amit Joshi",
          designation: "Workshop Instructor",
          qualification: "B.Tech (Mechanical Engineering), ITI (Welding)",
          experience: "8+ Years Experience",
          specialization: "Welding Technology, Sheet Metal Work",
          department: "workshop",
          category: "instructor",
          image: "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
          about: "Mr.Amit Joshi specializes in welding technology and sheet metal work.",
          contact: "Email: sbisht@gpnainital.ac.in | Phone: +91-9876543219 | Office: Workshop Building",
          priority: 10
        },
          {
          id: 8,
          name: "MR.Kamal kishor",
          designation: "Workshop Instructor",
          qualification: "B.Tech (Mechanical Engineering), ITI (Welding)",
          experience: "8+ Years Experience",
          specialization: "Welding Technology, Sheet Metal Work",
          department: "workshop",
          category: "instructor",
          image: "assets/images/facultyphotos/kamalkumar.jpg",
          about: "Ms. Sunita Bisht specializes in welding technology and sheet metal work.",
          contact: "Email: sbisht@gpnainital.ac.in | Phone: +91-9876543219 | Office: Workshop Building",
          priority: 10
        },
          {
          id: 8,
          name: "Mr.Jitendra Kumar Sharma",
          designation: "Workshop Instructor",
          qualification: "B.Tech (Mechanical Engineering), ITI (Welding)",
          experience: "8+ Years Experience",
          specialization: "Welding Technology, Sheet Metal Work",
          department: "workshop",
          category: "instructor",
          image: "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
          about: "Ms. Sunita Bisht specializes in welding technology and sheet metal work.",
          contact: "Email: sbisht@gpnainital.ac.in | Phone: +91-9876543219 | Office: Workshop Building",
          priority: 10
        },

        // Library Staff
        {
          id: 21,
          name: "Mrs.Hema Pant",
          designation: "Librarian",
          qualification: "M.Lib, Ph.D. in Library Science",
          experience: "18+ Years Experience",
          specialization: "Library Management, Digital Resources, Information Technology",
          department: "library",
          category: "library",
          image: "assets/images/facultyphotos/labwalimaam.jpg",
          about: "Dr. Anil Bhatt manages the college library and digital resources with extensive experience in library science.",
          contact: "Email: abhatt-library@gpnainital.ac.in | Phone: +91-9876543232 | Office: Library Building",
          priority: 10
        },
        
      ];
  
    }

    // Return data from localStorage
    return storedFaculty;
  } catch (error) {
    console.error('Error loading faculty data:', error);
    return [];
  }
}

// DOM Elements
const facultyContainer = document.getElementById('facultyContainer');
const administrationContainer = document.getElementById('administrationContainer');
const hodsContainer = document.getElementById('hodsContainer');
const facultyDetailModal = document.getElementById('facultyDetailModal');
const facultyDetailClose = document.getElementById('facultyDetailClose');

// Initialize Application (Fixed Async Handling)
let allFaculty = [];

document.addEventListener('DOMContentLoaded', async function() {
  console.log('Faculty JS loaded - Fixed Version');

  // ✅ Wait for data to load before rendering
  allFaculty = await loadFacultyData();

  const currentPage = window.location.pathname;

  if (currentPage.includes('about.html')) {
    renderAboutPageFaculty();
    setupFacultyEventListeners();
  } else if (currentPage.includes('faculty.html')) {
    renderFacultyList('all');
    setupFacultyEventListeners();
  } else if (currentPage.includes('library.html') || currentPage.includes('Library.html')) {
    renderLibraryStaff();
    setupFacultyEventListeners();
  } else if (currentPage.includes('workshop.html') || currentPage.includes('workshops.html')) {
    renderWorkshopStaff();
    setupFacultyEventListeners();
  } else if (currentPage.includes('officestaff.html')) {
    console.log('Office staff page detected - loading officestaff.js');
  } else {
    const department = getCurrentDepartment();
    if (department) {
      renderDepartmentFaculty(department);
      setupFacultyEventListeners();
    }
  }

  // Initialize AOS
  if (typeof AOS !== 'undefined') {
    AOS.init({
      duration: 1000,
      once: true,
      offset: 100
    });
  }
});

// Department Identifier
function getCurrentDepartment() {
  const currentPage = window.location.pathname;
  if (currentPage.includes('civil.html')) return 'civil';
  if (currentPage.includes('electronics.html')) return 'electronics';
  if (currentPage.includes('electrical.html')) return 'electrical';
  if (currentPage.includes('It.html') || currentPage.includes('it.html')) return 'it';
  if (currentPage.includes('mechanical.html')) return 'mechanical';
  if (currentPage.includes('pharmacy.html')) return 'pharmacy';
  return null;
}

// Setup Event Listeners
function setupFacultyEventListeners() {
  const filterButtons = document.querySelectorAll('.filter-btn');
  if (filterButtons.length > 0) {
    filterButtons.forEach(button => {
      button.addEventListener('click', function() {
        filterButtons.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
        const filterValue = this.getAttribute('data-filter');
        renderFacultyList(filterValue);
      });
    });
  }

  if (facultyDetailClose) {
    facultyDetailClose.addEventListener('click', closeFacultyModal);
  }

  if (facultyDetailModal) {
    facultyDetailModal.addEventListener('click', function(e) {
      if (e.target === facultyDetailModal) {
        closeFacultyModal();
      }
    });
  }

  const facultyDetailContent = document.querySelector('.faculty-detail-content');
  if (facultyDetailContent) {
    facultyDetailContent.addEventListener('click', e => e.stopPropagation());
  }

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && facultyDetailModal && facultyDetailModal.classList.contains('show')) {
      closeFacultyModal();
    }
  });
}

// Render All Faculty
function renderFacultyList(filter = 'all') {
  if (!facultyContainer) return;

  let facultyToShow = [];
  if (filter === 'all') {
    facultyToShow = [...allFaculty].sort((a, b) => (a.priority || 10) - (b.priority || 10));
  } else {
    facultyToShow = allFaculty.filter(faculty => {
      if (filter === 'administration') return faculty.department === 'administration';
      else if (filter === 'hod') return faculty.category === 'hod';
      else return faculty.department === filter;
    });
  }

  renderFacultyCards(facultyToShow, facultyContainer);
}

// Render About Page Faculty
function renderAboutPageFaculty() {
  if (administrationContainer) {
    const administrationFaculty = allFaculty.filter(f => f.department === 'administration')
      .sort((a, b) => (a.priority || 10) - (b.priority || 10));
    renderFacultyCards(administrationFaculty, administrationContainer);
  }

  if (hodsContainer) {
    const hodFaculty = allFaculty.filter(f => f.category === 'hod' && f.department !== 'administration')
      .sort((a, b) => (a.priority || 10) - (b.priority || 10));
    renderFacultyCards(hodFaculty, hodsContainer);
  }
}

// Render Department
function renderDepartmentFaculty(department) {
  if (!facultyContainer) return;
  const departmentFaculty = allFaculty.filter(f => f.department === department)
    .sort((a, b) => (a.priority || 10) - (b.priority || 10));
  renderFacultyCards(departmentFaculty, facultyContainer);
}

// Render Library
function renderLibraryStaff() {
  if (!facultyContainer) return;
  const libraryStaff = allFaculty.filter(f => f.department === 'library');
  renderFacultyCards(libraryStaff, facultyContainer);
}

// Render Workshop
function renderWorkshopStaff() {
  if (!facultyContainer) return;
  const workshopStaff = allFaculty.filter(f => f.department === 'workshop');
  renderFacultyCards(workshopStaff, facultyContainer);
}

// Render Cards
function renderFacultyCards(facultyArray, container) {
  if (!container) return;
  container.innerHTML = '';

  if (facultyArray.length === 0) {
    container.innerHTML = `
      <div class="col-12 text-center py-5">
        <i class="bi bi-people display-1 text-muted"></i>
        <h4 class="mt-3">No staff found</h4>
        <p class="text-muted">Please check back later for updates</p>
      </div>`;
    return;
  }

  facultyArray.forEach(faculty => {
    const card = document.createElement('div');
    card.className = 'col-md-6 col-lg-4 mb-4';
    card.innerHTML = `
      <div class="faculty-card" data-faculty-id="${faculty.id}">
        <span class="department-badge">${faculty.department}</span>
        <div class="faculty-img-container">
          <img src="${faculty.image}" alt="${faculty.name}" class="faculty-thumbnail">
          <div class="faculty-overlay">
            <h3>${faculty.name}</h3>
            <p>${faculty.designation}</p>
          </div>
        </div>
        <div class="faculty-card-body">
          <p>${faculty.qualification}</p>
          <span>${faculty.experience}</span>
          <p>${faculty.specialization}</p>
          <button class="btn view-profile-btn w-100">View Profile</button>
        </div>
      </div>
    `;

    const cardElement = card.querySelector('.faculty-card');
    cardElement.addEventListener('click', () => showFacultyDetail(faculty));

    const viewBtn = card.querySelector('.view-profile-btn');
    viewBtn.addEventListener('click', e => {
      e.stopPropagation();
      showFacultyDetail(faculty);
    });

    container.appendChild(card);
  });
}

// Faculty Detail Modal
function showFacultyDetail(faculty) {
  if (!facultyDetailModal) return;

  document.getElementById('facultyDetailMainImage').src = faculty.image;
  document.getElementById('facultyDetailName').textContent = faculty.name;
  document.getElementById('facultyDetailDesignation').textContent = faculty.designation;
  document.getElementById('facultyDetailAbout').textContent = faculty.about || '';
  document.getElementById('facultyDetailQualification').textContent = faculty.qualification || '';
  document.getElementById('facultyDetailExperience').textContent = faculty.experience || '';
  document.getElementById('facultyDetailSpecialization').textContent = faculty.specialization || '';
  document.getElementById('facultyDetailContact').textContent = faculty.contact || '';

  facultyDetailModal.classList.add('show');
  document.body.style.overflow = 'hidden';
}

function closeFacultyModal() {
  facultyDetailModal.classList.remove('show');
  document.body.style.overflow = 'auto';
}
