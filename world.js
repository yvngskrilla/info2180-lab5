document.addEventListener('DOMContentLoaded', function(){
    const lookupBtn = document.getElementById('lookup');
    const resultDiv = document.getElementById('result');

    lookupBtn.addEventListener('click', function(){
        const country = document.getElementById('country').value.trim();

        const xhr = new XMLHttpRequest();

        let url = 'world.php'
        if(country !== '') {
            url += '?country=' + encodeURIComponent(country);
        }

        
        xhr.open('GET', url, true);

        xhr.onload = function() {
            if(xhr.status === 200){
                resultDiv.innerHTML = xhr.responseText;
            }
            else{
                resultDiv.innerHTML = 'Error: ' + xhr.status;
            }
        };

        xhr.onerror = function(){
            resultDiv.innerHTML = 'Network Error. Could not reach the server.';
        };
        xhr.send();
    });
});