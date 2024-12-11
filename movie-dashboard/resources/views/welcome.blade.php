<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popular Movies Analytics Dashboard</title>
    
    <!-- Add Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

     <!-- Add Poppins Font -->
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>
<body style="font-family: 'Poppins', sans-serif; margin: 0; padding: 0; background: linear-gradient(135deg, #ff7e5f, #feb47b) !important; color: #f5f5f5 !important;">

    <!-- Header Section -->
    <header style="position: fixed; top: 0; left: 0; width: 100%; background: linear-gradient(to right, #000428, #004e92); color: #ffcc00; padding: 15px; text-align: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.7); z-index: 1000;">
        <h1 style="margin: 0; font-size: 32px; text-transform: uppercase; letter-spacing: 2px;">🎬 Popular Movies Dashboard 🎥</h1>
        <p style="margin: 5px 0 0; font-size: 16px; color: #e0e0e0;">Dive into the world of movies and analytics</p>

    <!-- Logout Button -->
    <div style="position: absolute; top: 15px; right: 20px;">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-logout" style="font-size: 16px; padding: 10px 10px; color: white; border-radius: 5px; margin-top: 15px;">
                <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> Logout
            </button>


        </form>
    </div>
    </header>

    <!-- Filter and KPI Section beside each other -->
    <section style="position: fixed; top: 80px; left: 0; width: 100%; display: flex; justify-content: space-between; padding: 30px; gap: 20px; background-color: #151515; border-bottom: 4px solid #ffcc00; z-index: 999;">
        <!-- Left Side: Filter Section -->
        <div style="flex: 1 1 45%; display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
            <form method="GET" action="{{ route('welcome') }}" style="width: 100%; display: flex; gap: 15px; flex-wrap: wrap; justify-content: center;">
                <!-- Genre Filter -->
                <div style="flex: 1 1 150px; max-width: 220px;">
                    <label for="genre-filter" style="font-weight: bold; color: #ffcc00;">Genre:</label>
                    <select id="genre-filter" name="genre" style="width: 100%; padding: 8px; border-radius: 8px; background-color: #252525; color: #fff; border: 2px solid #ffcc00;">
                        <option value="">All Genres</option>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre }}" {{ $defaultGenre == $genre ? 'selected' : '' }}>{{ ucfirst($genre) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Year Filter -->
                <div style="flex: 1 1 150px; max-width: 220px;">
                    <label for="year-filter" style="font-weight: bold; color: #ffcc00;">Year:</label>
                    <select id="year-filter" name="year" style="width: 100%; padding: 8px; border-radius: 8px; background-color: #252525; color: #fff; border: 2px solid #ffcc00;">
                        <option value="">All Years</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $defaultYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Country Filter -->
                <div style="flex: 1 1 150px; max-width: 220px;">
                    <label for="country-filter" style="font-weight: bold; color: #ffcc00;">Country:</label>
                    <select id="country-filter" name="country" style="width: 100%; padding: 8px; border-radius: 8px; background-color: #252525; color: #fff; border: 2px solid #ffcc00;">
                        <option value="">All Countries</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country }}" {{ $defaultCountry == $country ? 'selected' : '' }}>{{ ucfirst($country) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Button -->
                <div style="flex: 1 1 150px; max-width: 220px; display: flex; align-items: center; justify-content: center;">
                    <button type="submit" style="padding: 10px 20px; background-color: #ffcc00; color: #0d0d0d; border: none; border-radius: 8px; font-size: 14px; font-weight: bold; cursor: pointer; transition: background-color 0.3s;">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>



        <div style="flex: 1 1 45%; display: flex; justify-content: space-evenly; padding: 20px; gap: 15px; background-color: #252525; flex-wrap: wrap;">
            
                <!-- Right Side: KPI Section -->
        <!-- Total Movies -->
        <div style="flex: 1 1 200px; max-width: 250px; background-color: #252525; text-align: center; padding: 15px; border-radius: 10px; border: 2px solid #ffcc00;">
            <h3 style="font-size: 18px; color: #ffcc00;">Total Movies</h3>
            <p style="font-size: 24px; font-weight: bold; color: #f5f5f5;">{{ $totalMovies }}</p>
        </div>

        <!-- Average Revenue -->
            <div style="flex: 1 1 200px; max-width: 250px; background-color: #252525; text-align: center; padding: 15px; border-radius: 10px; border: 2px solid #ffcc00;">
                <h3 style="font-size: 18px; color: #ffcc00;">Average Revenue</h3>
                <p style="font-size: 24px; font-weight: bold; color: #f5f5f5;">${{ $averageRevenue }}M</p>
            </div>

            <!-- Average Budget -->
            <div style="flex: 1 1 200px; max-width: 250px; background-color: #252525; text-align: center; padding: 15px; border-radius: 10px; border: 2px solid #ffcc00;">
                <h3 style="font-size: 18px; color: #ffcc00;">Average Budget</h3>
                <p style="font-size: 24px; font-weight: bold; color: #f5f5f5;">${{ $averageBudget }}M</p>
            </div>
        </div>
    </section>
