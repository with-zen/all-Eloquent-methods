<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends Controller
{
        /**
     * @OA\Get(
     *     path="/users",
     *     summary="Get all users",
     *     description="Retrieve a list of all users",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *
     *     )
     * )
     */
    public function getAllUsers()
{
    return response()->json(User::all());
}
/**
 * @OA\Get(
 *     path="/api/users/{id}",
 *     summary="Get User by ID",
 *     description="Fetches a user by their ID. If the user does not exist, it returns an error message.",
 *     operationId="getUserById",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the user to fetch",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-01T10:00:00Z"),
 *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-01T10:00:00Z")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="User not found")
 *         )
 *     )
 * )
 */
public function getUserById($id)
{
    $user = User::find($id);
    return response()->json($user ?? ['error' => 'User not found'], $user ? 200 : 404);
}
/**
 * @OA\Get(
 *     path="/api/users/{id}/fail",
 *     summary="Get User by ID or Fail",
 *     description="Fetches a user by their ID. If the user does not exist, it throws a ModelNotFoundException and returns a 404 response.",
 *     operationId="getUserByIdOrFail",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the user to fetch",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-01T10:00:00Z"),
 *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-01T10:00:00Z")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="User not found")
 *         )
 *     )
 * )
 */
public function getUserByIdOrFail($id)
{
    try {
        $user = User::findOrFail($id);
        return response()->json($user);
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'User not found'], 404);
    }
}
/**
 * @OA\Get(
 *     path="/api/users/first",
 *     summary="Get the First User",
 *     description="Fetches the first user ordered by the `created_at` field.",
 *     operationId="getFirstUser",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="First user retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-01T10:00:00Z"),
 *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-01T10:00:00Z")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No user found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="No user found")
 *         )
 *     )
 * )
 */
public function getFirstUser()
{
    $user = User::orderBy('created_at')->first();
    return response()->json($user);
}
/**
 * @OA\Get(
 *     path="/api/users/first/active",
 *     summary="Get the First Active User or Fail",
 *     description="Fetches the first active user. If no active user is found, it returns an error message.",
 *     operationId="getFirstUserOrFail",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Active user retrieved successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="Jane Doe"),
 *             @OA\Property(property="email", type="string", example="jane@example.com"),
 *             @OA\Property(property="status", type="string", example="active"),
 *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-01T10:00:00Z"),
 *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-01T10:00:00Z")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No active user found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="No active user found")
 *         )
 *     )
 * )
 */
public function getFirstUserOrFail()
{
    try {
        $user = User::where('status', 'active')->firstOrFail();
        return response()->json($user);
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'No active user found'], 404);
    }
}
/**
 * @OA\Get(
 *     path="/api/users/active",
 *     summary="Get Active Users",
 *     description="Fetches all users with the status 'active'.",
 *     operationId="getActiveUsers",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of active users",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john@example.com"),
 *                 @OA\Property(property="status", type="string", example="active"),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-01T10:00:00Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-01T10:00:00Z")
 *             )
 *         )
 *     )
 * )
 */
public function getActiveUsers()
{
    $users = User::where('status', 'active')->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/emails",
 *     summary="Get All Emails",
 *     description="Fetches the email addresses of all users.",
 *     operationId="getAllEmails",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of user emails",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="string",
 *                 example="john@example.com"
 *             )
 *         )
 *     )
 * )
 */
public function getAllEmails()
{
    $emails = User::pluck('email');
    return response()->json($emails);
}
/**
 * @OA\Get(
 *     path="/api/users/first-email",
 *     summary="Get First User's Email",
 *     description="Fetches the email address of the first user in the database.",
 *     operationId="getFirstEmail",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="First user's email",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="email", type="string", example="john@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No email found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="No email found")
 *         )
 *     )
 * )
 */
public function getFirstEmail()
{
    $email = User::value('email');
    return response()->json(['email' => $email]);
}
/**
 * @OA\Post(
 *     path="/api/users/process-chunks",
 *     summary="Process Users in Chunks",
 *     description="Processes users in chunks of 100 at a time to optimize memory usage.",
 *     operationId="processUsersInChunks",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Users processed in chunks",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Users processed in chunks")
 *         )
 *     )
 * )
 */
