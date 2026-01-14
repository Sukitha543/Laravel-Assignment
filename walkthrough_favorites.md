# Walkthrough: Favorites Functionality Implementation

This document outlines the steps to implement the favorites (wishlist) functionality for the TimeBridge application.

## 1. Database Schema
We need a table to store items added to favorites by users.
- **Table Name**: `favorites`
- **Columns**:
    - `id` (Primary Key)
    - `user_id` (Foreign Key to `users`)
    - `product_id` (Foreign Key to `products`)
    - `timestamps` (`created_at`, `updated_at`)

## 2. Models
- Create a `Favorite` model.
- Define relationships:
    - `Favorite` belongs to `User`.
    - `Favorite` belongs to `Product`.

## 3. Backend Logic (FavoriteController)
We will create a `FavoriteController` to handle the logic.

### Methods:
- **`index()`**:
    - Retrieve all favorite items for the currently authenticated user.
    - Return the `favorites.blade.php` view with the items.

- **`store(Request $request, Product $product)`** (Add to Favorites):
    - **Authentication Check**: Ensure user is logged in (handled by middleware).
    - **Duplicate Check**: Check if the user already has this product in their favorites.
        - *If yes*: Redirect back with an error message: "This item has already been added to your favorites."
    - **Action**: Create a new `Favorite` record linked to the user and product.
    - **Response**: Redirect to the Favorites page with a success message: "Product added to favorites successfully!"

- **`destroy($id)`** (Remove from Favorites):
    - Find the `Favorite` by ID (ensure it belongs to the current user).
    - Delete the record.
    - Redirect back to the Favorites page with a success message.

## 4. Routes
Update `routes/web.php` to include authenticated routes for the favorite actions.

```php
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/add/{product}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});
```

## 5. Frontend Updates

### `favorites.blade.php`
- Remove dummy data.
- Iterate through the passed `$favorites` collection.
- **Display**:
    - Product Image (`product->image`)
    - Brand & Model (`product->brand`, `product->model`)
    - Price
    - "View Details" Link (pointing to `products.show`)
- **Remove Button**: Create a form with `@method('DELETE')` pointing to the destroy route.
- **Empty State**: Add logic to check if `$favorites` is empty.
    - If empty: Show "No Favorites Added" message.

### `product.blade.php`
- Update the Heart Icon (Add to Favorites button).
- Wrap it in a `<form>` pointing to the `favorites.store` route.
- This ensures that clicking it sends a POST request, which is the correct HTTP method for creating a resource (adding to favorites), and allows middleware to intercept unauthenticated users correctly.

## 6. Validation & Testing
- Test adding a new product to favorites.
- Test adding a duplicate product (verify error message).
- Test removing a product.
- Verify empty state behavior.
- Verify redirection for non-logged-in users (clicking the form button should trigger the auth middleware).