<!-- Movie Posters and Pie Chart Section -->
<section style="display: flex; flex-wrap: nowrap; justify-content: center; padding: 20px; background-color: #0d0d0d; position: relative; margin-top: 300px; overflow: hidden;">
    <!-- Movie Posters Section (Single Row with Duplicated Posters for Infinite Loop) -->
    <div class="movie-posters" style="display: flex; gap: 20px; padding: 0; animation: slideCircle 12s linear infinite; width: max-content;">
        <!-- Duplicate the Posters for Infinite Loop -->
        <div class="poster" style="flex: 0 0 auto; text-align: center; border-radius: 8px; overflow: hidden;">
            <img src="https://images.squarespace-cdn.com/content/v1/5acd17597c93273e08da4786/1547847934765-ZOU5KGSHYT6UVL6O5E5J/Shrek+Poster.png" alt="Movie Poster 1" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>
        <div class="poster" style="flex: 0 0 auto; text-align: center; border-radius: 8px; overflow: hidden;">
            <img src="https://miro.medium.com/v2/resize:fit:1400/1*iQhzIW0ZffqWaTI10ywLsA.jpeg" alt="Movie Poster 2" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>
        <div class="poster" style="flex: 0 0 auto; text-align: center; border-radius: 8px; overflow: hidden;">
            <img src="https://www.washingtonpost.com/graphics/2019/entertainment/oscar-nominees-movie-poster-design/img/black-panther-web.jpg" alt="Movie Poster 3" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>
        <div class="poster" style="flex: 0 0 auto; text-align: center; border-radius: 8px; overflow: hidden;">
            <img src="https://preview.redd.it/what-has-happened-to-movie-posters-v0-veyma8wnnhb81.jpg?width=640&crop=smart&auto=webp&s=3155408077eb1f8e3f8c4566b44e51204bc09ba9" alt="Movie Poster 4" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>
        <div class="poster" style="flex: 0 0 auto; text-align: center; border-radius: 8px; overflow: hidden;">
            <img src="https://i.ebayimg.com/images/g/GccAAOSwD9tjPfM6/s-l1200.jpg" alt="Movie Poster 5" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>
        <div class="poster" style="flex: 0 0 auto; text-align: center; border-radius: 8px; overflow: hidden;">
            <img src="https://th.bing.com/th/id/OIP.XqG7LUbIi8q7DdiRLAliLgHaK5?rs=1&pid=ImgDetMain" alt="Movie Poster 6" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>
        <div class="poster" style="flex: 0 0 auto; text-align: center; border-radius: 8px; overflow: hidden;">
            <img src="https://th.bing.com/th/id/OIP.bHpudLwNaTJB-Rs0MElZnwHaK-?rs=1&pid=ImgDetMain" alt="Movie Poster 7" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>
        <div class="poster" style="flex: 0 0 auto; text-align: center; border-radius: 8px; overflow: hidden;">
            <img src="https://i.pinimg.com/originals/6a/88/c6/6a88c6506d4a323189d0150f2c0739a5.jpg" alt="Movie Poster 8" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>
        <div class="poster" style="flex: 0 0 auto; text-align: center; border-radius: 8px; overflow: hidden;">
            <img src="https://webneel.com/daily/sites/default/files/images/daily/09-2019/2-movie-poster-design-aladdin-disney-glossy-composite.jpg" alt="Movie Poster 9" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>
        <div class="poster" style="flex: 0 0 auto; text-align: center; border-radius: 8px; overflow: hidden;">
            <img src="https://th.bing.com/th/id/OIP.r2zR1kgdSBUAyxKwHPdd0QHaK-?rs=1&pid=ImgDetMain" alt="Movie Poster 10" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>

        <!-- Duplicated Posters for Infinite Loop -->
        <div class="poster" style="flex: 0 0 auto; text-align: center; border-radius: 8px; overflow: hidden;">
            <img src="https://images.squarespace-cdn.com/content/v1/5acd17597c93273e08da4786/1547847934765-ZOU5KGSHYT6UVL6O5E5J/Shrek+Poster.png" alt="Movie Poster 1" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>
        <div class="poster" style="flex: 0 0 auto; text-align: center; border-radius: 8px; overflow: hidden;">
            <img src="https://miro.medium.com/v2/resize:fit:1400/1*iQhzIW0ZffqWaTI10ywLsA.jpeg" alt="Movie Poster 2" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>
        <div class="poster" style="flex: 0 0 auto; text-align: center; border-radius: 8px; overflow: hidden;">
            <img src="https://www.washingtonpost.com/graphics/2019/entertainment/oscar-nominees-movie-poster-design/img/black-panther-web.jpg" alt="Movie Poster 3" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>
        <div class="poster" style="flex: 0 0 auto; text-align: center; border-radius: 8px; overflow: hidden;">
            <img src="https://preview.redd.it/what-has-happened-to-movie-posters-v0-veyma8wnnhb81.jpg?width=640&crop=smart&auto=webp&s=3155408077eb1f8e3f8c4566b44e51204bc09ba9" alt="Movie Poster 4" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>
        <!-- Repeat for all other posters -->
    </div>
