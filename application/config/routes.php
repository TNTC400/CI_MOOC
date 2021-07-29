<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['login'] = 'Login/index';
$route['userlogin']= 'Login/doLogin';
$route['home'] = 'Home/index';
$route['home/(:num)'] = 'Home/LoadPage/$1';
$route['userlogout'] = 'Logout/doLogout';
$route['signup'] = 'SignUp/index';
$route['usersignup'] = 'SignUp/doSignUp';
$route['forgotpassword'] = 'Login/forgotPassword';
$route['sendtokenchangepassword'] = 'Login/sendTokenChangePassword';
$route['changepassword'] = 'Login/changePassword';
$route['viewmyprofile'] = 'User/viewMyProfile';

// Request manage
$route['requestmanage'] = 'Requestmanage';
$route['request/(:num)'] = 'Requestmanage/ShowPageRequest/$1';
$route['request/request/(:num)'] = 'Requestmanage/Request/$1';

// Borrow statuses
$route['borrowingmanage'] = 'Requestmanage/BorrowingPage';

// Detail of selected book
$route['bookdetail/(:num)'] = 'Book/detail/$1';

// Add new book
$route['addbook'] = 'AddBook/index';
$route['newbook'] = 'AddBook/add';

// Add to existed book
$route['addbook/(:num)'] = 'Book/ShowPageAddExisted/$1';
$route['addbook/addexisted/(:num)'] = 'Book/AddExisted/$1';
$route['deletebook/(:num)'] = 'Book/ShowPageDeleteExisted/$1';
$route['deletebook/delete/(:num)'] = 'Book/Delete/$1';
$route['myrequest'] = 'Requestmanage/UserRequest';

$route['acceptrequest/(:num)'] = 'Requestmanage/AcceptRequest/$1';
$route['bookreturn/(:num)'] = 'Requestmanage/BookReturn/$1';

// Search
$route['booksearch/(:num)/(:any)'] = 'Home/Search/$1';
$route['booksearch/(:num)'] = 'Home/Search/$1';
$route['borrowingsearch/(:num)'] = 'Requestmanage/BorrowingSearch/$1';
$route['requestsearch/(:num)'] = 'Requestmanage/RequestSearch/$1';