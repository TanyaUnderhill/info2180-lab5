// Wait for the HTML document to fully load
document.addEventListener("DOMContentLoaded", function () {
    
    // Get the elements from the page
    var lookupBtn = document.getElementById("lookup");
    var lookupCitiesBtn = document.getElementById("lookup-cities");
    var countryInput = document.getElementById("country");
    var resultDiv = document.getElementById("result");

    // Function to handle the AJAX request
    function makeRequest(url) {
        var xhttp = new XMLHttpRequest();
        
        xhttp.onreadystatechange = function() {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    // Success: put the HTML table into the result div
                    resultDiv.innerHTML = this.responseText;
                } else {
                    // Error: show the status code
                    resultDiv.innerHTML = "<p style='color:red;'>Error: Could not fetch data (Status " + this.status + ")</p>";
                }
            }
        };
        
        xhttp.open("GET", url, true);
        xhttp.send();
    }

    // 1. Listen for clicks on the "Lookup" button
    lookupBtn.addEventListener("click", function () {
        var country = encodeURIComponent(countryInput.value.trim());
        var url = "world.php?country=" + country;
        makeRequest(url);
    });

    // 2. Listen for clicks on the "Lookup Cities" button
    if (lookupCitiesBtn) {
        lookupCitiesBtn.addEventListener("click", function () {
            var country = encodeURIComponent(countryInput.value.trim());
            var url = "world.php?country=" + country + "&lookup=cities";
            makeRequest(url);
        });
    }
});