</section>

<!-- Add CSS for Animation -->
<style>
    /* Movie Posters Circular Animation */
    .movie-posters {
        display: flex;
        gap: 0;
        padding: 0;
        width: max-content;
        animation: slideCircle 12s linear infinite;
    }

    .poster {
        flex: 0 0 auto;
        text-align: center;
        border-radius: 8px;
        overflow: hidden;
        width: 300px; /* Ensure all posters have the same width */
    }

    /* Keyframes for Circular Animation */
    @keyframes slideCircle {
        0% {
            transform: translateX(0); /* Starting position */
        }
        25% {
            transform: translateX(-300px); /* Move the first poster out */
        }
        50% {
            transform: translateX(-600px); /* Move second poster out */
        }
        75% {
            transform: translateX(-900px); /* Move third poster out */
        }
        100% {
            transform: translateX(0); /* Reset to original position */
        }
    }

    section img {
        transition: transform 0.5s ease-in-out;
    }

    section img:hover {
        transform: scale(1.05); /* Optional, a subtle zoom effect on hover */
    }

    .table-hover tbody tr:hover {
        color: #ffd700; /* Change text color to yellow on hover */
    }

            /* Hover Effect */
    .btn-logout:hover {
    background-color: #007bff; /* New color: blue */
    transform: scale(1.1); /* Slightly enlarge the button */
    transition: all 0.3s ease; /* Smooth transition */
    }
</style>




<!-- KPI and Chart Section with Three Equal-Sized Graphs and Table Below -->
<section style="padding: 30px; background-color: #121212;">
    <!-- Three Graphs in One Line -->
    <div style="display: flex; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
        <!-- Genre Revenue Distribution Pie Chart -->
        <div style="flex: 1 1 32%; background-color: #1e1e1e; text-align: center; padding: 20px; border-radius: 12px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); min-height: 300px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <h3 style="font-size: 18px; color: #ffd700; font-weight: 600; margin: 0 0 15px;">Genre Revenue Distribution</h3>
            <canvas id="revenuePieChart" style="max-width: 100%; height: 200px;"></canvas>
        </div>

    <!-- Average Revenue Line Chart -->
    <div style="flex: 1 1 32%; background-color: #1e1e1e; text-align: center; padding: 20px; border-radius: 12px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); min-height: 300px; display: flex; flex-direction: column; justify-content: flex-start; align-items: center;">
        <h3 style="margin: 0 0 15px; font-size: 20px; color: #ffd700; font-weight: 600;">Average Revenue</h3> <!-- Title at the top -->
        <canvas id="averageRevenueLineChart" style="max-width: 100%; height: 400px; margin-top:54px;"></canvas> <!-- Increased height -->
    </div>

        <!-- Average Budget Chart -->
        <div style="flex: 1 1 32%; background-color: #1e1e1e; text-align: center; padding: 20px; border-radius: 12px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); min-height: 300px; display: flex; flex-direction: column; justify-content: flex-start; align-items: center;">
            <h3 style="margin: 0 0 15px; font-size: 20px; color: #ffd700; font-weight: 600;">Average Budget</h3>
            <canvas id="averageBudgetChart" width="400" height="250" style="max-width: 100%; height: 400px; margin-top:54px;"></canvas>
        </div>
    </div>

    <!-- Top Movies Table Below Graphs -->
    <div style="background-color: #1e1e1e; padding: 20px; border-radius: 12px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); margin-top: 20px;">
        <h4 class="text-center text-warning mb-4" style="font-size: 22px;">Top 20 Highest Revenue Movies</h4>

        <!-- Table -->
