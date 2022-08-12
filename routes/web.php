<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return 'Cleared';
});

Route::get('/registration', 'MembersController@registrationView')->middleware(['App\Http\Middleware\CheckValidAdminAuth', 'useraccess:registration.view']);

Route::group(['prefix' => '/res', 'middleware' => ['App\Http\Middleware\CheckValidAdminAuth', 'useraccess:registration.view']], function () {
    Route::post('/registration', 'MembersController@registrationSave')->name('res.guest.play.registration')->middleware('useraccess:registration.store');
    Route::post('/regNewMember', 'MembersController@regNewMember')->middleware('useraccess:registration.store');
    Route::post('/saveTheNewGuest', 'MembersController@saveTheNewGuest')->middleware('useraccess:registration.store');
    Route::post('/registerRegList', 'MembersController@registerRegList')->middleware('useraccess:registration.store');
    Route::get('/findMembers', 'MembersController@searchMembers');
    Route::get('/getToList', 'MembersController@getToList');
    Route::get('/gustRegFormInReg', 'MembersController@gustRegFormInReg');
});
Route::get('/auth', function () {
    return view('login_occgolf');
});
Route::post('auth/login', 'AuthLoginForOccGolf@authLoginForOccGolf');

    Route::get('/test-page', 'AdminController@testPage');
