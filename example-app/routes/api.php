<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::prefix('users')->group(function () {

    // General routes
    Route::get('/', [UserController::class, 'getAllUsers'])->name('users.getAll');
    Route::get('/{id}', [UserController::class, 'getUserById'])->name('users.getById');
    Route::get('/{id}/or-fail', [UserController::class, 'getUserByIdOrFail'])->name('users.getByIdOrFail');
    Route::get('/first', [UserController::class, 'getFirstUser'])->name('users.getFirst');
    Route::get('/first-or-fail', [UserController::class, 'getFirstUserOrFail'])->name('users.getFirstOrFail');

    // Status-based filtering
    Route::get('/status/active', [UserController::class, 'getActiveUsers'])->name('users.getActive');
    Route::get('/status/{status}', [UserController::class, 'getUsersByStatus'])->name('users.getByStatus');
    Route::get('/status/active-or-pending', [UserController::class, 'getActiveOrPendingUsers'])->name('users.getActiveOrPending');
    Route::get('/status/multiple', [UserController::class, 'getUsersByMultipleStatuses'])->name('users.getByMultipleStatuses');
    Route::get('/status/exclude', [UserController::class, 'getUsersExcludingStatuses'])->name('users.getExcludingStatuses');

    // Email and column-based queries
    Route::get('/emails', [UserController::class, 'getAllEmails'])->name('users.getAllEmails');
    Route::get('/email/first', [UserController::class, 'getFirstEmail'])->name('users.getFirstEmail');
    Route::get('/selected-columns', [UserController::class, 'getSelectedColumns'])->name('users.getSelectedColumns');
    Route::get('/distinct-statuses', [UserController::class, 'getDistinctStatuses'])->name('users.getDistinctStatuses');
    Route::get('/email/{email}', [UserController::class, 'getUserByEmail'])->name('users.getByEmail');

    // Null and range queries
    Route::get('/without-email', [UserController::class, 'getUsersWithoutEmail'])->name('users.getWithoutEmail');
    Route::get('/age/range/{minAge}/{maxAge}', [UserController::class, 'getUsersByAgeRange'])->name('users.getByAgeRange');
    Route::get('/age/outside/{minAge}/{maxAge}', [UserController::class, 'getUsersOutsideAgeRange'])->name('users.getOutsideAgeRange');

    // Date and time queries
    Route::get('/joined/date/{date}', [UserController::class, 'getUsersByJoinDate'])->name('users.getByJoinDate');
    Route::get('/joined/month/{month}', [UserController::class, 'getUsersByJoinMonth'])->name('users.getByJoinMonth');
    Route::get('/joined/day/{day}', [UserController::class, 'getUsersByJoinDay'])->name('users.getByJoinDay');
    Route::get('/joined/year/{year}', [UserController::class, 'getUsersByJoinYear'])->name('users.getByJoinYear');

    // Sorting and grouping
    Route::get('/sorted/name', [UserController::class, 'getUsersOrderedByName'])->name('users.getByName');
    Route::get('/sorted/latest', [UserController::class, 'getLatestUsers'])->name('users.getLatest');
    Route::get('/sorted/oldest', [UserController::class, 'getOldestUsers'])->name('users.getOldest');
    Route::get('/grouped/status', [UserController::class, 'getGroupedUsers'])->name('users.getGrouped');

    // Aggregates
    Route::get('/count', [UserController::class, 'getUserCount'])->name('users.getCount');
    Route::get('/age/sum', [UserController::class, 'getTotalAge'])->name('users.getTotalAge');
    Route::get('/age/average', [UserController::class, 'getAverageAge'])->name('users.getAverageAge');
    Route::get('/age/minimum', [UserController::class, 'getMinimumAge'])->name('users.getMinimumAge');
    Route::get('/age/maximum', [UserController::class, 'getMaximumAge'])->name('users.getMaximumAge');

    // Relationships
    Route::get('/with-posts', [UserController::class, 'getUsersWithPosts'])->name('users.getWithPosts');
    Route::get('/with-posts-and-comments', [UserController::class, 'getUsersWithPostsAndComments'])->name('users.getWithPostsAndComments');
    Route::get('/post-count', [UserController::class, 'getUsersWithPostCount'])->name('users.getPostCount');
    Route::get('/{id}/posts', [UserController::class, 'getUserPosts'])->name('users.getPosts');
    Route::get('/{id}/roles', [UserController::class, 'getUserRoles'])->name('users.getRoles');

    // CRUD operations
    Route::post('/', [UserController::class, 'createUser'])->name('users.create');
    Route::post('/find-or-create', [UserController::class, 'findOrCreateUser'])->name('users.findOrCreate');
    Route::post('/update-or-create', [UserController::class, 'updateOrCreateUser'])->name('users.updateOrCreate');
    Route::put('/{id}', [UserController::class, 'updateUser'])->name('users.update');
    Route::delete('/{id}', [UserController::class, 'deleteUser'])->name('users.delete');
    Route::delete('/multiple', [UserController::class, 'deleteMultipleUsers'])->name('users.deleteMultiple');
    Route::delete('/truncate', [UserController::class, 'truncateUsers'])->name('users.truncate');

    // Additional operations
    Route::put('/increment-age/{id}', [UserController::class, 'incrementUserAge'])->name('users.incrementAge');
    Route::put('/decrement-age/{id}', [UserController::class, 'decrementUserAge'])->name('users.decrementAge');
    Route::get('/refresh/{id}', [UserController::class, 'refreshUser'])->name('users.refresh');
    Route::post('/clone/{id}', [UserController::class, 'cloneUser'])->name('users.clone');
    Route::get('/exists/{id}', [UserController::class, 'checkUserExists'])->name('users.exists');
    Route::put('/update-email/{id}', [UserController::class, 'updateUserEmail'])->name('users.updateEmail');
    Route::post('/find-many', [UserController::class, 'getUsersByIds'])->name('users.getByIds');
    Route::get('/email-exists/{email}', [UserController::class, 'checkIfUserExistsByEmail'])->name('users.existsByEmail');
    Route::get('/email-doesnt-exist/{email}', [UserController::class, 'checkIfUserDoesNotExistByEmail'])->name('users.doesntExistByEmail');

    // Soft delete and trash
    Route::delete('/soft-delete/{id}', [UserController::class, 'softDeleteUser'])->name('users.softDelete');
    Route::put('/restore/{id}', [UserController::class, 'restoreUser'])->name('users.restore');
    Route::delete('/force-delete/{id}', [UserController::class, 'permanentlyDeleteUser'])->name('users.forceDelete');
    Route::get('/trashed', [UserController::class, 'getTrashedUsers'])->name('users.trashed');
    Route::get('/with-trashed', [UserController::class, 'getAllUsersIncludingTrashed'])->name('users.withTrashed');

    // Pagination
    Route::get('/paginate', [UserController::class, 'getPaginatedUsers'])->name('users.paginate');
    Route::get('/simple-paginate', [UserController::class, 'getSimplePaginatedUsers'])->name('users.simplePaginate');
    Route::get('/cursor-paginate', [UserController::class, 'getCursorPaginatedUsers'])->name('users.cursorPaginate');
});
