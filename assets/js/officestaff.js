// officestaff.js - Office Staff Data for Government Polytechnic Nainital
// Load data from API (PHP backend) or use localStorage as fallback

async function loadOfficeStaffData() {
  try {
    // Try to load from API first (uncomment when backend ready)
    // const response = await fetch('/backend/api/staff');
    // if (response.ok) {
    //   const staffData = await response.json();
    //   if (staffData.status === 'success') {
    //     return staffData.data;
    //   }
    // }

    // Fallback to localStorage
    const storedStaff = JSON.parse(localStorage.getItem('staff')) || [];

    // If no data in localStorage, use default data
    if (storedStaff.length === 0) {
      return [
        // Administrative Staff
        {
          id: 201,
          name: "Mr. Rakesh Kumar",
          designation: "Administrative Officer",
          qualification: "M.Com, MBA (HR)",
          experience: "15+ Years Experience",
          specialization: "Office Administration, Human Resources, Record Management",
          department: "administrative",
          category: "administrative",
          image: "https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=500&q=80",
          about: "Mr. Rakesh Kumar manages the administrative operations of the college and oversees office staff coordination.",
          contact: "Email: rkumar-admin@gpnainital.ac.in | Phone: +91-9876543301 | Office: Administrative Block, Ground Floor",
          priority: 1
        },
        {
          id: 202,
          name: "Ms. Sunita Rawat",
          designation: "Office Superintendent",
          qualification: "B.Com, Diploma in Office Management",
          experience: "12+ Years Experience",
          specialization: "Office Management, Documentation, Student Records",
          department: "administrative",
          category: "administrative",
          image: "https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=500&q=80",
          about: "Ms. Sunita Rawat handles office documentation and student record management with precision and efficiency.",
          contact: "Email: srawat-office@gpnainital.ac.in | Phone: +91-9876543302 | Office: Main Office, Ground Floor",
          priority: 2
        },

        // Account Section Staff
        {
          id: 203,
          name: "Mr. Alok Joshi",
          designation: "Account Officer",
          qualification: "M.Com, CA Inter",
          experience: "18+ Years Experience",
          specialization: "Financial Management, Budgeting, Accounts Reconciliation",
          department: "account",
          category: "account",
          image: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=500&q=80",
          about: "Mr. Alok Joshi manages the college finances, budgeting, and financial reporting with extensive experience in educational institution accounting.",
          contact: "Email: ajoshi-accounts@gpnainital.ac.in | Phone: +91-9876543303 | Office: Accounts Section, Ground Floor",
          priority: 1
        },
        {
          id: 204,
          name: "Ms. Priyanka Bisht",
          designation: "Account Assistant",
          qualification: "B.Com, Tally Certified",
          experience: "8+ Years Experience",
          specialization: "Tally Operations, Fee Collection, Voucher Processing",
          department: "account",
          category: "account",
          image: "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=500&q=80",
          about: "Ms. Priyanka Bisht handles day-to-day accounting operations including fee collection and voucher processing.",
          contact: "Email: pbisht-accounts@gpnainital.ac.in | Phone: +91-9876543304 | Office: Accounts Section, Ground Floor",
          priority: 2
        },

        // Technical Support Staff
        {
          id: 205,
          name: "Mr. Vikas Thapa",
          designation: "IT Support Engineer",
          qualification: "B.Tech (Computer Science), CCNA Certified",
          experience: "10+ Years Experience",
          specialization: "Network Administration, Hardware Maintenance, Software Support",
          department: "technical",
          category: "technical",
          image: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=500&q=80",
          about: "Mr. Vikas Thapa provides technical support for computer systems, network infrastructure, and software applications across the campus.",
          contact: "Email: vthapa-it@gpnainital.ac.in | Phone: +91-9876543305 | Office: IT Support Room, First Floor",
          priority: 1
        },
        {
          id: 206,
          name: "Mr. Deepak Negi",
          designation: "Lab Technician",
          qualification: "Diploma in Electronics, ITI (Electronics)",
          experience: "15+ Years Experience",
          specialization: "Electronics Lab Equipment, Computer Hardware, Instrument Maintenance",
          department: "technical",
          category: "technical",
          image: "https://images.unsplash.com/photo-1566492031773-4f4e44671d6d?auto=format&fit=crop&w=500&q=80",
          about: "Mr. Deepak Negi maintains and supports all laboratory equipment and technical instruments across various departments.",
          contact: "Email: dnegi-tech@gpnainital.ac.in | Phone: +91-9876543306 | Office: Electronics Lab, First Floor",
          priority: 2
        },

        // Support Staff
        {
          id: 207,
          name: "Mr. Harish Chandra",
          designation: "Office Assistant",
          qualification: "",
          experience: "",
          specialization: "",
          department: "support",
          category: "support",
          image: "https://images.unsplash.com/photo-1582750433449-648ed127bb54?auto=format&fit=crop&w=500&q=80",
          about: "Mr. Harish Chandra provides comprehensive office support and assists students with various administrative requirements.",
          contact: "Email: hchandra-office@gpnainital.ac.in | Phone: +91-9876543307 | Office: Main Office, Ground Floor",
          priority: 1
        },
        {
          id: 208,
          name: "Ms. Kavita Joshi",
          designation: "Receptionist",
          qualification: "B.A., Diploma in Office Management",
          experience: "6+ Years Experience",
          specialization: "",
          department: "support",
          category: "support",
          image: "https://images.unsplash.com/photo-1494790108755-2616b612b786?auto=format&fit=crop&w=500&q=80",
          about: "Ms. Kavita Joshi manages the college reception and serves as the first point of contact for visitors and callers.",
          contact: "",
          priority: 2
        },
        {
          id: 209,
          name: "Mr. Rajendra Singh",
          designation: "Store Keeper",
          qualification: "B.Com, Store Management Certificate",
          experience: "12+ Years Experience",
          specialization: "Inventory Management, Store Operations, Material Distribution",
          department: "support",
          category: "support",
          image: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=500&q=80",
          about: "Mr. Rajendra Singh manages the college store and ensures proper inventory control and material distribution.",
          contact: "Email: rsingh-store@gpnainital.ac.in | Phone: +91-9876543309 | Office: Store Room, Ground Floor",
          priority: 3
        },
        {
          id: 210,
          name: "Ms. Meena Devi",
          designation: "Office Attendant",
          qualification: "",
          experience: "",
          specialization: "",
          department: "support",
          category: "support",
          image: "https://images.unsplash.com/photo-1551836026-d5c88acceaac?auto=format&fit=crop&w=500&q=80",
          about: "Ms. Meena Devi provides essential office support services and assists in daily office operations.",
          contact: "",
          priority: 4
        }
      ];
    }

    // Return data from localStorage
    return storedStaff;
  } catch (error) {
    console.error('Error loading office staff data:', error);
    return [];
  }
}