Route::group(['middleware' => ['App\Http\Middleware\CheckValidAdminAuth']], function () {

    Route::post('/res/createNewMember', 'MembersController@createNewMember')->middleware('useraccess:member.add');
    Route::post('/res/createClub', 'MembersController@createClub')->middleware('useraccess:club.view');

    Route::get('/userlogout', 'AuthLoginForOccGolf@authlogoutuser');

    Route::get('/page/newMemberForm', 'GetAjaxPageController@addNewMember');
    Route::get('/page/addNewClubForm', 'GetAjaxPageController@addNewClubForm');
    Route::get('/page/help', 'GetAjaxPageController@helps');
    Route::get('/page/addnew', 'GetAjaxPageController@getAddNew');

    Route::get('/', 'AdminController@adminpage')->name('admin.home');
    Route::get('/admin', 'AdminController@adminpage')->name('admin.home');

    Route::get('/report', 'AdminController@reportdata');
    Route::get('admin/report/now', 'AdminController@nowreport')->middleware('useraccess:now.view');
    Route::get('admin/report/today', 'AdminController@todayreport')->middleware('useraccess:today.view');
    Route::get('admin/report/month', 'AdminController@month')->middleware('useraccess:month.view');
    Route::get('admin/report/week', 'AdminController@week')->middleware('useraccess:week.view');
    Route::get('/member/add', 'AdminController@member')->name('member.add.view')->middleware('useraccess:member.add');
    Route::get('/member/club', 'AdminController@club')->middleware('useraccess:club.view');
    Route::get('/member/upcoming-birthdays', 'AdminController@upcomingBirthDay')->name('member.upcomingbirthday')->middleware('useraccess:birthday.view');

    Route::get('/report/reportmember', 'AdminController@reportmember');
    Route::post('/singleprint', 'AdminController@singleprint')->name('singleprint')->middleware('useraccess:search.view');

    /* Guest Play */
    // Route::post('/guest-play/member/{memberId}/add', 'GuestPlayController@registerGuest');
    // Route::get('/guest-play/find/member', 'GuestPlayController@findMember')->name('guestplay.find.member');
    // Route::post('/guest-play/find/member', 'GuestPlayController@find_replay_edit_member');
    Route::get('/guest-play/add', 'GuestPlayController@registerGuestView')->name('guestplay.register')->middleware('useraccess:guest.play.view');
    Route::post('/guest-play/add', 'GuestPlayController@registerGuest')->middleware('useraccess:guest.play.store');
    Route::post('/guest-play/play-now', 'GuestPlayController@playNow')->name('guestplay.play.now')->middleware('useraccess:guest.play.store');
    Route::post('/guest-play/delete', 'GuestPlayController@deletePreRegistration')->name('guestplay.delete')->middleware('useraccess:guest.play.store');
    Route::post('/guest-play/edit/view', 'GuestPlayController@guestPlayEditView')->name('guest.play.edit')->middleware('useraccess:guest.play.view');
    Route::post('/guest-play/edit/update', 'GuestPlayController@registerGuestUpdate')->name('guest.play.update')->middleware('useraccess:guest.play.view');

    /* Sponsor Ticket */
    // Route::get('/sponsor-ticket', 'SponsorTicketController@ticketsView')->name('sponsor.ticket.view')->middleware('useraccess:sponsor.ticket.view');

    Route::get('/report/guest', 'AdminController@guestreport')->middleware('useraccess:guest.report.view');
    Route::get('/report/admember', 'AdminController@admember');
    Route::post('/add_memberdata', 'AdminController@addmemberdata')->name('add_memberdata');
    Route::post('/check_member', 'AdminController@check_member')->name('check_member');
    Route::get('/report/activity', 'AdminController@activity');
    Route::post('/report/activityadd', 'AdminController@addactivity');
    Route::post('/report/findinfromation', 'AdminController@findinformation');
    Route::get('/report/findinfromation', 'AdminController@findinformation');
    Route::post('/report/clubadd', 'AdminController@addclub')->name('clubadd');
    Route::post('/report/findgusthcp', 'AdminController@addclub');
    Route::get('/report/editmember', 'AdminController@editmember');
    Route::post('/report/findclub', 'AdminController@findclubmember');
    Route::get('/member/find/edit_member', 'AdminController@editreportmember');
    Route::post('/report/find_replay_edit_member', 'AdminController@find_replay_edit_member');
    
    Route::post('/report/find_replay_delete_member', 'AdminController@report_deletemember');
    Route::post('/report/find_replay_delete_club', 'AdminController@report_deleteclub');
    Route::post('/report/find_edit_replay_member', 'AdminController@report_find_edit_replay_member');
    Route::post('/report/find_edit_active', 'AdminController@activemember');
    Route::post('/report/todaylest_and_next', 'AdminController@todaylest_and_next');
    Route::post('/report/editnameclubname_replay_member', 'AdminController@edit_cludupdate_membername');

    // Yukenthan Editing.
    Route::get('report/search', 'AdminController@reportpage')->name('reportpage')->middleware('useraccess:search.view');

    Route::post('report/getdatareportpage', 'AdminController@getdatareportpage')->name('getdatareportpage')->middleware('useraccess:search.view');

    //member edit yuken
    Route::get('edit/{id}', 'AdminController@memberedits')->name('memberedits')->middleware('useraccess:member.edit');
    Route::post('/edit', 'AdminController@memberupdatess')->name('memberupdatess')->middleware('useraccess:member.edit');
    Route::get('member-profile/{id}', 'AdminController@memberProfile')->name('member.profile')->middleware('useraccess:member.edit');
    Route::get('member-pdf/{id}', 'AdminController@memberPdf')->name('member.pdf')->middleware('useraccess:member.edit');

    Route::get('member/member_info', 'AdminController@memberinfo')->name('memberinfo');
    //print
    Route::post('print', 'AdminController@printdetails')->name('printdetails')->middleware('useraccess:search.view');

    Route::post('databledata', 'AdminController@databledata')->name('databledata')->middleware('useraccess:search.view');

    Route::get('/exportdata', 'AdminController@exportdata')->name('exportdata')->middleware('useraccess:search.view');

    //new search design teeplay

    Route::get('/report_search', 'AdminController@report_search')->name('report_search')->middleware('useraccess:search.view');

    Route::post('/report_search_get_data', 'AdminController@report_search_get_data')->name('report_search_get_data')->middleware('useraccess:search.view');
    // End of teenplay search
    // search
    Route::get('/search', 'AdminController@search')->name('search');

    Route::get('/filter', 'AdminController@filter')->name('filter');

    Route::post('/importex', 'AdminController@importex')->name('importex');

    Route::post('/getspecific', 'AdminController@getspecific')->name('getspecific');

    //exportdata_fileds
    Route::post('/exportdata_fileds', 'AdminController@exportdata_fileds')->name('exportdata_fileds');


    // execel update filde from excel csv
    Route::get('/expertcsv', 'AdminController@expertcsv')->name('expertcsv')->middleware('useraccess:search.view');

    // execel update filde from excel csv
    Route::get('/experthcpcsv', 'AdminController@experthcpcsv')->name('experthcpcsv')->middleware('useraccess:search.view');


    // Message Sending SMS
    Route::get('/sending-sms', 'SendSmsController@sendSMSView')->name('send.sms');
    Route::post('/sending-sms', 'SendSmsController@sendSMS');

    //Ticketinf
    Route::get('/ticket', 'AdminController@ticket')->name('ticket')->middleware('useraccess:ticket.view');
    Route::get('/add/{id}', 'AdminController@add_ticket')->name('add_ticket')->middleware('useraccess:ticket.view');
    Route::post('/search_ticket_member', 'AdminController@search_ticket_member')->name('search_ticket_member')->middleware('useraccess:ticket.view');
    Route::post('/ticket_save', 'AdminController@ticket_save')->name('ticket_save')->middleware('useraccess:ticket.view');
    Route::post('/ticket_change_status', 'AdminController@ticket_change_status')->name('ticket_change_status')->middleware('useraccess:ticket.view');
    Route::get('/purchases', 'AdminController@purchases')->name('purchases')->middleware('useraccess:purchase.view');

    Route::get('/user-stats', 'AdminController@memberUserStats')->name('user.stats')->middleware('useraccess:user.stats.view');

    /* Save News Informations */
    Route::get('/news-info', 'AdminController@newsInfo')->name('news.info')->middleware('useraccess:news.view');
    Route::post('/news-info/{id}', 'AdminController@saveNewsInfo')->name('news.info.save')->middleware('useraccess:news.view');

   // Route::GET('/insertFerry', 'AdminController@insertFerry');

    Route::get('/tracking', 'MembersController@tracking');
    Route::get('/test-message', 'GuestPlayController@sendTestMessage')->name('send.test.sms');
});