public function processUsersInChunks()
{
    User::chunk(100, function ($users) {
        foreach ($users as $user) {
            // Perform some action on each user
        }
    });

    return response()->json(['message' => 'Users processed in chunks']);
}
/**
 * @OA\Post(
 *     path="/api/users/process-cursor",
 *     summary="Process Users with Cursor",
 *     description="Processes users one by one using a cursor for low memory usage.",
 *     operationId="processUsersWithCursor",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Users processed with cursor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Users processed with cursor")
 *         )
 *     )
 * )
 */
public function processUsersWithCursor()
{
    foreach (User::cursor() as $user) {
        // Perform some action on each user
    }

    return response()->json(['message' => 'Users processed with cursor']);
}
/**
 * @OA\Get(
 *     path="/api/users/selected-columns",
 *     summary="Get Selected Columns from Users",
 *     description="Retrieve a list of users with selected columns: id, name, and email.",
 *     operationId="getSelectedColumns",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of users with selected columns",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john.doe@example.com")
 *             )
 *         )
 *     )
 * )
 */
public function getSelectedColumns()
{
    $users = User::select('id', 'name', 'email')->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/distinct-statuses",
 *     summary="Get Distinct User Statuses",
 *     description="Retrieve a list of distinct statuses from the users table.",
 *     operationId="getDistinctStatuses",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of distinct user statuses",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="string",
 *                 example="active"
 *             )
 *         )
 *     )
 * )
 */
public function getDistinctStatuses()
{
    $statuses = User::distinct()->pluck('status');
    return response()->json($statuses);
}
/**
 * @OA\Get(
 *     path="/api/users/status/{status}",
 *     summary="Get Users by Status",
 *     description="Retrieve a list of users filtered by their status.",
 *     operationId="getUsersByStatus",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="status",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="string",
 *             example="active"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of users with the specified status",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *                 @OA\Property(property="status", type="string", example="active")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No users found with the specified status",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="error", type="string", example="No users found")
 *         )
 *     )
 * )
 */
public function getUsersByStatus($status)
{
    $users = User::where('status', $status)->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/active-or-pending",
 *     summary="Get Active or Pending Users",
 *     description="Retrieve a list of users whose status is either active or pending.",
 *     operationId="getActiveOrPendingUsers",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of active or pending users",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *                 @OA\Property(property="status", type="string", example="active")
 *             )
 *         )
 *     )
 * )
 */
public function getActiveOrPendingUsers()
{
    $users = User::where('status', 'active')
        ->orWhere('status', 'pending')
        ->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/statuses",
 *     summary="Get Users by Multiple Statuses",
 *     description="Retrieve a list of users filtered by multiple statuses.",
 *     operationId="getUsersByMultipleStatuses",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of users with specified statuses",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *                 @OA\Property(property="status", type="string", example="active")
 *             )
 *         )
 *     )
 * )
 */
public function getUsersByMultipleStatuses()
{
    $users = User::whereIn('status', ['active', 'pending'])->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/exclude-statuses",
 *     summary="Get Users Excluding Specific Statuses",
 *     description="Retrieve a list of users excluding certain statuses.",
 *     operationId="getUsersExcludingStatuses",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of users excluding specific statuses",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *                 @OA\Property(property="status", type="string", example="active")
 *             )
 *         )
 *     )
 * )
 */
public function getUsersExcludingStatuses()
{
    $users = User::whereNotIn('status', ['inactive', 'banned'])->get();
    return response()->json($users);
}

/**
 * @OA\Get(
 *     path="/api/users/no-email",
 *     summary="Get Users Without Email",
 *     description="Retrieve a list of users who do not have an email address.",
 *     operationId="getUsersWithoutEmail",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of users without email",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example=null)
 *             )
 *         )
 *     )
 * )
 */
