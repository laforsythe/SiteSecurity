<?php
    require 'includes/header.php';
?>



<div id="mySidepanel" class="sidepanel">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
    <!-- <a href="#">Favorited</a> -->
        <a href="tips.php">Staying Safe on the web</a>
        <a href="about.php">About Us</a>
</div>

<button class="openbtn" onclick="openNav()">☰</button>

<div class="searcher">
<h3>Check Domain <br> for SSL Certification</h3>


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
