# Walkthrough: Cart Functionality Implementation

This document outlines the steps to implement a functional shopping cart for the TimeBridge application.

## 1. Database Schema
We need a table to store items added to the cart by users.
- **Table Name**: `cart_items`
- **Columns**:
    - `id` (Primary Key)
    - `user_id` (Foreign Key to `users`)
    - `product_id` (Foreign Key to `products`)
    - `quantity` (Integer, default 1)
    - `timestamps` (`created_at`, `updated_at`)

## 2. Models
- Create a `CartItem` model.
- Define relationships:
    - `CartItem` belongs to `User`.
    - `CartItem` belongs to `Product`.

## 3. Backend Logic (CartController)
We will create a `CartController` to handle the logic.

### Methods:
- **`index()`**:
    - Retrieve all cart items for the currently authenticated user.
    - Calculate the total price of items in the cart.
    - Return the `cart.blade.php` view with the items and total.

- **`store(Request $request)`** (Add to Cart):
    - **Authentication Check**: Ensure user is logged in (handled by middleware).
    - **Validation**: Check if the `product_id` is valid.
    - **Duplicate Check**: Check if the user already has this product in their cart.
        - *If yes*: Redirect back with an error message: "Item has already been added to the cart."
    - **Action**: Create a new `CartItem` record linked to the user and product.
    - **Response**: Redirect to the Cart page with a success message: "Product added to cart successfully!"

- **`destroy($id)`** (Remove from Cart):
    - Find the `CartItem` by ID (ensure it belongs to the current user).
    - Delete the record.
    - Redirect back to the Cart page with a success message.

## 4. Routes
Update `routes/web.php` to include authenticated routes for the cart actions. Use the `auth` middleware (standard or Sanctum) to ensure only logged-in users can access these.

```php
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
});
```

## 5. Frontend Updates

### `cart.blade.php`
- Remove dummy data.
- Iterate through the passed `$cartItems`.
- **Display**:
    - Product Image (`product->image`)
    - Brand & Model (`product->brand`, `product->model`)
    - Material/Type (as secondary info)
    - Price
- **Remove Button**: Create a form with `@method('DELETE')` pointing to the destroy route.
- **Empty State**: Add logic to check if `$cartItems` is empty.
    - If empty: Show "Your cart is empty" message and hide the Checkout button/Order Summary.
- **Total Calculation**: Display the calculated total.

### `product.blade.php` & `product-detail.blade.php`
- Update the "Add to Cart" buttons.
- Wrap them in a `<form>` pointing to the `cart.store` route.
- Ensure authentication checks are seamless (middleware will redirect unauthenticated users to login automatically, which satisfies the requirement).

## 6. Validation & Testing
- Test adding a new product.
- Test adding a duplicate product (verify error message).
- Test removing a product.
- Verify total calculation.
- Verify empty state behavior.
- Verify redirection for non-logged-in users.
