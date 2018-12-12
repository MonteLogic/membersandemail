<?php
  // Add Scripts
  function me_add_scripts(){
    // Add Main CSS
    wp_enqueue_style('me-main-style', plugins_url(). '/index/css/style.css');
    // Add Main JS
    wp_enqueue_script('me-main-script', plugins_url(). '/index/js/main.js');

    // Add Google Script
    wp_register_script('google', 'https://apis.google.com/js/platform.js');
    wp_enqueue_script('google');
  }

  add_action('wp_enqueue_scripts', 'me_add_scripts');
