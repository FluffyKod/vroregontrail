<?php

// Change login redirect
function custom_login_redirect( $redirect_to, $request, $user ) {
  global $user;
  if( isset( $user->roles ) && is_array( $user->roles ) ) {
    if( in_array( "administrator", $user->roles ) ) {
      return '/admin/dashboard';
    } else {
      return home_url();
    }
  } else {
    return home_url();
  }
}
add_filter("login_redirect", "custom_login_redirect", 10, 3);
