<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Geolocation & IP Access Control</title>
  <!-- include the security.js file to run security checkups -->
  <script>
    // Counter to keep track of how many times geolocation permission is denied
    let deniedAttempts = 0;

    // Array of allowed IP addresses for exception cases
    const allowedIPs = ["102.0.16.202", "203.0.113.42", "198.51.100.7", "105.160.97.66"];

    /**
     * Function to enforce geolocation access
     * - Checks if the user is within a 50km radius of the allowed location
     * - If outside the allowed area, checks if the user's IP address is in the allowed IPs list
     * - Redirects to 'backup.php' if within the allowed area or if the IP is allowed
     * - Redirects to 'error' otherwise
     * - Prompts the user twice if geolocation permission is denied before redirecting
     */
    function enforceGeolocation() {
      const allowedLatitude = -1.2833; // Allowed latitude (Example: Nairobi)
      const allowedLongitude = 36.8167; // Allowed longitude (Example: Nairobi)
      const allowedRadius = 50000; // Allowed radius in meters (10km)

      navigator.geolocation.getCurrentPosition(
        (position) => {
          // Retrieve user's current latitude and longitude
          const {
            latitude,
            longitude
          } = position.coords;

          // Calculate distance from allowed location
          const distance = calculateDistance(latitude, longitude, allowedLatitude, allowedLongitude);

          // Check if user is within the allowed radius
          if (distance > allowedRadius) {
            // If user is outside the allowed location, check if their IP is allowed
            fetchUserIP().then(userIP => {
              if (allowedIPs.includes(userIP)) {
                window.location.href = "./backup/run_backup.php"; // Redirect to backup page
              } else {
                alert("Access Denied: You are outside the allowed location and your IP is not on the allowed list.");
                window.location.href = "error"; // Redirect to access denied page
              }
            });
          } else {
            window.location.href = "./backup/run_backup.php"; // Redirect to backup page
          }
        },
        (error) => {
          // Increment denied attempts counter
          deniedAttempts++;

          if (deniedAttempts < 2) {
            // Prompt the user again if permission is denied once
            alert("Geolocation permission denied. Please allow location access to continue.");
            enforceGeolocation(); // Retry enforcing geolocation
          } else {
            // Redirect after two denials
            alert("Geolocation permission denied twice. Access Denied.");
            window.location.href = "error";
          }
        }
      );
    }

    /**
     * Function to calculate the distance between two geographic coordinates
     * Uses the Haversine formula to calculate the great-circle distance
     * @param {number} lat1 - Latitude of the first point
     * @param {number} lon1 - Longitude of the first point
     * @param {number} lat2 - Latitude of the second point
     * @param {number} lon2 - Longitude of the second point
     * @returns {number} Distance in meters
     */
    function calculateDistance(lat1, lon1, lat2, lon2) {
      const R = 6371000; // Earth's radius in meters
      const dLat = ((lat2 - lat1) * Math.PI) / 180;
      const dLon = ((lon2 - lon1) * Math.PI) / 180;
      const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos((lat1 * Math.PI) / 180) * Math.cos((lat2 * Math.PI) / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
      return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    /**
     * Function to fetch the user's IP address
     * This function makes a request to an external IP API service to retrieve the user's IP
     * @returns {Promise<string>} A promise that resolves with the user's IP address
     */
    function fetchUserIP() {
      return fetch('https://api64.ipify.org?format=json')
        .then(response => response.json())
        .then(data => data.ip)
        .catch(error => {
          console.error("Error fetching IP:", error);
          return "";
        });
    }

    // Execute geolocation enforcement when the page loads
    window.onload = enforceGeolocation;
  </script>

</head>

<body>
  <h2>Geolocation & IP Access Control</h2>
  <p>Please allow location access to proceed.</p>
</body>

</html>