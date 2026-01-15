# Implementation Plan: Role-Based Sanctum API Authentication

This plan outlines the steps to implement Laravel Sanctum token-based authentication for Admins and Customers. The goal is to generate specific access tokens upon login that determine what actions a user can perform in the API.

## 1. Create API Authentication Controller
 We need a dedicated controller to handle API-specific login and logout, separate from the standard Web authentication.

- **Action**: Create `App\Http\Controllers\Api\AuthController`.
- **Logic**:
    - **Login**:
        - Validate credentials (email/password).
        - Verify user exists and password is correct.
        - Determine User Role (`admin` or `customer`).
        - Generate Sanctum Token with **Abilities** based on the role.
            - Admin Token: `['admin:access']` (or simply `['admin']`)
            - Customer Token: `['customer:access']` (or `['customer']`)
        - Return the token in a JSON response.
    - **Logout**:
        - Revoke the current access token.

## 2. Register Sanctum Middleware
Laravel Sanctum provides middleware to check if a token has specific abilities. We need to register these aliases in Laravel 11's `bootstrap/app.php`.

- **Action**: Update `bootstrap/app.php`.
- **Detail**: Register middleware aliases:
    - `'abilities' => \Laravel\Sanctum\Http\Middleware\CheckAbilities::class`
    - `'ability' => \Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class`

## 3. Update API Routes
We will configure the `routes/api.php` file to protect the action routes using these new token abilities.

- **Action**: Modify `routes/api.php`.
- **Detail**:
    - **Public Routes**: Add `/login` (API login).
    - **Protected User Routes** (Cart, Favorites, Checkout):
        - Middleware: `auth:sanctum`, `ability:customer` (or ensure they have customer privileges).
    - **Protected Admin Routes** (Product Management):
        - Middleware: `auth:sanctum`, `ability:admin`.
    - **Public/Private Hybrid**: Ensure `/user` route returns the authenticated user info.

## 4. Token Generation Logic (Pseudocode)
When a user logs in:
```php
if ($user->role === 'admin') {
    $token = $user->createToken('admin-token', ['admin']);
} else {
    $token = $user->createToken('customer-token', ['customer']);
}
return response()->json(['token' => $token->plainTextToken]);
```

## Important Consideration for Frontend
**Crucial**: Once this is implemented, the `api.php` routes will expect an `Authorization: Bearer <token>` header. 
- **Current HTML Forms**: Standard Blade forms (like your "Add to Cart" buttons) **do not** send this header automatically. They rely on Cookies/Sessions.
- **Impact**: If you strictly switch to this Token flow, you must either:
    1.  Update your frontend to use JavaScript (AJAX/Fetch) to attach the token to requests.
    2.  OR, if you intend to keep using Blade forms, we should maintain the `web` middleware (Cookie-based) as a fallback or parallel authentication method. 
    
    *For this plan, we will focus on building the API Token infrastructure as requested.*
