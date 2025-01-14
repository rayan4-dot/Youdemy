


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Udemy Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    /* Custom styles for Dark and Light mode */
    body {
      transition: background-color 0.3s ease, color 0.3s ease;
    }
/* Sidebar styling */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 270px;
    height: 100%;
    background-color: #38b2ac;
    color: white;
    padding-top: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
  }

  .main-content {
    margin-left: 270px;
    padding: 30px;
    transition: margin-left 0.3s ease;
  }

  @media (max-width: 768px) {
    .sidebar {
      width: 200px;
    }

    .main-content {
      margin-left: 200px;
    }
  }

  @media (max-width: 640px) {
    .sidebar {
      position: relative;
      width: 100%;
      height: auto;
    }

    .main-content {
      margin-left: 0;
    }
  }
    /* Light Mode */
    .light-mode {
      background-color: #fafafa;
      color: #2d3748;
    }

    .light-mode .sidebar {
      background-color:rgb(188, 31, 113); /* Light Green Sidebar */
    }

    .light-mode .card {
      background-color: #ffffff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .light-mode .card-header {
      background-color: #f1f5f9;
    }

    .light-mode .stat-card {
      background-color: #ffffff;
    }

    /* Dark Mode */
    .dark-mode {
      background-color: #1a202c;
      color: #edf2f7;
    }

    .dark-mode .sidebar {
      background-color: #6b46c1; /* Dark Purple Sidebar */
    }

    .dark-mode .card {
      background-color: #2d3748;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .dark-mode .card-header {
      background-color: #4a5568;
    }

    .dark-mode .stat-card {
      background-color: #4a5568;
    }

    /* Sidebar links */
    .sidebar a {
      text-decoration: none;
      color: #cbd5e0;
      font-size: 18px;
      display: block;
      padding: 15px;
      margin-bottom: 10px;
      border-radius: 17px;
      transition: background-color 0.3s ease;
    }

    .sidebar a:hover {
      background-color: #4a5568;
      color: white;
    }

    .sidebar .active {
      background-color: #38b2ac;
      color: white;
    }

    /* Main content */
    .main-content {
      margin-left: 270px;
      padding: 30px;
      transition: background-color 0.3s ease;
    }

    /* Stat cards */
    .stat-card {
      border-radius: 8px;
      padding: 2rem;
      margin-bottom: 1.5rem;
      text-align: center;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .stat-card h3 {
      font-size: 2rem;
      font-weight: 600;
    }

    .stat-card p {
      font-size: 1.125rem;
      color: #4a5568;
    }

    .chart-container {
      position: relative;
      height: 400px;
      width: 100%;
    }

    /* Toggle button icon styles */
    .toggle-btn {
      cursor: pointer;
    }

    /* Responsive layout */
    @media (max-width: 768px) {
      .sidebar {
        width: 200px;
      }

      .main-content {
        margin-left: 0;
        padding: 15px;
      }
    }


    /* Adjusted styles for dark mode */
.dark-mode {
  background-color: #1a202c;
  color: #f7fafc; /* Light text for dark mode */
}

.dark-mode a {
  color: #90cdf4; /* Light blue for links in dark mode */
}

.dark-mode a:hover {
  color: #ffffff; /* Bright white on hover */
}

.dark-mode .stat-card h3,
.dark-mode .stat-card p {
  color: #f7fafc; /* Ensure stat card text is visible */
}

.dark-mode .card-header {
  background-color: #4a5568; /* Contrast for card headers */
  color: #e2e8f0; /* Light header text */
}

.dark-mode .sidebar a {
  color: #cbd5e0; /* Lighter text for sidebar links */
}

.dark-mode .sidebar a:hover {
  background-color: #4a5568; /* Subtle hover effect */
}

  </style>

  
</head>

<body class="light-mode">

  <!-- Sidebar -->
  <div class="sidebar">
    <h2 class="text-white text-3xl font-bold text-center mb-12">Admin Dashboard</h2>
    <a href="#home" class="active">Home</a>
    <a href="#validate-accounts">Validation des Comptes Enseignants</a>
    <a href="#user-management">Gestion des étudiants</a>
    <a href="#content-management">Gestion des Contenus</a>
    <a href="#bulk-tags">Tags</a>
    </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Welcome Back, Admin</h1>
      <button class="bg-blue-500 text-white py-2 px-6 rounded-lg">Logout</button>
    </div>

    <!-- Dark Mode Toggle Button -->
    <div class="mb-6 flex justify-end">
      <button onclick="toggleDarkMode()" class="bg-gray-200 p-2 rounded-full dark:bg-gray-700">
        <svg id="dark-light-toggle" class="toggle-btn text-gray-600 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
          <path id="sun-icon" class="sun" d="M12 4.5A7.5 7.5 0 1 1 4.5 12 7.5 7.5 0 0 1 12 4.5ZM12 2a9.5 9.5 0 1 0 9.5 9.5 9.5 9.5 0 0 0-9.5-9.5Zm0 13a5 5 0 1 1-5-5 5 5 0 0 1 5 5Z" />
          <path id="moon-icon" class="moon hidden" d="M12 4c-4.418 0-8 3.582-8 8 0 4.418 3.582 8 8 8s8-3.582 8-8c0-4.418-3.582-8-8-8zM12 14c-1.5 0-2.88-.5-4-1.36A5.983 5.983 0 0 1 12 7c2.05 0 3.98 1.2 5 2.86C14.88 13.5 13.5 14 12 14z" />
        </svg>
      </button>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-12">
      <div class="stat-card">
        <h3>Total Cours</h3>
        <p>1,320</p>
      </div>
      <div class="stat-card">
        <h3>Enseignants Actifs</h3>
        <p>350</p>
      </div>
      <div class="stat-card">
        <h3>étudiants Inscrits</h3>
        <p>15,000</p>
      </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Cours by Category Chart -->
      <div class="card">
        <div class="card-header">Répartition des Cours par Catégorie</div>
        <div class="chart-container">
          <canvas id="categoryChart"></canvas>
        </div>
      </div>

      <!-- Top 3 Enseignants Chart -->
      <div class="card">
        <div class="card-header">Top 3 des Enseignants</div>
        <div class="chart-container">
          <canvas id="teachersChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    // Dark mode toggle
    function toggleDarkMode() {
      const body = document.body;
      const sunIcon = document.querySelector(".sun");
      const moonIcon = document.querySelector(".moon");

      body.classList.toggle("dark-mode");
      body.classList.toggle("light-mode");

      if (body.classList.contains("dark-mode")) {
        sunIcon.classList.add("hidden");
        moonIcon.classList.remove("hidden");
      } else {
        moonIcon.classList.add("hidden");
        sunIcon.classList.remove("hidden");
      }
    }

    // Cours by Category Chart
    const ctxCategory = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(ctxCategory, {
      type: 'pie',
      data: {
        labels: ['Technology', 'Business', 'Arts', 'Language'],
        datasets: [{
          label: 'Cours par Catégorie',
          data: [500, 320, 200, 300],
          backgroundColor: ['#38b2ac', '#48bb78', '#ed64a6', '#ed8936'],
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
        },
      },
    });

    // Top 3 Enseignants Chart
    const ctxTeachers = document.getElementById('teachersChart').getContext('2d');
    const teachersChart = new Chart(ctxTeachers, {
      type: 'bar',
      data: {
        labels: ['John Doe', 'Jane Smith', 'Mike Johnson'],
        datasets: [{
          label: 'Top 3 Enseignants (Students)',
          data: [10000, 8500, 7000],
          backgroundColor: '#63b3ed',
          borderColor: '#63b3ed',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 2000
            }
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      },
    });
  </script>
</body>

</html>