/* Admin and App Validation need to be done */
Route::post('/report/autocomplete-member-search', 'AdminController@autocomplete_member')->name('autocomplete.member.search');
Route::post('/report/autocomplete-club-search', 'AdminController@autocomplete_club')->name('autocomplete.club.search');

/* New Member Signup */
Route::get('/member-sign-up/{reference}', 'AdminController@newMemberSignupView')->name('new.member.signup.view');
Route::post('/member-sign-up/{reference}', 'AdminController@newMemberSignup');

Route::get('adminlogout', 'AuthLoginForOccGolf@authLogoutForOccGolf')->name('adminuser.logout');

// hcp reg get
Route::post('/hcpregget', 'AdminController@gustRegFormInReg')->name('hcpregget');

// round check
Route::post('/round_played_check', 'AdminController@round_played_check')->name('round_played_check');

//HCP Save modal
Route::post('/hcp_save', 'AdminController@hcp_save')->name('hcp_save');

//HCP Reset
Route::post('/hcp_reset', 'AdminController@hcp_reset')->name('hcp_reset');

//HCP Calculation
Route::post('/hcp_calcuation', 'AdminController@hcp_calcuation')->name('hcp_calcuation');

// Single label print
Route::post('/single_print', 'AdminController@single_print')->name('single_print');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['App\Http\Middleware\AppMiddleware']], function () {
    Route::get('/app', 'MembersController@app')->name('app');
    Route::post('app/change-profile-img', 'MembersController@uploadMemberImage')->name('change.profile.image');
    // Route::post('/app', 'MembersController@validate_mobile')->name('validate_mobile');
    Route::post('/app/{type?}', 'MembersController@validate_otp')->name('validate_otp');
    Route::post('/multi', 'AdminController@multi')->name('multi');
    Route::post('/app1', 'MembersController@hcp_manuval_update')->name('hcp_manuval_update');

    Route::get('/app/members', 'MembersController@registerRound')->name('register.round');
    Route::get('/app/gustRegFormInReg', 'MembersController@appGustRegFormInReg')->name('gustRegFormInReg');
    Route::post('/app/regNewMember', 'MembersController@regNewMember')->name('regNewMember');
    Route::post('/app/new-guest/save', 'MembersController@appSaveTheNewGuest')->name('saveTheNewGuest');
    Route::post('/app/register/reg-list', 'MembersController@appRegisterRegList')->name('registerRegList');
    Route::get('/app/log/out', 'AuthLoginForOccGolf@applogout')->name('applogout');

    Route::post('app/guest-play/register', 'GuestPlayController@registerGuestApp')->name('app.guest.play.register');

    Route::post('/sponser-ticket/transfer', 'SponsorTicketController@appTransferTicket')->name('sponsor.ticket.transfer');

});

Route::get('/{type}/{reference}', 'GuestPlayController@showTicket')->name('showticket');
Route::post('/{type}/{reference}', 'GuestPlayController@ticket_change_status');

Route::get('app/get-profile-img/{img}', 'MembersController@getMemberImage')->name('get.profile.image');


Route::post('/single_print_selected_data', 'AdminController@single_print_selected_data')->name('single_print_selected_data');


Route::get('/campaign', 'AdminController@campaign');
Route::get('/additional-info', 'AdminController@additionalInfo');


Route::post('/update_hcp_status', 'MembersController@update_hcp_status')->name('update_hcp_status');

Route::post('/ticket_change_status_app', 'AdminController@ticket_change_status')->name('ticket_change_status_app');
Route::get('/export', 'BackupController@export')->name('backup.excel.export');