public function getUsersWithoutEmail()
{
    $users = User::whereNull('email')->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/age-range/{minAge}/{maxAge}",
 *     summary="Get Users by Age Range",
 *     description="Retrieve a list of users whose age falls within the specified range.",
 *     operationId="getUsersByAgeRange",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="minAge",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             example=18
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="maxAge",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             example=40
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of users within the age range",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *                 @OA\Property(property="age", type="integer", example=30)
 *             )
 *         )
 *     )
 * )
 */
public function getUsersByAgeRange($minAge, $maxAge)
{
    $users = User::whereBetween('age', [$minAge, $maxAge])->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/outside-age-range/{minAge}/{maxAge}",
 *     summary="Get Users Outside Age Range",
 *     description="Retrieve a list of users whose age is outside the specified range.",
 *     operationId="getUsersOutsideAgeRange",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="minAge",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             example=18
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="maxAge",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             example=40
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of users outside the age range",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *                 @OA\Property(property="age", type="integer", example=45)
 *             )
 *         )
 *     )
 * )
 */
public function getUsersOutsideAgeRange($minAge, $maxAge)
{
    $users = User::whereNotBetween('age', [$minAge, $maxAge])->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/join-date/{date}",
 *     summary="Get Users by Join Date",
 *     description="Retrieve a list of users who joined on a specific date.",
 *     operationId="getUsersByJoinDate",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="date",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="string",
 *             format="date",
 *             example="2024-01-01"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of users who joined on the specified date",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *                 @OA\Property(property="created_at", type="string", format="date", example="2024-01-01")
 *             )
 *         )
 *     )
 * )
 */
public function getUsersByJoinDate($date)
{
    $users = User::whereDate('created_at', '=', $date)->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/join-month/{month}",
 *     summary="Get Users by Join Month",
 *     description="Retrieve a list of users who joined in a specific month.",
 *     operationId="getUsersByJoinMonth",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="month",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             example=1
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of users who joined in the specified month",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *                 @OA\Property(property="created_at", type="string", format="date", example="2024-01-15")
 *             )
 *         )
 *     )
 * )
 */

public function getUsersByJoinMonth($month)
{
    $users = User::whereMonth('created_at', '=', $month)->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/join-day/{day}",
 *     summary="Get Users by Join Day",
 *     description="Retrieve a list of users who joined on a specific day of the month.",
 *     operationId="getUsersByJoinDay",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="day",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             example=15
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of users who joined on the specified day",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *                 @OA\Property(property="created_at", type="string", format="date", example="2024-01-15")
 *             )
 *         )
 *     )
 * )
 */
public function getUsersByJoinDay($day)
{
    $users = User::whereDay('created_at', '=', $day)->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/join-year/{year}",
 *     summary="Get Users by Join Year",
 *     description="Retrieve a list of users who joined in a specific year.",
 *     operationId="getUsersByJoinYear",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="year",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             example=2024
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of users who joined in the specified year",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *                 @OA\Property(property="created_at", type="string", format="date", example="2024-01-15")
 *             )
 *         )
 *     )
 * )
 */
public function getUsersByJoinYear($year)
{
    $users = User::whereYear('created_at', '=', $year)->get();
    return response()->json($users);
}

/**
 * @OA\Get(
 *     path="/api/users/ordered-by-name",
 *     summary="Get Users Ordered by Name",
 *     description="Retrieve a list of users ordered by their name in ascending order.",
 *     operationId="getUsersOrderedByName",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of users ordered by name",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john.doe@example.com")
 *             )
 *         )
 *     )
 * )
 */
public function getUsersOrderedByName()
{
    $users = User::orderBy('name', 'asc')->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/latest",
 *     summary="Get Latest Users",
 *     description="Retrieve the most recent users based on the join date.",
 *     operationId="getLatestUsers",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of the latest users",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *                 @OA\Property(property="created_at", type="string", format="date", example="2024-01-01")
 *             )
 *         )
 *     )
 * )
 */

public function getLatestUsers()
{
    $users = User::latest()->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/oldest",
 *     summary="Get Oldest Users",
 *     description="Retrieve the list of users ordered by their join date from the oldest to the most recent.",
 *     operationId="getOldestUsers",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of oldest users",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *                 @OA\Property(property="created_at", type="string", format="date", example="2020-01-01")
 *             )
 *         )
 *     )
 * )
 */
