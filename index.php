<?php
    require 'includes/header.php';
?>

<div class="banner"> <img src="images/logo1.png"></div>



<div class="searcher">
<h3>Check for secure connections</h3>


    <div class="wrap">
        <div class="search">
            <input type="text" class="searchTerm" placeholder="Enter domain" id="query">
            <button  class="searchButton" id="check">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>

</div>

<br><br><br><br>
<hr>
<button class="clearer" onclick="clearStack()">Clear Stack</button>
<br>
<div class="parent" id="parent"></div>








<?php
    require 'includes/footer.php';
?>
