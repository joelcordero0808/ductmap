<?php
ob_start();
session_start();
// using ldap bind
$ldaprdn  = $_POST['username'];     // ldap rdn or dn
$ldappass = $_POST['password'];  // associated password

// connect to ldap server
//$ldapconn = ldap_connect("qrldap.qatarairways.com.qa")
$ldapconn = ldap_connect("qrldap.qatarairways.com.qa")
    or die("Could not connect to LDAP server.");

if ($ldapconn) {

    // binding to ldap server
    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

    // verify binding
    if ($ldapbind) {
        echo "Login";
        $_SESSION['username']=$ldaprdn;

    } else {
        echo "Failed";
    }

}


?>