// DOM Elements
const facultyContainer = document.getElementById('facultyContainer');
const facultyDetailModal = document.getElementById('facultyDetailModal');
const facultyDetailClose = document.getElementById('facultyDetailClose');

let officeStaff = [];

document.addEventListener('DOMContentLoaded', function() {
  console.log('Office Staff JS loaded');

  loadOfficeStaffData().then(data => {
    officeStaff = data;
    console.log('Loaded staff data:', officeStaff);

    if (window.location.pathname.includes('officestaff.html')) {
      renderOfficeStaffList('all');
      setupOfficeStaffEventListeners();
    }

    if (typeof AOS !== 'undefined') {
      AOS.init({
        duration: 1000,
        once: true,
        offset: 100
      });
    }
  });
});

function setupOfficeStaffEventListeners() {
  console.log('Setting up office staff event listeners');

  const filterButtons = document.querySelectorAll('.filter-btn');
  if (filterButtons.length > 0) {
    filterButtons.forEach(button => {
      button.addEventListener('click', function() {
        filterButtons.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
        const filterValue = this.getAttribute('data-filter');
        console.log('Filter button clicked:', filterValue);
        renderOfficeStaffList(filterValue);
      });
    });
  }

  if (facultyDetailClose) {
    facultyDetailClose.addEventListener('click', closeStaffModal);
  }

  if (facultyDetailModal) {
    facultyDetailModal.addEventListener('click', function(e) {
      if (e.target === facultyDetailModal) {
        closeStaffModal();
      }
    });
  }

  const facultyDetailContent = document.querySelector('.faculty-detail-content');
  if (facultyDetailContent) {
    facultyDetailContent.addEventListener('click', function(e) {
      e.stopPropagation();
    });
  }

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && facultyDetailModal && facultyDetailModal.classList.contains('show')) {
      closeStaffModal();
    }
  });
}

