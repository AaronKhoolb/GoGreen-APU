<!-- 
    Author: Khoo Lay Bin
    Date: 2026-1-5
    Description: This search bar will include into student desktop nav for event name searching
-->

<form action="/GoGreen-APU/frontend/student/explore/index.php" method="GET" class="desktop-search-bar">
    <input type="text" name="search" id="desktop-search-input" class="desktop-search-input" placeholder="Search events...">


    <button class="desktop-clear-btn clear-btn" type="button" data-target="desktop-search-input">
        <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
    </button>


    <button class="desktop-search-btn" type="submit">
        <img src="/GoGreen-APU/assets/icons/navigation/search.svg" alt="Search" class="search-icon">
        
        <span class="search-text">Search</span>
    </button>
</form>