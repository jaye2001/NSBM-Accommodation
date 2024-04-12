<?php

class Constants {
    public $DOMAIN = "http://localhost:880/NSBM%20Accommodation";

    private $paths = array(
      // Pages
      'home' => '',
      'login' => 'auth/login.php',
      'signup' => 'auth/signup.php',
      'logout' => 'auth/logout.php',
      'student_search' => 'StudentAcarch.phpcSe',
      'student_dashboard' => 'StudentDashboard.php',
      'warden_ad_view' => 'WardenAdOverview.php',
      'landlord_dashboard' => 'landlordsDashboard.php',
      'admin_dashboard' => 'AdminDashboard.php',
      'warden_approve' => 'WardenApprove.php',
      'warden_dashboard' => 'WardenDashboard.php',
      'student_reservations.php' => 'StudentReservationView.php',
      // API endpoints
      'approve_property' => 'api/property/approveProperty.php',
      'reject_property' => 'api/property/rejectProperty.php',
      // CSS files
      'signup_css' => 'css/signup.css',
      'login_css' => 'css/login.css',
      'main_css' => 'css/main.css',
    );
    
    public function get_link($page) {
        return $this->DOMAIN.'/'.$this->paths[$page];
    }
}

?>