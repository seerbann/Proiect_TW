<link rel="stylesheet" href="../common/styles.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<nav>
    <div class="logo" id="logo">
        <a href="#" class="logo" onclick="loadPage('/Proiect_TW/src/homePage')">AutoPark Smart Explorer</a>
    </div>
    <div class="nav-links" id="navLinks">
        <span class="material-symbols-outlined" onclick="hideMenu()">
            close
        </span>

        <ul>
            <li><a href="#" onclick="loadPage('/Proiect_TW/src/homePage/'); return false;">Home</a></li>
            <li><a href="#" onclick="loadPage('/Proiect_TW/src/csvExplorer'); return false;">CSV Explorer</a></li>
            <li><a href="#" onclick="loadPage('/Proiect_TW/src/login'); return false;">Admin</a></li>
            <li><a href="#" onclick="loadPage('/Proiect_TW/src/about'); return false;">About</a></li>
        </ul>
    </div>
    <span class="material-symbols-outlined" onclick="showMenu()">
        menu
    </span>
</nav>
<script>
    var navLinks = document.getElementById("navLinks");

    function showMenu() {
        navLinks.style.right = "0";
    }

    function hideMenu() {
        navLinks.style.right = "-200px";
    }


    /* 
    The loadPage function uses AJAX to fetch content from the server and inject it into the current page
     without a full page reload. This makes your web application more dynamic and responsive to user interactions.
    */
    function loadPage(pageUrl) {
        if (pageUrl.endsWith('/')) {
            pageUrl = pageUrl.slice(0, -1);
        }
        //creating the object
        const xhr = new XMLHttpRequest();
        //config the request
        xhr.open('GET', pageUrl, true); //true means async
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('content').innerHTML = xhr.responseText; //the content of the element with ID content is replaced with the response text
                history.pushState({
                    page: pageUrl
                }, '', pageUrl); // Update the URL in the browser's address bar
            } else {
                console.error('Error loading page: ' + xhr.status);
            }
        };
        xhr.send(); //This sends the request to the server.
    }

    // Handle back and forward navigation
    window.addEventListener('popstate', function(event) {
        if (event.state && event.state.page) {
            loadPage(event.state.page);
        } else {
            // Fallback to home page or initial page load
            loadPage('/Proiect_TW/src/homePage');
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Load the initial page based on the URL
        const initialPage = location.pathname === '/Proiect_TW/src/' ? '/Proiect_TW/src/homePage' : location.pathname;
        loadPage(initialPage);
    });
</script>