public function getOldestUsers()
{
    $users = User::oldest()->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/grouped",
 *     summary="Get Grouped Users",
 *     description="Retrieve the count of users grouped by their status.",
 *     operationId="getGroupedUsers",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Count of users grouped by status",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="status", type="string", example="active"),
 *                 @OA\Property(property="total", type="integer", example=10)
 *             )
 *         )
 *     )
 * )
 */
public function getGroupedUsers()
{
    $users = User::selectRaw('count(*) as total, status')->groupBy('status')->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/count",
 *     summary="Get User Count",
 *     description="Retrieve the total count of users.",
 *     operationId="getUserCount",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Total number of users",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="count", type="integer", example=100)
 *         )
 *     )
 * )
 */
public function getUserCount()
{
    $count = User::count();
    return response()->json(['count' => $count]);
}
/**
 * @OA\Get(
 *     path="/api/users/total-age",
 *     summary="Get Total Age of Users",
 *     description="Retrieve the total sum of all users' ages.",
 *     operationId="getTotalAge",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Total sum of users' ages",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="total_age", type="integer", example=2500)
 *         )
 *     )
 * )
 */
public function getTotalAge()
{
    $totalAge = User::sum('age');
    return response()->json(['total_age' => $totalAge]);
}
/**
 * @OA\Get(
 *     path="/api/users/average-age",
 *     summary="Get Average Age of Users",
 *     description="Retrieve the average age of all users.",
 *     operationId="getAverageAge",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Average age of users",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="average_age", type="integer", example=30)
 *         )
 *     )
 * )
 */
public function getAverageAge()
{
    $averageAge = User::avg('age');
    return response()->json(['average_age' => $averageAge]);
}
/**
 * @OA\Get(
 *     path="/api/users/minimum-age",
 *     summary="Get Minimum Age of Users",
 *     description="Retrieve the minimum age among all users.",
 *     operationId="getMinimumAge",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Minimum age of users",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="minimum_age", type="integer", example=18)
 *         )
 *     )
 * )
 */
public function getMinimumAge()
{
    $minAge = User::min('age');
    return response()->json(['minimum_age' => $minAge]);
}
/**
 * @OA\Get(
 *     path="/api/users/maximum-age",
 *     summary="Get Maximum Age of Users",
 *     description="Retrieve the maximum age among all users.",
 *     operationId="getMaximumAge",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Maximum age of users",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="maximum_age", type="integer", example=65)
 *         )
 *     )
 * )
 */
public function getMaximumAge()
{
    $maxAge = User::max('age');
    return response()->json(['maximum_age' => $maxAge]);
}
/**
 * @OA\Get(
 *     path="/api/users/with-posts",
 *     summary="Get Users With Posts",
 *     description="Retrieve users who have at least one post.",
 *     operationId="getUsersWithPosts",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of users with posts",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="posts", type="array",
 *                     @OA\Items(type="object", @OA\Property(property="title", type="string", example="First Post"))
 *                 )
 *             )
 *         )
 *     )
 * )
 */
public function getUsersWithPosts()
{
    $users = User::has('posts')->get(); // Assuming `posts` is a defined relationship.
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/with-posts-comments",
 *     summary="Get Users With Posts and Comments",
 *     description="Retrieve users with their posts and comments.",
 *     operationId="getUsersWithPostsAndComments",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of users with posts and comments",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="posts", type="array",
 *                     @OA\Items(type="object", @OA\Property(property="title", type="string", example="First Post"))
 *                 ),
 *                 @OA\Property(property="comments", type="array",
 *                     @OA\Items(type="object", @OA\Property(property="content", type="string", example="Great post!"))
 *                 )
 *             )
 *         )
 *     )
 * )
 */
public function getUsersWithPostsAndComments()
{
    $users = User::with(['posts', 'comments'])->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/with-post-count",
 *     summary="Get Users With Post Count",
 *     description="Retrieve users with the count of posts they have.",
 *     operationId="getUsersWithPostCount",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of users with post count",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="posts_count", type="integer", example=5)
 *             )
 *         )
 *     )
 * )
 */
