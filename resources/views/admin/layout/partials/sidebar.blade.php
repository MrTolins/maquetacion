
<div id="menu" class="sidebar">
    <svg style="width:48px;height:48px;cursor:pointer; padding:1em;" viewBox="0 0 24 24" href="javascript:void(0)" class="closebtn" onclick="closeMenu()">
        <path fill="currentColor" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
    </svg>

    <div class="sidebar-content">
        <ul>
            <li class="sidebar-item" data-url="{{route("faqs")}}">FAQs</li>
            <li class="sidebar-item" data-url="{{route("faqs_categories")}}">FAQs Categories</li>
            <li class="sidebar-item" data-url="{{route("users")}}">Users</li>
            <li class="sidebar-item" data-url="{{route("clients")}}">Clients</li>
        </ul>
    </div>
    
</div>


<div class="sidebar-title" onclick="openMenu()">

    <span >
        
        <svg style="width:48px;height:48px;cursor:pointer; padding:1em;" viewBox="0 0 24 24" href="javascript:void(0)" class="closebtn" onclick="closeMenu()">
            <path fill="currentColor" d="M3,15H21V13H3V15M3,19H21V17H3V19M3,11H21V9H3V11M3,5V7H21V5H3Z" />
        </svg> 
        
    </span>
</div>



<script>    
    function openMenu() {
      document.getElementById("menu").style.width = "100%";
      document.getElementById("main").style.filter = "blur(10px)";
      document.getElementById("lang-faqs").style.filter = "blur(10px)";
      document.getElementById("table-filter").style.filter = "blur(10px)";
    }
    
    function closeMenu() {
      document.getElementById("menu").style.width = "0%";
      document.getElementById("main").style.filter = "blur(0px)";
      document.getElementById("lang-faqs").style.filter = "blur(0px)";
      document.getElementById("table-filter").style.filter = "blur(0px)";
    }
    
</script>