<div class="table-responsive" style="overflow-x: auto;">
    <table class="table table-hover table-bordered" style="font-size: 14px;">
        <thead style="background-color: #343a40; color: #ffd700; font-size: 16px; text-align: center;">
            <tr>
                <th>Title</th>
                <th>Release Date</th>
                <th>Popularity</th>
                <th>Rating Average</th>
                <th>Budget</th>
                <th>Revenue</th>
            </tr>
        </thead>

        <tbody style="background-color: #2c2f33; color: #f1f1f1;">
            @foreach ($topMovies as $movie)
                <tr style="border-bottom: 1px solid #444; transition: color 0.3s;">
                    <td>{{ $movie->Original_Title }}</td>
                    <td>{{ \Carbon\Carbon::parse($movie->Release_Date)->format('Y-m-d') }}</td>
                    <td>{{ number_format($movie->Popularity, 2) }}</td>
                    <td>{{ number_format($movie->Rating_average, 2) }}</td>
                    <td>${{ number_format($movie->Budget, 2) }}</td>
                    <td>${{ number_format($movie->Revenue, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

        <!-- Pagination -->
        <nav class="mt-4">
            {{ $topMovies->links('pagination::bootstrap-5') }}
        </nav>
    </div>
</section>




    <!-- JavaScript for Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Revenue Pie Chart with a realistic 3D effect
const revenuePieCtx = document.getElementById('revenuePieChart').getContext('2d');

// Dynamic data passed from the backend
const pieChartData = @json($pieChartData ?? []);

// Extract labels (genres) and data (revenue)
const labels = pieChartData.map(data => data.genre);
const data = pieChartData.map(data => data.revenue);

// List of predefined colors
const colors = ['#ffb6b6', '#ff4c4c', '#b6ffb6', '#4cff4c', '#b6b6ff'];

// Create gradients for each color
const ctx = document.getElementById('revenuePieChart').getContext('2d');
const gradients = colors.map(color => {
    const gradient = ctx.createLinearGradient(0, 0, 0, 150); // Vertical gradient
    gradient.addColorStop(0, color); // Start with the original color
    gradient.addColorStop(1, darkenColor(color, 0.2)); // End with a slightly darker version of the color
    return gradient;
});

// Function to darken a color by a given factor (0.2 means 20% darker)
function darkenColor(color, factor) {
    let r = parseInt(color.slice(1, 3), 16);
    let g = parseInt(color.slice(3, 5), 16);
    let b = parseInt(color.slice(5, 7), 16);

    r = Math.round(r * (1 - factor));
    g = Math.round(g * (1 - factor));
    b = Math.round(b * (1 - factor));

    return `#${(1 << 24 | r << 16 | g << 8 | b).toString(16).slice(1)}`;
}

// Create the pie chart
new Chart(revenuePieCtx, {
    type: 'pie',
    data: {
        labels: labels, // Dynamic genre labels
        datasets: [{
            data: data, // Dynamic revenue data
            backgroundColor: gradients, // Apply dynamic gradients
            borderWidth: 2, // Adjust border width for better visual effect
            borderColor: '#fff', // White border for contrast
            hoverOffset: 10, // Slight hover offset for a more prominent 3D effect
        }]
    },
    options: {
        responsive: true,
        animation: {
            animateScale: true, // Scale animation for 3D effect
            animateRotate: true, // Rotation animation
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        const revenue = tooltipItem.raw.toLocaleString(); // Format revenue as comma-separated
                        return `${tooltipItem.label}: $${revenue}`; // Show genre and revenue
                    }
                }
            },
            legend: {
                position: 'bottom', // Position the legend at the bottom
                labels: {
                    font: {
                        size: 14, // Set the font size for better readability
                        family: 'Arial, sans-serif', // Set a clear font
                        weight: 'bold', // Make the text bold for better visibility
                        color: '#fff', // Set the font color to white
                    },
                    boxWidth: 20, // Make the legend square box slightly bigger
                    padding: 20, // Add space between legend items
                    generateLabels: function(chart) {
                        const data = chart.data;
                        return data.labels.map((label, index) => {
                            return {
                                text: `${label}: $${data.datasets[0].data[index].toLocaleString()}`, // Show genre and revenue
                                fillStyle: data.datasets[0].backgroundColor[index], // Apply the correct color
                                strokeStyle: data.datasets[0].borderColor, // Border color
                                lineWidth: 2, // Legend item border width
                            };
                        });
                    }
                },
                reverse: false, // Reverse the order of legend items (optional)
                labels: {
                    padding: 10, // Space between legend items
                }
            }
        },
        elements: {
            arc: {
                borderWidth: 2, // Adjust border width for better depth
                borderColor: '#fff', // White border for slices
                backgroundColor: (context) => {
                    const index = context.dataIndex;
                    return gradients[index]; // Match gradient to the slice
                }
            }
        },
        layout: {
            padding: {
                top: 30,  // Adjust top padding for better placement
                bottom: 80,  // Add space at the bottom for the legend
            }
        },
        cutout: '50%', // Adjust the inner cutout of the pie to give a "donut" effect (larger pie size)
    }
});

    

