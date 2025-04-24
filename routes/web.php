<?php

use App\Http\Controllers\adminImportsManipulations;
use App\Http\Controllers\AdminManipulationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserViewPageController;
use App\Http\Controllers\AdminViewPageController;
use App\Http\Controllers\UserAuthController;

Route::get('/', function () {
    return view('landing_page');
});

//Route::get('/test', function () {
//    return view('test');
//})->name('test');

Route::get('/user/auth/loginPage', [UserViewPageController::class, 'viewUserLoginPage'])->name('login');
Route::post('/user/auth/loginPage', [UserAuthController::class, 'userLogin'])->name('userPostLogin');
Route::get('/user/auth/logout', [UserAuthController::class, 'userLogout'])->name('user.logout');

Route::middleware(['auth','userAuth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminViewPageController::class, 'viewAdminDashboard'])->name('admin.dashboard.page');

    Route::get('/admin/allUsersPage', [AdminViewPageController::class, 'viewUsersPage'])->name('admin.view.users.page');
    Route::post('/admin/addUser', [AdminManipulationController::class, 'adminAddUser'])->name('addUser');
    Route::get('/admin/deleteUser/{id}', [AdminManipulationController::class, 'adminDeleteUser'])->name('admin.delete.user');
    Route::post('/admin/editUser', [AdminManipulationController::class, 'adminEditUser'])->name('admin.edit.user');

    Route::get('/admin/membersPage', [AdminViewPageController::class, 'adminMembersPage'])->name('admin.members.page');
    Route::post('/admin/addMember', [AdminManipulationController::class, 'adminAddMember'])->name('addMember');
    Route::post('/admin/editMember', [AdminManipulationController::class, 'adminEditMember'])->name('admin.edit.member');
    Route::get('/admin/deleteMember/{id}', [AdminManipulationController::class, 'adminDeleteMember'])->name('admin.delete.member');
    Route::post('/admin/addManyMembers', [adminImportsManipulations::class, 'adminAddExcelManyMembers'])->name('admin.addManyMembers');

    Route::get('/admin/groupsPage', [AdminViewPageController::class, 'viewGroupsPage'])->name('admin.groups.page');
    Route::post('/admin/addGroup', [AdminManipulationController::class, 'adminAddGroup'])->name('addGroup');
    Route::post('/admin/editGroup', [AdminManipulationController::class, 'adminEditGroup'])->name('admin.edit.group');
    Route::get('/admin/deleteGroup/{id}', [AdminManipulationController::class, 'adminDeleteGroup'])->name('admin.delete.group');

    Route::get('/admin/leaderPositionPage', [AdminViewPageController::class, 'adminViewLeaderPositionsPage'])->name('admin.leader.positions.page');
    Route::post('/admin/addLeaderPosition', [AdminManipulationController::class, 'adminAddLeaderPosition'])->name('admin.add.leader.position');
    Route::post('/admin/editLeaderPosition', [AdminManipulationController::class, 'adminEditLeaderPosition'])->name('admin.edit.leader.position');
    Route::get('/admin/deleteLeaderPosition/{id}', [AdminManipulationController::class, 'adminDeleteLeaderPosition'])->name('admin.delete.leader.position');

    Route::get('/admin/leadersPage', [AdminViewPageController::class, 'adminViewLeadersPage'])->name('admin.leaders.page');
    Route::post('/admin/addLeader', [AdminManipulationController::class, 'adminAddLeader'])->name('admin.add.leader');
    Route::post('/admin/editLeader', [AdminManipulationController::class, 'adminEditLeader'])->name('admin.edit.leader');
    Route::get('/admin/deleteLeader/{id}', [AdminManipulationController::class, 'adminDeleteLeader'])->name('admin.delete.leader');

    Route::get('/admin/announcementsPage', [AdminViewPageController::class, 'adminViewAnnouncementsPage'])->name('admin.announcements.page');
    Route::post('/admin/addAnnouncementsPage', [AdminManipulationController::class, 'adminAddAnnouncement'])->name('addAnnouncement');
    Route::post('/admin/editAnnouncement', [AdminManipulationController::class, 'adminEditAnnouncement'])->name('admin.edit.announcement');
    Route::get('/admin/deleteAnnouncement/{id}', [AdminManipulationController::class, 'adminDeleteAnnouncement'])->name('admin.delete.announcement');

    Route::get('/admin/baptismsPage', [AdminViewPageController::class, 'adminViewBaptismsPage'])->name('admin.baptisms.page');
    Route::post('/admin/addBaptismPage', [AdminManipulationController::class, 'adminAddBaptism'])->name('admin.add.baptism');
    Route::post('/admin/editBaptism', [AdminManipulationController::class, 'adminEditBaptism'])->name('admin.edit.baptism');
    Route::get('/admin/deleteBaptism/{id}', [AdminManipulationController::class, 'adminDeleteBaptism'])->name('admin.delete.baptism');
});

Route::middleware(['auth', 'userAuth:katibu'])->group(function () {

});
