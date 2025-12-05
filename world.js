document.addEventListener('DOMContentLoaded', function () {

    const countryInput = document.getElementById('country');
    const resultDiv = document.getElementById('result');

    const countryBtn = document.getElementById('lookup');          
    const citiesBtn  = document.getElementById('lookup-cities');   

    // Helper function to send AJAX request
    function makeRequest(mode) {
        const country = countryInput.value.trim();
        let url = 'world.php';
        const params = [];

        if (country !== '') {
            params.push('country=' + encodeURIComponent(country));
        }

        if (mode === 'cities') {
            // tell PHP we want city info
            params.push('lookup=cities');
        }

        if (params.length > 0) {
            url += '?' + params.join('&');
        }

        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                resultDiv.innerHTML = xhr.responseText;
            } else {
                resultDiv.innerHTML = 'Error: ' + xhr.status;
            }
        };

        xhr.onerror = function () {
            resultDiv.innerHTML = 'Network Error. Could not reach the server.';
        };

        xhr.send();
    }

    // When "Lookup Country" is clicked
    countryBtn.addEventListener('click', function () {
        makeRequest('country');
    });

    // When "Lookup Cities" is clicked
    citiesBtn.addEventListener('click', function () {
        makeRequest('cities');
    });

});