// Average Revenue Line Chart
const averageRevenueCtx = document.getElementById('averageRevenueLineChart').getContext('2d');
const averageRevenueChartData = @json($averageRevenueChartData);
const years = @json($averageRevenueYears);  // List of years
const genres = @json($genres);  // List of genres

const datasetsRevenue = genres.map((genre, index) => {
    return {
        label: genre,
        data: years.map(year => {
            const yearData = averageRevenueChartData[year] || [];
            const genreData = yearData.find(item => item.genre === genre);
            return genreData ? genreData.average_revenue : 0; // Default to 0 if no data for this year
        }),
        borderColor: `hsl(${index * 36}, 100%, 50%)`,
        backgroundColor: `hsla(${index * 36}, 100%, 75%, 0.2)`,
        fill: true,
        borderWidth: 3,
        tension: 0,  // Set to 0 to make the line straight (linear)
    };
});

new Chart(averageRevenueCtx, {
    type: 'line',
    data: {
        labels: years,
        datasets: datasetsRevenue
    },
    options: {
        responsive: true,
        animation: { duration: 1000, easing: 'easeOutBounce' },
        scales: {
            y: {
                ticks: { callback: function(value) { return '$' + value.toLocaleString(); } }
            }
        }
    }
});


// Average Budget Bar Chart
const averageBudgetCtx = document.getElementById('averageBudgetChart').getContext('2d');
const averageBudgetChartData = @json($averageBudgetChartData);

const datasetsBudget = genres.map((genre, index) => {
    return {
        label: genre,
        data: years.map(year => {
            const yearData = averageBudgetChartData[year] || [];
            const genreData = yearData.find(item => item.genre === genre);
            return genreData ? genreData.average_budget : 0; // Default to 0 if no data for this year
        }),
        backgroundColor: `hsl(${index * 36}, 100%, 75%)`,
        borderColor: `hsl(${index * 36}, 100%, 50%)`,
        borderWidth: 1,
    };
});

new Chart(averageBudgetCtx, {
    type: 'bar',
    data: {
        labels: years,
        datasets: datasetsBudget
    },
    options: {
        responsive: true,
        animation: { duration: 1000, easing: 'easeOutBounce' },
        scales: {
            x: { 
                title: { display: true, text: 'Year' }
            },
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Average Budget (in millions)' },
                ticks: {
                    callback: function(value) {
                        return '$' + (value / 1000000).toLocaleString(); // Format as million dollars
                    }
                }
            }
        }
    }
});
</script>

<!-- Bootstrap JS and dependencies (optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