public function getUsersWithPostCount()
{
    $users = User::withCount('posts')->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/{userId}/posts",
 *     summary="Get Posts of a User",
 *     description="Retrieve all posts made by a specific user.",
 *     operationId="getUserPosts",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="userId",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of posts by the user",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="title", type="string", example="First Post")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */
public function getUserPosts($userId)
{
    $user = User::find($userId);
    return response()->json($user->posts); // Assuming `posts` is a `hasMany` relation in the User model.
}
/**
 * @OA\Get(
 *     path="/api/users/{userId}/roles",
 *     summary="Get Roles of a User",
 *     description="Retrieve all roles assigned to a specific user.",
 *     operationId="getUserRoles",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="userId",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of roles assigned to the user",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Admin")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */
public function getUserRoles($userId)
{
    $user = User::find($userId);
    return response()->json($user->roles); // Assuming `roles` is a `belongsToMany` relation in the User model.
}
/**
 * @OA\Post(
 *     path="/api/users",
 *     summary="Create a User",
 *     description="Create a new user with provided name, email, and password.",
 *     operationId="createUser",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="User created successfully",
 *     )
 * )
 */
public function createUser(Request $request)
{
    $user = User::create($request->only(['name', 'email', 'password']));
    return response()->json($user, 201);
}
/**
 * @OA\Post(
 *     path="/api/users/find-or-create",
 *     summary="Find or Create a User",
 *     description="Find a user by email, or create a new user if not found.",
 *     operationId="findOrCreateUser",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User found or created",
 *     )
 * )
 */
public function findOrCreateUser(Request $request)
{
    $user = User::firstOrCreate(
        ['email' => $request->email],
        ['name' => $request->name, 'password' => bcrypt($request->password)]
    );
    return response()->json($user);
}
/**
 * @OA\Post(
 *     path="/api/users/update-or-create",
 *     summary="Update or Create a User",
 *     description="Update an existing user or create a new user if not found.",
 *     operationId="updateOrCreateUser",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated or created",
 *     )
 * )
 */
public function updateOrCreateUser(Request $request)
{
    $user = User::updateOrCreate(
        ['email' => $request->email],
        ['name' => $request->name, 'password' => bcrypt($request->password)]
    );
    return response()->json($user);
}
/**
 * @OA\Put(
 *     path="/api/users/{id}",
 *     summary="Update a User",
 *     description="Update the name and email of an existing user.",
 *     operationId="updateUser",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully",
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */
public function updateUser(Request $request, $id)
{
    $user = User::find($id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();

    return response()->json($user);
}
/**
 * @OA\Patch(
 *     path="/api/users/{id}/increment-age",
 *     summary="Increment User Age",
 *     description="Increment the age of a specific user by 1.",
 *     operationId="incrementUserAge",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User's age incremented successfully",
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */
public function incrementUserAge($id)
{
    $user = User::find($id);
    $user->increment('age', 1);

    return response()->json($user);
}
/**
 * @OA\Patch(
 *     path="/api/users/{id}/decrement-age",
 *     summary="Decrement User Age",
 *     description="Decrement the age of a specific user by 1.",
 *     operationId="decrementUserAge",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User's age decremented successfully",
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */
public function decrementUserAge($id)
{
    $user = User::find($id);
    $user->decrement('age', 1);

    return response()->json($user);
}
/**
 * @OA\Delete(
 *     path="/api/users/{id}",
 *     summary="Delete a User",
 *     description="Delete a specific user by their ID.",
 *     operationId="deleteUser",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="User deleted successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */
public function deleteUser($id)
{
    $user = User::find($id);
    if ($user) {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
    return response()->json(['error' => 'User not found'], 404);
}
/**
 * @OA\Delete(
 *     path="/api/users/delete-multiple",
 *     summary="Delete Multiple Users",
 *     description="Delete multiple users by their IDs.",
 *     operationId="deleteMultipleUsers",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="ids", type="array", @OA\Items(type="integer"), example={1, 2, 3})
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Users deleted successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Users deleted successfully")
 *         )
 *     )
 * )
 *  */
public function deleteMultipleUsers(Request $request)
{
    User::destroy($request->ids);
    return response()->json(['message' => 'Users deleted successfully']);
}

/**
 * @OA\Delete(
 *     path="/api/users/truncate",
 *     summary="Truncate All Users",
 *     description="Delete all users from the database.",
 *     operationId="truncateUsers",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="All users deleted successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="All users deleted successfully")
 *         )
 *     )
 * )
 */
public function truncateUsers()
{
    User::truncate();
    return response()->json(['message' => 'All users deleted successfully']);
}
/**
 * @OA\Patch(
 *     path="/api/users/{id}/refresh",
 *     summary="Refresh a User",
 *     description="Refresh the user's model instance to get the most recent data from the database.",
 *     operationId="refreshUser",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User refreshed successfully",
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */
public function refreshUser($id)
{
    $user = User::find($id)->refresh();
    return response()->json($user);
}
/**
 * @OA\Post(
 *     path="/api/users/{id}/clone",
 *     summary="Clone a User",
 *     description="Create a clone of an existing user.",
 *     operationId="cloneUser",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User cloned successfully",
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */
public function cloneUser($id)
{
    $user = User::find($id);
    $clone = $user->replicate();
    $clone->save();

    return response()->json($clone);
}
/**
 * @OA\Get(
 *     path="/api/users/{id}/exists",
 *     summary="Check if User Exists",
 *     description="Check if a user exists by their ID.",
 *     operationId="checkUserExists",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User existence status",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="exists", type="boolean")
 *         )
 *     )
 * )
 */
public function checkUserExists($id)
{
    $exists = User::where('id', $id)->exists();
    return response()->json(['exists' => $exists]);
}

/**
 * @OA\Put(
 *     path="/api/users/{id}/update-email",
 *     summary="Update User Email",
 *     description="Update the email of a user and return whether the email was changed.",
 *     operationId="updateUserEmail",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="email", type="string", example="new-email@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Email updated successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="wasChanged", type="boolean")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */
public function updateUserEmail(Request $request, $id)
{
    $user = User::find($id);
    $user->email = $request->email;
    $user->save();

    return response()->json(['wasChanged' => $user->wasChanged('email')]);
}

/**
 * @OA\Post(
 *     path="/api/users/get-by-ids",
 *     summary="Get Users by IDs",
 *     description="Retrieve users by their IDs.",
 *     operationId="getUsersByIds",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="ids", type="array", @OA\Items(type="integer"), example={1, 2, 3})
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Users retrieved successfully",
 *     )
 * )
 */
public function getUsersByIds(Request $request)
{
    $users = User::findMany($request->ids); // Pass an array of IDs
    return response()->json($users);
}

/**
 * @OA\Get(
 *     path="/api/users/email/{email}",
 *     summary="Get User by Email",
 *     description="Retrieve a user by their email address.",
 *     operationId="getUserByEmail",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", format="email")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User found",
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */
public function getUserByEmail($email)
{
    $user = User::firstWhere('email', $email);
    return response()->json($user ?? ['error' => 'User not found'], $user ? 200 : 404);
}

/**
 * @OA\Get(
 *     path="/api/users/email/{email}/exists",
 *     summary="Check if User Exists by Email",
 *     description="Check if a user exists by their email address.",
 *     operationId="checkIfUserExistsByEmail",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", format="email")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User existence status",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="exists", type="boolean")
 *         )
 *     )
 * )
 */
public function checkIfUserExistsByEmail($email)
{
    $exists = User::where('email', $email)->exists();
    return response()->json(['exists' => $exists]);
}
/**
 * @OA\Get(
 *     path="/api/users/email/{email}/does-not-exist",
 *     summary="Check if User Does Not Exist by Email",
 *     description="Check if a user does not exist by their email address.",
 *     operationId="checkIfUserDoesNotExistByEmail",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", format="email")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User non-existence status",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="doesnt_exist", type="boolean")
 *         )
 *     )
 * )
 */
public function checkIfUserDoesNotExistByEmail($email)
{
    $doesntExist = User::where('email', $email)->doesntExist();
    return response()->json(['doesnt_exist' => $doesntExist]);
}
/**
 * @OA\Delete(
 *     path="/api/users/{id}/soft-delete",
 *     summary="Soft Delete a User",
 *     description="Soft delete a specific user by their ID.",
 *     operationId="softDeleteUser",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User soft-deleted successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="User soft-deleted successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */
public function softDeleteUser($id)
{
    $user = User::find($id);
    if ($user) {
        $user->delete();
        return response()->json(['message' => 'User soft-deleted successfully']);
    }
    return response()->json(['error' => 'User not found'], 404);
}

/**
 * @OA\Patch(
 *     path="/api/users/{id}/restore",
 *     summary="Restore a Soft-Deleted User",
 *     description="Restore a soft-deleted user by their ID.",
 *     operationId="restoreUser",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User restored successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="User restored successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found or not trashed"
 *     )
 * )
 */
public function restoreUser($id)
{
    $user = User::withTrashed()->find($id);
    if ($user && $user->trashed()) {
        $user->restore();
        return response()->json(['message' => 'User restored successfully']);
    }
    return response()->json(['error' => 'User not found or not trashed'], 404);
}

/**
 * @OA\Delete(
 *     path="/api/users/{id}/permanently-delete",
 *     summary="Permanently Delete a User",
 *     description="Permanently delete a user by their ID.",
 *     operationId="permanentlyDeleteUser",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User permanently deleted",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="User permanently deleted")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */
public function permanentlyDeleteUser($id)
{
    $user = User::withTrashed()->find($id);
    if ($user) {
        $user->forceDelete();
        return response()->json(['message' => 'User permanently deleted']);
    }
    return response()->json(['error' => 'User not found'], 404);
}
/**
 * @OA\Get(
 *     path="/api/users/trashed",
 *     summary="Get Trashed Users",
 *     description="Retrieve users who have been soft-deleted (trashed).",
 *     operationId="getTrashedUsers",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of trashed users",
 *     )
 * )
 */
public function getTrashedUsers()
{
    $users = User::onlyTrashed()->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/all",
 *     summary="Get All Users Including Trashed",
 *     description="Retrieve all users, including those that have been soft-deleted.",
 *     operationId="getAllUsersIncludingTrashed",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="List of all users including trashed",
 *     )
 * )
 */
public function getAllUsersIncludingTrashed()
{
    $users = User::withTrashed()->get();
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/paginated",
 *     summary="Get Paginated Users",
 *     description="Retrieve a paginated list of users (10 users per page).",
 *     operationId="getPaginatedUsers",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Paginated list of users",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="current_page", type="integer"),
 *             @OA\Property(property="per_page", type="integer"),
 *             @OA\Property(property="total", type="integer")
 *         )
 *     )
 * )
 */
public function getPaginatedUsers()
{
    $users = User::paginate(10);
    return response()->json($users);
}

/**
 * @OA\Get(
 *     path="/api/users/simple-paginated",
 *     summary="Get Simple Paginated Users",
 *     description="Retrieve a simple paginated list of users (10 users per page).",
 *     operationId="getSimplePaginatedUsers",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Simple paginated list of users",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="current_page", type="integer"),
 *             @OA\Property(property="per_page", type="integer"),
 *             @OA\Property(property="total", type="integer")
 *         )
 *     )
 * )
 */
public function getSimplePaginatedUsers()
{
    $users = User::simplePaginate(10);
    return response()->json($users);
}
/**
 * @OA\Get(
 *     path="/api/users/cursor-paginated",
 *     summary="Get Cursor Paginated Users",
 *     description="Retrieve a cursor-paginated list of users (10 users per page).",
 *     operationId="getCursorPaginatedUsers",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="Cursor paginated list of users",
 *     )
 * )
 */
public function getCursorPaginatedUsers()
{
    $users = User::cursorPaginate(10);
    return response()->json($users);
}

}