// Render staff list
function renderOfficeStaffList(filter = 'all') {
  if (!facultyContainer || officeStaff.length === 0) return;

  let staffToShow = [];

  if (filter === 'all') {
    staffToShow = [...officeStaff].sort((a, b) => (a.priority || 10) - (b.priority || 10));
  } else {
    staffToShow = officeStaff.filter(staff => staff.department === filter);
  }

  console.log(`Rendering ${staffToShow.length} staff for filter "${filter}"`);
  renderStaffCards(staffToShow);
}

// Render staff cards
function renderStaffCards(staffArray) {
  if (!facultyContainer) return;
  facultyContainer.innerHTML = '';

  if (staffArray.length === 0) {
    facultyContainer.innerHTML = `
      <div class="col-12">
        <div class="no-faculty-message text-center py-5">
          <i class="bi bi-people display-1 text-muted"></i>
          <h4 class="mt-3">No staff found</h4>
          <p class="text-muted">Please check back later for updates</p>
        </div>
      </div>`;
    return;
  }

  const deptNames = {
    administrative: 'Administrative',
    account: 'Accounts',
    technical: 'Technical',
    support: 'Support'
  };

  staffArray.forEach(staff => {
    const staffCard = document.createElement('div');
    staffCard.className = 'col-md-6 col-lg-4 mb-4';
    staffCard.innerHTML = `
      <div class="faculty-card" data-staff-id="${staff.id}">
        <span class="department-badge">${deptNames[staff.department] || staff.department}</span>
        <div class="faculty-img-container">
          <img src="${staff.image}" alt="${staff.name}" class="faculty-thumbnail">
          <div class="faculty-overlay">
            <h3 class="faculty-name">${staff.name}</h3>
            <p class="faculty-designation">${staff.designation}</p>
          </div>
        </div>
        <div class="faculty-card-body">
          <p class="faculty-qualification">${staff.qualification || ''}</p>
          <span class="faculty-experience">${staff.experience || ''}</span>
          <p class="faculty-specialization">${staff.specialization || ''}</p>
          <div class="faculty-actions">
            <button class="btn view-profile-btn w-100">View Profile</button>
          </div>
        </div>
      </div>`;

    const cardElement = staffCard.querySelector('.faculty-card');
    const viewProfileBtn = staffCard.querySelector('.view-profile-btn');

    cardElement.addEventListener('click', () => showStaffDetail(staff));
    viewProfileBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      showStaffDetail(staff);
    });

    facultyContainer.appendChild(staffCard);
  });
}

// Show staff detail modal
function showStaffDetail(staff) {
  if (!facultyDetailModal) return;

  document.getElementById('facultyDetailMainImage').src = staff.image;
  document.getElementById('facultyDetailName').textContent = staff.name;
  document.getElementById('facultyDetailDesignation').textContent = staff.designation;

  const sections = [
    { id: 'facultyDetailAbout', value: staff.about },
    { id: 'facultyDetailQualification', value: staff.qualification },
    { id: 'facultyDetailExperience', value: staff.experience },
    { id: 'facultyDetailSpecialization', value: staff.specialization },
    { id: 'facultyDetailContact', value: staff.contact }
  ];

  sections.forEach(({ id, value }) => {
    const el = document.getElementById(id);
    if (el && el.closest('.faculty-detail-section')) {
      if (value && value.trim() !== '') {
        el.textContent = value;
        el.closest('.faculty-detail-section').style.display = 'block';
      } else {
        el.closest('.faculty-detail-section').style.display = 'none';
      }
    }
  });

  facultyDetailModal.classList.add('show');
  document.body.style.overflow = 'hidden';
  setTimeout(() => {
    facultyDetailModal.scrollTop = 0;
  }, 10);
}

// Close modal
function closeStaffModal() {
  if (!facultyDetailModal) return;
  facultyDetailModal.classList.remove('show');
  document.body.style.overflow = 'auto';
}
