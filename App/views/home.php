<?php
    loadComponent("header");
    loadComponent("nav");
    loadComponent("showcase");
    loadComponent("job_listing",["listings" => $listings]);
    loadComponent("bottom_banner");
    loadComponent("footer");
    
?>