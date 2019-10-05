 <div class="sticky">
  <nav class="top-bar" data-topbar role="navigation" data-options="sticky_on: large">
   <section class="top-bar-section">
    <!-- Right Nav Section -->
 <!-- Right Nav Section -->
    <ul class="right">
      <?php if (class_exists('woocommerce')) : {republic_wooaccinfo(); } else : get_search_form(); endif; ?>
        
    </ul>
         <!-- Left Nav Section -->
    <ul class="left">
     <?php republic_display_primary_menu();  ?>
    </ul>
    
  </section>
</nav>
</div>
